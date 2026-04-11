<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = ['name','username','email','password','role','is_active','avatar'];
    protected $hidden   = ['password','remember_token'];
    protected $casts    = ['email_verified_at'=>'datetime','is_active'=>'boolean','password'=>'hashed'];
    public function isAdmin(): bool   { return $this->role==='admin'; }
    public function isManager(): bool { return in_array($this->role,['admin','hr_manager']); }
    public function canEdit(): bool   { return in_array($this->role,['admin','hr_manager','hr_staff']); }
    public function getRoleLabelAttribute(): string {
        return match($this->role){
            'admin'=>'Administrator','hr_manager'=>'HR Manager',
            'hr_staff'=>'HR Staff','viewer'=>'Viewer',default=>$this->role,
        };
    }
    public function getRoleBadgeAttribute(): string {
        return match($this->role){
            'admin'      =>'<span class="badge badge-danger">Admin</span>',
            'hr_manager' =>'<span class="badge badge-primary">HR Manager</span>',
            'hr_staff'   =>'<span class="badge badge-info">HR Staff</span>',
            'viewer'     =>'<span class="badge badge-secondary">Viewer</span>',
            default      =>'<span class="badge badge-secondary">'.e($this->role).'</span>',
        };
    }
    public function activityLogs(){ return $this->hasMany(ActivityLog::class); }
    public function scopeActive($q){ return $q->where('is_active',true); }
}
