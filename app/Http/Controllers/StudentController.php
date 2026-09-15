<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

// index() bisa diakses admin & guru (role:admin,guru).
// Method lain (create/store/edit/update/destroy/import) dibatasi khusus role:admin di routes/web.php.
class StudentController extends Controller
{
    /**
     * Daftar siswa dengan filter kelas & pencarian nama.
     * Admin: lihat semua siswa, boleh filter berdasarkan kelas apapun.
     * Guru: otomatis dibatasi hanya siswa di kelasnya sendiri (filter kelas disembunyikan di view).
     * Diurutkan berdasarkan kelas dulu, baru alfabet nama di dalam kelas tersebut.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Student::query()
            ->select('students.*')
            ->join('classes', 'classes.id', '=', 'students.class_id')
            ->with('schoolClass');

        if (!$user->isAdmin()) {
            $query->where('students.class_id', $user->class_id);
        } elseif ($request->filled('class_id')) {
            $query->where('students.class_id', $request->class_id);
        }

        if ($request->filled('search')) {
            $query->where('students.name', 'like', '%' . $request->search . '%');
        }

        $students = $query
            ->orderBy('classes.name')
            ->orderBy('students.name')
            ->paginate(20)
            ->withQueryString();

        // Dropdown kelas cuma dibutuhkan admin; guru sudah otomatis dibatasi ke kelasnya.
        $classes = $user->isAdmin() ? SchoolClass::orderBy('name')->get() : collect();

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();
        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'unique:students,nis'],
            'name' => ['required', 'string', 'max:255'],
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Siswa ditambahkan.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return back()->with('success', 'Siswa dihapus.');
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::orderBy('name')->get();
        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'unique:students,nis,' . $student->id],
            'name' => ['required', 'string', 'max:255'],
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa diperbarui.');
    }

    public function importForm()
    {
        return view('students.import');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'excel_file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($validated['excel_file']->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            // toArray dengan key kolom huruf (A, B, C, ...) supaya urutan kolom jelas dibaca
            $rows = $sheet->toArray(null, true, true, true);
        } catch (\Throwable $e) {
            report($e); // tetap dicatat ke log untuk keperluan debugging

            return back()->with('error', 'File tidak bisa dibaca. Pastikan file Excel/CSV tidak rusak dan formatnya sesuai contoh.');
        }

        $classes = SchoolClass::all();

        $created = 0;
        $skipped = [];

        foreach ($rows as $rowNumber => $row) {
            // Baris 1 diasumsikan header (NIS, Nama, Kelas) — dilewati
            if ($rowNumber === 1) {
                continue;
            }

            $nis = trim((string) ($row['A'] ?? ''));
            $name = trim((string) ($row['B'] ?? ''));
            $kelasText = trim((string) ($row['C'] ?? ''));

            if ($nis === '' || $name === '' || $kelasText === '') {
                continue; // baris kosong, lewati tanpa dianggap error
            }

            // Cocokkan kolom "Kelas" di Excel dengan data kelas di database.
            // Cocok persis nama lengkap ATAU cocok kode singkat sebelum tanda " - " (misal "1A").
            $class = $classes->first(function ($c) use ($kelasText) {
                if (strcasecmp($c->name, $kelasText) === 0) {
                    return true;
                }
                $shortCode = trim(explode('-', $c->name)[0]);
                return strcasecmp($shortCode, $kelasText) === 0;
            });

            if (!$class) {
                $skipped[] = "Baris $rowNumber: kelas \"$kelasText\" tidak ditemukan (NIS $nis dilewati)";
                continue;
            }

            if (Student::where('nis', $nis)->exists()) {
                $skipped[] = "Baris $rowNumber: NIS $nis sudah terdaftar (dilewati)";
                continue;
            }

            Student::create([
                'nis' => $nis,
                'name' => $name,
                'class_id' => $class->id,
            ]);

            $created++;
        }

        return redirect()
            ->route('students.index')
            ->with('success', "$created siswa berhasil di-import dari Excel.")
            ->with('import_skipped', $skipped);
    }
}
