<?php

namespace App\Libraries;

use App\ActionInformation;
use App\AuditLog;
use App\Models\EmailQueue;
use App\Modules\Users\Models\Users;
use App\Modules\Users\Models\Templates;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CommonFunction
{

    /**
     * @param Carbon|string $updated_at
     * @param string $updated_by
     * @return string
     * @internal param $Users->id /string $updated_by
     */
    public static function showAuditLog($updated_at = '', $updated_by = '')
    {
        $update_was = 'Unknown';
        if ($updated_at && $updated_at > '0') {
            $update_was = Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->diffForHumans();
        }

        $user_name = 'Unknown';
        if ($updated_by) {
            $name = Users::where('id', $updated_by)->first();
            if ($name) {
                $user_name = $name->name;
            }
        }
        return '<span class="help-block">Last updated : <i>' . $update_was . '</i> by <b>' . $user_name . '</b></span>';
    }

    public static function showErrorPublic($param, $msg = 'Sorry! Something went wrong! ')
    {
        $j = strpos($param, '(SQL:');
        if ($j > 15) {
            $param = substr($param, 8, $j - 9);
        } else {
            //
        }
        return $msg . $param;
    }

    

    public static function trainingAdmin()
    {
        return ['1x101', '2x202', '2x203', '4x401'];
    }

    

    public static function updatedOn($updated_at = '')
    {
        $update_was = '';
        if ($updated_at && $updated_at > '0') {
            $update_was = Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->diffForHumans();
        }
        return $update_was;
    }

    public static function getUserId()
    {

        if (Auth::user()) {
            return Auth::user()->id;
        } else {
            return 0;
        }
    }

    public static function getUserType()
    {

        if (Auth::user()) {
            return Auth::user()->user_type;
        } else {
            // return 1;
            dd('Invalid User Type');
        }
    }

    public static function GlobalSettings()
    {
        $logoInfo = Logo::orderBy('id', 'DESC')->first();
        if ($logoInfo != "") {
            Session::put('logo', $logoInfo->logo);
            Session::put('title', $logoInfo->title);
            Session::put('manage_by', $logoInfo->manage_by);
            Session::put('help_link', $logoInfo->help_link);
        } else {
            Session::put('logo', 'assets/images/factory_logo.png');
        }
        //return $logoInfo;
    }

    public static function getUserTypeWithZero()
    {

        if (Auth::user()) {
            return Auth::user()->user_type;
        } else {
            return 0;
        }
    }

    

    public static function validateMobileNumber($mobile_no)
    {
        $mobile_validation_err = '';
        $first_digit = substr($mobile_no, 0, 1);
        $first_two_digit = substr($mobile_no, 0, 2);
        $first_four_digit = substr($mobile_no, 0, 4); // without '+'
        $first_five_digit = substr($mobile_no, 0, 5); // with '+'
        // if first two digit is 01
        if (strlen($mobile_no) < 11) {
            $mobile_validation_err = 'Mobile number should be minimum 11 digit';
        } elseif ($first_two_digit == '01') {
            if (strlen($mobile_no) != 11) {
                $mobile_validation_err = 'Mobile number should be 11 digit';
            }
        } // if first four digit is '8801'
        else if ($first_four_digit == '8801') {
            if (strlen($mobile_no) != 13) {
                $mobile_validation_err = 'Mobile number should be 14 digit';
            }
        }// if first five digit is '+8801'
        else if ($first_five_digit == '+8801') {
            if (strlen($mobile_no) != 14) {
                $mobile_validation_err = 'Mobile number should be 14 digit';
            }
        } // if first digit is only
        else if ($first_digit == '+') {
            // Mobile number will be ok
        } else {
            $mobile_validation_err = 'Please enter valid Mobile number';
        }

        if (strlen($mobile_validation_err) > 0) {
            return $mobile_validation_err;
        } else {
            return 'ok';
        }
    }

   

    public static function redirectToLogin()
    {
        echo "<script>location.replace('users/login');</script>";
    }

    public static function formateDate($date = '')
    {
        return date('d.m.Y', strtotime($date));
    }

    public static function convertUTF8($string)
    {
//        $string = 'u0986u09a8u09c7u09beu09dfu09beu09b0 u09b9u09c7u09beu09b8u09beu0987u09a8';
        $string = preg_replace('/u([0-9a-fA-F]+)/', '&#x$1;', $string);
        return html_entity_decode($string, ENT_COMPAT, 'UTF-8');
    }

    public static function showDate($updated_at = '')
    {
        if ($updated_at && $updated_at > '0') {
            $update_was = Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->diffForHumans();
        }

        return '<span class="help-block"><i>' . $update_was . '</i></span>';
    }


    /* This function determines if an user is an admin or sub-admin
     * Based On User Type
     *  */

    public static function isAdmin()
    {
        $user_type = Auth::user()->user_type;
        /*
         * 1x101 for System Admin
         * 5x501 for Agency Admin
         */
        if ($user_type == '1x101') {
            return true;
        } else {
            return false;
        }
    }

    public static function changeDateFormat($datePicker, $mysql = false, $with_time = false)
    {
        try {
            if ($mysql) {
                if ($with_time) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $datePicker)->format('d-M-Y');
                } else {
                    return Carbon::createFromFormat('d-M-Y', $datePicker)->format('Y-m-d');
                }
            } else {
                return Carbon::createFromFormat('Y-m-d', $datePicker)->format('d-M-Y');
            }
        } catch (\Exception $e) {
            if (env('APP_DEBUG')) {
                dd($e);
            } else {
                return $datePicker; //'Some errors occurred (code:793)';
            }
        }
    }


    public static function getFieldName($id, $field, $search, $table)
    {

        if ($id == NULL || $id == '') {
            return '';
        } else {
            return DB::table($table)->where($field, $id)->value($search);
        }
    }


    


    //   ConvParaEx function imported from Report Helper Libraries
    public static function ConvParaEx($sql, $data, $sm = '{$', $em = '}', $optional = false)
    {
        $sql = ' ' . $sql;
        $start = strpos($sql, $sm);
        $i = 0;
        while ($start > 0) {
            if ($i++ > 20) {
                return $sql;
            }
            $end = strpos($sql, $em, $start);
            if ($end > $start) {
                $filed = substr($sql, $start + 2, $end - $start - 2);
                if (strtolower(substr($filed, 0, 8)) == 'optional') {
                    $optionalCond = self::ConvParaEx(substr($filed, 9), $data, '[$', ']', true);
                    $sql = substr($sql, 0, $start) . $optionalCond . substr($sql, $end + 1);
                } else {
                    $inputData = self::getData($filed, $data, substr($sql, 0, $start));
                    if ($optional && (($inputData == '') || ($inputData == "''"))) {
                        $sql = '';
                        break;
                    } else {
                        $sql = substr($sql, 0, $start) . $inputData . substr($sql, $end + 1);
                    }
                }
            }
            $start = strpos($sql, $sm);
        }
        return trim($sql);
    }

    public static function getData($filed, $data, $prefix = null)
    {
        $filedKey = explode('|', $filed);
        $val = trim($data[$filedKey[0]]);
        if (!is_numeric($val)) {
            if ($prefix) {
                $prefix = strtoupper(trim($prefix));
                if (substr($prefix, strlen($prefix) - 3) == 'IN(') {
                    $vals = explode(',', $val);
                    $val = '';
                    for ($i = 0; $i < count($vals); $i++) {
                        if (is_numeric($vals[$i])) {
                            $val .= (strlen($val) > 0 ? ',' : '') . $vals[$i];
                        } else {
                            $val .= (strlen($val) > 0 ? ',' : '') . "'" . $vals[$i] . "'";
                        }
                    }
                } elseif (!(substr($prefix, strlen($prefix) - 1) == "'" || substr($prefix, strlen($prefix) - 1) == "%")) {
                    $val = "'" . $val . "'";
                }
            }
        }
        if ($val == '') $val = "''";
        return $val;
    }

    public static function getNotice($flag = 0)
    {
        if ($flag == 1) {
            $list = DB::select(DB::raw("SELECT date_format(updated_at,'%d %M, %Y') `Date`,heading,details,importance,id, case when importance='Top' then 1 else 0 end Priority FROM notice where status='public' or status='private' order by Priority desc, updated_at desc LIMIT 10"));
        } else {
            $list = DB::select(DB::raw("SELECT date_format(updated_at,'%d %M, %Y') `Date`,heading,details,importance,id, case when importance='Top' then 1 else 0 end Priority FROM notice where status='public' order by Priority desc, updated_at desc LIMIT 10"));
        }
        return $list;
    }


    public static function sendEmailSMS($caption = '', $appInfo = [], $receiverInfo = [])
    {

        try {
            $template = Templates::where('caption', $caption)->first();

            if ($caption == 'APP_RESUBMIT') {
                $template->email_content = str_replace('{$serviceName}', $appInfo['process_type_name'], $template->email_content);
                $template->email_content = str_replace('{$trackingNumber}', $appInfo['tracking_no'], $template->email_content);
            }elseif ($caption == 'CONFIRM_ACCOUNT') {
                $template->email_content = str_replace('{$temporary}', $appInfo['temp_pass'], $template->email_content);
            }

            if ($caption=='CRM_MEETING'){
                $template->email_content = str_replace('{$name}', $appInfo['name'], $template->email_content);
                $template->email_content = str_replace('{$subject}', $appInfo['subject'], $template->email_content);
                $template->email_content = str_replace('{$agenda}', $appInfo['agenda'], $template->email_content);
                $template->email_content = str_replace('{$time}', $appInfo['time'], $template->email_content);
                $template->email_content = str_replace('{$location}', $appInfo['location'], $template->email_content);
            }elseif ($caption=='CRM_MEETING_UPDATE'){
                $template->email_content = str_replace('{$name}', $appInfo['name'], $template->email_content);
                $template->email_content = str_replace('{$status}', $appInfo['status'], $template->email_content);
                $template->email_content = str_replace('{$subject}', $appInfo['subject'], $template->email_content);
                $template->email_content = str_replace('{$agenda}', $appInfo['agenda'], $template->email_content);
                $template->email_content = str_replace('{$time}', $appInfo['time'], $template->email_content);
                $template->email_content = str_replace('{$location}', $appInfo['location'], $template->email_content);
            }elseif($caption=='CRM_MEETING_REMINDER'){
                $template->email_content = str_replace('{$name}', $appInfo['name'], $template->email_content);
                $template->email_content = str_replace('{$subject}', $appInfo['subject'], $template->email_content);
                $template->email_content = str_replace('{$agenda}', $appInfo['agenda'], $template->email_content);
                $template->email_content = str_replace('{$time}', $appInfo['time'], $template->email_content);
                $template->email_content = str_replace('{$location}', $appInfo['location'], $template->email_content);
            }

            $smsBody = $template->sms_content;
            $header = $template->email_subject;
            $param = $template->email_content;
            $caption = $template->caption;
            $email_content = view("Users::message", compact('header', 'param'))->render();

            $emailQueueData = [];
            

            foreach ($receiverInfo as $receiver) {
                $emailQueue = [];
                
                $emailQueue['app_id'] = isset($appInfo['app_id']) ? $appInfo['app_id'] : 0;
                $emailQueue['caption'] = $caption;
                if (!empty($receiver['user_email']) && $template->email_active_status == 1) {
                    $emailQueue['email_content'] = $email_content;
                    $emailQueue['email_to'] = $receiver['user_email'];
                }

                $emailQueue['email_cc'] = !empty($template->email_cc) ? $template->email_cc : '';
                $emailQueue['email_subject'] = $header;
                $emailQueue['sms_content'] = '';
                $emailQueue['sms_to'] = '';
                if (!empty(trim($receiver['user_phone'])) && $template->sms_active_status == 1) {
                    $emailQueue['sms_content'] = $smsBody;
                    $emailQueue['sms_to'] = $receiver['user_phone'];
                }
                $emailQueue['attachment'] = isset($appInfo['attachment']) ? $appInfo['attachment'] : '';
                $emailQueue['attachment_certificate_name'] = isset($appInfo['attachment_certificate_name']) ? $appInfo['attachment_certificate_name'] : '';
                $emailQueue['secret_key'] = '';
                $emailQueue['pdf_type'] = '';
                $emailQueue['created_at'] = date('Y-m-d H:i:s');
                $emailQueue['created_by'] = CommonFunction::getUserId();
                $emailQueue['updated_at'] = date('Y-m-d H:i:s');
                $emailQueue['updated_by'] = CommonFunction::getUserId();

                $emailQueueData[] = $emailQueue;
            }

            EmailQueue::insert($emailQueueData);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getFile(), $e->getLine());
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . ' [CM-1005]');
            return Redirect::back()->withInput();
        }
    }

    public static function dateFromToGenerate($search_time, $search_date)
    {
        if ($search_date) {
            $from = Carbon::parse($search_date);
            $to = Carbon::parse($search_date);
        } else {
            $from = Carbon::now();
            $to = Carbon::now();
        }
        switch ($search_time) {
            case 30:
                $from->subMonth();
                $to->addMonth();
                break;
            case 15:
                $from->subWeeks(2);
                $to->addWeeks(2);
                break;
            case 7:
                $from->subWeek();
                $to->addWeek();
                break;
            case 1:
                $from->subDay();
                $to->addDay();
                break;
            default:
                $from->subDays($search_time);
                $to->addDays($search_time);
        }
        return $dateRange = [$from, $to];
    }

    public static function getEnumList($tableName, $columnName, $doubleCommaExist = false)
    {
        $enumArray = [];

        $enumString = DB::table('information_schema.columns')
            ->where('TABLE_SCHEMA', env('DB_DATABASE'))
            ->where('table_name', $tableName)
            ->where('data_type', 'enum')
            ->where('column_name', $columnName)
            // ->groupBy('column_name')
            ->first(['COLUMN_TYPE']);
        if (!isset($enumString->COLUMN_TYPE)) {
            return $enumArray;
        }

        /*  To eleminate "enum(" and ")" from COLUMN_TYPE   */
        $enumSubString = substr($enumString->COLUMN_TYPE, 5, -1);

        $explodedEnumArray = explode(",", $enumSubString);

        foreach ($explodedEnumArray as $key => $enumElement) {

            /*    */
            $element = substr($enumElement, 1, -1);

            if ($doubleCommaExist) {
                $element = str_replace("''", "'", $element);
            }

            $enumArray[$element] = $element;
        }

        $enumArray = Arr::sort($enumArray);
        return $enumArray;
    }


