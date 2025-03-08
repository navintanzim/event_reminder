<?php

namespace App\Modules\Meeting\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class MeetingAttendees extends Model
{

    protected $table = 'crm_meeting_attendees';
    protected $fillable = array(
        'id',
        'meeting_id',
        'contact_id',
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
