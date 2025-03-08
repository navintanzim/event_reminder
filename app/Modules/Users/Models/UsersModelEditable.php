<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class UsersModelEditable extends Model {

    protected $table = 'users';
    protected $fillable = array(
        'user_type',
        'password',
        'user_status',
        'name',
        'user_DOB',
        'user_pic',
        'email',
        'phone',
        'remember_token',
        'updated_by'
    );

    public static function boot() {
        parent::boot();
        // Before update
        static::creating(function($post) {
            if (Auth::guest()) {
                $post->created_by = 0;
                $post->updated_by = 0;
            } else {
                $post->created_by = CommonFunction::getUserId();
                $post->updated_by = CommonFunction::getUserId();
            }
        });

        static::updating(function($post) {
            if (Auth::guest()) {
                $post->updated_by = 0;
            } else {
                $post->updated_by = Auth::user()->id;
            }
        });
    }


    /*     * ***************************** Users Model Class ends here ************************* */
}
