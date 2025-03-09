<?php namespace App\Modules\Users\Controllers;

use App\ActionInformation;
use App\Http\Controllers\Controller;
use App\Modules\Users\Models\Users;
use App\Modules\Users\Models\UsersModel;
use App\Modules\Users\Models\UsersModelEditable;
use App\Modules\Users\Models\UserTypes;
use App\Modules\Settings\Models\Bank;
use App\Modules\Settings\Models\NeedHelp;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use Mpdf\Mpdf;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Users\Models\UserBankUpdateReq;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use yajra\Datatables\Datatables;
use Validator;

class UsersController extends Controller
{
   

    public function __construct()
    {
        // Set values for the variables in the constructor
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("Users::index");
    }

    /*
     * user's list for system admin
     */
    public function lists()
    {
        
        return view('Users::user_list');
    }



    /*
     * user's details information by ajax request
     */
    public function getList()
    {
        $mode = 'V';
        $userList = Users::getUserList();
//        dd($userList);
        return Datatables::of($userList)
            ->addColumn('action', function ($userList) use ($mode) {
               
                if ($mode) {
                    

                    return ' <a href="' . url('users/view/' . Encryption::encodeId($userList->id)) . '" class="btn btn-xs btn-primary open" ><i class="fa fa-folder-open-o"></i> Open</a>' ;
                } else {
                    return '';
                }
            })
            ->editColumn('user_status', function ($userList) {
                if ($userList->user_status == 'inactive') {
                    $activate = 'class="text-danger" ';
                } else {
                    $activate = 'class="text-success" ';
                }
                return '<span ' . $activate . '><b>' . $userList->user_status . '</b></span>';
            })
            ->editColumn('created_at', function ($userList) {
                return date("d-M-Y, H:i", strtotime($userList->created_at));
            })
            ->removeColumn('id', 'is_sub_admin')
            ->rawColumns(['user_status','action'])
            ->make(true);
    }


    public function getServerTime()
    {
        $databaseTime = DB::select("SELECT NOW() as db_time");
        $db_date = date('d-M-Y', strtotime($databaseTime[0]->db_time));
        $db_time = date('g:i:s A', strtotime($databaseTime[0]->db_time));
        $db_hour = date('g', strtotime($databaseTime[0]->db_time));
        $db_min = date('i', strtotime($databaseTime[0]->db_time));
        $db_sec = date('s', strtotime($databaseTime[0]->db_time));

//        $app_date = date('d-M-Y');
//        $app_time = date('g:i:s A');

        $dateTime = [
            'db_date' => $db_date,
            'db_time' => $db_time,
            'db_hour' => $db_hour,
            'db_min' => $db_min,
            'db_sec' => $db_sec,
//            'app_date' => $app_date,
//            'app_time' => $app_time,
        ];

        return $dateTime;
    }


    /*
     * view individual user from admin panel
     */
    public function view($id, Users $usersModel)
    {
       
        $user_id = Encryption::decodeId($id);
        $user = $usersModel->getUserRow($user_id);

       
        $user_type_part = explode('x', $user->user_type);


        if (count($user_type_part) > 1) {
            $user_types = UserTypes::where('id', 'LIKE', "$user_type_part[0]_" . substr($user_type_part[1], 0, 2) . "_")
                ->where('id', 'NOT LIKE', "$user_type_part[0]_" . substr($user_type_part[1], 0, 2) . "0")
                ->where('status', 'active')
                ->orderBy('type_name')
                ->pluck('type_name', 'id')->toArray();
            
            return view('Users::view-printable', compact("user", "user_types"));
        } else {
            Session::flash('error', 'User Type not defined.');
            return redirect('users/lists');
        }
    }


    // for adding new users from Authentic Admin's end
    public function createNewUser()
    {
        
        $logged_user_type = Auth::user()->user_type;
        $user_type_part = explode('x', $logged_user_type);
        if ($logged_user_type == '1x101') { // 1x101 is Sys Admin
            $user_types = UserTypes::where('is_registrable', '!=', '-1')
                ->pluck('type_name', 'id')->toArray();
        } else {
            $user_types = UserTypes::where('id', 'LIKE', "$user_type_part[0]x" . substr($user_type_part[1], 0, 2) . "_")
                ->where('id', 'NOT LIKE', "$user_type_part[0]_" . substr($user_type_part[1], 0, 2) . "0")
                ->orderBy('type_name')->pluck('type_name', 'id')->toArray();
        }

        return view("Users::new-user", compact("user_types", "logged_user_type"));
    }

    

