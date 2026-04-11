<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Departemen extends Model {
    use SoftDeletes;
    protected $fillable = ['divisi_id','nama','kode','is_active'];
    protected $casts = ['is_active'=>'boolean'];
    public function divisi()     { return $this->belongsTo(Divisi::class); }
    public function jabatans()   { return $this->hasMany(Jabatan::class); }
    public function rekrutmens() { return $this->hasMany(Rekrutmen::class); }
    public function karyawans()  { return $this->hasMany(Karyawan::class); }
    public function mppPositions(){ return $this->hasMany(MppPosition::class); }
    public function scopeActive($q){ return $q->where('is_active',true); }
}
