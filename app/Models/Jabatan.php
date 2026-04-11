<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Jabatan extends Model {
    use SoftDeletes;
    protected $fillable = ['departemen_id','nama','level','grade','is_active'];
    protected $casts = ['is_active'=>'boolean','grade'=>'integer'];
    public function departemen(){ return $this->belongsTo(Departemen::class); }
    public function karyawans() { return $this->hasMany(Karyawan::class); }
    public function scopeActive($q){ return $q->where('is_active',true); }
}
