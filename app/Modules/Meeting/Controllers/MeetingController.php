<?php

namespace App\Modules\Meeting\Controllers;

use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Meeting\Models\MeetingAttendees;
use App\Http\Controllers\Controller;
use App\Imports\ReminderImport;
use App\Models\EmailQueue;
use App\Modules\Meeting\Models\Meeting;
use App\Modules\Users\Models\Users;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;


class MeetingController extends Controller
{
    public function lists()
    {
        $monthArray = [
        1=>'1 Day', 3=>'3 Days',7=>'1 Week',15=>'2 Weeks',30=>'1 Month'
    ];
        $user = Users::where('user_status', 'Active')->select(['id', 'name'])->get();
        
        return view('Meeting::meeting.list', compact('user', 'monthArray'));
    }

    public function addNew($reference = null, $referance_id = null)
    {
        $reference = ($reference) ? Encryption::decode($reference) : '';
        $referance_id = ($referance_id) ? Encryption::decodeId($referance_id) : '';
        $status = ['' => 'Select'] + CommonFunction::getEnumList('crm_meeting', 'status');
        $userLists = Users::orderBy('users.name')->get(['users.id', 'users.name','users.email']);
        return view('Meeting::meeting.add-new', compact('userLists', 'status', 'reference', 'referance_id'));
    }

