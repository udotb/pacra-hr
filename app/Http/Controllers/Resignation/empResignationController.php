<?php

namespace App\Http\Controllers\Resignation;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Employees\PacraInterns;
use App\Models\Employees\UsersModel;
use App\Models\Leaves\pacraLeavesBalance;
use App\Models\Resignation\Pacraresignations;
use App\Models\Resignation\PacraresignationTypes;
use App\Models\Resignation\PacraSeparation;
use App\Models\Resignation\PacraSeparationCheckList;
use App\Models\Resignation\PacraTerminations;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class empResignationController extends Controller
{
    public function resignation(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Separation';


        $resignation = Pacraresignations::where('pacra_resignations.user_id', '=', $userId)
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
                'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
                'pacra_resignations.reason',
                'pacra_resignations.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            //->where('users.am_id', '=', $userId )
            ->get();

        $checkSeparationProcess = PacraSeparation::where('user_id', $userId)->get();


        /* $resignation = Pacraresignations::where('user_id', '=',$userId )
             ->get();*/

        // dd($checkSeparationProcess);
        return view('resignation', $this->viewData)
            ->with('resignation', $resignation)
            ->with('checkSeparationProcess', $checkSeparationProcess);
    }


    public function resignationForm(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Separation Form';
        $lastOneYear = date('Y-m-d', strtotime('-1 years'));
        $currentDate = Carbon::now()->toDateString();

        $isRcPart = DB::table('pacra_rc_data')
            ->select('opinion_id', 'date', 'analystId', 'supervisor_id', 'lead_rc', 'name')
            ->leftJoin('og_companies', 'og_companies.id', '=', 'pacra_rc_data.opinion_id')
            ->whereBetween('date', [$lastOneYear, $currentDate])
            ->where('analystId', $userId)
            ->orWhere('supervisor_id', $userId)
            ->orWhere('lead_rc', $userId)
            ->orderBy('name')
            ->get()
            ->groupBy('name');

        if ($request->id == null) {
            $getLeaveBalance = pacraLeavesBalance::where('user_id', '=', $userId)->get();
            $internCheck = PacraInterns::where('user_id', $userId)->count();
            $resignation_types = PacraresignationTypes:: where('isActive', '=', '1')->get();
            return view('resignationForm', $this->viewData)
                ->with('resignation_types', $resignation_types)
                ->with('getLeaveBalance', $getLeaveBalance)
                ->with('isRcPart', $isRcPart)
                ->with('internCheck', $internCheck)
                ->with('userId', $userId);
        } else {
            $resignation = Pacraresignations::where('id', '=', $request->id)->get();
            $resignation_types = PacraresignationTypes:: where('id', '=', $resignation->first()->resignation_type)->get();
            $getLeaveBalance = pacraLeavesBalance::where('user_id', '=', $resignation->first()->user_id)->get();
            $internCheck = PacraInterns::where('user_id', $resignation->first()->user_id)->count();

            return view('resignationForm', $this->viewData)
                ->with('resignation_types', $resignation_types)
                ->with('resignation', $resignation)
                ->with('internCheck', $internCheck)
                ->with('getLeaveBalance', $getLeaveBalance)
                ->with('userId', $userId);
        }
    }


    public function addResignation(Request $request)

    {
        // dd($request->all());
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $uhId = helpers::get_unit_head($amId);

        $this->viewData['meta_title'] = 'Resignation Form';

        $resigDate = strtotime($request->resignation_date);
        $lastWorkingDay = strtotime($request->lWorking_date);

        $datediff = $lastWorkingDay - $resigDate;
        $noticePeriod = $datediff / (60 * 60 * 24);

        if ($noticePeriod > 30) {
            $resigType = 4;
        } elseif ($noticePeriod == 30) {
            $resigType = 3;
        } elseif ($noticePeriod < 30) {
            $resigType = 2;
        }

        //dd($resigType);

        $teamlead = DB::table('og_users')->select('og_users.am_id', 'am.email', 'am.display_name'
            , 'am.id')
            ->leftJoin('og_users as am', 'am.id', '=', 'og_users.am_id')
            ->where('og_users.id', $request->uid)
            ->get();
        $unitHead = DB::table('og_users')->select('og_users.am_id', 'am.email', 'am.display_name'
            , 'am.id')
            ->leftJoin('og_users as am', 'am.id', '=', 'og_users.am_id')
            ->where('og_users.id', $teamlead->first()->id)
            ->get();


        $teamleademail = $teamlead->first()->email;
        $teamleadname = $teamlead->first()->display_name;
        $unitHeademail = $unitHead->first()->email;
        $usermails = DB::table('og_users')->select('email', 'display_name', 'phone', 'doj', 'address')
            ->where('og_users.id', $request->uid)
            ->get();


        $doj = new DateTime($usermails->first()->doj);
        $resignation_date = new DateTime($request->resignation_date);
        $interval = $doj->diff($resignation_date);
        //$periodServed = $interval->format('%y years %m months %d days %h hours %i minutes %S seconds');
        $periodServed = $interval->format('%y years %m months %d days');

        $last_working_day = new DateTime($request->lWorking_date);

        /* $noticePeriod = $resignation_date->diff($last_working_day);
         //$noticePeriod = $noticePeriod->format('%m months %d days');
         $noticePeriod = $noticePeriod->format('%d');*/

        //dd($noticePeriod);


        $usermail = $usermails->first()->email;
        $username = $usermails->first()->display_name;
        $hrmail = 'sehar.shahid@pacra.com';
        $financeEmail = 'aamir.hussain@pacra.com';
        $portalLink = "<a href='http://209.97.168.200/hr/public/resignation'>HRMS</a>";
        $portalLinkApproval = "<a href='https://209.97.168.200/hr/public/resignationApprovals'>HRMS</a>";


        if (!empty($request->recordid)) {
            $recordid = $request->recordid;
        } else {
            $recordid = 0;
        }
        if ($request->submit == 'Save') {

            Pacraresignations::updateOrCreate([
                'id' => $request->recordid,
                'user_id' => $userId,
            ],
                ['user_id' => $userId,
                    'am_id' => $amId,
                    'uh_id' => $uhId,
                    'resignation_type' => $resigType,
                    'resignation_date' => $request->resignation_date,
                    'last_working_day' => $request->lWorking_date,
                    'leave_balance' => $request->leaveBalance,
                    'inRC' => $request->inRC,
                    'reason' => $request->reason,
                    'total_period_served' => $periodServed,
                    'notice_period_days' => $noticePeriod,
                    'address' => $usermails->first()->address,
                    'phone' => $usermails->first()->phone,
                    'email' => $usermails->first()->email,
                    'status' => $request->submit,
                ]);
        } elseif ($request->submit == 'Entered') {

            $resignationID = Pacraresignations::updateOrCreate([
                'id' => $request->recordid,
                'user_id' => $userId,
            ],
                ['user_id' => $userId,
                    'am_id' => $amId,
                    'uh_id' => $uhId,
                    'resignation_type' => $resigType,
                    'resignation_date' => $request->resignation_date,
                    'last_working_day' => $request->lWorking_date,
                    'leave_balance' => $request->leaveBalance,
                    'inRC' => $request->inRC,
                    'reason' => $request->reason,
                    'total_period_served' => $periodServed,
                    'notice_period_days' => $noticePeriod,
                    'address' => $usermails->first()->address,
                    'phone' => $usermails->first()->phone,
                    'email' => $usermails->first()->email,
                    'status' => $request->submit,
                ]);


            Mail::send([], [], function ($message) use ($request, $teamleademail, $usermail, $hrmail, $username, $portalLink) {

                $message->to($usermail)
                    ->subject($username . ' Resignation Submitted')
                    ->setBody('<h1>Dear ' . $username . ' </h1>
                        <br>Your Resignation Submitted Successfully<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });


            Mail::send([], [], function ($message) use ($request, $teamleademail, $portalLinkApproval, $usermail, $hrmail, $unitHeademail, $username, $teamleadname, $portalLink) {

                $message->to($teamleademail)
                    ->cc($unitHeademail)
                    ->cc($hrmail)
                    ->subject($username . ' Resignation Submitted ')
                    ->setBody('<h1>Dear ' . $teamleadname . '</h1>
                        <br>Your team member ' . $username . ' has entered Resignation.<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLinkApproval, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

        } else {
            $resignationID = Pacraresignations::updateOrCreate([
                'id' => $request->recordid,
            ],
                ['user_id' => $request->uid,
                    'resignation_type' => $resigType,
                    'resignation_date' => $request->resignation_date,
                    'last_working_day' => $request->lWorking_date,
                    'leave_balance' => $request->leaveBalance,
                    'inRC' => $request->inRC,
                    'reason' => $request->reason,
                    'total_period_served' => $periodServed,
                    'notice_period_days' => $noticePeriod,
                    'address' => $usermails->first()->address,
                    'phone' => $usermails->first()->phone,
                    'email' => $usermails->first()->email,
                    'status' => $request->submit,
                ]);

            Mail::send([], [], function ($message) use ($request, $teamleademail, $usermail, $hrmail, $username, $portalLink, $unitHeademail, $financeEmail) {

                $message->to($usermail)
                    ->cc($unitHeademail)
                    ->cc($hrmail)
                    ->subject('Dear' . $username . 'TL' . $request->submit . 'Your Resignation')
                    ->setBody('<h1>Dear ' . $username . ' </h1>
                        <br>Your Team Lead has  ' . $request->submit . ' your Resignation. <br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

        }

        $message = 'Your Resignation Submitted Successfully!';

        return redirect()->route('empSeparationForm', ['id' => $resignationID->id]);


        // return redirect()->back()->with('message',$message );

    }


    public function resignationApprovals(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Resignation';
        $resignation = Pacraresignations::where('pacra_resignations.am_id', '=', $userId)->whereNull('pacra_resignations.terminated')->whereNull('pacra_resignations.internship_ended')
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
                'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
                'pacra_resignations.reason',
                'pacra_resignations.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->where('pacra_resignations.status', '=', 'Entered')
            ->get();
        $checkSeparationProcess = PacraSeparation::where('user_id', $userId)->get();

        // dd($resignation);
        return view('resignation', $this->viewData)
            ->with('resignation', $resignation)
            ->with('checkSeparationProcess', $checkSeparationProcess)
            ->with('userId', $userId);
    }


    public function empSeparationForm(Request $request)

    {

        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation Form';

        $resignation = Pacraresignations::where('pacra_resignations.id', '=', $request->id)
            ->get();
        $leaveBalance = pacraLeavesBalance::where('user_id', '=', $resignation->first()->user_id)
            ->pluck('current_balance');
        // dd($resignation->first()->user_id );
        // dd($leaveBalance->first());
        $seprattionCheckList = PacraSeparationCheckList::where('isActive', 1)
            ->get();

        if ($resignation->first()->user_id == $userId) {
            //  dd('emp');
            $seprationDetails = UsersModel:: where('pacra_resignations.id', '=', $request->id)
                ->select('og_users.display_name', 'og_designations.title as designation', 'og_users.doj', 'pacra_resignations.id as regisID',
                    'pacra_resignations.user_id as uuid', 'pacra_resignations.am_id as amID', 'pacra_resignations.resignation_type as resigType',
                    'pacra_resignations.uh_id as uhID', 'pacra_resignations.email',
                    'pacra_resignations.phone', 'pacra_resignations.address', 'pacra_resignations.resignation_date',
                    'pacra_resignations.last_working_day', 'pacra_resignations.reason', 'pacra_resignations.inRC', 'pacra_resignations.total_period_served',
                    'pacra_resignations.notice_period_days', 'og_companies.name as client')
                ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
                ->leftjoin('pacra_resignations', 'pacra_resignations.user_id', '=', 'og_users.id')
                ->leftjoin('og_companies', 'og_companies.id', '=', 'pacra_resignations.inRC')
                //->where('pacra_resignations.status', '=', 'Approved')
                ->orderBY('pacra_resignations.id', 'DESC')
                ->Limit(1, 1)
                ->get();

            return view('separation', $this->viewData)
                ->with('seprationDetails', $seprationDetails)
                ->with('seprattionCheckList', $seprattionCheckList)
                ->with('userRights', $userRights)
                ->with('userId', $userId);
        } elseif ($resignation->first()->am_id == $userId) {
            // dd('team');
            $seprationDetails = UsersModel::where('og_users.id', '=', $userId)
                ->select('og_users.id as ID', 'og_users.display_name', 'og_designations.title as designation', 'og_users.designation_id',
                    'pacra_resignations.resignation_type as resigType', 'pacra_resignations.notice_period_days')
                ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
                ->leftjoin('pacra_resignations', 'pacra_resignations.am_id', '=', 'og_users.id')
                ->get();

            $checkPortfolio = DB::table('pacra_portfolio')
                ->select('company_id', 'user_id', 'manager_id', 'lead_rc_id')
                ->where('user_id', $resignation->first()->user_id)
                ->orWhere('manager_id', $resignation->first()->user_id)
                ->orWhere('lead_rc_id', $resignation->first()->user_id)
                ->get();


            //dd($checkPortfolio);
            return view('separation', $this->viewData)
                ->with('seprationDetails', $seprationDetails)
                ->with('seprattionCheckList', $seprattionCheckList)
                ->with('resignation', $resignation)
                ->with('checkPortfolio', $checkPortfolio)
                ->with('userRights', $userRights)
                ->with('userId', $userId);
        } else {
            // dd('team');
            $seprationDetails = UsersModel::where('og_users.id', '=', $userId)
                ->select('og_users.id as ID', 'og_users.display_name', 'og_designations.title as designation', 'og_users.designation_id')
                ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
                ->get();
            return view('separation', $this->viewData)
                ->with('seprationDetails', $seprationDetails)
                ->with('seprattionCheckList', $seprattionCheckList)
                ->with('resignation', $resignation)
                ->with('leaveBalance', $leaveBalance)
                ->with('userRights', $userRights)
                ->with('leaveBalance', $leaveBalance)
                ->with('userId', $userId);
        }


    }

    public function TlSeparationList(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation List';
        $resignationDetail = Pacraresignations::where('status', '=', 'Approved')
            ->get();
        $designationArray = array(1, 2, 3, 4, 5, 9, 10, 16, 26);
        $unitHeadArray = array();

        $resignation = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            ->where('pacra_resignations.am_id', $userId)
            ->where('pacra_resignations.status', '=', 'Approved')
//            ->orWhere('pacra_resignations.status', '=', 'tl_submit')
            ->get();

//         dd($resignation);

        return view('TLseparationList', $this->viewData)
            ->with('resignation', $resignation)
            ->with('userId', $userId)
            ->with('userRights', $userRights);
    }


    public function TLempSeparationForm(Request $request)

    {

        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation Form';

        $resignation = Pacraresignations::where('pacra_resignations.id', '=', $request->id)
            ->get();

        $resignation_types = PacraresignationTypes:: where('id', '=', $resignation->first()->resignation_type)->get();


        $leaveBalance = pacraLeavesBalance::where('user_id', '=', $resignation->first()->user_id)
            ->pluck('current_balance');
        $seprattionCheckList = PacraSeparationCheckList::where('isActive', 1)
            ->get();

        $seprationDetails = UsersModel::where('og_users.id', '=', $userId)
            ->select('og_users.id as ID', 'og_users.display_name', 'og_designations.title as designation', 'og_users.designation_id',
                'pacra_resignations.resignation_type as resigType', 'pacra_resignations.notice_period_days')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->leftjoin('pacra_resignations', 'pacra_resignations.am_id', '=', 'og_users.id')
            ->get();

        //dd($resignation_types);

        $checkPortfolio = DB::table('pacra_portfolio')
            ->select('company_id', 'user_id', 'manager_id', 'lead_rc_id')
            ->where('user_id', $resignation->first()->user_id)
            ->orWhere('manager_id', $resignation->first()->user_id)
            ->orWhere('lead_rc_id', $resignation->first()->user_id)
            ->get();

        return view('TLseparationForm', $this->viewData)
            ->with('seprationDetails', $seprationDetails)
            ->with('seprattionCheckList', $seprattionCheckList)
            ->with('resignation', $resignation)
            ->with('checkPortfolio', $checkPortfolio)
            ->with('resignation_types', $resignation_types)
            ->with('userRights', $userRights)
            ->with('userId', $userId);


    }


    public function separationMIT(Request $request)

    {


        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation List';
        $resignationDetail = Pacraresignations::where('status', '=', 'Approved')
            ->get();
        $designationArray = array(1, 2, 3, 4, 5, 9, 10, 16, 26);
        $unitHeadArray = array();

        $resignation = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->rightjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            // ->where('pacra_emp_separation.section_two_name', !Null)
            ->where('pacra_emp_separation.section_three_name', Null)
            ->get();

        //dd($resignation);

        return view('MITseparationList', $this->viewData)
            ->with('resignation', $resignation)
            ->with('userId', $userId)
            ->with('userRights', $userRights);
    }

    public function MITempSeparationForm(Request $request)

    {

        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation Form';

        $resignation = Pacraresignations::where('pacra_resignations.id', '=', $request->id)
            ->get();
        $leaveBalance = pacraLeavesBalance::where('user_id', '=', $resignation->first()->user_id)
            ->pluck('current_balance');

        $seprattionCheckList = PacraSeparationCheckList::where('isActive', 1)
            ->get();


        // dd('team');
        $seprationDetails = UsersModel::where('og_users.id', '=', $userId)
            ->select('og_users.id as ID', 'og_users.display_name', 'og_designations.title as designation', 'og_users.designation_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->get();
        return view('MITseparationForm', $this->viewData)
            ->with('seprationDetails', $seprationDetails)
            ->with('seprattionCheckList', $seprattionCheckList)
            ->with('resignation', $resignation)
            ->with('leaveBalance', $leaveBalance)
            ->with('userRights', $userRights)
            ->with('leaveBalance', $leaveBalance)
            ->with('userId', $userId);


    }


    public function separationAdmin(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation List';
        $resignationDetail = Pacraresignations::where('status', '=', 'Approved')
            ->get();
        $designationArray = array(1, 2, 3, 4, 5, 9, 10, 16, 26);
        $unitHeadArray = array();


        $resignation = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->rightjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            // ->where('pacra_emp_separation.section_two_name', !Null)
            ->where('pacra_emp_separation.section_four_name', Null)
            ->get();

        //dd($userRights);

        return view('AdminSeparationList', $this->viewData)
            ->with('resignation', $resignation)
            ->with('userId', $userId)
            ->with('userRights', $userRights);
    }

    public function AdminEmpSeparationForm(Request $request)

    {

        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation Form';

        $resignation = Pacraresignations::where('pacra_resignations.id', '=', $request->id)
            ->get();
        $leaveBalance = pacraLeavesBalance::where('user_id', '=', $resignation->first()->user_id)
            ->pluck('current_balance');

        $seprattionCheckList = PacraSeparationCheckList::where('isActive', 1)
            ->get();


        // dd('team');
        $seprationDetails = UsersModel::where('og_users.id', '=', $userId)
            ->select('og_users.id as ID', 'og_users.display_name', 'og_designations.title as designation', 'og_users.designation_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->get();
        return view('AdminSeparationForm', $this->viewData)
            ->with('seprationDetails', $seprationDetails)
            ->with('seprattionCheckList', $seprattionCheckList)
            ->with('resignation', $resignation)
            ->with('leaveBalance', $leaveBalance)
            ->with('userRights', $userRights)
            ->with('leaveBalance', $leaveBalance)
            ->with('userId', $userId);


    }


    public function separationHR(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation List';
        $resignationDetail = Pacraresignations::where('status', '=', 'Approved')
            ->get();
        $designationArray = array(1, 2, 3, 4, 5, 9, 10, 16, 26);
        $unitHeadArray = array();


        $resignation = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->rightjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
//             ->where('pacra_emp_separation.section_two_name', Null)
            ->where('pacra_emp_separation.section_five_name', Null)
            ->get();
//        dd($resignation);

        //dd($userRights);

        return view('HRseparationList', $this->viewData)
            ->with('resignation', $resignation)
            ->with('userId', $userId)
            ->with('userRights', $userRights);
    }

    public function HREmpSeparationForm(Request $request)

    {

        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation Form';

        $resignation = Pacraresignations::where('pacra_resignations.id', '=', $request->id)
            ->get();
        $leaveBalance = pacraLeavesBalance::where('user_id', '=', $resignation->first()->user_id)
            ->pluck('current_balance');

        $seprattionCheckList = PacraSeparationCheckList::where('isActive', 1)
            ->get();


        // dd('team');
        $seprationDetails = UsersModel::where('og_users.id', '=', $userId)
            ->select('og_users.id as ID', 'og_users.display_name', 'og_designations.title as designation', 'og_users.designation_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->get();
        return view('HRSeparationForm', $this->viewData)
            ->with('seprationDetails', $seprationDetails)
            ->with('seprattionCheckList', $seprattionCheckList)
            ->with('resignation', $resignation)
            ->with('leaveBalance', $leaveBalance)
            ->with('userRights', $userRights)
            ->with('leaveBalance', $leaveBalance)
            ->with('userId', $userId);

    }


    public function separationFinance(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation List';
        $resignationDetail = Pacraresignations::where('status', '=', 'Approved')
            ->get();
        $designationArray = array(1, 2, 3, 4, 5, 9, 10, 16, 26);
        $unitHeadArray = array();

        $startDate = Carbon::now();
        $firstDay = $startDate->subMonths(3)->format('Y-m-d');

        $resignation = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            ->whereDate('pacra_emp_separation.updated_at', '>', $firstDay)
            ->whereNull('pacra_emp_separation.section_seven_name')
            ->where(function ($subQuery) {
                return $subQuery
                    ->whereNotNull('pacra_emp_separation.section_two_name')
                    ->whereNotNull('pacra_emp_separation.section_three_name')
                    ->whereNotNull('pacra_emp_separation.section_four_name')
                    ->whereNotNull('pacra_emp_separation.section_five_name');
            })
            ->orderBy('pacra_emp_separation.date_by_emp', 'DESC')
            ->get();


        return view('FinanceSeparationList', $this->viewData)
            ->with('resignation', $resignation)
//            ->with('resignation2', $resignation2)
            ->with('userId', $userId)
            ->with('userRights', $userRights);
    }

    public function settlementFinance(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Settlement List';

        $startDate = Carbon::now();
        $firstDay = $startDate->subMonths(6)->format('Y-m-d');

        $resignation = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            ->whereDate('pacra_emp_separation.updated_at', '>', $firstDay)
            ->whereNotNull('pacra_emp_separation.section_eight_name')
//            ->whereNull('pacra_emp_separation.paid')
            ->orderBy('pacra_emp_separation.date_by_emp', 'DESC')
            ->get();

        return view('FinanceSettelmentList', $this->viewData)
            ->with('resignation', $resignation)
            ->with('userId', $userId)
            ->with('userRights', $userRights);
    }

    public function clearFinalSettlement($id)
    {
        $rt = new PacraSeparation();
        $ids = $rt->find($id);
        $ids['paid'] = 'Paid';
        $ids->save();
        return back();
    }

    public function FinanceEmpSeparationForm(Request $request)

    {

        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation Form';

        $resignation = Pacraresignations::where('pacra_resignations.id', '=', $request->id)
            ->get();
        $leaveBalance = pacraLeavesBalance::where('user_id', '=', $resignation->first()->user_id)
            ->pluck('current_balance');

        $seprattionCheckList = PacraSeparationCheckList::where('isActive', 1)
            ->get();


        // dd('team');
        $seprationDetails = UsersModel::where('og_users.id', '=', $userId)
            ->select('og_users.id as ID', 'og_users.display_name', 'og_designations.title as designation', 'og_users.designation_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->get();
        return view('FinanceSeparationForm', $this->viewData)
            ->with('seprationDetails', $seprationDetails)
            ->with('seprattionCheckList', $seprattionCheckList)
            ->with('resignation', $resignation)
            ->with('leaveBalance', $leaveBalance)
            ->with('userRights', $userRights)
            ->with('leaveBalance', $leaveBalance)
            ->with('userId', $userId);

    }


    public function separationCEO(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation List';
        $resignationDetail = Pacraresignations::where('status', '=', 'Approved')
            ->get();
        $designationArray = array(1, 2, 3, 4, 5, 9, 10, 16, 26);
        $unitHeadArray = array();
        $startDate = Carbon::now();
        $firstDay = $startDate->subMonths(3)->format('Y-m-d');

        $resignation = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->rightjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
//            ->where('pacra_emp_separation.section_eight_name', Null)
            ->whereDate('pacra_emp_separation.updated_at', '>', $firstDay)
            ->get();

        //dd($resignation);

        return view('CeoSeparationList', $this->viewData)
            ->with('resignation', $resignation)
            ->with('userId', $userId)
            ->with('userRights', $userRights);
    }

    public function CEOEmpSeparationForm(Request $request)

    {

        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation Form';

        $resignation = Pacraresignations::where('pacra_resignations.id', '=', $request->id)
            ->get();
        $leaveBalance = pacraLeavesBalance::where('user_id', '=', $resignation->first()->user_id)
            ->pluck('current_balance');

        $seprattionCheckList = PacraSeparationCheckList::where('isActive', 1)
            ->get();


        // dd('team');
        $seprationDetails = UsersModel::where('og_users.id', '=', $userId)
            ->select('og_users.id as ID', 'og_users.display_name', 'og_designations.title as designation', 'og_users.designation_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->get();
        return view('CeoSeparationForm', $this->viewData)
            ->with('seprationDetails', $seprationDetails)
            ->with('seprattionCheckList', $seprattionCheckList)
            ->with('resignation', $resignation)
            ->with('leaveBalance', $leaveBalance)
            ->with('userRights', $userRights)
            ->with('leaveBalance', $leaveBalance)
            ->with('userId', $userId);

    }


    public function SeparationFormPreview(Request $request)

    {
        $this->viewData['meta_title'] = 'Separation Form';

        $resignation = Pacraresignations::where('pacra_resignations.id', '=', $request->id)
            ->get();

        $seprationDetails = UsersModel:: where('pacra_resignations.id', '=', $request->id)
            ->select('og_users.display_name as empName', 'og_designations.title as empDesignation', 'og_users.doj as empDoj', 'pacra_resignations.id as regisID',
                'pacra_resignations.user_id as uuid', 'pacra_resignations.am_id as amID', 'pacra_resignations.resignation_type as resigType',
                'pacra_resignations.uh_id as uhID', 'pacra_resignations.email as empOfficialEmail',
                'pacra_resignations.phone as empPhone', 'pacra_resignations.address as empAddress', 'pacra_resignations.resignation_date',
                'pacra_resignations.last_working_day', 'pacra_resignations.reason', 'pacra_resignations.inRC', 'pacra_resignations.total_period_served',
                'pacra_resignations.notice_period_days', 'og_companies.name as client',
                'pacra_emp_separation.emp_check_list', 'pacra_emp_separation.date_by_emp',
                'sign.sign as empSignature')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->leftjoin('pacra_resignations', 'pacra_resignations.user_id', '=', 'og_users.id')
            ->leftjoin('og_companies', 'og_companies.id', '=', 'pacra_resignations.inRC')
            ->leftJoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', 'pacra_resignations.id')
            ->leftJoin('sign', 'sign.u_id', 'pacra_resignations.user_id')

            //->where('pacra_resignations.status', '=', 'Approved')
            ->orderBY('pacra_resignations.id', 'DESC')
            ->Limit(1, 1)
            ->get();


        $getEmpList = PacraSeparationCheckList::whereIN('id', [1, 2, 3, 4, 5])->get();
        $getTLList = PacraSeparationCheckList::whereIN('id', [6, 7, 8])->get();
        $getMitList = PacraSeparationCheckList::whereIN('id', [9, 10, 11, 12])->get();
        $getAdminList = PacraSeparationCheckList::whereIN('id', [13, 14, 15, 16, 24])->get();
        $getHRList = PacraSeparationCheckList::whereIN('id', [17, 18, 19, 20, 21])->get();
        $getFinList = PacraSeparationCheckList::whereIN('id', [22, 23])->get();

        $explode_id = array_map('intval', explode(',', $seprationDetails->first()->emp_check_list));

        $getEmpCheckList = PacraSeparationCheckList::whereIn('id', $explode_id)->get();

        $getTlData = PacraSeparation::where('pacra_emp_separation.resign_id', '=', $request->id)
            ->select('pacra_emp_separation.section_two_date', 'pacra_emp_separation.commentShortNotice',
                'pacra_emp_separation.section_two_comment', 'pacra_emp_separation.section_two_check_list',
                'og_users.display_name as TLName', 'og_designations.title as TlDesig', 'sign.sign as TlSign')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'pacra_emp_separation.section_two_designation')
            ->leftjoin('og_users', 'og_users.id', '=', 'pacra_emp_separation.section_two_name')
            ->leftJoin('sign', 'sign.u_id', 'pacra_emp_separation.section_two_name')
            ->get();

        $TLexplode_id = array_map('intval', explode(',', $getTlData->first()->section_two_check_list));
        $getTLCheckList = PacraSeparationCheckList::whereIn('id', $TLexplode_id)->get();


        $getMITData = PacraSeparation::where('pacra_emp_separation.resign_id', '=', $request->id)
            ->select('pacra_emp_separation.section_three_date',
                'pacra_emp_separation.section_three_comment', 'pacra_emp_separation.section_three_check_list',
                'og_users.display_name as MITName', 'og_designations.title as MITDesig', 'sign.sign as MITSign')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'pacra_emp_separation.section_three_designation')
            ->leftjoin('og_users', 'og_users.id', '=', 'pacra_emp_separation.section_three_name')
            ->leftJoin('sign', 'sign.u_id', 'pacra_emp_separation.section_three_name')
            ->get();

        $MITexplode_id = array_map('intval', explode(',', $getMITData->first()->section_three_check_list));

        $getMITCheckList = PacraSeparationCheckList::whereIn('id', $MITexplode_id)->get();

        $getAdminData = PacraSeparation::where('pacra_emp_separation.resign_id', '=', $request->id)
            ->select('pacra_emp_separation.section_four_date',
                'pacra_emp_separation.section_four_comment', 'pacra_emp_separation.section_four_check_list',
                'pacra_emp_separation.section_four_cost',
                'og_users.display_name as AdminName', 'og_designations.title as AdminDesig',
                'sign.sign as AdminSign')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'pacra_emp_separation.section_four_designation')
            ->leftjoin('og_users', 'og_users.id', '=', 'pacra_emp_separation.section_four_name')
            ->leftJoin('sign', 'sign.u_id', 'pacra_emp_separation.section_four_name')
            ->get();

        $AdminExplode_id = array_map('intval', explode(',', $getAdminData->first()->section_four_check_list));

        $getAdminCheckList = PacraSeparationCheckList::whereIn('id', $AdminExplode_id)->get();

        $getHRData = PacraSeparation::where('pacra_emp_separation.resign_id', '=', $request->id)
            ->select('pacra_emp_separation.section_five_date',
                'pacra_emp_separation.section_five_comment', 'pacra_emp_separation.section_five_check_list',
                'pacra_emp_separation.leave_balance',
                'og_users.display_name as HRName', 'og_designations.title as HRDesig',
                'sign.sign as HRSign')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'pacra_emp_separation.section_five_designation')
            ->leftjoin('og_users', 'og_users.id', '=', 'pacra_emp_separation.section_five_name')
            ->leftJoin('sign', 'sign.u_id', 'pacra_emp_separation.section_five_name')
            ->get();

        $HRExplode_id = array_map('intval', explode(',', $getHRData->first()->section_five_check_list));

        $getHRCheckList = PacraSeparationCheckList::whereIn('id', $HRExplode_id)->get();

        $getFinanceData = PacraSeparation::where('pacra_emp_separation.resign_id', '=', $request->id)
            ->select('pacra_emp_separation.section_seven_date',
                'pacra_emp_separation.section_seven_comment', 'pacra_emp_separation.section_seven_check_list',
                'pacra_emp_separation.leave_balance', 'pacra_emp_separation.settlement_date',
                'og_users.display_name as FinancaName', 'og_designations.title as FinancaDesig',
                'sign.sign as FinancaSign')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'pacra_emp_separation.section_seven_designation')
            ->leftjoin('og_users', 'og_users.id', '=', 'pacra_emp_separation.section_seven_name')
            ->leftJoin('sign', 'sign.u_id', 'pacra_emp_separation.section_seven_name')
            ->get();

        $FinanceExplode_id = array_map('intval', explode(',', $getFinanceData->first()->section_seven_check_list));
        $getFinanceCheckList = PacraSeparationCheckList::whereIn('id', $FinanceExplode_id)->get();


        $getCeoData = PacraSeparation::where('pacra_emp_separation.resign_id', '=', $request->id)
            ->select('pacra_emp_separation.section_eight_date',
                'pacra_emp_separation.section_eight_comment',
                'og_users.display_name as CeoName', 'og_designations.title as CeoDesig',
                'sign.sign as CeoSign')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'pacra_emp_separation.section_eight_designation')
            ->leftjoin('og_users', 'og_users.id', '=', 'pacra_emp_separation.section_eight_name')
            ->leftJoin('sign', 'sign.u_id', 'pacra_emp_separation.section_eight_name')
            ->get();

        //dd($seprationDetails->first()->emp_check_list);

        return view('SeparationFormPreview', $this->viewData)
            ->with('seprationDetails', $seprationDetails)
            ->with('getEmpCheckList', $getEmpCheckList)
            ->with('getTlData', $getTlData)
            ->with('getTLCheckList', $getTLCheckList)
            ->with('getMITData', $getMITData)
            ->with('getMITCheckList', $getMITCheckList)
            ->with('getAdminData', $getAdminData)
            ->with('getAdminCheckList', $getAdminCheckList)
            ->with('getHRData', $getHRData)
            ->with('getHRCheckList', $getHRCheckList)
            ->with('getFinanceData', $getFinanceData)
            ->with('getFinanceCheckList', $getFinanceCheckList)
            ->with('AdminExplode_id', $AdminExplode_id)
            ->with('explode_id', $explode_id)
            ->with('TLexplode_id', $TLexplode_id)
            ->with('MITexplode_id', $MITexplode_id)
            ->with('HRExplode_id', $HRExplode_id)
            ->with('FinanceExplode_id', $FinanceExplode_id)
            ->with('getEmpList', $getEmpList)
            ->with('getTLList', $getTLList)
            ->with('getMitList', $getMitList)
            ->with('getAdminList', $getAdminList)
            ->with('getFinList', $getFinList)
            ->with('getHRList', $getHRList)
            ->with('resignation', $resignation)
            ->with('getCeoData', $getCeoData);

    }


    public function separationList(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation List';
        $resignationDetail = Pacraresignations::where('status', '=', 'Approved')
            ->get();

        //dd($resignationDetail);


        $designationArray = array(1, 2, 3, 4, 5, 9, 10, 16, 26);
        $unitHeadArray = array();


        /*elseif(in_array($userDesignation, $designationArray)){
            $resignation  = Pacraresignations::where('pacra_resignations.uh_id', '=', $userId)
                ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                    'pacra_resignations.id as resigID','pacra_resignations.user_id','pacra_resignations.am_id as teamLead',
                    'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
                    'pacra_resignations.reason',
                    'pacra_resignations.status'
                )
                ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
                ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
                //->where('users.am_id', '=', $userId )
                ->get();
        }*/

        $resignation = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->rightjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            ->get();

        return view('separationList', $this->viewData)
            ->with('resignation', $resignation)
            ->with('userId', $userId)
            ->with('userRights', $userRights);

    }


    public function addSeparation(Request $request)

    {
        //dd($request->all());

        $getResignationDetails = Pacraresignations::where('id', $request->regisID)->first();


        $usermails = DB::table('og_users')->select('email', 'display_name', 'phone', 'doj', 'address', 'pemail')
            ->where('og_users.id', $getResignationDetails->user_id)
            ->first();

        $teamlead = DB::table('og_users')->select('og_users.am_id', 'am.email', 'am.display_name', 'am.id')
            ->leftJoin('og_users as am', 'am.id', '=', 'og_users.am_id')
            ->where('og_users.id', $getResignationDetails->user_id)
            ->get();
        $unitHead = DB::table('og_users')->select('og_users.am_id', 'am.email', 'am.display_name', 'am.id')
            ->leftJoin('og_users as am', 'am.id', '=', 'og_users.am_id')
            ->where('og_users.id', $teamlead->first()->id)
            ->get();


        $usermail = $usermails->email;
        $userPersonalEmail = $usermails->email;
        $username = $usermails->display_name;
        $teamleademail = $teamlead->first()->email;
        $teamleadname = $teamlead->first()->display_name;
        $unitHeademail = $unitHead->first()->email;
        $hrmail = helpers::hrEmail(Auth::id());
        $mitEmail = helpers::mitEmail(Auth::id());
        $adminEmail = helpers::adminEmail(Auth::id());
        $financeEmail = helpers::financeEmail(Auth::id());
        $ceoEmail = helpers::ceoEmail(Auth::id());
        $portalLink = "<a href='http://209.97.168.200/hr/public/resignation'>HRMS</a>";
        //dd($hrmail);

        if (!empty($request->chklist)) {
            $emp_check_list = implode(",", $request->chklist);
        }
        $currentDate = Carbon::now()->toDateString();

        //dd($currentDate);

        //dd($request->all());
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Separation Form';


        if ($request->submit == 'emp_submit') {
            PacraSeparation::updateOrCreate([
                'user_id' => $request->uuid,
                'resign_id' => $request->regisID,
                'emp_reason_short_notice' => $request->ReasonShortNotice,
                'emp_check_list' => $emp_check_list,
                'date_by_emp' => $currentDate
            ]);

            Mail::send([], [], function ($message) use ($request, $teamleademail, $usermail, $hrmail, $username, $portalLink) {

                $message->to($usermail)
                    ->subject($username . 'Submit His/Her Sepration Form')
                    ->setBody('<h1>Dear ' . $username . ' </h1>
                    <br>Your Sepration Form Submitted Successfully<br>
                    <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

            $portalLink = "<a href='http://209.97.168.200/hr/public/TlSeparationList'>HRMS</a>";

            Mail::send([], [], function ($message) use ($request, $teamleademail, $usermail, $hrmail, $username, $teamleadname, $portalLink) {

                $message->to($teamleademail)
                    ->subject($username . ' Submitted His/Her Sepration Form')
                    ->setBody('<h1>Dear ' . $teamleadname . '</h1>
                    <br>' . $username . ' Submitted His/Her Sepration Form<br>
                    <br>Thank you.<br>
                    <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });


        } elseif ($request->submit == 'tl_submit') {
            PacraSeparation::updateOrCreate([
                'resign_id' => $request->regisID,
            ],
                ['section_two_name' => $request->userID,
                    'section_two_designation' => $request->DesigID,
                    'section_two_date' => $currentDate,
                    'section_two_comment' => $request->comments,
                    'commentShortNotice' => $request->commentShortNotice,
                    'section_two_check_list' => $emp_check_list
                ]);


            $resignationID = Pacraresignations::updateOrCreate([
                'id' => $request->regisID,
            ],
                [
                    'status' => $request->submit,
                ]);


            $portalLink = "<a href='http://209.97.168.200/hr/public/separationMIT'>HRMS</a>";
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $userPersonalEmail, $hrmail, $username, $portalLink, $unitHeademail, $mitEmail) {
                $message->to($mitEmail)
                    ->cc($userPersonalEmail)
                    ->cc($teamleademail)
                    ->cc($unitHeademail)
                    ->subject($teamleadname . 'Submitted Separation Form of ' . $username)
                    ->setBody($teamleadname . 'Submitted Separation Form of ' . $username . '
                        <br><h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });


        } elseif ($request->submit == 'mit_submit') {
            PacraSeparation::updateOrCreate([
                'resign_id' => $request->regisID,
            ],
                ['section_three_name' => $request->userID,
                    'section_three_designation' => $request->DesigID,
                    'section_three_date' => $currentDate,
                    'section_three_comment' => $request->comments,
                    'section_three_check_list' => $emp_check_list
                ]);

            $portalLink = "<a href='http://209.97.168.200/hr/public/separationAdmin'>HRMS</a>";
            Mail::send([], [], function ($message) use ($request, $teamleademail, $userPersonalEmail, $username, $portalLink, $adminEmail) {
                $message->to($adminEmail)
                    ->cc($userPersonalEmail)
                    ->cc($teamleademail)
                    ->subject('MIT Submitted Separation Form of ' . $username)
                    ->setBody('MIT Submitted Separation Form of ' . $username . '
                        <br><h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });


        } elseif ($request->submit == 'admin_submit') {
            PacraSeparation::updateOrCreate([
                'resign_id' => $request->regisID,
            ],
                ['section_four_name' => $request->userID,
                    'section_four_designation' => $request->DesigID,
                    'section_four_date' => $currentDate,
                    'section_four_comment' => $request->comments,
                    'section_four_check_list' => $emp_check_list,
                    'section_four_cost' => $request->cost
                ]);

            $portalLink = "<a href='http://209.97.168.200/hr/public/separationHR'>HRMS</a>";
            Mail::send([], [], function ($message) use ($request, $teamleademail, $userPersonalEmail, $username, $portalLink, $hrmail) {
                $message->to($hrmail)
                    ->cc($userPersonalEmail)
                    ->cc($teamleademail)
                    ->subject('Admin Submitted Separation Form of ' . $username)
                    ->setBody('Admin Submitted Separation Form of ' . $username . '
                        <br><h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        } elseif ($request->submit == 'hr_submit') {
            PacraSeparation::updateOrCreate([
                'resign_id' => $request->regisID,
            ],
                ['section_five_name' => $request->userID,
                    'section_five_designation' => $request->DesigID,
                    'section_five_date' => $currentDate,
                    'section_five_comment' => $request->comments,
                    'section_five_check_list' => $emp_check_list,
                    'leave_balance' => $request->leave
                ]);


            $portalLink = "<a href='http://209.97.168.200/hr/public/separationFinance'>HRMS</a>";
            Mail::send([], [], function ($message) use ($request, $teamleademail, $userPersonalEmail, $username, $portalLink, $financeEmail) {
                $message->to($financeEmail)
                    ->cc($userPersonalEmail)
                    ->cc($teamleademail)
                    ->subject('HR Submitted Separation Form of ' . $username)
                    ->setBody('HR Submitted Separation Form of ' . $username . '
                        <br><h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

        } elseif ($request->submit == 'shortNotice_submit') {
            PacraSeparation::updateOrCreate([
                'resign_id' => $request->regisID,
            ],
                ['section_six_name' => $request->userID,
                    'section_six_designation' => $request->DesigID,
                    'section_six_date' => $currentDate,
                    'section_six_comment' => $request->comments,
                    'noticeRequired' => $request->noticeRequired,
                    'noticeShort' => $request->noticeShort
                ]);


        } elseif ($request->submit == 'finance_submit') {
            PacraSeparation::updateOrCreate([
                'resign_id' => $request->regisID,
            ],
                ['section_seven_name' => $request->userID,
                    'section_seven_designation' => $request->DesigID,
                    'section_seven_date' => $currentDate,
                    'section_seven_comment' => $request->comments,
                    'section_seven_check_list' => $emp_check_list,
                    'settlement_date' => $request->settlement_date
                ]);

            $portalLink = "<a href='http://209.97.168.200/hr/public/separationCEO'>HRMS</a>";
            Mail::send([], [], function ($message) use ($request, $teamleademail, $userPersonalEmail, $username, $portalLink, $ceoEmail) {
                $message->to($userPersonalEmail)
                    ->cc($teamleademail)
                    ->subject('Accounts Submitted Separation Form of ' . $username)
                    ->setBody('Accounts Submitted Separation Form of ' . $username . '
                        <br><h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

            Mail::send([], [], function ($message) use ($request, $teamleademail, $userPersonalEmail, $username, $portalLink, $ceoEmail) {
                $message->to($ceoEmail)
                    ->subject('Accounts Submitted Separation Form of ' . $username)
                    ->setBody('Dear Sir, Accounts has Submitted Separation Form of ' . $username . ' kindly Approve.
                        <br><h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        } elseif ($request->submit == 'ceo_submit') {
            PacraSeparation::updateOrCreate([
                'resign_id' => $request->regisID,
            ],
                ['section_eight_name' => $request->userID,
                    'section_eight_designation' => $request->DesigID,
                    'section_eight_date' => $currentDate,
                    'section_eight_comment' => $request->comments
                ]);


            $portalLink = "<a href='http://209.97.168.200/hr/public/separationCEO'>HRMS</a>";
            Mail::send([], [], function ($message) use ($request, $teamleademail, $userPersonalEmail, $username, $portalLink, $unitHeademail, $financeEmail, $hrmail) {
                $message->to($userPersonalEmail)
                    ->cc($teamleademail)
                    ->cc($hrmail)
                    ->cc($financeEmail)
                    ->cc($unitHeademail)
                    ->subject('CEO Approved Separation Form of ' . $username)
                    ->setBody('CEO Approved Separation Form of ' . $username . '
                        <br><h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        }


        return redirect()->route('resignation');


    }


    public function ResignationReport(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Resignation Report';
        $resignations = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status as resigStatus'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->orderBY('pacra_resignations.resignation_date', 'DESC')
            ->whereNull('pacra_resignations.terminated')
            ->whereNull('pacra_resignations.internship_ended')
            ->get();

        //dd($resignation);
        return view('ResignationReport', $this->viewData)
            ->with('resignations', $resignations)
            ->with('userId', $userId);
    }


    public function separationReport(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $userDesignation = helpers::get_designation(Auth::id());
        $userRights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Separation Report';
        $resignationDetail = Pacraresignations::where('status', '=', 'Approved')
            ->get();


        $designationArray = array(1, 2, 3, 4, 5, 9, 10, 16, 26);
        $unitHeadArray = array();


        $resignation = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->rightjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            ->orderBY('pacra_resignations.resignation_date', 'desc')
            ->get();


        return view('separationReport', $this->viewData)
            ->with('resignation', $resignation)
            ->with('userRights', $userRights);

    }

    public function terminateEmployee($id, Request $request)
    {
        $teamLead = DB::table('og_users')->where('id', $id)->pluck('am_id');
        $unitHead = helpers::get_unit_head($teamLead);
        $leaveBalance = helpers::get_leave_balance($id);
        $userName = helpers::get_userName($id);
        $userEmail = helpers::get_userEmail($id);
        $teamleademail = helpers::get_teamlead_email($id);
        $teamleadName = helpers::get_teamlead_name($id);

        $userData = DB::table('og_users')->select('email', 'display_name', 'phone', 'doj', 'address')
            ->where('og_users.id', $id)
            ->get();

        $doj = new DateTime($userData->first()->doj);
        $termination_date = new DateTime($request->termination_date);
        $interval = $doj->diff($termination_date);
        $periodServed = $interval->format('%y years %m months %d days');

        $termination_date = strtotime($request->termination_date);
        $lastWorkingDate = strtotime($request->last_date);

        $datediff = $lastWorkingDate - $termination_date;
        $noticePeriod = $datediff / (60 * 60 * 24);

        $resignationTable = new Pacraresignations();
        $resignationTable->user_id = $id;
        $resignationTable->am_id = $teamLead[0];
        $resignationTable->uh_id = $unitHead;
        $resignationTable->resignation_type = 5;
        $resignationTable->resignation_date = $request->termination_date;
        $resignationTable->last_working_day = $request->last_date;
        $resignationTable->leave_balance = $leaveBalance;
        $resignationTable->reason = $request->termination_reason;
        $resignationTable->status = 'Entered';
        $resignationTable->total_period_served = $periodServed;
        $resignationTable->notice_period_days = $noticePeriod;
        $resignationTable->address = $userData->first()->address;
        $resignationTable->phone = $userData->first()->phone;
        $resignationTable->email = $userData->first()->email;
        $resignationTable->terminated = 1;
        $resignationTable->save();

        $separationTable = new PacraSeparation;
        $separationTable->user_id = $id;
        $separationTable->resign_id = $resignationTable->id;
        $separationTable->emp_reason_short_notice = 'System generated Termination';
        $separationTable->emp_check_list = $request->termination_reason;
        $separationTable->date_by_emp = $request->termination_date;
        $separationTable->save();

        Mail::send([], [], function ($message) use ($request, $userName, $userEmail, $teamleademail) {
            $message->to($teamleademail)
                ->cc($userEmail)
                ->subject('Employment Ended ' . $userName)
                ->setBody('HR has initiated the Employment ending process of ' . $userName . '
                        <br><h3>New Extended Date:</h3>' . $request->termination_reason, 'text/html');
            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        });

        return back()->with('success', 'Employee Termination Entered Successfully');
    }

    public function terminationApprovals()
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Employment Ended';
        $termination  = Pacraresignations::where('pacra_resignations.am_id', '=', $userId)->where('pacra_resignations.terminated', 1)
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
                'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
                'pacra_resignations.reason',
                'pacra_resignations.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->where('pacra_resignations.status', '=', 'Entered')
            ->get();
        $checkSeparationProcess = PacraSeparation::where('user_id', $userId)->get();

        return view('termination', $this->viewData)
            ->with('termination', $termination)
            ->with('checkSeparationProcess', $checkSeparationProcess)
            ->with('userId', $userId);
    }

    public function TerminationReport(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Termination Report';
        $terminations = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status as resigStatus'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->orderBY('pacra_resignations.resignation_date', 'DESC')
            ->where('pacra_resignations.terminated', 1)
            ->get();

        //dd($resignation);
        return view('TerminationReport', $this->viewData)
            ->with('terminations', $terminations)
            ->with('userId', $userId);
    }

    public function EndInternshipApprovals()
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Interns';

        $pacraInterns = Pacraresignations::where('pacra_resignations.am_id', '=', $userId)->where('pacra_resignations.internship_ended', 1)
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
                'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
                'pacra_resignations.reason',
                'pacra_resignations.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->where('pacra_resignations.status', '=', 'Entered')
            ->get();

        $checkSeparationProcess = PacraSeparation::where('user_id', $userId)->get();

        return view('interns', $this->viewData)
            ->with('pacraInterns', $pacraInterns)
            ->with('checkSeparationProcess', $checkSeparationProcess)
            ->with('userId', $userId);

    }

    public function EndInternship(Request $request)
    {
        $teamLead = DB::table('og_users')->where('id', $request->id)->pluck('am_id');
        $unitHead = helpers::get_unit_head($teamLead);
        $leaveBalance = helpers::get_leave_balance($request->id);
        $userName = helpers::get_userName($request->id);
        $userEmail = helpers::get_userEmail($request->id);
        $teamleademail = helpers::get_teamlead_email($request->id);
        $teamleadName = helpers::get_teamlead_name($request->id);

        $userData = DB::table('og_users')->select('email', 'display_name', 'phone', 'doj', 'address')
            ->where('og_users.id', $request->id)
            ->get();

        $doj = new DateTime($userData->first()->doj);
        $termination_date = new DateTime($request->end_date);
        $interval = $doj->diff($termination_date);
        $periodServed = $interval->format('%y years %m months %d days');

        $termination_date = strtotime($request->termination_date);
        $lastWorkingDate = strtotime($request->last_date);

        $datediff = $lastWorkingDate - $termination_date;
        $noticePeriod = $datediff / (60 * 60 * 24);

        $interTable = PacraInterns::where('user_id', $request->id)->first();
        $interTable->action = 'ended';
        $interTable->reason = $request->reason;
        $interTable->end_date = $request->end_date;
        $interTable->status = 'Entered';
        $interTable->update();

        $resignationTable = new Pacraresignations();
        $resignationTable->user_id = $request->id;
        $resignationTable->am_id = $teamLead[0];
        $resignationTable->uh_id = $unitHead;
        $resignationTable->resignation_type = 6;
        $resignationTable->resignation_date = $request->end_date;
        $resignationTable->last_working_day = $request->end_date;
        $resignationTable->leave_balance = $leaveBalance;
        $resignationTable->reason = $request->reason;
        $resignationTable->status = 'Entered';
        $resignationTable->total_period_served = $periodServed;
        $resignationTable->notice_period_days = $noticePeriod;
        $resignationTable->address = $userData->first()->address;
        $resignationTable->phone = $userData->first()->phone;
        $resignationTable->email = $userData->first()->email;
        $resignationTable->internship_ended = 1;
        $resignationTable->save();

        $separationTable = new PacraSeparation;
        $separationTable->user_id = $request->id;
        $separationTable->resign_id = $resignationTable->id;
        $separationTable->emp_reason_short_notice = 'System generated Internship Ended';
        $separationTable->emp_check_list = $request->reason;
        $separationTable->date_by_emp = $request->end_date;
        $separationTable->save();

        Mail::send([], [], function ($message) use ($request, $userName, $teamleademail) {
            $message->to($teamleademail)
                ->subject('Internship Ended ' . $userName)
                ->setBody('HR has ended the Internship of ' . $userName . '
                        <br><h3>Reason:</h3>' . $request->reason, 'text/html');
            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        });

        return back()->with('success', 'Intern Exit Process Initiated Successfully');
    }

    public function InternsReport(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Interns Report';
        $terminations = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status as resigStatus'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->orderBY('pacra_resignations.resignation_date', 'DESC')
            ->where('pacra_resignations.internship_ended', 1)
            ->get();

        return view('TerminationReport', $this->viewData)
            ->with('terminations', $terminations)
            ->with('userId', $userId);
    }

    public function extendInternship(Request $request)
    {
        $userName = helpers::get_userName($request->id);
        $userEmail = helpers::get_userEmail($request->id);
        $teamleademail = helpers::get_teamlead_email($request->id);
        $teamleadName = helpers::get_teamlead_name($request->id);


        $pacraInterns = PacraInterns::where('user_id', $request->id)->first();
        $pacraInterns->extension_date = $request->extended_date;
        $pacraInterns->action = 'extended';
        $pacraInterns->status = 'Entered';
        $pacraInterns->update();

        Mail::send([], [], function ($message) use ($request, $userName, $userEmail, $teamleademail) {
            $message->to($teamleademail)
                ->cc($userEmail)
                ->subject('Internship Extended ' . $userName)
                ->setBody('HR has extended the Internship of ' . $userName . '
                        <br><h3>New Extended Date:</h3>' . $request->extended_date, 'text/html');
            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        });

        return back()->with('success', 'Internship Extended Successfully');
    }
}
