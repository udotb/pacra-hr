<?php

namespace App\Http\Controllers\Leaves;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Attendance\AttendanceModel;
use App\Models\attendance\PacraClientVisit;
use App\Models\attendance\WorkFromHomeModel;
use App\Models\Employees\UsersModel;
use App\Models\Leaves\pacraLeavesBalance;
use App\Models\Leaves\PacraLeavesModel;
use App\Models\Leaves\PacraLeavesTypeModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class pacraLeavesController extends Controller
{


    public function test(Request $request)

    {
        $currentDate = (Carbon::now());
        /*  $Holiday =DB::raw('SELECT * FROM pacra_holidays WHERE '.$currentDate.' between from_date and to_date');
              //->get();*/

        $leaves = PacraLeavesModel::whereDate('from_date', '<=', carbon::now())->whereDate('to_date', '>=', carbon::now())
            ->where('leave_type', '<>', 8)
            // ->where('status', 'Approved')
            ->get();

        //  dd($leaves);


        if (!empty($leaves->first()->id)) {
            foreach ($leaves as $leave) {

                AttendanceModel::updateOrCreate([
                    //Add unique field combo to match here
                    //For example, perhaps you only want one entry per user:
                    'user_id' => $leave->user_id,
                    'date' => date('Y-m-d'),
                ], [
                    'user_id' => $leave->user_id,
                    'date' => date('Y-m-d'),
                    'log_in_time' => date("H:i:s"),
                    'ip_address_login' => '125.209.73.138',
                    'log_out_time' => date("H:i:s"),
                    'ip_address_logout' => '125.209.73.138',
                    'status' => 3,
                    'office_hours' => '00:00:00'
                ]);


                DB::statement("UPDATE  pacra_leaves_balance SET current_balance = current_balance - 1
                 where user_id = $leave->user_id");

            }

        }


        dd('Ok');


    }


    public function leaveApplication(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Leave Application';

        $getLeaveBalance = pacraLeavesBalance::select('current_balance')->where('user_id', '=', $userId)
            ->pluck('current_balance')->first();


        $getLeaveTaken = PacraLeavesModel::where('user_id', '=', $userId)
            ->whereYear('from_date', Carbon::now()->year)
            ->get()
            ->sum('leave_days');

//        $userDetail = UsersModel::where('id', $userId)->get();
//
//
//        $date1 = $userDetail->first()->doj;
//        $date2 = date("H:i:s ");
//        $diff = abs(strtotime($date2) - strtotime($date1));
//        $years = floor($diff / (365 * 60 * 60 * 24));
//        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
//        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
//        $experience = $years . '.' . $months;

//        if ($experience < 2) {
//
//            $firstYear = DB::table('pacra_leave_policy')
//                ->select('title', 'policy')
//                ->where('title', '=', '1st Year')
//                ->get();
//
//            $leavesPerMonth = $firstYear[0]->policy / 12;
//        } else {
//            $secondYear = DB::table('pacra_leave_policy')
//                ->select('title', 'policy')
//                ->where('title', '=', '2nd Year')
//                ->get();
//
//            $leavesPerMonth = $secondYear[0]->policy / 12;
//
//        }
        $leavesPerMonth = $getLeaveBalance / 12;
        $leavesPerMonth = number_format((float)$leavesPerMonth, 2, '.', '');

        $leaves_types = PacraLeavesTypeModel::where('isActive', '=', '1')->get();

        return view('leave_application', $this->viewData)
            ->with('leaves_types', $leaves_types)
            ->with('getLeaveBalance', $getLeaveBalance)
            ->with('getLeaveTaken', $getLeaveTaken)
            ->with('getLeaveTaken', $getLeaveTaken)
            ->with('leavesPerMonth', $leavesPerMonth)
            ->with('userId', $userId);
    }


    public function addLeaves(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $teamleademail = helpers::get_teamlead_email($request->uid);
        $teamleadname = helpers::get_teamlead_name($request->uid);
        $username = helpers::get_userName($request->uid);
        $usermail = helpers::get_userEmail($request->uid);
        $hrmail = helpers::hrEmail($request->uid);

        $portalLink = "<a href=" . url('leave_history') . ">HRMS</a>";
        $portalLinkApproval = "<a href=" . url('leave_approvals') . ">HRMS</a>";

        $getLeaveBalance = pacraLeavesBalance::where('user_id', '=', $userId)->get();

        $workingDays = 0;

        $startTimestamp = strtotime($request->from_date);
        $endTimestamp = strtotime($request->to_date);

        for ($i = $startTimestamp; $i <= $endTimestamp; $i = $i + (60 * 60 * 24)) {
            if (date("N", $i) <= 5) $workingDays = $workingDays + 1;
        }

        if ($request->hasFile('file')) {
            // Get filename with extension
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('file')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //dd($fileNameToStore);
            // Upload File
            $file_path = $request->file('file')->storeAs('leaveAttachment/', $fileNameToStore);
        }
//        if (($request->leave_type != 1 or $request->leave_type != 2) and $workingDays >= 3 and $request->file == null) {
        if (($request->leave_type == '5' and $workingDays >= 3 and $request->file == null)) {
            return redirect()->back()->with('message', 'Your Leave Days is greater than 3 days, Please upload a valid file in attachment.');
        } else {
            if ($request->file == null) {
                $file_path = 'N/A';
            } else {
                $file_path = $file_path;
            }


            $checkExistingFromDate = PacraLeavesModel::where('user_id', $userId)->where('leave_type', '!=', 8)
                ->whereBetween('from_date', [$request->from_date, $request->to_date])->get();
            $checkExistingToDate = PacraLeavesModel::where('user_id', $userId)->where('leave_type', '!=', 8)
                ->whereBetween('to_date', [$request->from_date, $request->to_date])->get();

//            $check = PacraLeavesModel::where('user_id', '=', $userId)->first();

            if ($checkExistingFromDate->count() != 0 || $checkExistingToDate->count() != 0) {
                return redirect()->back()->with('error', 'You have already applied Leave for these days');
            } else {
                PacraLeavesModel::updateOrCreate([
                    'user_id' => $userId,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                ],
                    ['user_id' => $userId,
                        'leave_type' => $request->leave_type,
                        'from_date' => $request->from_date,
                        'to_date' => $request->to_date,
                        'leave_days' => $workingDays,
                        'existing_balance' => $getLeaveBalance[0]->current_balance,
                        'new_balance' => $getLeaveBalance[0]->current_balance - $workingDays,
                        'reason' => $request->reason,
                        'file' => $file_path,
                        'status' => $request->submit,
                        'approved_by' => ''
                    ]);

                Mail::send([], [], function ($message) use ($request, $teamleademail, $usermail, $hrmail, $username, $portalLink) {
                    $message->to($usermail)
                        ->subject($username . ' Leave Application Submitted')
                        ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>Your leave application <br>
                        <br><b>From: </b> ' . $request->from_date . ' <br>
                        <br><b>To: </b>' . $request->to_date . '<br>
                         <br>has been successfully submitted.<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                    $message->from('webmaster@pacra.com', 'Webmaster PACRA');
                });
                Mail::send([], [], function ($message) use ($request, $teamleademail, $teamleadname, $usermail, $hrmail, $username, $portalLinkApproval) {
                    $message->to($teamleademail)
//                    ->cc($hrmail)
                        ->subject($username . ' Applied for Leave ')
                        ->setBody('<h3>Dear ' . $teamleadname . ' </h3>
                        <br>Your Team Member ' . $username . ' has applied for Leave
                        <br><b>From: </b> ' . $request->from_date . ' <br>
                        <br><b>To: </b>' . $request->to_date . '<br>
                        <br>Please Approve/ Decline.<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLinkApproval, 'text/html');
                    $message->from('webmaster@pacra.com', 'Webmaster PACRA');
                });
            }
            return redirect()->back()->with('message', 'Leave Application Submitted Successfully');
        }
    }


    public function leaveApprovals(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Leave Approvals';

        $pendingApprovals = PacraLeavesModel::where('pacra_leaves.status', '=', 'Entered')
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_leaves.id as leaveID', 'pacra_leaves.user_id', 'pacra_leaves_type.name as leaveType',
                'pacra_leaves.from_date', 'pacra_leaves.to_date', 'pacra_leaves.leave_days', 'pacra_leaves.reason',
                'pacra_leaves.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_leaves.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_leaves_type', 'pacra_leaves_type.id', '=', 'pacra_leaves.leave_type')
            ->where('users.am_id', '=', $userId)
            ->orderBY('pacra_leaves.from_date', 'DESC')
            ->get();

        $ceoApproval = PacraLeavesModel::where('pacra_leaves.status', '=', 'Entered')
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_leaves.id as leaveID', 'pacra_leaves.user_id', 'pacra_leaves_type.name as leaveType',
                'pacra_leaves.from_date', 'pacra_leaves.to_date', 'pacra_leaves.leave_days', 'pacra_leaves.reason',
                'pacra_leaves.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_leaves.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_leaves_type', 'pacra_leaves_type.id', '=', 'pacra_leaves.leave_type')
            ->where('users.am_id', '=', $userId)
            ->orWhere('pacra_leaves.leave_type', 10)
            ->orderBY('pacra_leaves.from_date', 'DESC')
            ->get();

        return view('leavesApprovals', $this->viewData)
            ->with('pendingApprovals', $pendingApprovals)
            ->with('ceoApproval', $ceoApproval);
    }


    public function leave_approvalsHr(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Leave Approvals';

        $pendingApprovals = PacraLeavesModel::where('pacra_leaves.status', '=', 'Recommend')
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_leaves.id as leaveID', 'pacra_leaves.user_id', 'pacra_leaves_type.name as leaveType',
                'pacra_leaves.from_date', 'pacra_leaves.to_date', 'pacra_leaves.leave_days', 'pacra_leaves.reason',
                'pacra_leaves.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_leaves.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_leaves_type', 'pacra_leaves_type.id', '=', 'pacra_leaves.leave_type')
            //->where('users.am_id', '=', $userId )
            ->orderBY('pacra_leaves.from_date', 'DESC')
            ->get();


        return view('leavesApprovals', $this->viewData)
            ->with('pendingApprovals', $pendingApprovals);

    }


    public function leaveEditApprove(Request $request, $id)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Leave Edit / Approve';


        $leaveDetails = PacraLeavesModel::where('pacra_leaves.id', '=', $id)
            ->leftjoin('pacra_leaves_type', 'pacra_leaves_type.id', '=', 'pacra_leaves.leave_type')
            ->get();
        // dd($leaveDetails);

        $leaves_types = PacraLeavesTypeModel::where('isActive', '=', '1')->get();

        $getLeaveBalance = pacraLeavesBalance::where('user_id', '=', $leaveDetails->first()->user_id)
            ->get();

        $getLeaveTaken = PacraLeavesModel::where('user_id', '=', $leaveDetails->first()->user_id)
            //->whereMonth('from_date',Carbon::now()->month )
            ->whereYear('from_date', Carbon::now()->year)
            ->get()->sum('leave_days');

        $userDetail = UsersModel::where('id', $leaveDetails->first()->user_id)->get();


        $date1 = $userDetail->first()->doj;
        $date2 = date("H:i:s ");
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $experience = $years . '.' . $months;

        if ($experience < 2) {

            $firstYear = DB::table('pacra_leave_policy')
                ->select('title', 'policy')
                ->where('title', '=', '1st Year')
                ->get();

            $leavesPerMonth = $firstYear[0]->policy / 12;

        } else {
            $secondYear = DB::table('pacra_leave_policy')
                ->select('title', 'policy')
                ->where('title', '=', '2nd Year')
                ->get();

            $leavesPerMonth = $secondYear[0]->policy / 12;

        }


        $this->viewData['meta_title'] = 'Leave / Approval ' . $userDetail->first()->display_name;


        return view('leave_edit_approve', $this->viewData)
            ->with('leaves_types', $leaves_types)
            ->with('leaveDetails', $leaveDetails)
            ->with('userId', $userId)
            ->with('user_rights', $user_rights)
            ->with('getLeaveBalance', $getLeaveBalance)
            ->with('getLeaveTaken', $getLeaveTaken)
            ->with('getLeaveTaken', $getLeaveTaken)
            ->with('leavesPerMonth', $leavesPerMonth)
            ->with('leaveID', $id);
    }

    public function empLeaveEditApprovals(Request $request)
    {

        //dd($request->all());
        $userId = helpers::get_orignal_id(Auth::id());
        $getLeaveBalance = pacraLeavesBalance::where('user_id', '=', $request->user_id)
            ->get();


        $workingDays = 0;

        $startTimestamp = strtotime($request->from_date);
        $endTimestamp = strtotime($request->to_date);

        for ($i = $startTimestamp; $i <= $endTimestamp; $i = $i + (60 * 60 * 24)) {
            if (date("N", $i) <= 5) $workingDays = $workingDays + 1;
        }

        $teamleademail = helpers::get_teamlead_email($request->user_id);
        $teamleadname = helpers::get_teamlead_name($request->user_id);
        $username = helpers::get_userName($request->user_id);
        $usermail = helpers::get_userEmail($request->user_id);
        $hrmail = helpers::hrEmail($request->user_id);

        $portalLink = "<a href=" . url('leave_history') . ">HRMS</a>";
        $portalLinkApproval = "<a href=" . url('leave_approvals') . ">HRMS</a>";


        if ($request->submit == 'Entered') {

            PacraLeavesModel::where('id', '=', $request->leaveID)
                ->update(['user_id' => $request->user_id,
                    'leave_type' => $request->leave_type,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'leave_days' => $workingDays,
                    'existing_balance' => $getLeaveBalance[0]->current_balance,
                    'new_balance' => $getLeaveBalance[0]->current_balance - $workingDays,
                    'reason' => $request->reason,
                    'status' => $request->submit,
                    'approved_by' => ''

                ]);
            // dd('Submit');
        } elseif ($request->submit == 'Recommend') {

            PacraLeavesModel::where('id', '=', $request->leaveID)
                ->update(['user_id' => $request->user_id,
                    'leave_type' => $request->leave_type,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'leave_days' => $workingDays,
                    'existing_balance' => $getLeaveBalance[0]->current_balance,
                    'new_balance' => $getLeaveBalance[0]->current_balance - $workingDays,
                    'reason' => $request->reason,
                    'status' => $request->submit,
                    'recommend_by' => $userId

                ]);


            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {

                $message->to($usermail)
//                    ->cc($hrmail, $teamleademail)
                    ->subject($teamleadname . ' Recommend Leave Application of ' . $username)
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>Your Team Lead has Recommended your leave application
                        <br><b>From: </b> ' . $request->from_date . ' <br>
                        <br><b>To: </b>' . $request->to_date . '<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });


        } elseif ($request->submit == 'Approve') {

            PacraLeavesModel::where('id', '=', $request->leaveID)
                ->update(['user_id' => $request->user_id,
                    'leave_type' => $request->leave_type,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'leave_days' => $workingDays,
                    'existing_balance' => $getLeaveBalance[0]->current_balance,
                    'new_balance' => $getLeaveBalance[0]->current_balance - $workingDays,
                    'reason' => $request->reason,
                    'status' => 'Approved',
                    'approved_by' => $userId

                ]);

            if ($userId == 10) {
                Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {

                    $message->to($usermail)
                        ->cc($hrmail, $teamleademail)
                        ->subject('CEO Approved  Leave Application of ' . $username)
                        ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>CEO has approved your leave application
                        <br><b>From: </b> ' . $request->from_date . ' <br>
                        <br><b>To: </b>' . $request->to_date . '<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                    $message->from('webmaster@pacra.com', 'Webmaster PACRA');
                });
            } else {
                Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {

                    $message->to($usermail)
                        ->cc($hrmail, $teamleademail)
                        ->subject('HR Approved  Leave Application of ' . $username)
                        ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>HR has approved your leave application
                        <br><b>From: </b> ' . $request->from_date . ' <br>
                        <br><b>To: </b>' . $request->to_date . '<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                    $message->from('webmaster@pacra.com', 'Webmaster PACRA');
                });
            }


            // dd('Submit');
        } elseif ($request->submit == 'Decline') {

            PacraLeavesModel::where('id', '=', $request->leaveID)
                ->update(['user_id' => $request->user_id,
                    'leave_type' => $request->leave_type,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'leave_days' => $workingDays,
                    'reason' => $request->reason,
                    'status' => 'Decline',
                    'approved_by' => $userId

                ]);


            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {

                $message->to($usermail)
                    ->cc($hrmail, $teamleademail)
                    ->subject($teamleadname . ' / HR Declined Leave Application of ' . $username)
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>Your ' . $teamleadname . ' / HR has declined your leave application
                        <br><b>From: </b> ' . $request->from_date . ' <br>
                        <br><b>To: </b>' . $request->to_date . '<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

        }

        return redirect()->route('leave_approvals');

    }


    public function leaveHistory(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Leave History';

        $pendingApprovals = PacraLeavesModel::where('pacra_leaves.user_id', '=', $userId)
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_leaves.id as leaveID', 'pacra_leaves.user_id', 'pacra_leaves_type.name as leaveType',
                'pacra_leaves.from_date', 'pacra_leaves.to_date', 'pacra_leaves.leave_days', 'pacra_leaves.reason',
                'pacra_leaves.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_leaves.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_leaves_type', 'pacra_leaves_type.id', '=', 'pacra_leaves.leave_type')
            ->whereNull('pacra_leaves.is_edited')
            ->orderby('pacra_leaves.from_date', 'DESC')
            ->get();
        $pendingApprovedLeave = PacraLeavesModel::where('user_id', '=', $userId)
            ->whereYear('from_date', Carbon::now()->year)
            ->where('status', 'Entered')
            ->count();

        // dd($pendingApprovals);

