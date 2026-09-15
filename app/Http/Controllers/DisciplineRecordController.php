<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DisciplineRecord;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class DisciplineRecordController extends Controller
{
    /**
     * Tampilkan daftar record.
     * Admin: lihat semua record, boleh filter kelas apapun + cari nama siswa.
     * Guru: hanya lihat record siswa di kelasnya sendiri, filter kelas disembunyikan (percuma), cari nama tetap bisa.
     */
    public function index(Request $request)
    {
        $records = $this->visibleRecordsQuery($request->user(), $request)->paginate(20)->withQueryString();

        $classes = $request->user()->isAdmin() ? SchoolClass::orderBy('name')->get() : collect();

        return view('records.index', compact('records', 'classes'));
    }

    /**
     * Export daftar catatan disiplin (sesuai batasan role & filter yang aktif) ke file Excel (.xlsx).
     */
    public function exportExcel(Request $request)
    {
        try {
            $records = $this->visibleRecordsQuery($request->user(), $request)->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Catatan Disiplin');

            $headers = ['Tanggal', 'Siswa', 'Kode', 'Kategori', 'Tingkat', 'Poin', 'Dicatat Oleh'];
            $sheet->fromArray($headers, null, 'A1');
            $sheet->getStyle('A1:G1')->getFont()->setBold(true);

            $row = 2;
            foreach ($records as $record) {
                $sheet->setCellValue("A{$row}", $record->date->format('d M Y'));
                $sheet->setCellValue("B{$row}", $record->student->name);
                $sheet->setCellValue("C{$row}", $record->category->code ?? '-');
                $sheet->setCellValue("D{$row}", $record->category->name ?? '-');
                $sheet->setCellValue("E{$row}", $record->category->severityLabel() ?? '-');
                $sheet->setCellValueExplicit(
                    "F{$row}",
                    $record->category->points ?? 0,
                    \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC
                );
                $sheet->setCellValue("G{$row}", $record->recordedBy->name ?? '-');
                $row++;
            }

            foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G'] as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $filename = 'catatan-disiplin-' . ($request->filled('month') ? $request->month : now()->format('Y-m-d')) . '.xlsx';

            return response()->streamDownload(function () use ($spreadsheet) {
                (new Xlsx($spreadsheet))->save('php://output');
            }, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal membuat file Excel. Silakan coba lagi.');
        }
    }

    /**
     * Export daftar catatan disiplin (sesuai batasan role & filter yang aktif) ke file PDF.
     */
    public function exportPdf(Request $request)
    {
        try {
            $records = $this->visibleRecordsQuery($request->user(), $request)->get();

            $pdf = Pdf::loadView('records.pdf', [
                'records' => $records,
                'generatedAt' => now(),
            ])->setPaper('a4', 'landscape');

            $filename = 'catatan-disiplin-' . ($request->filled('month') ? $request->month : now()->format('Y-m-d')) . '.pdf';

            return $pdf->download($filename);
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal membuat file PDF. Silakan coba lagi.');
        }
    }

    /**
     * Query dasar daftar catatan disiplin yang boleh dilihat user saat ini,
     * dipakai bersama oleh tampilan halaman, export Excel, dan export PDF
     * supaya datanya selalu konsisten (termasuk batasan role guru vs admin
     * dan filter kelas/pencarian nama yang sedang aktif).
     */
    private function visibleRecordsQuery($user, ?Request $request = null)
    {
        $query = DisciplineRecord::with(['student', 'category', 'recordedBy'])
            ->latest('date');

        if (!$user->isAdmin()) {
            // Batasan eksplisit: guru hanya boleh lihat data kelasnya.
            // Ditulis di sini (bukan lewat global scope) supaya jelas terbaca
            // saat code review dan tidak "hilang" di lapisan model.
            $query->whereHas('student', function ($q) use ($user) {
                $q->where('class_id', $user->class_id);
            });
        } elseif ($request?->filled('class_id')) {
            // Filter kelas cuma berlaku untuk admin — guru sudah otomatis dibatasi di atas.
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        if ($request?->filled('search')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter bulan (format "YYYY-MM"), dipakai untuk export laporan bulanan dari Dashboard
        if ($request?->filled('month')) {
            try {
                $monthDate = \Illuminate\Support\Carbon::createFromFormat('Y-m', $request->month);
                $query->whereYear('date', $monthDate->year)->whereMonth('date', $monthDate->month);
            } catch (\Exception $e) {
                // Format bulan tidak valid, abaikan filter ini
            }
        }

        return $query;
    }

    public function create(Request $request)
    {
        $user = $request->user();

        // Guru hanya boleh pilih siswa dari kelasnya sendiri di dropdown form.
        // Diurutkan berdasarkan kelas lalu alfabet nama supaya dropdown-nya rapi.
        $studentsQuery = Student::query()
            ->select('students.*')
            ->join('classes', 'classes.id', '=', 'students.class_id');

        if (!$user->isAdmin()) {
            $studentsQuery->where('students.class_id', $user->class_id);
        }

        $students = $studentsQuery
            ->orderBy('classes.name')
            ->orderBy('students.name')
            ->get();

        $categories = Category::all()->sort(function ($a, $b) {
            return strnatcasecmp($a->code ?: $a->name, $b->code ?: $b->name);
        })->values();

        return view('records.create', compact('students', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $user = $request->user();
        $student = Student::findOrFail($validated['student_id']);

        // Pengecekan keamanan di server side: walaupun dropdown di form sudah
        // difilter, guru bisa saja mengirim student_id lain lewat request manual.
        // Ini validasi wajib, bukan sekadar UI filter.
        if (!$user->isAdmin() && $student->class_id !== $user->class_id) {
            abort(403, 'Anda hanya dapat mencatat siswa di kelas Anda sendiri.');
        }

        DisciplineRecord::create([
            ...$validated,
            'recorded_by' => $user->id,
        ]);

        return redirect()
            ->route('records.index')
            ->with('success', 'Catatan disiplin berhasil disimpan.');
    }

    public function destroy(Request $request, DisciplineRecord $record)
    {
        $user = $request->user();

        if (!$user->isAdmin() && $record->student->class_id !== $user->class_id) {
            abort(403);
        }

        $record->delete();

        return back()->with('success', 'Catatan dihapus.');
    }
}
