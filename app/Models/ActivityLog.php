<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model {
    protected $fillable = ['user_id','module','action','subject_type','subject_id','old_values','new_values','ip_address'];
    protected $casts    = ['old_values'=>'array','new_values'=>'array'];
    public function user(){ return $this->belongsTo(User::class); }
    public static function log(string $module, string $action, $subject=null, array $old=[], array $new=[]): void {
        static::create([
            'user_id'      => auth()->id(),
            'module'       => $module,
            'action'       => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->id,
            'old_values'   => $old ?: null,
            'new_values'   => $new ?: null,
            'ip_address'   => request()->ip(),
        ]);
    }
}
