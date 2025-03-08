<?php

namespace App\Modules\Users\Models;

use App\Libraries\CommonFunction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

    protected $table = 'notifications';
    protected $fillable = array(
         'source',
         'ref_id',
         'destination',
         'status',
         'is_sent',
         'msg_type',
         'template_id',
         'priority',
         'created_by',
         'updated_by'
    );

    public static function boot()
    {
        parent::boot();
        // Before update
        static::creating(function($post)
        {
            $post->created_by = CommonFunction::getUserId();
            $post->updated_by = CommonFunction::getUserId();
        });

        static::updating(function($post)
        {
            $post->updated_by = Auth::user()->id;
        });

    }


    public function sendSecondStepSMS($code){

        $smsData['source'] = 'Your verification code: '.$code;

        $smsData['destination'] = Auth::user()->phone;
        $smsData['msg_type'] = 'SMS';
        $smsData['ref_id'] = Auth::user()->id;
        $smsData['is_sent'] = 0;
        $smsData['template_id'] = 0;
        $smsData['priority'] = 9;

        Notification::create($smsData);
    }


    public static function resendSMS($id)
    {
        $sms = Notification::findOrFail($id);
        Notification::create([
            'source' => $sms->source,
            'ref_id' => $sms->ref_id,
            'destination' => $sms->destination,
            'is_sent' => 0,
            'sent_on' => $sms->sent_on,
            'no_of_try' => $sms->no_of_try,
            'msg_type' => $sms->msg_type,
            'template_id' => $sms->template_id
        ]);
    }

    public static function sendCustomMessage($message,$destination,$msg_type,$ref_id,$priority)
    {
        Notification::create([
            'source' => $message,
            'destination' => $destination,
            'msg_type' => $msg_type,
            'ref_id' => $ref_id,
            'is_sent' => 0,
            'priority' => $priority
        ]);
    }

    /*     * ******************End of Model Class***************** */
}
