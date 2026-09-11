<?php

namespace App\Http\Controllers;

use App\Models\DisciplineRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $period = $request->query('period', 'week'); // 'week' atau 'month'

        if ($period === 'month') {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        } else {
            $period = 'week';
            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
        }

        $query = DisciplineRecord::with('category')
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()]);

        // Guru hanya lihat statistik siswa di kelasnya sendiri, sama seperti halaman lain
        if (!$user->isAdmin()) {
            $query->whereHas('student', function ($q) use ($user) {
                $q->where('class_id', $user->class_id);
            });
        }

        $records = $query->get();

        $totalPositif = $records->filter(fn ($r) => $r->category->type === 'positif')->count();
        $totalNegatif = $records->filter(fn ($r) => $r->category->type === 'negatif')->count();
        $netPoin = $records->sum(fn ($r) => $r->category->points);

        // Breakdown tingkat keparahan untuk chart
        $severityCounts = [
            'ringan' => $records->filter(fn ($r) => $r->category->severity === 'ringan')->count(),
            'sedang' => $records->filter(fn ($r) => $r->category->severity === 'sedang')->count(),
            'berat' => $records->filter(fn ($r) => $r->category->severity === 'berat')->count(),
        ];

        // Data harian untuk chart tren (positif vs negatif per hari dalam periode)
        $dailyLabels = [];
        $dailyPositif = [];
        $dailyNegatif = [];

        $cursor = $start->copy();
        while ($cursor->lte($end) && $cursor->lte(Carbon::now())) {
            $dateStr = $cursor->toDateString();
            $dailyLabels[] = $cursor->translatedFormat('d M');
            $dailyPositif[] = $records->filter(fn ($r) => $r->date->toDateString() === $dateStr && $r->category->type === 'positif')->count();
            $dailyNegatif[] = $records->filter(fn ($r) => $r->date->toDateString() === $dateStr && $r->category->type === 'negatif')->count();
            $cursor->addDay();
        }

        return view('dashboard', [
            'period' => $period,
            'totalPositif' => $totalPositif,
            'totalNegatif' => $totalNegatif,
            'netPoin' => $netPoin,
            'severityCounts' => $severityCounts,
            'dailyLabels' => $dailyLabels,
            'dailyPositif' => $dailyPositif,
            'dailyNegatif' => $dailyNegatif,
        ]);
    }
}
