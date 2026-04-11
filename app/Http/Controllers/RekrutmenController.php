<?php
namespace App\Http\Controllers;

use App\Models\Rekrutmen;
use App\Models\Divisi;
use App\Models\Departemen;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekrutmenController extends Controller
{
    public function index(Request $request)
    {
        $years    = Rekrutmen::select('year')->distinct()->orderByDesc('year')->pluck('year');
        $divisis  = Divisi::active()->orderBy('nama')->get();
        $filters  = $request->only(['year','month','progress','category_level','divisi_id','priority','sourch','gender','search']);
        return view('rekrutmen.index', compact('years','divisis','filters'));
    }

    public function datatables(Request $request)
    {
        $q = Rekrutmen::with(['divisi','departemen'])
            ->select('rekrutmens.*');

        if ($v = $request->year)           $q->where('year', $v);
        if ($v = $request->month)          $q->where('month_number', $v);
        if ($v = $request->progress)       $q->where('progress', $v);
        if ($v = $request->category_level) $q->where('category_level', $v);
        if ($v = $request->divisi_id)      $q->where('divisi_id', $v);
        if ($v = $request->priority)       $q->where('priority', $v);
        if ($v = $request->sourch)         $q->where('sourch', $v);
        if ($v = $request->gender)         $q->where('gender', $v);
        if ($v = $request->search) {
            $q->where(function($sub) use ($v) {
                $sub->where('nama_lengkap','like',"%$v%")
                    ->orWhere('plan_job_title','like',"%$v%");
            });
        }

        return datatables()->of($q)
            ->addIndexColumn()
            ->addColumn('progress_badge', fn($r) => $r->progress_badge)
            ->addColumn('priority_badge', fn($r) => $r->priority_badge)
            ->addColumn('divisi_nama',    fn($r) => $r->divisi?->nama ?? '—')
            ->addColumn('dept_nama',      fn($r) => $r->departemen?->nama ?? '—')
            ->addColumn('sla_html', function($r) {
                if (!$r->sla) return '<span class="text-muted">—</span>';
                $color = $r->sla_color;
                return "<span class=\"text-$color font-weight-bold\">{$r->sla} hari</span>";
            })
            ->addColumn('action', function($r) {
                $show   = route('rekrutmen.show',   $r->id);
                $edit   = route('rekrutmen.edit',   $r->id);
                $del    = route('rekrutmen.destroy', $r->id);
                return '
                <div class="btn-group btn-group-sm">
                  <a href="'.$show.'" class="btn btn-info btn-xs" title="Detail"><i class="fas fa-eye"></i></a>
                  <a href="'.$edit.'" class="btn btn-warning btn-xs" title="Edit"><i class="fas fa-edit"></i></a>
                  <button onclick="confirmDelete('.$r->id.',\''.$del.'\')" class="btn btn-danger btn-xs" title="Hapus"><i class="fas fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['progress_badge','priority_badge','sla_html','action'])
            ->make(true);
    }

    public function create()
    {
        $divisis    = Divisi::active()->orderBy('nama')->get();
        $departemens = Departemen::active()->orderBy('nama')->get();
        $progressOptions = Rekrutmen::progressOptions();
        $levelOptions    = Rekrutmen::levelOptions();
        $sourchOptions   = Rekrutmen::sourchOptions();
        $months = Rekrutmen::monthMap();
        return view('rekrutmen.create', compact('divisis','departemens','progressOptions','levelOptions','sourchOptions','months'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap'   => 'required|string|max:200',
            'no_telp'        => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:200',
            'gender'         => 'nullable|in:Male,Female',
            'plan_job_title' => 'required|string|max:200',
            'departemen_id'  => 'nullable|exists:departemens,id',
            'divisi_id'      => 'nullable|exists:divisis,id',
            'category_level' => 'nullable|string|max:100',
            'status'         => 'required|in:Open,In Progress,Closed',
            'progress'       => 'required|string|max:100',
            'priority'       => 'nullable|in:P1,P2,P3,NP',
            'status_ata'     => 'nullable|in:Full Approval,Not Yet,Pending',
            'sourch'         => 'nullable|string|max:50',
            'user_pic'       => 'nullable|string|max:100',
            'site'           => 'nullable|string|max:100',
            'date_approved'  => 'nullable|date',
            'date_progress'  => 'nullable|date',
            'month_number'   => 'nullable|integer|min:1|max:12',
            'year'           => 'nullable|integer|min:2020|max:2030',
            'sla'            => 'nullable|numeric|min:0',
            'remarks'        => 'nullable|string',
        ]);

        if ($data['month_number']) {
            $data['month_name'] = Rekrutmen::monthMap()[$data['month_number']];
        }
        $data['created_by'] = auth()->id();

        $rek = Rekrutmen::create($data);
        ActivityLog::log('rekrutmen', 'create', $rek, [], $rek->toArray());

        return redirect()->route('rekrutmen.index')->with('success', 'Kandidat berhasil ditambahkan.');
    }

    public function show($id)
    {
        $rek = Rekrutmen::with(['divisi','departemen','karyawan'])->findOrFail($id);
        return view('rekrutmen.show', compact('rek'));
    }

    public function edit($id)
    {
        $rek         = Rekrutmen::findOrFail($id);
        $divisis     = Divisi::active()->orderBy('nama')->get();
        $departemens = Departemen::active()->orderBy('nama')->get();
        $progressOptions = Rekrutmen::progressOptions();
        $levelOptions    = Rekrutmen::levelOptions();
        $sourchOptions   = Rekrutmen::sourchOptions();
        $months = Rekrutmen::monthMap();
        return view('rekrutmen.edit', compact('rek','divisis','departemens','progressOptions','levelOptions','sourchOptions','months'));
    }

    public function update(Request $request, $id)
    {
        $rek  = Rekrutmen::findOrFail($id);
        $data = $request->validate([
            'nama_lengkap'   => 'required|string|max:200',
            'no_telp'        => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:200',
            'gender'         => 'nullable|in:Male,Female',
            'plan_job_title' => 'required|string|max:200',
            'departemen_id'  => 'nullable|exists:departemens,id',
            'divisi_id'      => 'nullable|exists:divisis,id',
            'category_level' => 'nullable|string|max:100',
            'status'         => 'required|in:Open,In Progress,Closed',
            'progress'       => 'required|string|max:100',
            'priority'       => 'nullable|in:P1,P2,P3,NP',
            'status_ata'     => 'nullable|in:Full Approval,Not Yet,Pending',
            'sourch'         => 'nullable|string|max:50',
            'user_pic'       => 'nullable|string|max:100',
            'site'           => 'nullable|string|max:100',
            'date_approved'  => 'nullable|date',
            'date_progress'  => 'nullable|date',
            'month_number'   => 'nullable|integer|min:1|max:12',
            'year'           => 'nullable|integer|min:2020|max:2030',
            'sla'            => 'nullable|numeric|min:0',
            'remarks'        => 'nullable|string',
        ]);

        if (!empty($data['month_number'])) {
            $data['month_name'] = Rekrutmen::monthMap()[$data['month_number']];
        }
        $data['updated_by'] = auth()->id();

        $old = $rek->toArray();
        $rek->update($data);
        ActivityLog::log('rekrutmen', 'update', $rek, $old, $rek->fresh()->toArray());

        return redirect()->route('rekrutmen.index')->with('success', 'Data kandidat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rek = Rekrutmen::findOrFail($id);
        ActivityLog::log('rekrutmen', 'delete', $rek, $rek->toArray(), []);
        $rek->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
    }

    public function exportExcel(Request $request)
    {
        // TODO: implement dengan Maatwebsite Excel
        return back()->with('info', 'Fitur export sedang dikembangkan.');
    }
}