    public function storeNewMeetingData(Request $request)
    {
        $rules = [];
        $rules['caption'] = 'required';
        $rules['assigned_to'] = 'required';
        $rules['duration'] = 'required';

        $messages = [];
        $messages['caption.required'] = 'The Subject field is required';
        $messages['assigned_to.required'] = 'The Subject field is required';
        $messages['duration.required'] = 'The Subject field is required';
        $this->validate($request, $rules, $messages);

        try {

            DB::beginTransaction();

            $meetingObject = new Meeting;
            $meetingObject->caption = $request->get('caption');
            $meetingObject->agenda = $request->get('agenda');
            $meetingObject->start_dt = date('Y-m-d H:i:s', strtotime($request->get('start_dt')));
            $meetingObject->location = $request->get('location');
            $meetingObject->assigned_to = $request->get('assigned_to');
            $meetingObject->duration = $request->get('duration');
            $meetingObject->description = $request->get('description');
            $meetingObject->status = $request->get('status');
            
            if ($request->get('status') == 'Held') {
                $meetingObject->outcome = $request->get('outcome');
            } elseif ($request->get('status') == 'Planned' && $request->get('is_reminder') == 'on') {
                $meetingObject->is_reminder = $request->get('is_reminder') == 'on' ? 1 : 0;
                $meetingObject->reminder_time = $request->get('reminder_time');
            }

            $trackingPrefix = 'MEET-' . date("dMY") . '-';
                $maxTrackingNo = DB::table('crm_meeting')
                ->select(DB::raw("IFNULL(MAX(SUBSTR(tracking_no, -5, 5))+1, 1) as max_tracking_no"))
                ->where('id', '!=', $meetingObject->id)
                ->where('tracking_no', 'like', $trackingPrefix . '%')
                ->first();
        
            $tracking_no = $trackingPrefix . str_pad($maxTrackingNo->max_tracking_no, 5, '0', STR_PAD_LEFT);
            $meetingObject->tracking_no = $tracking_no;
            
            $meetingObject->save();
            $meeting_id = $meetingObject->id;
            foreach ($request->get('contact_id_to') as $key=>$data) {
                $objMeetingAttendees = new  MeetingAttendees();
                $objMeetingAttendees->meeting_id = $meeting_id;
                $objMeetingAttendees->contact_id = $data;
                $objMeetingAttendees->save();
                if($meetingObject->status != 'Held' ){
                    
                        $appInfo = [];
                        $receiverInfo = [];
                        $appInfo = [
                            'app_id' => $meeting_id,
                            'subject' => $meetingObject->caption,
                            'agenda' => $meetingObject->agenda,
                            'time' => Carbon::parse($meetingObject->start_dt)->format('F j, Y \a\t g:i A'),
                            'location' => $meetingObject->location,
                            'status' => $meetingObject->status
                        ];
                        $userEmail = Users::where('id', $objMeetingAttendees->contact_id)->pluck('email')->first();
                        $appInfo['name'] = CommonFunction::userNameShow($objMeetingAttendees->contact_id);
                        $receiverInfo[] = [
                            'user_email' => $userEmail,
                            'user_phone' => ''
                        ];
                        if($meetingObject->status == 'Planned'){
                            CommonFunction::sendEmailSMS('CRM_MEETING', $appInfo, $receiverInfo);
                        } elseif (in_array($meetingObject->status, ['Posponded','Cancelled'])){
                            CommonFunction::sendEmailSMS('CRM_MEETING_UPDATE', $appInfo, $receiverInfo);
                        }
                    

                }
            }

            DB::commit();

            Session::flash('success', 'New meeting has been created successfully.');
            return redirect('/meeting/edit/' . Encryption::encodeId($meeting_id));
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage());
            return Redirect::back()->withInput();
        }
    }

    public function getList(Request $request)
    {
       
        $meetingList = Meeting::leftjoin('users as assigned_user', 'assigned_user.id', 'crm_meeting.assigned_to')
            ->leftjoin('users AS created_user', 'created_user.id', 'crm_meeting.created_by')
            ->select([
                'crm_meeting.id as id',
                'crm_meeting.caption as caption',
                'crm_meeting.start_dt as start_dt',
                'crm_meeting.status as status',
                'crm_meeting.assigned_to',
                'crm_meeting.created_by',
                'crm_meeting.created_at',
                'crm_meeting.updated_by',
                'crm_meeting.updated_at',
                'assigned_user.name as assigned_name',
                'created_user.name as creator_name',
            ]);

        
        if ($request->get('searchData') == 1) {
            if ($request->get('assigned_to') != '') {
                $meetingList->where(function ($query) use ($request) {
                    $query->where('crm_meeting.created_by', $request->get('created_by'))
                        ->orWhere('crm_meeting.assigned_to', $request->get('assigned_to'));
                });
            }
            if ($request->get('date_within')) {
                $dateRange = CommonFunction::dateFromToGenerate($request->get('date_within'), $request->get('created_date') != '' ? $request->get('created_date') : null);
                $meetingList->whereBetween(DB::raw('date(crm_meeting.created_at)'), $dateRange);
            } else {
                $request->get('created_date') != '' ? $meetingList->whereDate('crm_meeting.created_at', '=', date("Y-m-d", strtotime($request->get('created_date')))) : '';
            }
            if ($request->get('name') != '') {
                $meetingList->where(function ($query) use ($request) {
                    $query->Where('crm_meeting.caption', 'like', '%' . $request->get('name') . '%');
                });
            }
        }
        $meetingList->groupBy('crm_meeting.id')->orderBy('crm_meeting.id', 'DESC');
        return Datatables::of($meetingList)
            ->addColumn('action', function ($meetingList) {
                $edit_btn = ' <a href="' . url('/meeting/edit/' . Encryption::encodeId($meetingList->id)) .
                    '" class="btn btn-xs btn-info" ><i class="fa fa-check-circle"></i> Edit</a>';
                $view_btn = ' <a href="' . url('/meeting/view/' . Encryption::encodeId($meetingList->id)) . '" class="btn btn-xs btn-primary open" ><i class="fa fa-folder-open-o"></i> Open</a>';
                if (Auth::user()->user_type != "1x101" && Auth::user()->id != $meetingList->assigned_to) {
                    $edit_btn = '';
                }
                return $view_btn;
            })
            ->editColumn('start_dt', function ($meetingList) {
                $date = Carbon::parse($meetingList->start_dt);
                return $date->isoFormat('MMMM Do YYYY');
            })
            
            ->editColumn('created_at', function ($meetingList) {
                return date('d-M-Y', strtotime($meetingList->created_at));
            })->editColumn('updated_at', function ($meetingList) {
                return date('d-M-Y', strtotime($meetingList->updated_at));
            })
            ->rawColumns([ 'action'])
            ->make(true);
    }

    public function viewMeetingData($id)
    {
        $id = Encryption::decodeId($id);
        $userLists = Users::all(['id', 'name']);
        $meeting_data = Meeting::find($id);
        $meeting_attendees_data = MeetingAttendees::where('meeting_id', $id)->get();
        $parent_type = ['' => 'Select'] + CommonFunction::getEnumList('crm_meeting', 'parent_type');
        $status = ['' => 'Select'] + CommonFunction::getEnumList('crm_meeting', 'status');

        return view('Meeting::meeting.view', compact('meeting_data', 'meeting_attendees_data', 'userLists', 'parent_type', 'status'));
    }

    public function editMeetingData($id)
    {
        $userId = $id;


        $id = Encryption::decodeId($id);
        $userLists = Users::groupBy('users.id')->orderBy('users.name')->get(['users.id', 'users.name','users.email']);
        $meeting_data = Meeting::find($id);
        if (Auth::user()->user_type != "1x101" && (Auth::user()->id != $meeting_data->assigned_to || Auth::user()->id != $meeting_data->created_by)) {
            return Redirect::back();
        }
        $meeting_attendees_data = MeetingAttendees::where('meeting_id', $id)->get();
        $status = ['' => 'Select'] + CommonFunction::getEnumList('crm_meeting', 'status');
        return view('Meeting::meeting.edit', compact('meeting_data', 'meeting_attendees_data', 'userLists', 'status', 'userId'));
    }

    public function updateMeetingData(Request $request)
    {
        $request->all();
        $rules = [];
        $rules['caption'] = 'required';
        $rules['assigned_to'] = 'required';
        $rules['start_dt'] = 'required';
        $rules['duration'] = 'required';

        $messages = [];
        $messages['caption.required'] = 'The Subject field is required';
        $messages['assigned_to.required'] = 'The Subject field is required';
        $messages['start_dt.required'] = 'The Subject field is required';
        $messages['duration.required'] = 'The Subject field is required';
        $this->validate($request, $rules, $messages);
        try {
            DB::beginTransaction();
            $id = Encryption::decodeId($request->meeting_id);

            $meetingObject = Meeting::find($id);

            $meetingObject->caption = $request->get('caption');
            $meetingObject->agenda = $request->get('agenda');
            $meetingObject->start_dt = date('Y-m-d H:i:s', strtotime($request->get('start_dt')));
            $meetingObject->location = $request->get('location');
            $meetingObject->assigned_to = $request->get('assigned_to');
            $meetingObject->duration = $request->get('duration');
            $meetingObject->description = $request->get('description');
            $meetingObject->status = $request->get('status');
            $meetingObject->updated_by = Auth::user()->id;
           
            if ($request->get('status') == 'Held') {
                $meetingObject->outcome = $request->get('outcome');
            } elseif ($request->get('status') == 'Planned' && $request->get('is_reminder') == 'on') {
                $meetingObject->is_reminder = $request->get('is_reminder') == 'on' ? 1 : 0;
                $meetingObject->reminder_time = $request->get('reminder_time');
            }
            
            $meetingObject->save();
            MeetingAttendees::where('meeting_id', $id)->delete();
            $meeting_id = $meetingObject->id;
            foreach ($request->get('contact_id_to') as $key=>$data) {
                $objMeetingAttendees = new  MeetingAttendees();
                $objMeetingAttendees->meeting_id = $meeting_id;
                $objMeetingAttendees->contact_id = $data;
                $objMeetingAttendees->save();
                if($meetingObject->status != 'Held' ){
                    
                        $appInfo = [];
                        $receiverInfo = [];
                        $appInfo = [
                            'app_id' => $meeting_id,
                            'subject' => $meetingObject->caption,
                            'agenda' => $meetingObject->agenda,
                            'time' => Carbon::parse($meetingObject->start_dt)->format('F j, Y \a\t g:i A'),
                            'location' => $meetingObject->location,
                            'status' => $meetingObject->status
                        ];
                        $userEmail = Users::where('id', $objMeetingAttendees->contact_id)->pluck('email')->first();
                        $appInfo['name'] = CommonFunction::userNameShow($objMeetingAttendees->contact_id);
                        $receiverInfo[] = [
                            'user_email' => $userEmail,
                            'user_phone' => ''
                        ];
                        if($meetingObject->status == 'Planned'){
                            CommonFunction::sendEmailSMS('CRM_MEETING', $appInfo, $receiverInfo);
                        } elseif (in_array($meetingObject->status, ['Posponded','Cancelled'])){
                            CommonFunction::sendEmailSMS('CRM_MEETING_UPDATE', $appInfo, $receiverInfo);
                        }
                     
                }
            }

            DB::commit();
            Session::flash('success', 'Meeting has been updated successfully.');
            return redirect('/meeting/edit/' . $request->meeting_id);
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . $e->getLine() . $e->getFile());
            return Redirect::back()->withInput();
        }
    }

    
    public function getTaskMeeting()
    {
        $meetingData = [];
        $meetingData = DB::table('crm_meeting as m')
            ->leftJoin('crm_meeting_attendees as a', function($join){
                $join->on('m.id', '=', 'a.meeting_id');
            })
            ->where('m.status','Planned')
            ->where(function ($query) {
                $query->where('m.assigned_to', Auth::user()->id);
                $query->orWhere('a.contact_id', Auth::user()->id);
            })->distinct()->get(['start_dt as start', 'caption as title', DB::raw("'Meeting'")])->toArray();

        return $meetingData;
    }

    public function searchForm(Request $request)
    {
        $action_url = $request->action_url;
        $monthArray = [1=>'1 Day', 3=>'3 Days',7=>'1 Week',15=>'2 Weeks',30=>'1 Month'];
        $user = Users::where('user_status', 'Active')->orderBy('users.name')->select(['id', 'name'])->get();
        $html = strval(view('Meeting::search', compact('user', 'monthArray','action_url')));
        return response()->json(['responseCode' => 1, 'html' => $html]);
    }

    public function getEmployeeUser(Request $request)
    {
        $data = array();
        $q = $request->get('q');
        $user_result = Users::select('id', 'name', 'email')
            ->where('name', 'LIKE', '%' . $q . '%')
            ->where('user_status', 'active')
            ->where('user_type', '5x505')->get();
        foreach ($user_result as $key => $value) {
            $data[] = array('value' => $value->name . ' (' . $value->email . ')', 'id' => $value->id, 'contact_name' => $value->users_name);
        }

        return json_encode($data);
    }

    public function sample()
    {

        return view('Meeting::meeting.sample');
    }

    public function uploadExcel(Request $request)
    {
        try {

            DB::beginTransaction();

            $All = [];
            $html = $request->file('file');
            $path = 'uploads/finance/';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $path = 'uploads/finance/' . date('Y') . '/' . date('m') . '/';

            if ($request->hasFile('file')) {
                $img_file = $html->getClientOriginalName();
                $mime_type = $html->getClientMimeType();
                if (($mime_type == 'application/vnd.ms-excel'|| $mime_type =='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') && $html->getClientOriginalExtension()!="xls"){

                    $reader=Excel::toArray(new ReminderImport, $html);
                    

                    foreach ($reader as $key=>$row) {

                        for ($i = 0; $i < count($row); $i++) {

                            $AppId ='';
                            $Caption = '';
                            $Agenda = '';
                            $Time = '';
                            $Location = '';
                            $Status = '';
                            $Receiver = '';

                            $AppId =$row[$i][0];
                            
                            if (isset($row[$i][1])) {
                                $Caption = $row[$i][1];
                            }
                            if (isset($row[$i][2])) {
                                $Agenda = $row[$i][2];
                            }
                            if (isset($row[$i][3])) {
                                $Time = $row[$i][3];
                            }
                            // $VchrNo = $row[$i][2];
                            // $VDate = $row[$i][3];
                            // $VDate='';
//                             if($i != 0) {
// //                                $unix_date = ($row[$i][3] - 25569) * 86400;
//                                 if(is_numeric ($row[$i][3])){
//                                     $VDate = gmdate("Y-m-d H:i", ($row[$i][3] - 25569) * 86400);
//                                 }else{
//                                     $VDate = date("Y-m-d H:i", strtotime($row[$i][3] ) );
//                                 }
//                             }
                            if ( isset($row[$i][4])) {
                                $Location = $row[$i][4];
                            }
                            if ( isset($row[$i][5])) {
                                $Status = $row[$i][5];
                            }
                            if ( isset($row[$i][6])) {
                                $Receiver = $row[$i][6];
                            }
                            
                            if(!empty($AppId )){
                                array_push($All, array(
                                    "AppId" => $AppId,
                                    "Caption" => $Caption,
                                    "Agenda" => $Agenda,
                                    "Time" => $Time,
                                    "Location" => $Location,
                                    "Status" => $Status,
                                    "Receiver" => $Receiver,
                                ));
                            }
                            
                            
                        }
                    }
                    
                    $html->move($path, $img_file);
                    $filepath = $path . '/' . $img_file;
                } else {
                    Session::flash('error', 'File must be xlsx or csv format');
                    return redirect()->back();
                }
            }
            
            if (count($All) > 1) {
                
                foreach ($All as $key => $data) {
                    if ($key != 0) {


                        $data = array_filter($data);
                        
                        $appInfo = [];
                        $receiverInfo = [];
                        $appInfo = [
                            'app_id' => $data['AppId'],
                            'subject' => 'CRM Meeting Information',
                            'agenda' => $data['Agenda'],
                            'time' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['Time']))->format('F j, Y \a\t g:i A'),
                            'location' => $data['Location'],
                            'status' => $data['Status']
                        ];
                        $userName = Users::where('email', $data['Receiver'])->pluck('name')->first();
                        $appInfo['name'] = $userName;
                        $receiverInfo[] = [
                            'user_email' => $data['Receiver'],
                            'user_phone' => ''
                        ];
                        
                        
                            CommonFunction::sendEmailSMS($data['Caption'], $appInfo, $receiverInfo);
                        
                    }

                }
            }

            DB::commit();

            $EmailData = EmailQueue::where('config_id',1)->select(['app_id', 'caption','email_content','email_to','email_subject'])->get();
            
            Session::flash('success', 'File has been uploaded successfully.');
            return view('Meeting::meeting.html_view', compact('EmailData'));
            

        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . $e->getLine() . $e->getFile());
            return Redirect::back()->withInput();
        }
    }


    

}
