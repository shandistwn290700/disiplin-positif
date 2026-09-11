<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Rekap total poin per siswa. Guru hanya lihat kelasnya, admin lihat semua.
     * Admin bisa filter kelas apapun + cari nama siswa; guru cuma bisa cari nama.
     */
    public function index(Request $request)
    {
        $students = $this->rekapPoinQuery($request->user(), $request)->paginate(20)->withQueryString();

        $classes = $request->user()->isAdmin() ? SchoolClass::orderBy('name')->get() : collect();

        return view('reports.index', compact('students', 'classes'));
    }

    /**
     * Export rekap poin (sesuai batasan role & filter yang aktif) ke file Excel (.xlsx).
     */
    public function exportExcel(Request $request)
    {
        $students = $this->rekapPoinQuery($request->user(), $request)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Poin');

        $sheet->fromArray(['Nama', 'Kelas', 'Total Poin'], null, 'A1');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $row = 2;
        foreach ($students as $student) {
            $sheet->setCellValue("A{$row}", $student->name);
            $sheet->setCellValue("B{$row}", $student->schoolClass->name ?? '-');
            $sheet->setCellValueExplicit(
                "C{$row}",
                $student->total_points,
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC
            );
            $row++;
        }

        foreach (['A', 'B', 'C'] as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'laporan-rekap-poin-' . now()->format('Y-m-d') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Export rekap poin (sesuai batasan role & filter yang aktif) ke file PDF.
     */
    public function exportPdf(Request $request)
    {
        $students = $this->rekapPoinQuery($request->user(), $request)->get();

        $pdf = Pdf::loadView('reports.pdf', [
            'students' => $students,
            'generatedAt' => now(),
        ])->setPaper('a4', 'portrait');

        $filename = 'laporan-rekap-poin-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Query dasar rekap total poin per siswa, dipakai bersama oleh
     * tampilan halaman, export Excel, dan export PDF supaya datanya
     * selalu konsisten (termasuk batasan role guru vs admin dan
     * filter kelas/pencarian nama yang sedang aktif).
     */
    private function rekapPoinQuery($user, ?Request $request = null)
    {
        $query = Student::query()
            ->select('students.*')
            ->selectSub(function ($sub) {
                $sub->from('discipline_records')
                    ->join('categories', 'categories.id', '=', 'discipline_records.category_id')
                    ->whereColumn('discipline_records.student_id', 'students.id')
                    ->selectRaw('COALESCE(SUM(categories.points), 0)');
            }, 'total_points')
            ->with('schoolClass');

        if (!$user->isAdmin()) {
            $query->where('class_id', $user->class_id);
        } elseif ($request?->filled('class_id')) {
            // Filter kelas cuma berlaku untuk admin — guru sudah otomatis dibatasi di atas.
            $query->where('class_id', $request->class_id);
        }

        if ($request?->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return $query->orderByDesc('total_points');
    }
}
