<?php
namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Departemen;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    // ─── DIVISI ─────────────────────────────────────────────
    public function divisiIndex()
    {
        $divisis = Divisi::withCount(['departemens','karyawans','rekrutmens'])
            ->orderBy('nama')->get();
        return view('master.divisi', compact('divisis'));
    }

    public function divisiStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:200|unique:divisis,nama',
            'kode' => 'nullable|string|max:10',
        ]);
        $data['is_active'] = true;
        Divisi::create($data);
        return response()->json(['success' => true, 'message' => 'Divisi berhasil ditambahkan.']);
    }

    public function divisiUpdate(Request $request, $id)
    {
        $divisi = Divisi::findOrFail($id);
        $data = $request->validate([
            'nama'      => 'required|string|max:200|unique:divisis,nama,'.$id,
            'kode'      => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);
        $divisi->update($data);
        return response()->json(['success' => true, 'message' => 'Divisi berhasil diperbarui.']);
    }

    public function divisiDestroy($id)
    {
        $divisi = Divisi::findOrFail($id);
        if ($divisi->karyawans()->count() > 0 || $divisi->rekrutmens()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Divisi tidak dapat dihapus karena masih digunakan.'], 422);
        }
        $divisi->delete();
        return response()->json(['success' => true, 'message' => 'Divisi berhasil dihapus.']);
    }

    // ─── DEPARTEMEN ──────────────────────────────────────────
    public function deptIndex()
    {
        $departemens = Departemen::with('divisi')
            ->withCount(['karyawans','rekrutmens'])
            ->orderBy('nama')->get();
        $divisis = Divisi::active()->orderBy('nama')->get();
        return view('master.departemen', compact('departemens','divisis'));
    }

    public function deptStore(Request $request)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:200|unique:departemens,nama',
            'divisi_id' => 'nullable|exists:divisis,id',
            'kode'      => 'nullable|string|max:10',
        ]);
        $data['is_active'] = true;
        Departemen::create($data);
        return response()->json(['success' => true, 'message' => 'Departemen berhasil ditambahkan.']);
    }

    public function deptUpdate(Request $request, $id)
    {
        $dept = Departemen::findOrFail($id);
        $data = $request->validate([
            'nama'      => 'required|string|max:200|unique:departemens,nama,'.$id,
            'divisi_id' => 'nullable|exists:divisis,id',
            'kode'      => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);
        $dept->update($data);
        return response()->json(['success' => true, 'message' => 'Departemen berhasil diperbarui.']);
    }

    public function deptDestroy($id)
    {
        $dept = Departemen::findOrFail($id);
        if ($dept->karyawans()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Departemen masih digunakan.'], 422);
        }
        $dept->delete();
        return response()->json(['success' => true, 'message' => 'Departemen berhasil dihapus.']);
    }

    public function deptByDivisi($divisiId)
    {
        $depts = Departemen::where('divisi_id', $divisiId)->active()->orderBy('nama')->get(['id','nama']);
        return response()->json($depts);
    }

    // ─── JABATAN ─────────────────────────────────────────────
    public function jabatanIndex()
    {
        $jabatans    = Jabatan::with('departemen.divisi')->withCount('karyawans')->orderBy('nama')->get();
        $departemens = Departemen::active()->with('divisi')->orderBy('nama')->get();
        return view('master.jabatan', compact('jabatans','departemens'));
    }

    public function jabatanStore(Request $request)
    {
        $data = $request->validate([
            'nama'         => 'required|string|max:200',
            'departemen_id'=> 'nullable|exists:departemens,id',
            'level'        => 'nullable|string|max:100',
            'grade'        => 'nullable|integer|min:1|max:20',
        ]);
        $data['is_active'] = true;
        Jabatan::create($data);
        return response()->json(['success' => true, 'message' => 'Jabatan berhasil ditambahkan.']);
    }

    public function jabatanUpdate(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $data = $request->validate([
            'nama'         => 'required|string|max:200',
            'departemen_id'=> 'nullable|exists:departemens,id',
            'level'        => 'nullable|string|max:100',
            'grade'        => 'nullable|integer|min:1|max:20',
            'is_active'    => 'boolean',
        ]);
        $jabatan->update($data);
        return response()->json(['success' => true, 'message' => 'Jabatan berhasil diperbarui.']);
    }

    public function jabatanDestroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        if ($jabatan->karyawans()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Jabatan masih digunakan.'], 422);
        }
        $jabatan->delete();
        return response()->json(['success' => true, 'message' => 'Jabatan berhasil dihapus.']);
    }

    public function jabatanByDept($deptId)
    {
        $jabatans = Jabatan::where('departemen_id', $deptId)->active()->orderBy('nama')->get(['id','nama','level','grade']);
        return response()->json($jabatans);
    }
}
