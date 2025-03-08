<?php

namespace App\Modules\Meeting\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{

    protected $table = 'crm_meeting';
    protected $fillable = array(
        'id',
        'tracking_no',
        'caption',
        'agenda',
        'start_dt',
        'duration',
        'others_description',
        'location',
        'status',
        'outcome',
        'reminder_time',
        'is_reminder',
        'description',
        'assigned_to',
        'deleted',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    );

    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->created_by = CommonFunction::getUserId();
            $post->updated_by = CommonFunction::getUserId();
        });

        static::updating(function ($post) {
            $post->updated_by = CommonFunction::getUserId();
        });
    }

    public function scopeWithoutTimestamps()
    {
        $this->timestamps = false;
        return $this;
    }

    /*     * *****************************End of Model Class********************************** */
}
