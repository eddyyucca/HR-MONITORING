<?php
namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Divisi;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Rekrutmen;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $tipe    = $request->get('tipe', 'all');
        $divisis = Divisi::active()->orderBy('nama')->get();
        $filters = $request->only(['tipe','status','divisi_id','level','terms','search']);
        $totalStaff    = Karyawan::staff()->active()->count();
        $totalNonStaff = Karyawan::nonStaff()->active()->count();
        return view('karyawan.index', compact('divisis','filters','tipe','totalStaff','totalNonStaff'));
    }

    public function staff(Request $request)
    {
        return redirect()->route('karyawan.index', array_merge($request->all(), ['tipe'=>'Staff']));
    }

    public function nonStaff(Request $request)
    {
        return redirect()->route('karyawan.index', array_merge($request->all(), ['tipe'=>'Non-Staff']));
    }

    public function datatables(Request $request)
    {
        $q = Karyawan::with(['divisi','departemen','jabatan'])->select('karyawans.*');

        if ($v = $request->tipe   and $v !== 'all') $q->where('tipe', $v);
        if ($v = $request->status)                  $q->where('status', $v);
        if ($v = $request->divisi_id)               $q->where('divisi_id', $v);
        if ($v = $request->level)                   $q->where('level', $v);
        if ($v = $request->terms)                   $q->where('terms', $v);
        if ($v = $request->search) {
            $q->where(function($sub) use ($v) {
                $sub->where('nama','like',"%$v%")
                    ->orWhere('position','like',"%$v%")
                    ->orWhere('no_karyawan','like',"%$v%");
            });
        }

        return datatables()->of($q)
            ->addIndexColumn()
            ->addColumn('tipe_badge',   fn($r) => $r->tipe_badge)
            ->addColumn('status_badge', fn($r) => $r->status_badge)
            ->addColumn('divisi_nama',  fn($r) => $r->divisi?->nama ?? '—')
            ->addColumn('dept_nama',    fn($r) => $r->departemen?->nama ?? '—')
            ->addColumn('gaji_fmt',     fn($r) => $r->basic_salary_formatted)
            ->addColumn('action', function($r) {
                $show = route('karyawan.show',   $r->id);
                $edit = route('karyawan.edit',   $r->id);
                $del  = route('karyawan.destroy', $r->id);
                return '
                <div class="btn-group btn-group-sm">
                  <a href="'.$show.'" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                  <a href="'.$edit.'" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a>
                  <button onclick="confirmDelete('.$r->id.',\''.$del.'\')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['tipe_badge','status_badge','gaji_fmt','action'])
            ->make(true);
    }

    public function create()
    {
        $divisis     = Divisi::active()->orderBy('nama')->get();
        $departemens = Departemen::active()->orderBy('nama')->get();
        $jabatans    = Jabatan::active()->orderBy('nama')->get();
        $rekrutmens  = Rekrutmen::where('progress','On Board')
            ->whereDoesntHave('karyawan')
            ->orderBy('nama_lengkap')->get();
        $levelOptions = Karyawan::levelOptions();
        return view('karyawan.create', compact('divisis','departemens','jabatans','rekrutmens','levelOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'salutation'         => 'nullable|string|max:10',
            'nama'               => 'required|string|max:200',
            'no_karyawan'        => 'nullable|string|max:50|unique:karyawans,no_karyawan',
            'alamat'             => 'nullable|string',
            'no_telp'            => 'nullable|string|max:30',
            'email'              => 'nullable|email|max:200',
            'company'            => 'nullable|string|max:200',
            'position'           => 'required|string|max:200',
            'jabatan_id'         => 'nullable|exists:jabatans,id',
            'departemen_id'      => 'nullable|exists:departemens,id',
            'divisi_id'          => 'nullable|exists:divisis,id',
            'work_location'      => 'nullable|string|max:100',
            'tipe'               => 'required|in:Staff,Non-Staff',
            'level'              => 'nullable|string|max:100',
            'level_direct_report'=> 'nullable|string|max:100',
            'grade'              => 'nullable|integer|min:1|max:20',
            'terms'              => 'required|in:PKWT,PKWTT',
            'durasi'             => 'nullable|string|max:50',
            'durasi_en'          => 'nullable|string|max:50',
            'status'             => 'required|in:Kontrak,Percobaan,Tetap,Selesai',
            'tgl_ol'             => 'nullable|date',
            'tgl_berakhir'       => 'nullable|date',
            'poh'                => 'nullable|string|max:100',
            'basic_salary'       => 'nullable|numeric|min:0',
            'weeks_on'           => 'nullable|integer|min:0',
            'weeks_off'          => 'nullable|integer|min:0',
            'inpatient_local'    => 'nullable|numeric|min:0',
            'inpatient_interlokal'=>'nullable|numeric|min:0',
            'outpatient'         => 'nullable|numeric|min:0',
            'frames'             => 'nullable|numeric|min:0',
            'lens'               => 'nullable|numeric|min:0',
            'signature_name'     => 'nullable|string|max:200',
            'signature_title'    => 'nullable|string|max:200',
            'rekrutmen_id'       => 'nullable|exists:rekrutmens,id',
        ]);
        $data['created_by'] = auth()->id();

        $kar = Karyawan::create($data);
        ActivityLog::log('karyawan', 'create', $kar, [], $kar->toArray());

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kar = Karyawan::with(['divisi','departemen','jabatan','rekrutmen'])->findOrFail($id);
        return view('karyawan.show', compact('kar'));
    }

    public function edit($id)
    {
        $kar         = Karyawan::findOrFail($id);
        $divisis     = Divisi::active()->orderBy('nama')->get();
        $departemens = Departemen::active()->orderBy('nama')->get();
        $jabatans    = Jabatan::active()->orderBy('nama')->get();
        $levelOptions = Karyawan::levelOptions();
        return view('karyawan.edit', compact('kar','divisis','departemens','jabatans','levelOptions'));
    }

    public function update(Request $request, $id)
    {
        $kar  = Karyawan::findOrFail($id);
        $data = $request->validate([
            'salutation'         => 'nullable|string|max:10',
            'nama'               => 'required|string|max:200',
            'no_karyawan'        => 'nullable|string|max:50|unique:karyawans,no_karyawan,'.$id,
            'alamat'             => 'nullable|string',
            'no_telp'            => 'nullable|string|max:30',
            'email'              => 'nullable|email|max:200',
            'company'            => 'nullable|string|max:200',
            'position'           => 'required|string|max:200',
            'jabatan_id'         => 'nullable|exists:jabatans,id',
            'departemen_id'      => 'nullable|exists:departemens,id',
            'divisi_id'          => 'nullable|exists:divisis,id',
            'work_location'      => 'nullable|string|max:100',
            'tipe'               => 'required|in:Staff,Non-Staff',
            'level'              => 'nullable|string|max:100',
            'level_direct_report'=> 'nullable|string|max:100',
            'grade'              => 'nullable|integer|min:1|max:20',
            'terms'              => 'required|in:PKWT,PKWTT',
            'durasi'             => 'nullable|string|max:50',
            'durasi_en'          => 'nullable|string|max:50',
            'status'             => 'required|in:Kontrak,Percobaan,Tetap,Selesai',
            'tgl_ol'             => 'nullable|date',
            'tgl_berakhir'       => 'nullable|date',
            'poh'                => 'nullable|string|max:100',
            'basic_salary'       => 'nullable|numeric|min:0',
            'weeks_on'           => 'nullable|integer|min:0',
            'weeks_off'          => 'nullable|integer|min:0',
            'inpatient_local'    => 'nullable|numeric|min:0',
            'inpatient_interlokal'=>'nullable|numeric|min:0',
            'outpatient'         => 'nullable|numeric|min:0',
            'frames'             => 'nullable|numeric|min:0',
            'lens'               => 'nullable|numeric|min:0',
            'signature_name'     => 'nullable|string|max:200',
            'signature_title'    => 'nullable|string|max:200',
        ]);
        $data['updated_by'] = auth()->id();

        $old = $kar->toArray();
        $kar->update($data);
        ActivityLog::log('karyawan', 'update', $kar, $old, $kar->fresh()->toArray());

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kar = Karyawan::findOrFail($id);
        ActivityLog::log('karyawan', 'delete', $kar, $kar->toArray(), []);
        $kar->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
    }

    public function exportExcel()
    {
        return back()->with('info', 'Fitur export sedang dikembangkan.');
    }
}
