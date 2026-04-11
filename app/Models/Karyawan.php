<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model {
    use SoftDeletes;
    protected $fillable = [
        'salutation','nama','no_karyawan','alamat','no_telp','email',
        'company','position','jabatan_id','departemen_id','divisi_id',
        'work_location','tipe','level','level_direct_report','grade',
        'terms','durasi','durasi_en','status','tgl_ol','tgl_berakhir',
        'poh','basic_salary','nominal_terbilang','nominal_terbilang_id',
        'weeks_on','weeks_off','inpatient_local','inpatient_interlokal',
        'outpatient','frames','lens','signature_name','signature_title',
        'rekrutmen_id','created_by','updated_by',
    ];
    protected $casts = [
        'tgl_ol'=>'date','tgl_berakhir'=>'date',
        'basic_salary'=>'decimal:2','inpatient_local'=>'decimal:2',
        'inpatient_interlokal'=>'decimal:2','outpatient'=>'decimal:2',
        'frames'=>'decimal:2','lens'=>'decimal:2',
        'grade'=>'integer','weeks_on'=>'integer','weeks_off'=>'integer',
    ];
    public function divisi()     { return $this->belongsTo(Divisi::class); }
    public function departemen() { return $this->belongsTo(Departemen::class); }
    public function jabatan()    { return $this->belongsTo(Jabatan::class); }
    public function rekrutmen()  { return $this->belongsTo(Rekrutmen::class); }
    public function createdBy()  { return $this->belongsTo(User::class,'created_by'); }
    public function updatedBy()  { return $this->belongsTo(User::class,'updated_by'); }

    public function scopeStaff($q)         { return $q->where('tipe','Staff'); }
    public function scopeNonStaff($q)      { return $q->where('tipe','Non-Staff'); }
    public function scopeKontrak($q)       { return $q->where('status','Kontrak'); }
    public function scopeProbation($q)     { return $q->where('status','Percobaan'); }
    public function scopeActive($q)        { return $q->whereIn('status',['Kontrak','Percobaan','Tetap']); }
    public function scopeByDivisi($q,$id)  { return $q->where('divisi_id',$id); }

    public function getStatusBadgeAttribute(): string {
        return match($this->status) {
            'Kontrak'   => '<span class="badge badge-primary">Kontrak</span>',
            'Percobaan' => '<span class="badge badge-warning">Probation</span>',
            'Tetap'     => '<span class="badge badge-success">Tetap</span>',
            'Selesai'   => '<span class="badge badge-danger">Selesai</span>',
            default     => '<span class="badge badge-secondary">'.e($this->status).'</span>',
        };
    }
    public function getTipeBadgeAttribute(): string {
        return $this->tipe==='Staff'
            ? '<span class="badge badge-info">Staff</span>'
            : '<span class="badge badge-warning">Non-Staff</span>';
    }
    public function getBasicSalaryFormattedAttribute(): string {
        return 'Rp '.number_format($this->basic_salary??0,0,',','.');
    }
    public static function levelOptions(): array {
        return ['Executive Committee','General Manager','Senior Manager','Manager',
                'Assistant Manager','Supervisor','Officer','Labour Supply','Non Staff'];
    }
}