//     public static function getImageConfig($type)
//     {
//         extract(CommonFunction::getImageDocConfig());
//         $config = Configuration::where('caption', $type)->value('details');
//         $reportHelper = new ReportHelper();
// //        [File Format: *.jpg / *.png Dimension: {$height}x{$width}px File size($filesize)KB]
//         if ($type == 'IMAGE_SIZE') {
//             $data['width'] = ($IMAGE_WIDTH - ($IMAGE_WIDTH * $IMAGE_DIMENSION_PERCENT) / 100) . '-' . ($IMAGE_WIDTH + ($IMAGE_WIDTH * $IMAGE_DIMENSION_PERCENT) / 100);
//             $data['height'] = ($IMAGE_HEIGHT - ($IMAGE_HEIGHT * $IMAGE_DIMENSION_PERCENT) / 100) . '-' . ($IMAGE_HEIGHT + ($IMAGE_HEIGHT * $IMAGE_DIMENSION_PERCENT) / 100);
//             $data['variation'] = $IMAGE_DIMENSION_PERCENT;
//             $data['filesize'] = $IMAGE_SIZE;
//         } elseif ($type == 'DOC_IMAGE_SIZE') {
//             $data['width'] = ($DOC_WIDTH - ($DOC_WIDTH * $IMAGE_DIMENSION_PERCENT) / 100) . '-' . ($DOC_WIDTH + ($DOC_WIDTH * $IMAGE_DIMENSION_PERCENT) / 100);
//             $data['height'] = ($DOC_HEIGHT - ($DOC_HEIGHT * $IMAGE_DIMENSION_PERCENT) / 100) . '-' . ($DOC_HEIGHT + ($DOC_HEIGHT * $IMAGE_DIMENSION_PERCENT) / 100);
//             $data['variation'] = $DOC_DIMENSION_PERCENT;
//             $data['filesize'] = $DOC_SIZE;
//         }
//         $string = $reportHelper->ConvParaEx($config, $data);
//         return $string;
//     }

