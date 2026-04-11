<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\MppPosition;
use App\Models\Rekrutmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->get('year', date('Y'));

        // Helper: Rekrutmen query scoped to selected year
        $rek = fn () => Rekrutmen::byYear($year);

        // ── Karyawan ──────────────────────────────────────────────────
        $totalStaff    = Karyawan::staff()->active()->count();
        $totalNonStaff = Karyawan::nonStaff()->active()->count();
        $totalKaryawan = $totalStaff + $totalNonStaff;
        $staffKontrak  = Karyawan::staff()->kontrak()->count();
        $staffProb     = Karyawan::staff()->probation()->count();

        // ── Rekrutmen aggregates ──────────────────────────────────────
        $totalRek   = $rek()->count();
        $onBoard    = $rek()->onBoard()->count();
        $compro     = $rek()->active()->count();
        $failed     = $rek()->failed()->count();
        $conversion = $totalRek > 0 ? round($onBoard / $totalRek * 100, 1) : 0;

        // ── MPP ───────────────────────────────────────────────────────
        $totalMpp = MppPosition::byYear($year)->active()->count();

        // ── Chart data ────────────────────────────────────────────────
        $rekPerBulan = $rek()
            ->select('month_number', 'month_name', DB::raw('count(*) as total'))
            ->groupBy('month_number', 'month_name')
            ->orderBy('month_number')
            ->get();

        $rekPerProgress = $rek()
            ->select('progress', DB::raw('count(*) as total'))
            ->groupBy('progress')
            ->get()->pluck('total', 'progress');

        $rekPerDivisi = $rek()
            ->select('divisi_id', DB::raw('count(*) as total'))
            ->with('divisi:id,nama')
            ->groupBy('divisi_id')
            ->orderByDesc('total')
            ->take(10)->get();

        $rekPerLevel = $rek()
            ->select('category_level', DB::raw('count(*) as total'))
            ->groupBy('category_level')
            ->orderByDesc('total')
            ->get()->pluck('total', 'category_level');

        $rekPerPriority = $rek()
            ->select('priority', DB::raw('count(*) as total'))
            ->whereNotNull('priority')
            ->groupBy('priority')
            ->get()->pluck('total', 'priority');

        $rekPerSourch = $rek()
            ->select('sourch', DB::raw('count(*) as total'))
            ->groupBy('sourch')
            ->orderByDesc('total')
            ->get()->pluck('total', 'sourch');

        // ── Pipeline ──────────────────────────────────────────────────
        $pipeline = Rekrutmen::with('divisi')
            ->where('progress', 'Compro')
            ->orderByDesc('year')
            ->orderByDesc('month_number')
            ->take(10)->get();

        // ── Year selector (always include current year) ───────────────
        $availableYears = Rekrutmen::select('year')
            ->distinct()->orderByDesc('year')->pluck('year')
            ->prepend((int) date('Y'))->unique()->values();

        return view('dashboard.index', compact(
            'year', 'availableYears',
            'totalStaff', 'totalNonStaff', 'totalKaryawan',
            'staffKontrak', 'staffProb',
            'totalRek', 'onBoard', 'compro', 'failed', 'conversion',
            'totalMpp',
            'rekPerBulan', 'rekPerProgress', 'rekPerDivisi',
            'rekPerLevel', 'rekPerPriority', 'rekPerSourch',
            'pipeline'
        ));
    }

    public function stats(Request $request)
    {
        $year = (int) $request->get('year', date('Y'));

        return response()->json([
            'rekrutmen' => [
                'total'   => Rekrutmen::byYear($year)->count(),
                'onboard' => Rekrutmen::byYear($year)->onBoard()->count(),
                'compro'  => Rekrutmen::byYear($year)->active()->count(),
                'failed'  => Rekrutmen::byYear($year)->failed()->count(),
            ],
            'karyawan' => [
                'total'     => Karyawan::active()->count(),
                'staff'     => Karyawan::staff()->active()->count(),
                'non_staff' => Karyawan::nonStaff()->active()->count(),
            ],
            'mpp' => [
                'total' => MppPosition::byYear($year)->active()->count(),
            ],
        ]);
    }
}
