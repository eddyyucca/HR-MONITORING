<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rekrutmen extends Model {
    use SoftDeletes;
    protected $fillable = [
        'nama_lengkap','no_telp','email','gender',
        'plan_job_title','departemen_id','divisi_id','category_level',
        'status','progress','priority','status_ata',
        'sourch','user_pic','site',
        'date_approved','date_progress','month_number','month_name','year','sla',
        'remarks','evrp_bsi','evrp_wetar','ata_status',
        'created_by','updated_by',
    ];
    protected $casts = [
        'date_approved'=>'date','date_progress'=>'date',
        'year'=>'integer','month_number'=>'integer','sla'=>'decimal:2',
    ];
    public function divisi()     { return $this->belongsTo(Divisi::class); }
    public function departemen() { return $this->belongsTo(Departemen::class); }
    public function createdBy()  { return $this->belongsTo(User::class,'created_by'); }
    public function updatedBy()  { return $this->belongsTo(User::class,'updated_by'); }
    public function karyawan()   { return $this->hasOne(Karyawan::class); }

    public function scopeByYear($q,$y)     { return $q->where('year',$y); }
    public function scopeByProgress($q,$p) { return $q->where('progress',$p); }
    public function scopeByDivisi($q,$id)  { return $q->where('divisi_id',$id); }
    public function scopeByPriority($q,$p) { return $q->where('priority',$p); }
    public function scopeOnBoard($q)       { return $q->where('progress','On Board'); }
    public function scopeActive($q)        { return $q->where('progress','Compro'); }
    public function scopeFailed($q)        { return $q->where('progress','LIKE','Failed%'); }

    public function getProgressBadgeAttribute(): string {
        return match($this->progress) {
            'On Board'           => '<span class="badge badge-success">On Board</span>',
            'Compro'             => '<span class="badge" style="background:#6f42c1;color:#fff">Compro</span>',
            'Failed - Interview' => '<span class="badge badge-danger">Failed</span>',
            'MCU'                => '<span class="badge badge-info">MCU</span>',
            'Offering Letter'    => '<span class="badge badge-warning">Offering Letter</span>',
            default              => '<span class="badge badge-secondary">'.e($this->progress).'</span>',
        };
    }
    public function getPriorityBadgeAttribute(): string {
        if(!$this->priority) return '<span class="text-muted">—</span>';
        return match($this->priority) {
            'P1' => '<span class="badge badge-danger">P1</span>',
            'P2' => '<span class="badge badge-warning">P2</span>',
            'P3' => '<span class="badge badge-info">P3</span>',
            'NP' => '<span class="badge badge-secondary">NP</span>',
            default => '<span class="badge badge-secondary">'.e($this->priority).'</span>',
        };
    }
    public function getSlaColorAttribute(): string {
        if(!$this->sla) return 'secondary';
        if($this->sla <= 30) return 'success';
        if($this->sla <= 60) return 'warning';
        return 'danger';
    }
    public static function progressOptions(): array {
        return ['Compro','Waiting Schedule Interview','Waiting Result Interview','Interview User',
                'MCU','Offering Letter','Waiting Result Offering Letter','Waiting On Board',
                'On Board','Failed - Interview','Failed - MCU','Failed - OL','Cancelled'];
    }
    public static function levelOptions(): array {
        return ['Executive Committee','General Manager','Senior Manager','Manager',
                'Assistant Manager','Supervisor','Officer','Labour Supply','Non-Staff'];
    }
    public static function sourchOptions(): array {
        return ['Referral','BSI','LinkedIn','PUS','JobStreet','Indeed','Internal','Lainnya'];
    }
    public static function monthMap(): array {
        return [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',
                7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
    }
}