//     public static function getImageDocConfig()
//     {
//         $config = array();
//         $config['IMAGE_DIMENSION'] = Configuration::where('caption', 'IMAGE_SIZE')->value('value');
//         $config['IMAGE_SIZE'] = Configuration::where('caption', 'IMAGE_SIZE')->value('value2');

//         // Image size
//         $split_img_size = explode('-', $config['IMAGE_SIZE']);
//         $config['IMAGE_MIN_SIZE'] = $split_img_size[0];
//         $config['IMAGE_MAX_SIZE'] = $split_img_size[1];

//         // image dimension
//         $split_img_dimension = explode('x', $config['IMAGE_DIMENSION']);
//         $split_img_variation = explode('~', $split_img_dimension[1]);
//         $config['IMAGE_WIDTH'] = $split_img_dimension[0];
//         $config['IMAGE_HEIGHT'] = $split_img_variation[0];
//         $config['IMAGE_DIMENSION_PERCENT'] = $split_img_variation[1];

//         //image max/min width and height
//         $config['IMAGE_MIN_WIDTH'] = $split_img_dimension[0] - (($split_img_dimension[0] * $split_img_variation[1]) / 100);
//         $config['IMAGE_MAX_WIDTH'] = $split_img_dimension[0] + (($split_img_dimension[0] * $split_img_variation[1]) / 100);

