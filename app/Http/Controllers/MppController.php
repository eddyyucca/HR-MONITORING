<?php
namespace App\Http\Controllers;

use App\Models\MppPosition;
use App\Models\Divisi;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MppController extends Controller
{
    public function index(Request $request)
    {
        $year    = $request->get('year', date('Y'));
        $divisis = Divisi::active()->orderBy('nama')->get();
        $filters = $request->only(['year','divisi_id','category_grade','search']);

        // Summary per divisi
        $summary = MppPosition::byYear($year)->active()
            ->select('divisi_id',
                DB::raw('count(*) as total_posisi'),
                DB::raw('SUM(mpp_jan+mpp_feb+mpp_mar+mpp_apr+mpp_may+mpp_jun+mpp_jul+mpp_aug+mpp_sep+mpp_oct+mpp_nov+mpp_dec) as total_mpp'),
                DB::raw('SUM(existing_jan+existing_feb+existing_mar+existing_apr+existing_may+existing_jun+existing_jul+existing_aug+existing_sep+existing_oct+existing_nov+existing_dec) as total_existing')
            )
            ->with('divisi:id,nama')
            ->groupBy('divisi_id')
            ->orderByDesc('total_posisi')
            ->get();

        $totalMpp      = MppPosition::byYear($year)->active()->count();
        $totalKaryawan = Karyawan::active()->count();
        $years         = MppPosition::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('mpp.index', compact('year','divisis','filters','summary','totalMpp','totalKaryawan','years'));
    }

    public function datatables(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $q = MppPosition::with(['divisi','departemen'])->byYear($year)->active()->select('mpp_positions.*');

        if ($v = $request->divisi_id)      $q->where('divisi_id', $v);
        if ($v = $request->category_grade) $q->where('category_grade', $v);
        if ($v = $request->search)         $q->where('job_title','like',"%$v%");

        return datatables()->of($q)
            ->addIndexColumn()
            ->addColumn('divisi_nama',   fn($r) => $r->divisi?->nama ?? '—')
            ->addColumn('dept_nama',     fn($r) => $r->departemen?->nama ?? '—')
            ->addColumn('mpp_total_col', fn($r) => $r->mpp_total)
            ->addColumn('action', function($r) {
                $show = route('mpp.show',   $r->id);
                $edit = route('mpp.edit',   $r->id);
                $del  = route('mpp.destroy', $r->id);
                return '
                <div class="btn-group btn-group-sm">
                  <a href="'.$show.'" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                  <a href="'.$edit.'" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a>
                  <button onclick="confirmDelete('.$r->id.',\''.$del.'\')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $divisis     = Divisi::active()->orderBy('nama')->get();
        $departemens = Departemen::active()->orderBy('nama')->get();
        $gradeOptions = MppPosition::gradeOptions();
        $months      = MppPosition::monthColumns();
        $years       = [date('Y'), date('Y')+1, date('Y')+2];
        return view('mpp.create', compact('divisis','departemens','gradeOptions','months','years'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tahun'          => 'required|integer|min:2020|max:2030',
            'job_title'      => 'required|string|max:200',
            'app_name'       => 'nullable|string|max:300',
            'cost_centre'    => 'nullable|string|max:100',
            'site'           => 'nullable|string|max:100',
            'departemen_id'  => 'nullable|exists:departemens,id',
            'divisi_id'      => 'nullable|exists:divisis,id',
            'category_grade' => 'nullable|string|max:100',
            'remarks'        => 'nullable|string',
        ]);
        // Monthly MPP + existing
        foreach (array_keys(MppPosition::monthColumns()) as $m) {
            $data["mpp_$m"]      = $request->input("mpp_$m", 0);
            $data["existing_$m"] = $request->input("existing_$m", 0);
        }
        $data['is_active']  = true;
        $data['created_by'] = auth()->id();

        $mpp = MppPosition::create($data);
        ActivityLog::log('mpp', 'create', $mpp, [], $mpp->toArray());

        return redirect()->route('mpp.index')->with('success', 'Posisi MPP berhasil ditambahkan.');
    }

    public function show($id)
    {
        $mpp = MppPosition::with(['divisi','departemen'])->findOrFail($id);
        $months = MppPosition::monthColumns();
        return view('mpp.show', compact('mpp','months'));
    }

    public function edit($id)
    {
        $mpp         = MppPosition::findOrFail($id);
        $divisis     = Divisi::active()->orderBy('nama')->get();
        $departemens = Departemen::active()->orderBy('nama')->get();
        $gradeOptions = MppPosition::gradeOptions();
        $months      = MppPosition::monthColumns();
        return view('mpp.edit', compact('mpp','divisis','departemens','gradeOptions','months'));
    }

    public function update(Request $request, $id)
    {
        $mpp  = MppPosition::findOrFail($id);
        $data = $request->validate([
            'tahun'          => 'required|integer|min:2020|max:2030',
            'job_title'      => 'required|string|max:200',
            'app_name'       => 'nullable|string|max:300',
            'cost_centre'    => 'nullable|string|max:100',
            'site'           => 'nullable|string|max:100',
            'departemen_id'  => 'nullable|exists:departemens,id',
            'divisi_id'      => 'nullable|exists:divisis,id',
            'category_grade' => 'nullable|string|max:100',
            'remarks'        => 'nullable|string',
        ]);
        foreach (array_keys(MppPosition::monthColumns()) as $m) {
            $data["mpp_$m"]      = $request->input("mpp_$m", 0);
            $data["existing_$m"] = $request->input("existing_$m", 0);
        }
        $data['updated_by'] = auth()->id();

        $old = $mpp->toArray();
        $mpp->update($data);
        ActivityLog::log('mpp', 'update', $mpp, $old, $mpp->fresh()->toArray());

        return redirect()->route('mpp.index')->with('success', 'Posisi MPP berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mpp = MppPosition::findOrFail($id);
        ActivityLog::log('mpp', 'delete', $mpp, $mpp->toArray(), []);
        $mpp->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
    }

    public function gapAnalysis(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $mppPerDivisi = MppPosition::byYear($year)->active()
            ->select('divisi_id', DB::raw('count(*) as total_mpp'))
            ->with('divisi:id,nama')->groupBy('divisi_id')->get();

        $karPerDivisi = Karyawan::active()
            ->select('divisi_id', DB::raw('count(*) as total_kar'))
            ->groupBy('divisi_id')->get()->keyBy('divisi_id');

        $years = MppPosition::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');
        return view('mpp.gap', compact('mppPerDivisi','karPerDivisi','year','years'));
    }

    public function exportExcel()
    {
        return back()->with('info', 'Fitur export sedang dikembangkan.');
    }
}