//        $unplannedLeaves = PacraLeavesModel::where('user_id', '=', $userId)
//            ->where('leave_type', '=', 8)
//            ->whereYear('from_date', Carbon::now()->year)
//            ->get()->sum('leave_days');
//
//        $plannedLeaves = PacraLeavesModel::where('user_id', '=', $userId)
//            ->where('leave_type', '<>', 8)
//            ->where('status', 'Approved')
//            ->whereYear('from_date', Carbon::now()->year)
//            ->get()->sum('leave_days');

        $unplannedLeaves = AttendanceModel::leftjoin('pacra_leaves', 'pacra_leaves.user_id', 'pacra_attendance.user_id')
            ->where('pacra_attendance.user_id', $userId)
            ->where('pacra_leaves.leave_type', 8)
            ->where('pacra_attendance.status', 1)
            ->whereYear('pacra_attendance.date', Carbon::now()->year)
            ->count();

        $plannedLeaves = AttendanceModel::where('user_id', '=', $userId)
            ->where('status', 3)
            ->whereYear('date', Carbon::now()->year)
            ->count();

        $absentStatus = AttendanceModel:: where('user_id', '=', $userId)
            ->where('status', 4)
            ->whereYear('date', Carbon::now()->year)
            ->count();


//        dd($pendingApprovals);
        return view('leaveHistory', $this->viewData)
            ->with('pendingApprovals', $pendingApprovals)
            ->with('unplannedLeaves', $unplannedLeaves)
            ->with('pendingApprovedLeave', $pendingApprovedLeave)
            ->with('absentStatus', $absentStatus)
            ->with('plannedLeaves', $plannedLeaves);

    }


    public function leaveBalancesAllEmp(Request $request)

    {
        $this->viewData['meta_title'] = 'All Employees Leave Balnce';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $allEmpLeaveBalances = pacraLeavesBalance::where('og_users.is_active', 1)
            ->select('og_users.display_name', 'pacra_leaves_balance.current_balance', 'pacra_negative_leaves.negative_balance')
            ->leftJoin('og_users', 'og_users.id', '=', 'pacra_leaves_balance.user_id')
            ->leftJoin('pacra_negative_leaves', 'pacra_negative_leaves.user_id', '=', 'pacra_leaves_balance.user_id')
            ->get();
        //dd($allEmpLeaveBalances);


        return view('leave_balances_all_emp', $this->viewData)
            ->with('allEmpLeaveBalances', $allEmpLeaveBalances);

    }


    public function workFromHome(Request $request)

    {
        $this->viewData['meta_title'] = 'Work From Home Application History';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $attribute = 'WFH';
        $allWFHs = WorkFromHomeModel::where('user_id', '=', $userId)
            //->where('attribute', '=', 'WFH')
            ->get();
        return view('work_from_home', $this->viewData)
            ->with('allWFHs', $allWFHs)
            ->with('attribute', $attribute)
            ->with('user_rights', $user_rights);

    }


    public function workFromHomeApplication(Request $request)


    {
        // dd($request->id);

        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());


        if ($request->id == null or $request->id == 'WFH' or $request->id == 'siteVisit') {


            $this->viewData['meta_title'] = 'Work From Home Application';


            return view('wfh_application', $this->viewData)
                ->with('user_rights', $user_rights)
                ->with('userId', $userId);
        } else {

            $WFH = WorkFromHomeModel::where('id', '=', $request->id)
                ->get();
            $attribute = $WFH->first()->attribute;

            if ($attribute == 'WFH') {
                $this->viewData['meta_title'] = 'Work From Home Application';
            } else {
                $this->viewData['meta_title'] = 'Work From Home Application';

            }


            $amId = DB::table('og_users')->where('id', $WFH[0]->user_id)->pluck('am_id');


            return view('wfh_application', $this->viewData)
                ->with('WFH', $WFH)
                ->with('user_rights', $user_rights)
                ->with('attribute', $attribute)
                ->with('amId', $amId);


        }
        //return view('wfh_application', $this->viewData);
    }

    public function addWFH(Request $request)
    {
        //dd($request->all());
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Work From Home Application';
        $teamleademail = helpers::get_teamlead_email($request->uid);
        $teamleadname = helpers::get_teamlead_name($request->uid);
        $username = helpers::get_userName($request->uid);
        $usermail = helpers::get_userEmail($request->uid);
        $hrmail = helpers::hrEmail($request->uid);
        $portalLink = "<a href=" . url('leave_history') . ">HRMS</a>";
        $portalLinkApproval = "<a href=" . url('wfh_approvals_list') . ">HRMS</a>";
        if ($request->submit == 'Entered') {
            WorkFromHomeModel::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'user_id' => $userId,
                'dates' => $request->dates,
            ], [
                'user_id' => $userId,
                //'attribute'=>$request->attribute,
                'dates' => $request->dates,
                'reason' => $request->reason,
                'status' => $request->submit,
                'approved_by' => ''
            ]);
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $username, $portalLink) {
                $message->to($usermail)
                    ->subject($username . ' WFH application submitted')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>Your WFH Application is successfully submitted<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $username, $portalLinkApproval, $portalLink) {
                $message->to($teamleademail)
                    ->subject($username . ' Apply for WFH Please Recommend')
                    ->setBody('<h3>Dear ' . $teamleadname . '</h3>
                        <br>' . $username . '  Applied for WFH Please Recommend/ Decline<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLinkApproval, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        } elseif ($request->submit == 'Recommend') {
            WorkFromHomeModel::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'id' => $request->recordid,
            ], [
                'dates' => $request->get('dates'),
                'reason' => $request->get("reason"),
                'status' => $request->get('submit'),
                'recommend_by' => $userId
            ]);
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $username, $portalLink) {
                $message->to($usermail)
//                    ->cc($teamleademail)
                    ->subject($username . ' Team Lead / Manager ' . $request->submit . ' Your WFH Application ')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>Team Lead / Manager ' . $request->submit . ' Your WFH Application <br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {
                $message->to($hrmail)
//                    ->cc($teamleademail)
//                    ->cc($usermail)
                    ->subject($username . ' Apply for Work From Home Please Approve/ Decline')
                    ->setBody('<h3>Dear HR</h3>
                        <br>' . $username . "'s " . 'Team Lead/ Manager Recommended His/ Her Work From Home Application. Please Approve / Decline<br>
                         <br><b>Dates: </b> ' . $request->dates . ' <br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        } elseif ($request->submit == 'Decline-TL') {
            WorkFromHomeModel::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'id' => $request->recordid,
            ], [
                'dates' => $request->get('dates'),
                'reason' => $request->get("reason"),
                'status' => $request->get('submit'),
                'recommend_by' => $userId
            ]);
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $username, $portalLink) {
                $message->to($usermail)
//                    ->cc($teamleademail)
                    ->subject($username . ' Team Lead / Manager Declined Your WFH Application ')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>Team Lead / Manager has Declined Your WFH Application <br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
            //hr approval
        } elseif ($request->submit == 'Approve') {
            WorkFromHomeModel::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'id' => $request->recordid,
            ], [
                'dates' => $request->get('dates'),
                'reason' => $request->get("reason"),
                'status' => $request->get('submit'),
                'approved_by' => $userId
            ]);
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $username, $hrmail, $portalLink) {
                $message->to($usermail)
                    ->cc($teamleademail)
                    ->subject($username . ' HR ' . $request->submit . ' Your WFH Application ')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>HR ' . $request->submit . ' Your WFH Application <br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        } elseif ($request->submit == 'Decline-HR') {
            WorkFromHomeModel::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'id' => $request->recordid,
            ], [
                'dates' => $request->get('dates'),
                'reason' => $request->get("reason"),
                'status' => $request->get('submit'),
                'approved_by' => $userId
            ]);
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $username, $hrmail, $portalLink) {
                $message->to($usermail)
                    ->cc($teamleademail)
                    ->subject($username . ' HR declined Your WFH Application ')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>HR has declined Your WFH Application <br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        }
        $message = 'Your ' . $request->attribute . ' added Successfully!';
        return redirect()->back()->with('message', $message);
    }

    public function deleteWFH(Request $request)
    {
        //dd($request->id);
        $wfhApplication = WorkFromHomeModel::find($request->id);

        $wfhApplication->delete();
        $message = 'Your Application deleted Successfully!';


        return redirect()->back()->with('message', $message);

    }

    public function wfhApprovalsList(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());

        $this->viewData['meta_title'] = 'WFH Approvals';

        $pendingApprovals = WorkFromHomeModel::where('pacra_workfromhome.status', '=', 'Entered')
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_workfromhome.id as wfhID', 'pacra_workfromhome.user_id',
                'pacra_workfromhome.dates', 'pacra_workfromhome.reason',
                'pacra_workfromhome.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_workfromhome.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            //->Where('attribute', '=', 'WFH')
            ->where('users.am_id', '=', $userId)
            ->orderBY('pacra_workfromhome.dates', 'DESC')
            ->get();

        //dd($pendingApprovals);

        $pendingApprovalsHR = WorkFromHomeModel::where('pacra_workfromhome.status', '=', 'Recommend')
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_workfromhome.id as wfhID', 'pacra_workfromhome.user_id',
                'pacra_workfromhome.dates', 'pacra_workfromhome.reason',
                'pacra_workfromhome.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_workfromhome.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->orderBY('pacra_workfromhome.dates', 'DESC')
            // ->Where('attribute', '=', 'WFH')
            // ->where('users.am_id', '=', $userId )
            ->get();


        return view('wfh_approvals', $this->viewData)
            ->with('pendingApprovals', $pendingApprovals)
            ->with('pendingApprovalsHR', $pendingApprovalsHR)
            ->with('user_rights', $user_rights);

    }

    public function siteVisit(Request $request)

    {
        $this->viewData['meta_title'] = 'Client Visit Application History';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $attribute = 'siteVisit';
        $allWFHs = PacraClientVisit::where('user_id', '=', $userId)
            ->get();
        return view('client_visit_list', $this->viewData)
            ->with('allWFHs', $allWFHs)
            ->with('attribute', $attribute)
            ->with('user_rights', $user_rights);

    }

    public function siteVisitApplication(Request $request)


    {
        //dd($request->id);

        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $userDesig = helpers::get_designation(Auth::id());
        $this->viewData['meta_title'] = 'Client Visit Application';

        $outstanding = DB::table('og_ratings as t')
            ->select('t.id as recordid', 't.client_id as Id',
                'og_companies.name as Entity',
                DB::raw('(CASE WHEN og_sectors.title = "" || og_sectors.title is NULL THEN og_main_sectors.title  ELSE og_sectors.title END) AS Industry'),
                'a.id as analyst', 'b.id as lead_rc_id', 'pacra_portfolio.manager_id as manager'
            )
            ->leftjoin('pacra_rc_data', 'pacra_rc_data.id', '=', 't.rcId')
            ->leftjoin('pacra_criticality_factor', 'pacra_criticality_factor.id', '=', 'pacra_rc_data.final_criticality_factor')
            ->leftJoin('og_companies', 'og_companies.id', '=', 't.client_id')
            ->leftjoin('og_main_sectors', 'og_main_sectors.id', '=', 'og_companies.main_sector_id')
            ->leftjoin('og_users', 'og_users.id', '=', 'og_companies.client_of_id')
            ->leftjoin('pacra_portfolio', 'pacra_portfolio.company_id', '=', 't.client_id')
            ->leftjoin('og_users AS a', 'a.id', '=', 'pacra_portfolio.user_id')
            ->leftjoin('og_users AS b', 'b.id', '=', 'pacra_portfolio.lead_rc_id')
            ->leftjoin('og_users AS c', 'c.id', '=', 'pacra_portfolio.manager_id')
            ->leftjoin('og_sectors', 'og_sectors.id', '=', 'og_companies.sector_id')
            ->where('t.notification_date', DB::raw("(select max(`notification_date`) from og_ratings as t2
                                  where t.client_id = t2.client_id and t.pacra_action != 5  and t.pacra_action != 6 and t.pacra_action != 11
                                  and t.pacra_lterm <> 198 and  t.pacra_lterm <> 177 and  t.pacra_lterm <> 124 and  t.pacra_lterm <> 122 and
                                  t.pacra_lterm <> 123 and  t.pacra_lterm <> 69

                                ) "))
            ->orderby('Entity')
            ->get();

        //dd($outstanding);

        $teamMembers = UsersModel::where('am_id', '=', $userId)
            ->where('is_active', 1)
            ->get();

        $clintVisitTimes = DB::table('pacra_clientvist_time')
            ->get();


        if ($request->id == null) {

            return view('siteVisitapplication', $this->viewData)
                ->with('user_rights', $user_rights)
                ->with('userId', $userId)
                ->with('outstanding', $outstanding)
                ->with('teamMembers', $teamMembers)
                ->with('clintVisitTimes', $clintVisitTimes)
                ->with('userDesig', $userDesig);
        } else {

            $siteVisit = PacraClientVisit::where('pacra_client_visit.id', '=', $request->id)
                ->select('pacra_client_visit.id as recordId', 'pacra_client_visit.user_id', 'pacra_client_visit.dates', 'pacra_client_visit.time', 'pacra_client_visit.client_id',
                    'pacra_client_visit.team', 'pacra_client_visit.team_time', 'pacra_client_visit.comments',
                    'pacra_client_visit.status', 'og_companies.name as cName', 'pacra_clientvist_time.title as visitTime'
                    , 'teamTimes.title as teamTimes')
                ->leftjoin('og_companies', 'og_companies.id', '=', 'pacra_client_visit.client_id')
                ->leftjoin('pacra_clientvist_time', 'pacra_clientvist_time.id', '=', 'pacra_client_visit.time')
                ->leftjoin('pacra_clientvist_time as teamTimes', 'teamTimes.id', '=', 'pacra_client_visit.team_time')
                //->leftjoin("og_users",\DB::raw("FIND_IN_SET(og_users.id,pacra_client_visit.team)"),">",\DB::raw("'0'"))
                ->get();
            // dd($siteVisit->last()->team_time,$siteVisit->last()->team);

            $users_id = explode(',', $siteVisit->last()->team);
            $times = explode(',', $siteVisit->last()->team_time);

            $teams = UsersModel::whereIn('id', $users_id)->get();
            $teamTimes = DB::table('pacra_clientvist_time')->whereIn('id', $times)->get();
            $temp = [];
            foreach ($users_id as $key => $index) {
                $temp[$index] = $times[$key];
            }
            $amId = DB::table('og_users')->where('id', $siteVisit->first()->user_id)->pluck('am_id');


            return view('siteVisitapplication', $this->viewData)
                ->with('siteVisit', $siteVisit)
                ->with('user_rights', $user_rights)
                ->with('userId', $userId)
                ->with('outstanding', $outstanding)
                ->with('clintVisitTimes', $clintVisitTimes)
                //->with('attribute', $attribute)
                ->with('amId', $amId)
                ->with('teamMembers', $teamMembers)
                ->with('teams', $teams)
                ->with('teamTimes', $teamTimes)
                ->with('userDesig', $userDesig)
                ->with('temp', $temp);


        }
        //return view('wfh_application', $this->viewData);
    }

    public function addSiteVisit(Request $request)

    {
        $this->viewData['meta_title'] = 'Client Visit Application History';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());


        $teamleademail = helpers::get_teamlead_email($request->uid);
        $teamleadname = helpers::get_teamlead_name($request->uid);
        $username = helpers::get_userName($request->uid);
        $usermail = helpers::get_userEmail($request->uid);
        $hrmail = helpers::hrEmail($request->uid);

        $portalLink = "<a href=" . url('siteVisit') . ">HRMS</a>";
        $portalLinkApproval = "<a href=" . url('siteVisit_approvals_list') . ">HRMS</a>";

        //dd($request->all());
        //dd(array_filter($request->team));
        if ($request->team != null) {
            //dd('ok');
            $team = array_filter($request->team);
            $team = (implode(",", $team));
//            dd($team);
            $teamTime = array_filter($request->teamtime);
            $teamTime = (implode(",", $teamTime));
        } else {
            $team = '';
            $teamTime = '';
        }

        $check = PacraClientVisit::where('user_id', '=', $userId)->first();
        $check2 = PacraClientVisit::where('client_id', '=', $request->get('client'))->first();
        $check3 = PacraClientVisit::whereIn('dates', [$request->get('dates')])->first();
//        dd($check3);

        if ($request->submit == 'Entered') {
//            if ($check == true && $check2 == true && $check3 == true) {
//                return redirect()->back()->with('error', 'You have already applied Client Visit for these days');
//            } else {
            PacraClientVisit::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'user_id' => $userId,
                'dates' => $request->dates,
            ], [
                'user_id' => $request->get('uid'),
                'dates' => $request->get('dates'),
                'time' => $request->get("time"),
                'client_id' => $request->get('client'),
                'team' => $team,
                'team_time' => $teamTime,
                'comments' => $request->get('reason'),
                'status' => $request->get('submit')

            ]);
