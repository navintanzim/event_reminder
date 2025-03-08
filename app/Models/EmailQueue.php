<?php

namespace App\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;


class EmailQueue extends Model {

    protected $table = 'email_queue';
    protected $fillable = array(
        'id',
        'app_id',
        'email_content',
        'sms_content',
        'email_to',
        'sms_to',
        'email_subject',
        'email_cc',
        'attachment',
        'secret_key',
        'pdf_type',
        'email_status',
        'sms_status',
		'template_id',
		'created_by',
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

    /*     * *******************************************End of Model Class********************************************* */
}