//         $config['IMAGE_MIN_HEIGHT'] = $split_img_variation[0] - (($split_img_variation[0] * $split_img_variation[1]) / 100);
//         $config['IMAGE_MAX_HEIGHT'] = $split_img_variation[0] + (($split_img_variation[0] * $split_img_variation[1]) / 100);

//         //========================= image config end =====================
//         // for doc file
//         $config['DOC_DIMENSION'] = Configuration::where('caption', 'DOC_IMAGE_SIZE')->value('value');
//         $config['DOC_SIZE'] = Configuration::where('caption', 'DOC_IMAGE_SIZE')->value('value2');

//         // Doc size
//         $split_doc_size = explode('-', $config['DOC_SIZE']);
//         $config['DOC_MIN_SIZE'] = $split_doc_size[0];
//         $config['DOC_MAX_SIZE'] = $split_doc_size[1];

//         // doc dimension
//         $split_doc_dimension = explode('x', $config['DOC_DIMENSION']);
//         $split_doc_variation = explode('~', $split_doc_dimension[1]);
//         $config['DOC_WIDTH'] = $split_doc_dimension[0];
//         $config['DOC_HEIGHT'] = $split_doc_variation[0];
//         $config['DOC_DIMENSION_PERCENT'] = $split_doc_variation[1];