//            }

            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {

                $message->to($usermail)
                    //->cc($hrmail, $teamleademail)
                    ->subject($username . ' Client Visit application submitted')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                    <br>Your Client Visit Application is successfully submitted<br>
                    <br>Thank you.<br>
                    <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $portalLinkApproval, $username, $portalLink) {

                $message->to($teamleademail)
                    ->cc($hrmail)
                    ->subject($username . ' Apply for Client Visit Please Recommend')
                    ->setBody('<h3>Dear ' . $teamleadname . '</h3>
                    <br>' . $username . '  Applied for Client Visit Please Recommend/ Decline<br>
                     <br><b>Dates: </b> ' . $request->dates . ' <br>
                    <br>Thank you.<br>
                    <h3>URL:</h3>' . $portalLinkApproval, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

        } elseif
        ($request->submit == 'Update') {

            DB::table('pacra_client_visit')->where('id', $request->recordid)->update(
                [
                    'user_id' => $request->get('uid'),
                    'dates' => $request->get('dates'),
                    'time' => $request->get("time"),
                    'client_id' => $request->get('client'),
                    'team' => $team,
                    'team_time' => $teamTime,
                    'comments' => $request->get('reason'),
                    'status' => 'Entered'
                ]);

        } elseif
        ($request->submit == 'approve') {

            DB::table('pacra_client_visit')->where('id', $request->recordid)->update(
                [
                    'dates' => $request->get('dates'),
                    'time' => $request->get("time"),
                    'client_id' => $request->get('client'),
                    'team' => $team,
                    'team_time' => $teamTime,
                    'comments' => $request->get('reason'),
                    'approved_by' => $userId,
                    'status' => $request->get('submit')
                ]);

            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {

                $message->to($usermail)
                    ->cc($teamleademail)
                    ->cc($hrmail)
                    ->subject($username . ' HR/TL Approved Your Client Visit Application ')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                    <br>HR/TL Approved Your Client Visit Application <br>
                    <br>Thank you.<br>
                    <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

        } elseif
        ($request->submit == 'decline') {

            DB::table('pacra_client_visit')->where('id', $request->recordid)->update(
                [
                    'dates' => $request->get('dates'),
                    'time' => $request->get("time"),
                    'client_id' => $request->get('client'),
                    'team' => $team,
                    'team_time' => $teamTime,
                    'comments' => $request->get('reason'),
                    'approved_by' => $userId,
                    'status' => $request->get('submit')
                ]);

            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {

                $message->to($usermail)
                    ->cc($teamleademail)
                    ->cc($hrmail)
                    ->subject($username . ' HR/TL Decliend Your Client Visit Application ')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                    <br>HR/TL Decliend Your Client Visit Application <br>
                    <br>Thank you.<br>
                    <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

        }
        return redirect()->route('siteVisit');
    }

    public
    function siteVisitApprovalsList(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());

        $this->viewData['meta_title'] = 'Client Visit Approvals';

        $pendingApprovals = PacraClientVisit::where('pacra_client_visit.status', '=', 'Entered')
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_client_visit.id as wfhID', 'pacra_client_visit.user_id',
                'pacra_client_visit.dates', 'pacra_client_visit.comments',
                'pacra_client_visit.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_client_visit.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            //->Where('attribute', '=', 'siteVisit')
            ->where('users.am_id', '=', $userId)
            ->get();

        //dd($pendingApprovals);


        $pendingApprovalsHR = PacraClientVisit::where('pacra_client_visit.status', '=', 'Recommend')
            ->select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
                'pacra_client_visit.id as wfhID', 'pacra_client_visit.user_id',
                'pacra_client_visit.dates', 'pacra_client_visit.comments',
                'pacra_client_visit.status'
            )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_client_visit.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')

            // ->where('users.am_id', '=', $userId )
            ->get();


        return view('siteVisitApprovalsList', $this->viewData)
            ->with('pendingApprovals', $pendingApprovals)
            ->with('pendingApprovalsHR', $pendingApprovalsHR)
            ->with('user_rights', $user_rights);

    }


    public
    function leavesReport(Request $request)
    {


        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Leaves History';


        $pendingApprovals = PacraLeavesModel:://where('pacra_leaves.status', 'Recommend')
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_leaves.id as leaveID', 'pacra_leaves.user_id', 'pacra_leaves_type.name as leaveType',
            'pacra_leaves.from_date', 'pacra_leaves.to_date', 'pacra_leaves.leave_days', 'pacra_leaves.reason',
            'pacra_leaves.status', 'pacra_leaves.existing_balance', 'pacra_leaves.new_balance'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_leaves.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_leaves_type', 'pacra_leaves_type.id', '=', 'pacra_leaves.leave_type')
            ->whereDate('from_date', '<=', carbon::now())->whereDate('to_date', '>=', carbon::now())
            ->orderby('pacra_leaves.from_date', 'DESC')
            //->where('users.am_id', '=', $userId )
            ->get();
        $pendingApprovedLeave = PacraLeavesModel::where('status', 'Recommend')
            ->whereYear('from_date', Carbon::now()->year)
            //->where('status', 'Recommend')
            ->count();

        // dd($pendingApprovals);

        $unplannedLeaves = PacraLeavesModel::where('user_id', '=', $userId)
            ->where('leave_type', '=', 8)
            ->whereYear('from_date', Carbon::now()->year)
            ->get()->sum('leave_days');

        $plannedLeaves = PacraLeavesModel::where('user_id', '=', $userId)
            ->where('leave_type', '<>', 8)
            ->where('status', 'Approved')
            ->whereYear('from_date', Carbon::now()->year)
            ->get()->sum('leave_days');

        $presentEmployees = AttendanceModel::where('date', '=', date('Y-m-d'))
            ->count();

        $getActiveEmployee = DB::table('og_users')
            ->where('is_active', '=', 1)
            ->whereNotIn('og_users.id', [48, 297, 298])
            ->count();

        $absentemployees = $getActiveEmployee - $presentEmployees;

        $onLeaves = PacraLeavesModel::whereDate('from_date', '<=', carbon::now())->whereDate('to_date', '>=', carbon::now())
            ->where('leave_type', '<>', 8)
            ->where('status', '<>', 'Decline')
            ->count();

        $getActiveEmployeeNames = DB::table('og_users')
            ->where('is_active', '=', 1)
            ->whereNotIn('og_users.id', [48, 297, 298])
            ->orderBy('display_name')
            ->get();

        $getLeaveTypes = DB::table('pacra_leaves_type')
            ->where('isActive', '=', 1)
            ->get();

        $getLeaveStatus = DB::table('pacra_leaves')
            ->select('status')
            ->distinct('status')
            ->get();

        //dd($getLeaveStatus);


        return view('leaves', $this->viewData)
            ->with('user_rights', $user_rights)
            ->with('pendingApprovals', $pendingApprovals)
            ->with('pendingApprovedLeave', $pendingApprovedLeave)
            ->with('unplannedLeaves', $unplannedLeaves)
            ->with('plannedLeaves', $plannedLeaves)
            ->with('presentEmployees', $presentEmployees)
            ->with('getActiveEmployee', $getActiveEmployee)
            ->with('absentemployees', $absentemployees)
            ->with('onLeaves', $onLeaves)
            ->with('getActiveEmployeeNames', $getActiveEmployeeNames)
            ->with('getLeaveTypes', $getLeaveTypes)
            ->with('getLeaveStatus', $getLeaveStatus);

    }


    public
    function leavesReportFilter(Request $request)
    {

        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Leaves History';

        $allEmployee = UsersModel::select('id')
            ->where('is_active', 1)
            ->whereNotIn('og_users.id', [48, 297, 298])
            ->get()->pluck('id')->toarray();

        $allLeaveType = PacraLeavesTypeModel::where('isActive', 1)->get()->pluck('id')->toarray();
        $allLeaveStatus = DB::table('pacra_leaves')
            ->select('status')
            ->distinct('status')
            ->get()->pluck('status')->toarray();

        //$emp = UsersModel:: whereIn('id', $allEmployee)->select('display_name')->get();

        //dd($allLeaveStatus);

        if ($request->empId == null) {
            $empID = $allEmployee;
        } else {
            $empID = explode(',', (int)$request->empId);
            $empID = array_map('intval', $empID);
        }

        if ($request->leaveType == null) {
            $type = $allLeaveType;
        } else {
            $type = explode(',', $request->leaveType);
            $type = array_map('intval', $type);
        }

        if ($request->leaveStatus == null) {
            $status = $allLeaveStatus;
        } else {
            $status = explode(',', $request->leaveStatus);
            //$status = array_map('intval',$status);
        }


        if ($request->from_date == null) {
            $from_date = carbon::now();
        } else {
            $from_date = $request->from_date;
        }

        if ($request->to_date == null) {
            $to_date = carbon::now();
        } else {
            $to_date = $request->to_date;
        }

        // dd($from_date);
        // dd($request->all());
//dd($empID, $type);


        $pendingApprovals = PacraLeavesModel:://where('pacra_leaves.status', 'Recommend')
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_leaves.id as leaveID', 'pacra_leaves.user_id', 'pacra_leaves_type.name as leaveType',
            'pacra_leaves.from_date', 'pacra_leaves.to_date', 'pacra_leaves.leave_days', 'pacra_leaves.reason',
            'pacra_leaves.status', 'pacra_leaves.existing_balance', 'pacra_leaves.new_balance', 'pacra_leaves.leave_type'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_leaves.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_leaves_type', 'pacra_leaves_type.id', '=', 'pacra_leaves.leave_type')
            ->whereIn('pacra_leaves.user_id', $empID)
            ->whereIn('pacra_leaves.leave_type', $type)
            ->whereIn('pacra_leaves.status', $status)
            ->whereDate('pacra_leaves.from_date', '>=', $from_date)
            ->whereDate('pacra_leaves.to_date', '<=', $to_date)
            ->orderby('pacra_leaves.from_date', 'DESC')

            //->where('users.am_id', '=', $userId )
            ->get();
        //print_r($pendingApprovals->getBindings() );

        //dd($pendingApprovals);

        // dd($empID,$type,$status,$from_date,$to_date);
        $pendingApprovedLeave = PacraLeavesModel::where('status', 'Recommend')
            ->whereYear('from_date', Carbon::now()->year)
            //->where('status', 'Recommend')
            ->count();

        // dd($pendingApprovals);

        $unplannedLeaves = PacraLeavesModel::where('user_id', '=', $userId)
            ->where('leave_type', '=', 8)
            ->whereYear('from_date', Carbon::now()->year)
            ->get()->sum('leave_days');

        $plannedLeaves = PacraLeavesModel::where('user_id', '=', $userId)
            ->where('leave_type', '<>', 8)
            ->where('status', 'Approved')
            ->whereYear('from_date', Carbon::now()->year)
            ->get()->sum('leave_days');

        $presentEmployees = AttendanceModel::where('date', '=', date('Y-m-d'))
            ->count();

        $getActiveEmployee = DB::table('og_users')
            ->where('is_active', '=', 1)
            ->whereNotIn('og_users.id', [48, 297, 298])
            ->count();

        $absentemployees = $getActiveEmployee - $presentEmployees;

        $onLeaves = PacraLeavesModel::whereDate('from_date', '<=', carbon::now())->whereDate('to_date', '>=', carbon::now())
            ->where('leave_type', '<>', 8)
            ->where('status', '<>', 'Decline')
            ->count();

        $getActiveEmployeeNames = DB::table('og_users')
            ->where('is_active', '=', 1)
            ->whereNotIn('og_users.id', [48, 297, 298])
            ->orderBy('display_name')
            ->get();

        $getLeaveTypes = DB::table('pacra_leaves_type')
            ->where('isActive', '=', 1)
            ->get();

        $getLeaveStatus = DB::table('pacra_leaves')
            ->select('status')
            ->distinct('status')
            ->get();

        //dd($getLeaveStatus);


        return view('leaves', $this->viewData)
            ->with('user_rights', $user_rights)
            ->with('pendingApprovals', $pendingApprovals)
            ->with('pendingApprovedLeave', $pendingApprovedLeave)
            ->with('unplannedLeaves', $unplannedLeaves)
            ->with('plannedLeaves', $plannedLeaves)
            ->with('presentEmployees', $presentEmployees)
            ->with('getActiveEmployee', $getActiveEmployee)
            ->with('absentemployees', $absentemployees)
            ->with('onLeaves', $onLeaves)
            ->with('getActiveEmployeeNames', $getActiveEmployeeNames)
            ->with('getLeaveTypes', $getLeaveTypes)
            ->with('getLeaveStatus', $getLeaveStatus);

    }


    public
    function pacrawfh(Request $request)
    {
        $getAllUser = UsersModel::where('is_active', 1)
            ->select('id')
            ->whereNotIN('id', [10, 12, 48, 243, 297, 298, 344])
            ->get();

        //dd($getAllUser);
        foreach ($getAllUser as $user) {

            WorkFromHomeModel::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'user_id' => $user->id,
                'dates' => '2021-09-06,2021-09-07'
            ], [
                'user_id' => $user->id,
                //'attribute'=>$request->attribute,
                'dates' => '2021-09-06,2021-09-07',
                'reason' => 'As per HR Announcement on Teams',
                'status' => 'Approve',
                'approved_by' => 88
            ]);


        }

    }

}
