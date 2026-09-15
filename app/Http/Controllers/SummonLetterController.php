<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Student;
use App\Models\SummonLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SummonLetterController extends Controller
{
    /**
     * Halaman utama: antrian siswa yang perlu dipanggil + riwayat surat yang sudah dibuat.
     * Guru hanya melihat siswa di kelasnya sendiri, sama seperti halaman lain.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $threshold = SiteSetting::current()->summon_letter_threshold ?? -100;

        $studentsQuery = Student::with('schoolClass');
        if (!$user->isAdmin()) {
            $studentsQuery->where('class_id', $user->class_id);
        }
        $students = $studentsQuery->get();

        // Hitung siswa mana saja yang berada di "antrian" (perlu surat baru)
        $queue = $students->map(function ($student) use ($threshold) {
            $totalPoints = $student->totalPoints();
            $lastLetter = $student->summonLetters()->latest('id')->first();
            $baseline = $lastLetter ? $lastLetter->points_at_generation : 0;

            $eligible = $totalPoints <= ($baseline + $threshold);

            return $eligible ? [
                'student' => $student,
                'total_points' => $totalPoints,
            ] : null;
        })->filter()->values();

        $historyQuery = SummonLetter::with(['student.schoolClass', 'generatedBy']);
        if (!$user->isAdmin()) {
            $historyQuery->whereHas('student', function ($q) use ($user) {
                $q->where('class_id', $user->class_id);
            });
        }
        $history = $historyQuery->latest('id')->paginate(15);

        return view('summon-letters.index', compact('queue', 'history', 'threshold'));
    }

    public function create(Request $request, Student $student)
    {
        $user = $request->user();
        if (!$user->isAdmin()) {
            abort(403, 'Hanya admin yang dapat membuat surat pemanggilan.');
        }

        return view('summon-letters.create', [
            'student' => $student,
            'totalPoints' => $student->totalPoints(),
        ]);
    }

    public function store(Request $request, Student $student)
    {
        $user = $request->user();
        if (!$user->isAdmin()) {
            abort(403, 'Hanya admin yang dapat membuat surat pemanggilan.');
        }

        $validated = $request->validate([
            'meeting_date' => ['required', 'date', 'after_or_equal:today'],
            'meeting_time' => ['required', 'string', 'max:10'],
        ]);

        // Percobaan ulang maksimal 3x kalau nomor surat kebetulan bentrok
        // (misal 2 staff generate surat di detik yang sama persis).
        $letter = null;
        $attempts = 0;

        while (!$letter && $attempts < 3) {
            $attempts++;

            try {
                $letter = SummonLetter::create([
                    'student_id' => $student->id,
                    'letter_number' => $this->generateLetterNumber(),
                    'points_at_generation' => $student->totalPoints(),
                    'meeting_date' => $validated['meeting_date'],
                    'meeting_time' => $validated['meeting_time'],
                    'generated_by' => $user->id,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($attempts >= 3) {
                    report($e);

                    return back()->with('error', 'Gagal membuat surat karena benturan nomor. Silakan coba lagi.');
                }
                // lanjut ke percobaan berikutnya dengan nomor baru
            }
        }

        return redirect()->route('summon.pdf', $letter);
    }

    /**
     * Nomor surat otomatis, format: 001/SDITBN/S.Pem/VII/2026
     * Urut nomor global (semua surat yang pernah dibuat), bulan dalam angka Romawi.
     */
    private function generateLetterNumber(): string
    {
        $nextNumber = SummonLetter::count() + 1;
        $sequence = str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);

        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = $romanMonths[now()->month - 1];
        $year = now()->year;

        return "{$sequence}/SDITBN/S.Pem/{$month}/{$year}";
    }

    public function pdf(Request $request, SummonLetter $letter)
    {
        $user = $request->user();
        if (!$user->isAdmin() && $letter->student->class_id !== $user->class_id) {
            abort(403);
        }

        try {
            $setting = SiteSetting::current();
            $letter->load('student.schoolClass');

            $pdf = Pdf::loadView('summon-letters.pdf', [
                'letter' => $letter,
                'setting' => $setting,
            ])->setPaper('a4', 'portrait');

            return $pdf->stream('surat-pemanggilan-' . str_replace('/', '-', $letter->letter_number) . '.pdf');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal membuat file PDF surat. Silakan coba lagi.');
        }
    }
}