    /*
     * individual User's profile Info view
     */
    public function profileInfo()
    {
        
        try {
           
            $users = Users::find(Auth::user()->id);
            

            $userType = CommonFunction::getUserType();
            
            $user_type_info = UserTypes::where('id', $users->user_type)->first();
            // $image_config = CommonFunction::getImageConfig('IMAGE_SIZE');
            // $doc_config = CommonFunction::getImageConfig('DOC_IMAGE_SIZE');
            
            $id = Encryption::encodeId(Auth::user()->id);
            
            return view('Users::profile-info', compact('id', 'users', 'user_type_info'));
        } catch (\Exception $e) {
            Session::flash('error', 'Something went wrong ! [UC-102]');
            return \redirect('dashboard');
        }
    }

/*
     * user's account activaton
     */
    public function activate($id)
    {
        
        $user_id = Encryption::decodeId($id);
        try {
            $user = Users::where('id', $user_id)->first();

            $user_active_status = $user->user_status;

            if ($user_active_status == 'active') {
                Users::where('id', $user_id)->update(['user_status' => 'inactive']);
                Session::flash('error', "User's Profile has been deactivated Successfully!");
            } else {
                
                Users::where('id', $user_id)->update(['user_status' => 'active']);
                Session::flash('success', "User's profile has been activated successfully!");

            }
            // maybe destroy session of deactivated users?
            // CustomAuthController::killUserSession($user_id);
          
                return redirect('users/lists');
            
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage());
            return Redirect::back()->withInput();
        }
    }

    /*
     * User's password update function
     */
    public function updatePassFromProfile(Request $request)
    {
        $userId = Encryption::decodeId($request->get('Uid'));
       

        $dataRule = [
            'user_old_password' => 'required',
            'user_new_password' => [
                'required',
                'min:6',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,}$/'
            ],
            'user_confirm_password' => [
                'required',
                'same:user_new_password',
            ]
        ];

        $validator = Validator::make($request->all(), $dataRule);
        if ($validator->fails()) {
            return redirect('users/profileinfo#tab_2')->withErrors($validator)->withInput();
        }

        try {
            $old_password = $request->get('user_old_password');
            $new_password = $request->get('user_new_password');

            $password_match = Users::where('id', Auth::user()->id)->pluck('password');
            $password_chk = Hash::check($old_password, $password_match);

            if ($password_chk == true) {
                Users::where('id', Auth::user()->id)
                    ->update(array('password' => Hash::make($new_password)));

                Auth::logout();
                $loginObj = new LoginController();
                $loginObj->entryAccessLogout();

                \Session::flash('success', 'Your password has been changed successfully! Please login with the new password.');
                return redirect('login');
            } else {
                \Session::flash('error', 'Password do not match');
                return Redirect('users/profileinfo#tab_2')->with('status', 'error');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.');
            return Redirect::back()->withInput();
        }
    }

    /*
     * password update from admin panel
     */
    public function resetPassword($id)
    {
       
        try {
            $user_id = Encryption::decodeId($id);
            $password = str_random(10);

            $user_active_status = DB::table('users')->where('id', $user_id)->pluck('user_status');
            $email_address = DB::table('users')->where('id', $user_id)->pluck('email');
            if ($user_active_status == 'active') {
                Users::where('id', $user_id)->update([
                    'password' => Hash::make($password)
                ]);

                \Session::flash('success', "User's password has been reset successfully! An email has been sent to the user!");
            } else {
                \Session::flash('error', "User profile has not been activated yet! Password can not be changed");
            }
            return redirect('users/lists');
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage());
            return Redirect::back()->withInput();
        }
    }


    public function storeNewUser(Request $request)
    {
        
        $rules = [];
        $rules['name'] = 'required';
        $rules['user_type'] = 'required';
       
        $rules['user_DOB'] = 'required|date';
        $rules['phone'] = array('required', 'regex:/^(?:\+88|01)?(?:\d{11}|\d{13})$/');
        $rules['email'] = 'required|email|unique:users';
      
        $messages = [];
        $messages['user_DOB.required'] = 'The Date of Birth field is required';
        $messages['user_DOB.date'] = 'The Date of Birth field is required';
        $messages['phone.required'] = 'The Phone No. field is required';
        $messages['phone.regex'] = 'Please enter a valid phone number';

        $this->validate($request, $rules, $messages);
        try {
          
            if (Auth::user()->user_type == '1x101') {     //System admin
                $desk_id = '';
                $user_type = $request->get('user_type');
            } else {
                $desk_id = Auth::user()->desk_id;
                $user_type = Auth::user()->user_type;
            }

            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $encrypted_pass = Hash::make(implode($pass));

            $data = array(
                'name' => $request->get('name'),
                'user_DOB' => CommonFunction::changeDateFormat($request->get('user_DOB'), true),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
                'user_type' => $user_type,
                'password' => $encrypted_pass,
                'user_status' => 'active'
            );

            Users::create($data);

            $receiverInfo[] = [
                'email' => $request->get('email'),
                'phone' => $request->get('phone')
            ];

            $appInfo = [
                'temp_pass' => implode($pass)
            ];

            CommonFunction::sendEmailSMS('CONFIRM_ACCOUNT', $appInfo, $receiverInfo);

            Session::flash('success', 'User has been created successfully! An email has been sent to the user.');

            return redirect('users/create-new-user');

        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage());
            return Redirect::back()->withInput();
        }
    }



    /*
     * edit individual user from admin panel
     */
    public function edit($id)
    {
        $user_id = Encryption::decodeId($id);
        $users = Users::where('id', $user_id)->first();

        list($user_type) = explode('x', $users->user_type);
        
        $logged_in_user_type = CommonFunction::getUserType();
       
        $user_type_part = explode('x', $logged_in_user_type);
        $edit_user_type = UserTypes::where('id', $users->user_type)->value('type_name');
        
        $user_types = [$users->user_type => $edit_user_type] + UserTypes::where('id', 'LIKE', "$user_type_part[0]x" . substr($user_type_part[1], 0, 2) . "_")
                    ->where('id', 'NOT LIKE', "$user_type_part[0]_" . substr($user_type_part[1], 0, 2) . "0")
                    ->where('id', '!=', '1X101')
                    ->orderBy('type_name')->pluck('type_name', 'id')
                    ->all();
        $branch_list = array();
        
        return view('Users::edit', compact("users", "user_types", 'logged_in_user_type'));
    }

    public function update(Request $request,$id)
    {
        $user_id = Encryption::decodeId($id);
        $rules = [];
        $rules['name'] = 'required';
        $rules['user_type'] = 'required';
        $rules['phone'] = array('required', 'regex:/^(?:\+88|01)?(?:\d{11}|\d{13})$/');

        $messages = [];
        $messages['phone.required'] = 'The Phone No. field is required';
        $messages['phone.regex'] = 'Please enter a valid phone number';

        $this->validate($request, $rules, $messages);

       
        try {
            DB::beginTransaction();
            
            $mobile_no_validate = CommonFunction::validateMobileNumber($request->get('phone'));
            if ($mobile_no_validate != 'ok') {
                Session::flash('error', $mobile_no_validate);
                return redirect('users/edit/' . $id)->withInput();
            }
            if (substr($request->get('phone'), 0, 2) == '01') {
                $mobile_no = '+88' . $request->get('phone');
            } else {
                $mobile_no = $request->get('phone');
            }


            UsersModelEditable::find($user_id)->update([
                'name' => $request->get('name'),
                'phone' => $mobile_no,
                'updated_by' => CommonFunction::getUserId(),
            ]);

            $user_data = Users::where('id', $user_id)->first();

            list($user_type) = explode('x', $user_data->user_type);

            DB::commit();
            Session::flash('success', "User's profile has been updated successfully!");
            return redirect('users/edit/' . $id);
        } catch (\Exception $e) {
            dd( $e);
            Session::flash('error', 'Sorry! Something is Wrong.');
            return Redirect::back()->withInput();
        }
    }


    public function profile_update(Request $request)
    {
        $userId = Encryption::decodeId($request->get('Uid'));
        
        $rules = [
            'name' => 'required',
            'phone' => 'required',
        ];
		$messages = [];
        $messages['name.required'] = 'The Name field is required';
        $messages['phone.required'] = 'The Phone No. field is required';
        $messages['phone.regex'] = 'Please enter a valid phone number';

        $this->validate($request, $rules,$messages);

        $auth_token_allow = 0;
        if ($request->get('auth_token_allow') == '1') {
            $auth_token_allow = 1;
        }
        if (substr($request->get('phone'), 0, 2) == '01') {
            $mobile_no = '+88' . $request->get('phone');
        } else {
            $mobile_no = $request->get('phone');
        }
        $dateOfBirth = $request->get('user_DOB');

        $data = [
            'name' => $request->get('name'),
            'user_DOB' => ($dateOfBirth) ? CommonFunction::changeDateFormat($dateOfBirth, true) : $dateOfBirth,
            'phone' => '+880'.$mobile_no,
            'updated_by' => CommonFunction::getUserId()
        ];

    
        $prefix = date('Y_');


        UsersModelEditable::find($userId)->update($data);
        UsersModel::find($userId)->first();

        Session::flash('success', 'Your profile has been updated successfully.');
        return redirect('users/profileinfo');
    }



    /*
     * user support
     */


    public function getUserSession(Request $request)
    {
        if (Auth::user()) {
            $checkSession= 0;
            $checkSession = UsersModel::where(['id' => Auth::user()->id,'user_status' => 'active' ])->count();
           
            if ($checkSession >= 1) {
                $data = ['responseCode' => 1, 'data' => 'matched'];
            } else {
                Auth::logout();
                $data = ['responseCode' => -1, 'data' => 'not matched'];
            }
        } else {
            Auth::logout();
            $data = ['responseCode' => -1, 'data' => 'closed'];
        }

//		$LgController = new LoginController;
//		if (!$LgController->_checkSecurityProfile($request)) {
//			Auth::logout();
//			$data = ['responseCode' => -1, 'data' => 'Security Profile does not matched'];
//		}

        return response()->json($data);
    }

    

    public function entryAccessLog()
    {
        // access_log table.
        $str_random = str_random(10);
        $insert_id = DB::table('user_logs')->insertGetId(
            array(
                'user_id' => Auth::user()->id,
                'login_dt' => date('Y-m-d H:i:s'),
                'ip_address' => \Request::getClientIp(),
                'access_log_id' => $str_random
            )
        );

        Session::put('access_log_id', $str_random);
    }


    public function appFormEditView($Id, $openMode = '', Request $request)
    {
        $mode = 'SecurityBreak';
        $viewMode = 'SecurityBreak';
        if ($openMode == 'view') {
            $viewMode = 'on';
            $mode = '-V-';
        } else if ($openMode == 'edit') {
            $viewMode = 'off';
            $mode = '-E-';
        }
        $viewMode = 'on';
        $mode = '-V-';
        
        try {
            $id = Encryption::decodeId($Id);
            $master_data = UserBankUpdateReq::find($id);
            $bankData = DB::table('bank as b')
                ->leftJoin('bank_branch_routing_number as br','br.bank_id','b.id')
                ->where('b.id',$master_data->bank_id)
                ->where('br.id',$master_data->branch_id)
                ->select(
                    'b.name as bank_name',
                    'br.branch_name as branch_name',
                    'br.routing_no as routing_no'
                )->first();
            $public_html = strval(view("Users::bank-update-info", compact('master_data','bankData')));
            return response()->json(['responseCode' => 1, 'html' => $public_html]);
        } catch (\Exception $e) {
            return response()->json(['responseCode' => 1, 'html' => CommonFunction::showErrorPublic($e->getMessage()) . "[VA-1015]"]);
        }
    }
    

}
