<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Libraries\Encryption;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class CustomAuthController extends Controller
{

    public function index()
    {
        if(Auth::check()){
            return redirect('/dashboard');
        }else{
            return view('auth.login');
        }
        
    }

    public function customLogin(Request $request)
    {
       $validator =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('dashboard')->withSuccess('Logged in');
        }
        $validator['emailPassword'] = 'Email address or password is incorrect.';
        return redirect("login")->withErrors($validator);
    }



    public function registration()
    {
        if(Auth::check()){
            return redirect('/dashboard');
        }else{
            return view('auth.registration');
        }
        
    }

    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }


    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    public function notifications()
    {
        //  $notifications= [];

        $notifications = EmailQueue::where('email_to', Auth::user()->email)
            ->where('web_notification', 0)
            ->orWhere('email_cc', Auth::user()->email)
            ->orderby('created_at', 'desc')->get([
                'id',
                'email_subject',
                'web_notification',
                'created_at'
            ]);

//        foreach ($notifications as $key => $value) {
//            $value['id'] = Encryption::encodeId($value->id);
//        }

        $new_data = $notifications->map(function ($notification) {
            return [
                'id' => Encryption::encodeId($notification->id),
                'email_subject' => $notification->email_subject,
                'web_notification' => $notification->web_notification,
                'created_at' => $notification->created_at
            ];
        });
        return response()->json($new_data);
    }

    public function notificationCount()
    {
        /*
         * Query cache.
         * after every five minutes query will execute
         */
        $notificationsCount = Cache::remember('notificationCount' . Auth::user()->email, 5, function () {
            return EmailQueue::where('email_to', Auth::user()->email)
                ->where('web_notification', 0)
                ->orWhere('email_cc', Auth::user()->email)
                ->orderby('created_at', 'desc')
                ->count();
        });

        return response()->json($notificationsCount);
    }


    public function notificationSingle($id)
    {
        $id = Encryption::decodeId($id);
        EmailQueue::where('id', $id)
            ->update([
                'web_notification' => 1,
            ]);

        $singleNotificInfo = EmailQueue::where('id', $id)->first();

        return view('singleNotificInfo', compact('singleNotificInfo'));
    }

    public function notificationAll()
    {
        EmailQueue::where('email_to', Auth::user()->email)
            ->orWhere('email_cc', Auth::user()->email)
            ->update([
                'web_notification' => 1,
            ]);
        $notificationsAll = EmailQueue::where('email_to', Auth::user()->email)
            ->orWhere('email_cc', Auth::user()->email)
            ->orderby('created_at', 'desc')->get();

        return view('singleNotificInfo', compact('notificationsAll'));
    }


}