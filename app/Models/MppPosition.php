<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MppPosition extends Model {
    use SoftDeletes;
    protected $fillable = [
        'tahun','job_title','app_name','cost_centre','site',
        'departemen_id','divisi_id','category_grade',
        'mpp_jan','mpp_feb','mpp_mar','mpp_apr','mpp_may','mpp_jun',
        'mpp_jul','mpp_aug','mpp_sep','mpp_oct','mpp_nov','mpp_dec',
        'existing_jan','existing_feb','existing_mar','existing_apr',
        'existing_may','existing_jun','existing_jul','existing_aug',
        'existing_sep','existing_oct','existing_nov','existing_dec',
        'remarks','is_active','created_by','updated_by',
    ];
    protected $casts = ['tahun'=>'integer','is_active'=>'boolean'];
    public function divisi()     { return $this->belongsTo(Divisi::class); }
    public function departemen() { return $this->belongsTo(Departemen::class); }
    public function createdBy()  { return $this->belongsTo(User::class,'created_by'); }
    public function scopeByYear($q,$y)  { return $q->where('tahun',$y); }
    public function scopeByDivisi($q,$id){ return $q->where('divisi_id',$id); }
    public function scopeActive($q)     { return $q->where('is_active',true); }
    public function getMppTotalAttribute(): int {
        return max($this->mpp_jan,$this->mpp_feb,$this->mpp_mar,$this->mpp_apr,
                   $this->mpp_may,$this->mpp_jun,$this->mpp_jul,$this->mpp_aug,
                   $this->mpp_sep,$this->mpp_oct,$this->mpp_nov,$this->mpp_dec);
    }
    public static function monthColumns(): array {
        return ['jan'=>'Januari','feb'=>'Februari','mar'=>'Maret','apr'=>'April',
                'may'=>'Mei','jun'=>'Juni','jul'=>'Juli','aug'=>'Agustus',
                'sep'=>'September','oct'=>'Oktober','nov'=>'November','dec'=>'Desember'];
    }
    public static function gradeOptions(): array {
        return ['Executive Committee','General Manager','Senior Manager','Manager',
                'Assistant Manager','Supervisor','Officer','Labour Supply','Non-Staff'];
    }
}
