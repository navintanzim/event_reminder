<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class Users extends Model {

    protected $table = 'users';
    protected $fillable = array(
        'id',
        'name',
        'user_type',
        'email',
        'phone',
        'password',
        'user_status',
        'email_verified_at',
        'user_DOB',
        'remember_token',
        'created_at',
        'created_by',
        'updated_at',
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
                $post->created_by = Auth::user()->id;
                $post->updated_by = Auth::user()->id;
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

    function chekced_verified($TOKEN_NO, $data) {
        DB::table($this->table)
                ->where('user_hash', $TOKEN_NO)
                ->update($data);
    }

    function profile_update($table, $field, $check, $value) {
        return DB::table($table)->where($field, $check)->update($value);
    }

    public static function getUserList(){

        $user_list_query = Users::leftJoin('user_types as ut', 'ut.id', '=', 'users.user_type')
                ->orderBy('users.id', 'desc')
                ->orderBy('users.created_at', 'desc')
                ->where('users.user_status', '!=', 'rejected');

       
        $user_list = $user_list_query->get([
                    'users.id',
                    'users.name',
                    'users.created_at',
                    'users.email',
                    'users.user_status',
                    'users.user_type',
                    'ut.type_name',
                ]);

        return $user_list;

    }
    public static function getRejectedUserList(){
        return Users::leftJoin('user_types as mty', 'mty.id', '=', 'users.user_type')
                ->leftJoin('area_info', 'users.district', '=', 'area_info.area_id')
                ->leftJoin('area_info as ai', 'users.thana', '=', 'ai.area_id')
                ->leftJoin('company_info as ci', 'users.user_sub_type', '=', 'ci.id') // will be applied only in case of applicant users
                ->orderBy('users.id', 'desc')
                ->orderBy('users.created_at', 'desc')
                ->where('users.user_status','rejected')
                ->get([
                    'users.id',
                    'users.name',
                    'users.created_at',
                    'users.user_sub_type',
                    'users.email',
                    'users.user_status',
                    'users.user_type',
                    'users.user_status_comment as reject_reason',
                    'users.updated_at',
                    'ai.area_nm as thana',
                    'area_info.area_nm as users_district',
                    'mty.type_name',
                    'ci.company_name'
                ]);

    }

    function getHistory($email)
    {
        $users_type = Auth::user()->user_type;
        $type = explode('x', $users_type)[0];
        if ($type == 1)
        { // 1x101 for Super Admin
            return DB::table('failed_login_history')->where('email',$email)->get(['email','remote_address','created_at']);
//                            ->where('users.user_type', '!=', Auth::user()->user_type
        }
    }


    function getUserRow($user_id) {
        return Users::leftJoin('user_types as mty', 'mty.id', '=', 'users.user_type')
                        ->where('users.id', $user_id)
                        ->first(['users.*', 'mty.type_name','mty.id as type_id']);
    }

    function checkEmailAndGetMemId($email) {
        return DB::table($this->table)
                        ->where('email', $email)
                        ->pluck('id');
    }

    public static function setLanguage($lang) {
        Users::find(Auth::user()->id)->update(['user_language' => $lang]);
    }

    

    /*     * ***************************** Users Model Class ends here ************************* */
}