//         //doc max/min width and height
//         $config['DOC_MIN_WIDTH'] = $split_doc_dimension[0] - (($split_doc_dimension[0] * $split_doc_variation[1]) / 100);
//         $config['DOC_MAX_WIDTH'] = $split_doc_dimension[0] + (($split_doc_dimension[0] * $split_doc_variation[1]) / 100);

//         $config['DOC_MIN_HEIGHT'] = $split_doc_variation[0] - (($split_doc_variation[0] * $split_doc_variation[1]) / 100);
//         $config['DOC_MAX_HEIGHT'] = $split_doc_variation[0] + (($split_doc_variation[0] * $split_doc_variation[1]) / 100);

//         return $config;
//     }

//     public static function lastAction()
//     {
//         $lastAction = ActionInformation::where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->limit(3)->get([
//             'action',
//             'updated_at',
//         ]);
//         return $lastAction;
//     }

    public static function checkCompleteProfileInfo()
    {
        if (Auth::user()->name == '' || Auth::user()->user_last_name == '' || Auth::user()->phone == '') {
            return false;
        } else {
            return true;
        }
    }

   


    public static function convert_number_to_words($number)
    {
        $common = new CommonFunction;
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $common->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $common->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $common->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $common->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }


    public static function assignedToName($userLists)
    {
        return $userLists->name . ' ' . $userLists->user_middle_name . ' ' . $userLists->user_last_name;
    }

    public static function userNameShow($user_id, $extraPerm = null)
    {
        $user = Users::where('id', $user_id)->first(['name', 'email']);
        if ($user) {
            $name = $user->name;
            $email = $user->email;
            $returnAbleData = $name;
            
            $returnAbleData =  $name . ' (' . $email . ')';
            return $returnAbleData;
        }
        return '';
    }

    public static function userMailShow($user_id)
    {
        $user = Users::where('id', $user_id)->first(['email']);
        if ($user) {
            return $user->email;
        }
        return '';
    }


    public static function stringLimit($string, $limit = 20, $type = false)
    {
        if (strlen($string) > $limit) {
            $stringCut = substr($string, 0, $limit);
            $endPoint = strrpos($stringCut, ' ');
            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= $limit == 100 ? "....<a class='click1' id='" . $type . "' href='javascript:void(0);'>See More</a>" : "... ";
        }
        return $string;
    }

    public static function smsCode($message, $phone)
    {
        $sms_api_url = env('sms_api_url');

        try {
            $generateTocken = SELF::getSMSToken();
            if ($generateTocken['http_code'] != 200) {
                return false;
            }
            $decoded_json = json_decode($generateTocken['data'], true);
            $token = $decoded_json['access_token'];

/////////// SMS sending start
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$sms_api_url",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n\t    \"msg\": \"$message\",\n\t    \"destination\": \"$phone\"\n\t\n}\n",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer $token",
                    "Content-Type: application/json",
                    "Content-Type: text/plain"
                ),
            ));

            $result = curl_exec($curl);
            if (!curl_errno($curl)) {
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            } else {
                $http_code = 0;
            }

            curl_close($curl);
            return ['http_code' => intval($http_code), 'data' => $result];
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

   
    public static function getSMSToken()
    {
        $sms_client_id = env('sms_client_id');
        $sms_client_secret = env('sms_client_secret');
        $sms_idp_url = env('sms_idp_url');
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
                'client_id' => $sms_client_id,
                'client_secret' => $sms_client_secret,
                'grant_type' => 'client_credentials'
            )));
            curl_setopt($curl, CURLOPT_URL, "$sms_idp_url");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            $result = curl_exec($curl);
            if (!curl_errno($curl)) {
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            } else {
                $http_code = 0;
            }
            curl_close($curl);

            return ['http_code' => intval($http_code), 'data' => $result];
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function updateMobileNo($mobileNo)
    {
        $mobileNo = trim($mobileNo);
        if (substr($mobileNo, 0, 3) == '+88') {
            $mobileNo = substr_replace($mobileNo, '88', 0, 3);
        }
//        else if (substr($mobileNo, 0, 3) == '+96') {
//            $mobileNo = substr_replace($mobileNo, '96', 0, 3);
//        } else if (substr($mobileNo, 0, 5) == '00966') {
//            $mobileNo = substr_replace($mobileNo, '966', 0, 5);
//        }
        if ($two_digit = substr($mobileNo, 0, 2) == '01') {
            $mobileNo = '88' . $mobileNo;
        }
//        if ($two_digit = substr($mobileNo, 0, 2) == '05') {
//            $mobileNo = '966' . substr($mobileNo, 1, strlen($mobileNo));
//        }
        $mobileNo = trim($mobileNo, '-');
        return $mobileNo;
    }

    public static function saveEmailNotification($project_name, $milestone_name, $invoice_number, $invoice_amt, $invoice_status, $target_dt)
    {
        $saveData = false;
        $templateObj = Templates::where('caption', 'APP_BILLING')->where('is_archive', 0)->first([
            'id',
            'email_subject',
            'email_content',
            'email_cc',
        ]);
        $emailBody = $templateObj->email_content;
        $emailBody = str_replace('{project_name}', $project_name, $emailBody);
        $emailBody = str_replace('{milestone_name}', $milestone_name, $emailBody);
        $emailBody = str_replace('{}', $invoice_number, $emailBody);
        $emailBody = str_replace('{billing_amt}', $invoice_amt, $emailBody);
        $emailBody = str_replace('{status}', $invoice_status, $emailBody);
        $emailBody = str_replace('{target_dt}', $target_dt, $emailBody);


        $info['template_id'] = $templateObj->id;
        $info['caption'] = 'APP_BILLING';
        $info['subject'] = $templateObj->email_subject;
        $info['email_body'] = $emailBody;

        $accounts_user = Users::where('user_type', '6x606')->get();
        foreach ($accounts_user as $user) {
            $info['email'] = $user->email;
            $info['mobile_no'] = '';
            $template_id = $info['template_id'];

            $header = $info['subject'];
            $param = $info['email_body'];
            $caption = $info['caption'];
            $email_content = view("Users::message", compact('header', 'param'))->render();


            $emailQueue = [];
            
            $emailQueue['app_id'] = 0;
            $emailQueue['caption'] = $caption;
            $emailQueue['email_content'] = $email_content;
            $emailQueue['email_to'] = $info['email'];
            // $ccValArr = Configuration::where('caption', 'CC_EMAIL')->first(['value']);
            // $emailQueue['email_cc'] = $ccValArr ? $ccValArr->value : '';

            $emailQueue['email_subject'] = $header;
            $emailQueue['sms_content'] = '';
            $emailQueue['sms_to'] = '';
            $emailQueue['attachment'] = '';
            $emailQueue['attachment_certificate_name'] = '';
            $emailQueue['secret_key'] = '';
            $emailQueue['pdf_type'] = '';
            $emailQueue['created_at'] = date('Y-m-d H:i:s');
            $emailQueue['updated_at'] = date('Y-m-d H:i:s');
            $emailQueue['template_id'] = $template_id;
            $emailQueue['config_id'] = 1;

            $saveData = EmailQueue::insert($emailQueue);
        }
        return $saveData;
    }

    public static function dateDiff($end_date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $end_date)->diffForHumans();
    }

    public static function getEmployeeId($id)
    {
        $user = Users::select('employee_id', 'office_id')->find($id);
        $empID = "";

        if ($user->employee_id!= null) {
            $empID = $user->employee_id;
        } elseif ($user->office_id != null) {
            $empID = $user->office_id;
        } else {
            $empID = "Office ID Not Found";
        }
        return $empID;
    }

    /*     * ****************************End of Class***************************** */
}
