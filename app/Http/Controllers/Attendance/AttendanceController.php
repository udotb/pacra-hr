<?php

namespace App\Http\Controllers\Attendance;

use App\Exports\UsersExport;
use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\attendance\attendanceActivityModel;
use App\Models\attendance\AttendanceEditRequest;
use App\Models\Attendance\AttendanceModel;
use App\Models\attendance\PacraPresence;
use App\Models\Employees\UsersModel;
use App\Models\holidaysModel;
use App\Models\Leaves\pacraLeavesBalance;
use App\Models\Leaves\PacraLeavesModel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class AttendanceController extends Controller
{

    public function attendanceEmployee(Request $request)

    {

        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'My Board';

        $current_date = Carbon::now()->toDateString();

        $ip_address = $request->ip();

        $attendanceActivity = attendanceActivityModel::where('date', '=', date('Y-m-d'))
            ->where('user_id', '=', $userId)
            ->orderby('id', 'desc')
            ->limit(1)
            ->get();

        $todayAttendanceActivity = attendanceActivityModel::where('date', '=', date('Y-m-d'))
            ->where('user_id', '=', $userId)
            ->get();


        // dd($attendanceActivity);
        $today_attendance = AttendanceModel::where('date', '=', date('Y-m-d'))
            ->where('user_id', '=', $userId)
            ->get();

        $maxPunchIn = attendanceActivityModel::where('date', '=', date('Y-m-d'))
            ->where('user_id', '=', $userId)
            ->where('activity', '=', 'punch_in')
            ->orderby('id', 'DESC')
            ->limit(1)
            ->get();

        $last_two_days_attendance = AttendanceModel::
        where('user_id', '=', $userId)
            ->select('pacra_attendance.id as attendanceRecordID', 'pacra_attendance.user_id', 'pacra_attendance.date', 'pacra_attendance.punch_out_status', 'pacra_attendance.log_in_time',
                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance.ip_address_logout',
                'pacra_attendance.status', 'pacra_attendance.office_hours', 'pacra_attendance_status.title')
            ->leftjoin('pacra_attendance_status', 'status', '=', 'pacra_attendance_status.id')
            ->orderBy('pacra_attendance.id', 'DESC')
            //->paginate(10);
            ->Limit(3)
            ->get();

        $checkEditAttendanceApp = AttendanceEditRequest::where('attendance_record', $last_two_days_attendance->first()->attendanceRecordID ?? 0)->get();
        if (Carbon::now() <= Carbon::now()->addMonth()) {
            $currentMonthStart = new Carbon('21th ' . date('M'));
            $currentMonthStart = Carbon::parse($currentMonthStart)->subMonth()->format('Y-m-d');
            $currentMonthEnd = new Carbon('20th ' . date('M'));
            $currentMonthEnd = Carbon::parse($currentMonthEnd)->addMonth()->format('Y-m-d');
        } else {
            $currentMonthStart = new Carbon('21th ' . date('M'));
            $currentMonthStart = Carbon::parse($currentMonthStart)->format('Y-m-d');
            $currentMonthEnd = new Carbon('20th ' . date('M'));
            $currentMonthEnd = Carbon::parse($currentMonthEnd)->addMonth()->format('Y-m-d');
        }

        $to = Carbon::createFromFormat('Y-m-d', $currentMonthStart);
        $from = Carbon::now();
        $diffInMonthdays = $to->diffInWeekdays($from);

        $ontime_statistics = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->where('status', 2)
            ->count();

        $late_statistics = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->where('status', 1)
            ->count();

        $absent_statistics = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->where('status', 4)
            ->count();

        $leave_statistics = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->where('status', 3)
            ->count();

        $holiday_statistics = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->where('status', 6)
            ->count();

        $weekend_statistics = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->where('status', 5)
            ->count();


        $now = now();
        if ($now < new Carbon('first day of July ' . date('Y'))) {
            $year_start = $now->subYear()->month(7)->day(1)->hour(0)->minute(0)->second(0)->format('Y-m-d');
            $year_end = $now->month(6)->day(30)->minute(0)->second(0)->addYear()->format('Y-m-d');
        } else {
            $year_start = $now->month(7)->day(1)->hour(0)->minute(0)->second(0)->format('Y-m-d');
            $year_end = $now->addYear()->month(6)->day(30)->hour(0)->minute(0)->second(0)->addYear()->format('Y-m-d');
        }
        $ontime_statisticsYear = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$year_start, $year_end])
            ->where('status', 2)
            ->count();

        $late_statisticsYear = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$year_start, $year_end])
            ->where('status', 1)
            ->count();


        $absent_statisticsYear = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$year_start, $year_end])
            ->where('status', 4)
            ->count();

        $leave_statisticsYear = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$year_start, $year_end])
            ->where('status', 3)
            ->count();

        $holiday_statisticsYear = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$year_start, $year_end])
            ->where('status', 6)
            ->count();

        $weekend_statisticsYear = AttendanceModel::Where('user_id', '=', $userId)
            ->whereBetween('date', [$year_start, $year_end])
            ->where('status', 5)
            ->count();

        $chkWFH = DB::select('select * from pacra_workfromhome WHERE  status = "Approve" and user_id = ' . $userId . '  and  FIND_IN_SET("' . $current_date . '", dates) ');


        $chkClientVsit = DB::select('select * from pacra_client_visit WHERE  status = "approve" and user_id = ' . $userId . '  and  FIND_IN_SET("' . $current_date . '", dates) ');
        $chkClientVsitTeam = DB::select('select * from pacra_client_visit WHERE  status = "approve" and team IN(' . $userId . ')  and  FIND_IN_SET("' . $current_date . '", dates) ');

        $year_start = strtotime($year_start);
        //$current_date = strtotime($current_date);
        //$datediff = $current_date - $year_start;
        $current_date = Carbon::now()->format('Y-m-d');
        $yearToDateDays = Carbon::parse($year_start)->diffInWeekdays($current_date);
//        $yearToDateDays = $datediff / (60 * 60 * 24) + 1;
        $currentYear = Carbon::now()->year;
        $getLeaveTaken = PacraLeavesModel::where('user_id', '=', $userId)
            ->where('from_date', 'LIKE', '%' . $currentYear . '%')
            ->whereBetween('from_date', [$currentMonthStart, $currentMonthEnd])
            ->get()
            ->sum('leave_days');

        $userDetail = UsersModel::where('id', $userId)->get();
        $date1 = $userDetail->first()->doj;
        $date2 = date("H:i:s ");
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $experience = $years . '.' . $months;

//        if ($experience < 1.1) {
//            $firstYear = DB::table('pacra_leave_policy')
//                ->select('title', 'policy')
//                ->where('title', '=', '1st Year')
//                ->get();
//            $leavesPerMonth = $firstYear[0]->policy / 12;
//        } elseif ($experience < 2.1) {
//            $secondYear = DB::table('pacra_leave_policy')
//                ->select('title', 'policy')
//                ->where('title', '=', '2nd Year')
//                ->get();
//            $leavesPerMonth = $secondYear[0]->policy / 12;
//        } else {
//            $thirddYear = DB::table('pacra_leave_policy')
//                ->select('title', 'policy')
//                ->where('title', '=', '3rd Year')
//                ->get();
//            $leavesPerMonth = $thirddYear[0]->policy / 12;
//        }
        $currentYear = Carbon::now()->year;

//        $leavesRemaining = PacraLeavesModel::where('user_id', $userId)->where('from_date', 'LIKE', '%' . $currentYear . '%')->latest('updated_at')->first();
        $leavesRemaining = pacraLeavesBalance::where('user_id', $userId)->first();
        if (!empty($leavesRemaining->current_balance)) {
            $leavesPerMonth = $leavesRemaining->current_balance / 12;
        } else {
            $leavesPerMonth = 0 / 12;
        }

//        $leavesPerMonth = pacraLeavesBalance::where('user_id', $userId)->get();
//        $leavesPerMonth = $leavesPerMonth[0]->current_balance / 12;
//        dd(number_format((float)$leavesPerMonth, 2, '.', ''));

        $getLeaveBalance = $leavesPerMonth - $getLeaveTaken;

        if (Carbon::now() >= Carbon::now()->addMonth()) {
            $monthStartDate = Carbon::now()->addMonth()->format('M');
        } else {
            $monthStartDate = Carbon::now()->format('M');
        }

        $empDesignation = UsersModel::where('id', $userId)->get();

        return view('attendance_employee', $this->viewData)
            ->with('ip_address', $ip_address)
            ->with('empDesignation', $empDesignation)
            ->with('monthStartDate', $monthStartDate)
            ->with('today_attendance', $today_attendance)
            ->with('last_two_days_attendance', $last_two_days_attendance)
            ->with('ontime_statistics', $ontime_statistics)
            ->with('late_statistics', $late_statistics)
            ->with('absent_statistics', $absent_statistics)
            ->with('leave_statistics', $leave_statistics)
            ->with('holiday_statistics', $holiday_statistics)
            ->with('weekend_statistics', $weekend_statistics)
            ->with('ontime_statisticsYear', $ontime_statisticsYear)
            ->with('currentMonthStart', $currentMonthStart)
            ->with('late_statisticsYear', $late_statisticsYear)
            ->with('absent_statisticsYear', $absent_statisticsYear)
            ->with('leave_statisticsYear', $leave_statisticsYear)
            ->with('holiday_statisticsYear', $holiday_statisticsYear)
            ->with('weekend_statisticsYear', $weekend_statisticsYear)
            ->with('attendanceActivity', $attendanceActivity)
            ->with('todayAttendanceActivity', $todayAttendanceActivity)
            ->with('maxPunchIn', $maxPunchIn)
            ->with('chkWFH', $chkWFH)
            ->with('chkClientVsit', $chkClientVsit)
            ->with('chkClientVsitTeam', $chkClientVsitTeam)
            ->with('userId', $userId)
            ->with('checkEditAttendanceApp', $checkEditAttendanceApp)
            ->with('yearToDateDays', $yearToDateDays)
            ->with('diffInMonthdays', $diffInMonthdays)
            ->with('getLeaveBalance', $getLeaveBalance)
            ->with('getLeaveTaken', $getLeaveTaken)
            ->with('leavesPerMonth', $leavesPerMonth);
    }


    public function addMarkAttendance(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());

        $from = date('Y-m-21');
        $to = date('Y-m-t');
        $current_time = date("H:i:s ");

        $lateComingCount = AttendanceModel::
        whereBetween('date', [$from, $to])
            ->where('user_id', '=', $userId)
            ->where('status', '=', 1)
            ->count();

        $getLeaveBalance = pacraLeavesBalance::where('user_id', '=', $userId)
            ->get();


        attendanceActivityModel::create(['user_id' => $userId, 'date' => date('Y-m-d'),
            'time' => date("H:i:s"), 'activity' => $request->punch_in_value
        ]);

        $ip_address = $request->ip();
        if (date("H:i:s") > date("10:00:59"))
            $login_status = 1;
        else
            $login_status = 2;


        $today_attendance = AttendanceModel::where('date', '=', date('Y-m-d'))
            ->where('user_id', '=', $userId)
            ->get();

        if ($today_attendance->isEmpty()) {


//            if ($lateComingCount > 4 and ($current_time > date("09:15:59") && $current_time < date("10:30:59"))) {
//
//                PacraLeavesModel::create(['user_id' => $userId, 'leave_type' => 8,
//                    'from_date' => date('Y-m-d'), 'to_date' => date('Y-m-d'),
//                    'leave_days' => 0.50, 'existing_balance' => $getLeaveBalance[0]->current_balance,
//                    'new_balance' => $getLeaveBalance[0]->current_balance - 0.50,
//                    'reason' => 'Late Coming More than 4 time after 09:15 AM',
//                    'status' => 'Approved', 'approved_by' => 1]);
//
//                pacraLeavesBalance::where('user_id', '=', $userId)
//                    ->update(['current_balance' => $getLeaveBalance[0]->current_balance - 0.50]);

//            } elseif ($lateComingCount > 4 and ($current_time > date("09:00:59") && $current_time < date("09:15:59"))) {
//
//                PacraLeavesModel::create(['user_id' => $userId, 'leave_type' => 8,
//                    'from_date' => date('Y-m-d'), 'to_date' => date('Y-m-d'),
//                    'leave_days' => 0.25, 'existing_balance' => $getLeaveBalance[0]->current_balance,
//                    'new_balance' => $getLeaveBalance[0]->current_balance - 0.25,
//                    'reason' => 'Late Coming More than 4 time after 09:00 AM',
//                    'status' => 'Approved', 'approved_by' => 1]);
//
//                pacraLeavesBalance::where('user_id', '=', $userId)
//                    ->update(['current_balance' => $getLeaveBalance[0]->current_balance - 0.25]);

//            } elseif (($current_time > date("13:00:59") && $current_time < date("18:00:59"))) {
            if (($current_time > date("13:00:59") && $current_time < date("18:00:59"))) {

                PacraLeavesModel::updateOrCreate([
                    'user_id' => $userId,
                ],
                    ['leave_type' => 8,
                        'from_date' => date('Y-m-d'), 'to_date' => date('Y-m-d'),
                        'leave_days' => 0.75, 'existing_balance' => $getLeaveBalance[0]->current_balance,
                        'new_balance' => $getLeaveBalance[0]->current_balance - 0.75,
                        'reason' => 'Login After 13:00 PM',
                        'status' => 'Approved', 'approved_by' => 1]);

                pacraLeavesBalance::where('user_id', '=', $userId)
                    ->update(['current_balance' => $getLeaveBalance[0]->current_balance - 0.75]);

            } elseif (($current_time > date("10:30:59") && $current_time < date("13:00:59"))) {

                PacraLeavesModel::updateOrCreate([
                    'user_id' => $userId,
                ],
                    ['leave_type' => 8,
                        'from_date' => date('Y-m-d'), 'to_date' => date('Y-m-d'),
                        'leave_days' => 0.50, 'existing_balance' => $getLeaveBalance[0]->current_balance,
                        'new_balance' => $getLeaveBalance[0]->current_balance - 0.50,
                        'reason' => 'Login After 10:30 AM',
                        'status' => 'Approved', 'approved_by' => 1]);

                pacraLeavesBalance::where('user_id', '=', $userId)
                    ->update(['current_balance' => $getLeaveBalance[0]->current_balance - 0.50]);

            } elseif (($current_time > date("10:00:59") && $current_time < date("10:30:59"))) {
                PacraLeavesModel::updateOrCreate(['user_id' => $userId,
                ],
                    ['leave_type' => 8,
                        'from_date' => date('Y-m-d'), 'to_date' => date('Y-m-d'),
                        'leave_days' => 0.25, 'existing_balance' => $getLeaveBalance[0]->current_balance,
                        'new_balance' => $getLeaveBalance[0]->current_balance - 0.25,
                        'reason' => 'Login After 10:00 AM',
                        'status' => 'Approved', 'approved_by' => 1]);

                pacraLeavesBalance::where('user_id', '=', $userId)
                    ->update(['current_balance' => $getLeaveBalance[0]->current_balance - 0.25]);
            }

//            $attendance = AttendanceModel::create(['user_id' => $userId, 'date' => date('Y-m-d'),
//                'log_in_time' => date("H:i:s"), 'ip_address_login' => $ip_address,
//                'status' => $login_status, 'office_hours' => '00:00:00']);

            $attendance = AttendanceModel::updateOrCreate([
                'user_id' => $userId,
                'date' => date('Y-m-d'),
            ],
                [
                    'log_in_time' => date("H:i:s"),
                    'ip_address_login' => $ip_address,
                    'status' => $login_status,
                    'office_hours' => '00:00:00']);
        } else {

            if ($request->punch_in_value == 'punch_in') {

//                AttendanceModel::where('date', '=', date('Y-m-d'))
//                    ->where('user_id', '=', $userId)
//                    ->update(['log_out_time' => NULL, 'ip_address_logout' => NULL]);

                AttendanceModel::updateOrCreate([
                    'user_id' => $userId,
                    'date' => date('Y-m-d'),
                ],
                    [
                        'log_in_time' => date("H:i:s"),
                        'ip_address_login' => $ip_address,
                        'status' => $login_status,
                        'office_hours' => '00:00:00']);

            } else {
                $office_hours = AttendanceModel::where('date', '=', date('Y-m-d'))
                    ->where('user_id', '=', $userId)
                    ->pluck('office_hours');

                $existing_hrs = $office_hours[0];


                $maxPunchIn = attendanceActivityModel::where('date', '=', date('Y-m-d'))
                    ->where('user_id', '=', $userId)
                    ->where('activity', '=', 'punch_in')
                    ->orderby('id', 'DESC')
                    ->limit(1)
                    ->pluck('time');


                $Interval = (strtotime($current_time) - strtotime($maxPunchIn[0]));

                $new_hrs = gmdate("H:i", $Interval); //$request->office_hours;

                $secs = strtotime($existing_hrs) - strtotime("00:00:00");
                $office_hours = date("H:i:s", strtotime($new_hrs) + $secs);


                AttendanceModel::where('date', '=', date('Y-m-d'))
                    ->where('user_id', '=', $userId)
                    ->update(['log_out_time' => date("H:i:s"), 'ip_address_logout' => $ip_address, 'office_hours' => $office_hours]
                    );
            }

        }

        return redirect()->back()->with('message', 'Your Attendance has been successfully Marked!');
    }


    public function getRecordForRecord($request)
    {
        $startDate = Carbon::now();
        $firstDay = $startDate->firstOfMonth()->format('Y-m-d');
        $lastDay = $startDate->lastOfMonth()->format('Y-m-d');

        if (!isset($request->from_date) && !isset($request->to_date)) {
            return AttendanceModel::Wherebetween('date', [$firstDay, $lastDay])
                ->select('pacra_attendance.user_id', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                    'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance.punch_out_status',
                    'og_users.display_name', 'pacra_attendance_status.title as Astatus')
                ->leftjoin('pacra_attendance_status', 'status', '=', 'pacra_attendance_status.id')
                ->leftJoin('og_users', 'og_users.id', '=', 'pacra_attendance.user_id')
                ->orderBy('pacra_attendance.id', 'DESC')
                ->orderby('date', 'DESC')
                ->get();


        } else {
            return AttendanceModel::Wherebetween('date', [$request->from_date, $request->to_date])
                ->select('pacra_attendance.user_id', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                    'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance.punch_out_status',
                    'og_users.display_name', 'pacra_attendance_status.title as Astatus')
                ->leftjoin('pacra_attendance_status', 'status', '=', 'pacra_attendance_status.id')
                ->leftJoin('og_users', 'og_users.id', '=', 'pacra_attendance.user_id')
                ->where('user_id', $request->user_id)
                ->orderBy('pacra_attendance.id', 'DESC')
                ->orderby('date', 'DESC')
                ->get();
        }

    }

    public function getEmployeeAttendanceReport(Request $request)

    {
//        dd($request->all());

        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Attendance Report';

        $employee_attendance = $this->getRecordForRecord($request);
        return view('employee_attendance_report', $this->viewData)
            ->with('userId', $userId)
            ->with('employee_attendance', $employee_attendance);
    }


    public function addMarkPresence(Request $request)
    {

        $userId = helpers::get_orignal_id(Auth::id());
        $reason = $request->reason;
        PacraPresence::create(['user_id' => $userId, 'date' => date('Y-m-d'), 'reason' => $reason]);
        return redirect()->back()->with('message', 'Your Presence has been successfully Marked!');
    }


    public function holidays(Request $request)
    {

        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Holidays';

        $allHolidays = holidaysModel::all();
        //dd($allHolidays);
        return view('holidays', $this->viewData)
            ->with('allHolidays', $allHolidays)
            ->with('user_rights', $user_rights);
    }


    public function holidayForm(Request $request)
    {


        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Add Holidays';
        $holidays_type = DB::table('pacra_holidays_type')
            ->get();

        if ($request->id == null) {
            return view('holiday_form', $this->viewData)
                ->with('holidays_type', $holidays_type)
                ->with('user_rights', $user_rights);
        } else {

            $leave = holidaysModel::select('pacra_holidays.id', 'pacra_holidays.holiday_name', 'pacra_holidays.holiday_type',
                'pacra_holidays.from_date', 'pacra_holidays.to_date', 'pacra_holidays.status', 'pacra_holidays_type.title')
                ->leftjoin('pacra_holidays_type', 'pacra_holidays_type.id', '=', 'pacra_holidays.holiday_type')
                ->where('pacra_holidays.id', '=', $request->id)
                ->get();


            return view('holiday_form', $this->viewData)
                ->with('holidays_type', $holidays_type)
                ->with('leave', $leave)
                ->with('user_rights', $user_rights);
        }


    }


    public function addHoliday(Request $request)
    {
        $ceoEmail = 'shahzad@pacra.com';
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Holidays';

        $holiday = holidaysModel::updateOrCreate([
            'id' => $request->recordid,
        ], [
            'holiday_name' => $request->get('holiday_name'),
            'holiday_type' => $request->get('holiday_type'),
            'from_date' => $request->get("from_date"),
            'to_date' => $request->get('to_date'),
            'status' => $request->get('submit')
        ]);
        $holidayName = $request->get('holiday_name');
        $link = 'https://209.97.168.200/hr/public/holidays';

//        Mail::send([], [], function ($message) use ($ceoEmail, $holidayName, $link) {
//            $message->to($ceoEmail)
//                ->subject('PACRA Holiday Approval')
//                ->setBody('<h3>Dear Sir,</h3>
//                        <br>Please Approve PACRA Holiday(s). ' . $holidayName . '<br>
//                        <br>Thank you.<br>' . 'URL:' . $link, 'text/html');
//            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
//        });
        return redirect()->route('holidays');
    }


    public function attendance_report(Request $request)

    {

        $today_attendance = DB::table('og_users')
            ->select('og_users.id', 'og_users.display_name', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance_status.title as attendanceStatus')
            ->leftJoin('pacra_attendance',
                function ($join) {
                    $join->on('og_users.id', '=', 'pacra_attendance.user_id')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
                })
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 10, 344])
//            ->whereNotIn('pacra_attendance.status', [4, 3])
            //->where('pacra_attendance.date','=',date("Y-m-d"))

            ->orderBy('og_users.display_name', 'ASC')
            ->get();

        //dd($today_attendance);

        return view('today_attendance_report')
            ->with('today_attendance', $today_attendance);

    }


    public function MbAttendance(Request $request)

    {
        $this->viewData['meta_title'] = 'Morning Briefing Attendance';
        $activeEmployees = UsersModel::where('is_active', 1)
            ->whereNotIn('id', [48, 297, 298, 372, 243])
            ->whereNotIn('department', [5, 6, 7, 12, 13, 14, 21, 22])
            ->orderBy('display_name')
            ->get();

        //dd($activeEmployees);

        return view('uploadMbAttendance', $this->viewData)
            ->with('activeEmployees', $activeEmployees);

    }


    public function markMbAttendance(Request $request)

    {

        $leaves = PacraLeavesModel::whereDate('from_date', '=', $request->date)->whereDate('to_date', '<=', $request->date)
            ->pluck('user_id')->toArray();
        // ->where('leave_type', '<>',8)
        // ->where('status', 'Approved')
        //->get();

        $getLeaveBalance = pacraLeavesBalance::where('user_id', '=', 125)
            ->get();


        $absentEmp = $request->users;

        $employees = array_diff($absentEmp, $leaves);

        //dd($result);
        foreach ($employees as $index => $employee) {

            //dd($employee);
            $getLeaveBalance = pacraLeavesBalance::where('user_id', '=', $employee)
                ->get();
//dd($getLeaveBalance);
            PacraLeavesModel::create([

                'user_id' => $employee,
                'leave_type' => 9,
                'from_date' => $request->date,
                'to_date' => $request->date,
                'leave_days' => 0.25,
                'existing_balance' => $getLeaveBalance->first()->current_balance,
                'new_balance' => $getLeaveBalance->first()->current_balance - 0.25,
                'reason' => 'Absent From Morning Briefing',
                'status' => 'Approved',
                'approved_by' => 1


            ]);


            DB::statement("UPDATE  pacra_leaves_balance SET current_balance = current_balance - 0.25
                 where user_id = $employee");


        }

        return redirect()->back()->with('message', 'Records Updated successfully....!');


    }

    public function editAttendanceRequest(Request $request, $id)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Edit Attendance';
        $getAttendanceDetail = AttendanceModel::where('id', $id)->get();
        $attendanceEditReason = DB::table('pacra_attendance_edit_reason')
            ->where('isActive', '=', 1)
            ->get();
        $getAttendanceApprovalDetail = '';


        return view('editAttendance', $this->viewData)
            ->with('attendanceEditReason', $attendanceEditReason)
            ->with('getAttendanceDetail', $getAttendanceDetail)
            ->with('getAttendanceApprovalDetail', $getAttendanceApprovalDetail)
            ->with('userId', $userId)
            ->with('amId', $amId);
        // return redirect()->back()->with('message', 'Records Updated successfully....!');

    }

    public function addeditAttendanceRequest(Request $request)

    {//dd($request->all());
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $getAttendanceDetails = AttendanceModel::where('id', $request->attendanceRecordID)->get();
        $leaveData = PacraLeavesModel::where('user_id', $request->user_id)
            ->where('from_date', $getAttendanceDetails->first()->date)
            ->get();
        // dd($leaveData);
        $teamleademail = helpers::get_teamlead_email($request->user_id);
        $teamleadname = helpers::get_teamlead_name($request->user_id);
        $username = helpers::get_userName($request->user_id);
        $usermail = helpers::get_userEmail($request->user_id);
        $hrmail = helpers::hrEmail($request->user_id);
        $portalLink = "<a href=" . url('attendance_employee') . ">HRMS</a>";
        $portalLinkApproval = "<a href=" . url('editAttendanceRequestList') . ">HRMS</a>";
        //dd($leaveData->first()->leave_days);
        if ($request->submit == 'Entered') {
            if ($request->hasFile('file')) {
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $file_path = $request->file('file')->storeAs('editAttendance/', $fileNameToStore);
            }
            $attendanceRequest = AttendanceEditRequest::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'attendance_record' => $request->attendanceRecordID,
            ], [
                'attendance_record' => $request->attendanceRecordID,
                'user_id' => $userId,
                'am_id' => $amId,
                'attendance_edit_reason' => $request->editReason,
                'old_punch_in' => $request->old_punchIn,
                'new_punch_in' => $request->punch_in,
                'attachment' => $file_path,
                'status' => $request->submit
                // 'recommendBy' => $request->attendanceRecordID,
                //'approvedBy' => $request->attendanceRecordID
            ]);
            //dd('Ok');
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $username, $portalLink) {
                $message->to($usermail)
                    ->subject($username . ' You Applied for Edit Attendance Request')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>Your request for "Edit Attendance" successfully submitted.<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLinkApproval) {
                $message->to($teamleademail)
                    ->subject($username . ' Applied for Edit Attendance Request')
                    ->setBody('<h3>Dear ' . $teamleadname . '</h3>
                        <br>' . $username . ' Applied for Edit Attendance Request.<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLinkApproval, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        } elseif ($request->submit == 'Recommended') {
            $attendanceRequest = AttendanceEditRequest::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'attendance_record' => $request->attendanceRecordID,
            ], [
                'attendance_record' => $request->attendanceRecordID,
                'attendance_edit_reason' => $request->editReason,
                'old_punch_in' => $request->old_punchIn,
                'new_punch_in' => $request->punch_in,
                'status' => $request->submit,
                'recommendBy' => $userId
                //'approvedBy' => $request->attendanceRecordID
            ]);
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLinkApproval) {
                $message->to($hrmail)
                    ->cc($usermail)
                    ->subject($username . ' Request for Edit Attendance Recommended By TL')
                    ->setBody('<h3>Dear HR</h3>
                        <br>' . $username . '  Request for Edit Attendance has been Recommended By TL. Please Authenticate.<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLinkApproval, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        } elseif ($request->submit == 'Declined') {
            $attendanceRequest = AttendanceEditRequest::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'attendance_record' => $request->attendanceRecordID,
            ], [
                'attendance_record' => $request->attendanceRecordID,
                'attendance_edit_reason' => $request->editReason,
                'old_punch_in' => $request->old_punchIn,
                'new_punch_in' => $request->punch_in,
                'status' => $request->submit,
                'recommendBy' => $userId,
                'approvedBy' => $userId
            ]);
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {
                $message->to($usermail)
                    ->subject($username . ' TL Declined Edit Attendance Request')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>TL Declined your Edit Attendance Request.<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
            //hr-approval
        } elseif ($request->submit == 'Approved') {
            $attendanceRequest = AttendanceEditRequest::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'attendance_record' => $request->attendanceRecordID,
            ], [
                'attendance_record' => $request->attendanceRecordID,
                'attendance_edit_reason' => $request->editReason,
                'old_punch_in' => $request->old_punchIn,
                'new_punch_in' => $request->punch_in,
                'status' => $request->submit,
                'approvedBy' => $userId
            ]);
            AttendanceModel::updateOrCreate([
                'id' => $request->attendanceRecordID,
                'user_id' => $request->user_id,
                'date' => $getAttendanceDetails->first()->date,
            ], [
                'user_id' => $request->user_id,
                'log_in_time' => $request->punch_in,
                'status' => 2,
            ]);
            attendanceActivityModel::updateOrCreate([
//                'attendance_record' => $request->attendanceRecordID,
                'user_id' => $request->user_id,
                'date' => $getAttendanceDetails->first()->date,
                'activity' => 'punch_in'
            ], [
                'user_id' => $request->user_id,
                'time' => $request->punch_in,
            ]);
            if (!$leaveData->isEmpty()) {
                $leaves = $leaveData->first()->leave_days;
                \Illuminate\Support\Facades\DB::statement("UPDATE  pacra_leaves_balance SET current_balance = current_balance + $leaves
                     where user_id = $request->user_id");
                $affectedRows = PacraLeavesModel::where('id', $leaveData->first()->id)->delete();
            }
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {
                $message->to($usermail)
                    ->cc($teamleademail)
                    ->subject(' HR Authenticate Your Edit Attendance Request')
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>HR Authenticated Your Edit Attendance Request<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
            return redirect()->route('editAttendanceRequestListHR');
        } elseif ($request->submit == 'Declined-HR') {
            $attendanceRequest = AttendanceEditRequest::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'attendance_record' => $request->attendanceRecordID,
            ], [
                'attendance_record' => $request->attendanceRecordID,
                'attendance_edit_reason' => $request->editReason,
                'old_punch_in' => $request->old_punchIn,
                'new_punch_in' => $request->punch_in,
                'status' => $request->submit,
                'recommendBy' => $userId,
                'approvedBy' => $userId
            ]);
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $usermail, $hrmail, $username, $portalLink) {
                $message->to($usermail)
                    ->subject($username . 'HR Declined Edit Attendance Request')
                    ->cc($teamleademail)
                    ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>HR Declined your Edit Attendance Request.<br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        }
        return redirect()->route('attendance_employee');
    }


    public function editAttendanceRequestList(Request $request)

    {
        $this->viewData['meta_title'] = 'Edit Attendance Approvals';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());

        $getAttendanceEditRequestList = AttendanceEditRequest::where('pacra_attendance_edit_request.am_id', $userId)
            ->select('og_users.display_name', 'og_users.avatar_file', 'og_designations.title as designation',
                'pacra_attendance_edit_request.id', 'pacra_attendance_edit_request.attendance_record as attendance_record',
                'pacra_attendance_edit_request.user_id', 'pacra_attendance_edit_request.am_id',
                'pacra_attendance_edit_request.attendance_edit_reason',
                'pacra_attendance_edit_request.old_punch_in', 'pacra_attendance_edit_request.new_punch_in',
                'pacra_attendance_edit_request.attachment', 'pacra_attendance_edit_request.status',
                'pacra_attendance_edit_reason.title as reason', 'pacra_attendance.date'
            )
            ->leftJoin('og_users', 'og_users.id', '=', 'pacra_attendance_edit_request.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->leftJoin('pacra_attendance', 'pacra_attendance.id', '=', 'pacra_attendance_edit_request.attendance_record')
            ->leftJoin('pacra_attendance_edit_reason', 'pacra_attendance_edit_reason.id', '=', 'pacra_attendance_edit_request.attendance_edit_reason')
            ->where('pacra_attendance_edit_request.status', 'Entered')
            ->orderBy('pacra_attendance_edit_request.created_at', 'desc')
            ->get();


        return view('attendance_edit_approval_list', $this->viewData)
            ->with('getAttendanceEditRequestList', $getAttendanceEditRequestList)
            ->with('user_rights', $user_rights);


    }

    public function editAttendanceRequestListHR(Request $request)

    {
        $this->viewData['meta_title'] = 'Edit Attendance Approvals';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());

        $getAttendanceEditRequestList = AttendanceEditRequest::where('pacra_attendance_edit_request.status', 'Recommended')
            ->select('og_users.display_name', 'og_users.avatar_file', 'og_designations.title as designation',
                'pacra_attendance_edit_request.id', 'pacra_attendance_edit_request.attendance_record as attendance_record',
                'pacra_attendance_edit_request.user_id', 'pacra_attendance_edit_request.am_id',
                'pacra_attendance_edit_request.attendance_edit_reason',
                'pacra_attendance_edit_request.old_punch_in', 'pacra_attendance_edit_request.new_punch_in',
                'pacra_attendance_edit_request.attachment', 'pacra_attendance_edit_request.status',
                'pacra_attendance_edit_reason.title as reason', 'pacra_attendance.date'
            )
            ->leftJoin('og_users', 'og_users.id', '=', 'pacra_attendance_edit_request.user_id')
            ->leftJoin('pacra_attendance', 'pacra_attendance.id', '=', 'pacra_attendance_edit_request.attendance_record')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->leftJoin('pacra_attendance_edit_reason', 'pacra_attendance_edit_reason.id', '=', 'pacra_attendance_edit_request.attendance_edit_reason')
            ->get();


        return view('attendance_edit_approval_list', $this->viewData)
            ->with('getAttendanceEditRequestList', $getAttendanceEditRequestList)
            ->with('user_rights', $user_rights);


    }


    public function editAttendanceRequestApproval(Request $request, $id)

    {
        $this->viewData['meta_title'] = 'Edit Attendance Approvals';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());


        $getAttendanceApprovalDetail = AttendanceEditRequest::where('attendance_record', $id)
            ->select('pacra_attendance.date', 'pacra_attendance_edit_request.id', 'pacra_attendance_edit_request.attendance_record as attendance_record',
                'pacra_attendance_edit_request.user_id', 'pacra_attendance_edit_request.am_id',
                'pacra_attendance_edit_request.attendance_edit_reason',
                'pacra_attendance_edit_request.old_punch_in', 'pacra_attendance_edit_request.new_punch_in',
                'pacra_attendance_edit_request.status', 'pacra_attendance_edit_reason.title as reason',
                'pacra_attendance_edit_request.attachment')
            ->leftJoin('pacra_attendance', 'pacra_attendance.id', '=', 'pacra_attendance_edit_request.attendance_record')
            ->leftJoin('pacra_attendance_edit_reason', 'pacra_attendance_edit_reason.id', '=', 'pacra_attendance_edit_request.attendance_edit_reason')
            ->get();

        //dd($getAttendanceApprovalDetail);

        $attendanceEditReason = DB::table('pacra_attendance_edit_reason')
            ->where('isActive', '=', 1)
            ->get();
        return view('editAttendance', $this->viewData)
            ->with('attendanceEditReason', $attendanceEditReason)
            ->with('getAttendanceApprovalDetail', $getAttendanceApprovalDetail)
            ->with('user_rights', $user_rights);


    }


    public function editAttendanceRequestReport(Request $request)

    {
        $this->viewData['meta_title'] = 'Edit Attendance Approvals';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());

        $getAttendanceEditRequestList = '';
        $getAttendanceEditRequestList = AttendanceEditRequest::where('pacra_attendance_edit_request.status', 'Approved')
            ->select('og_users.display_name', 'og_users.avatar_file', 'og_designations.title as designation',
                'pacra_attendance_edit_request.id', 'pacra_attendance_edit_request.attendance_record as attendance_record',
                'pacra_attendance_edit_request.user_id', 'pacra_attendance_edit_request.am_id',
                'pacra_attendance_edit_request.attendance_edit_reason',
                'pacra_attendance_edit_request.old_punch_in', 'pacra_attendance_edit_request.new_punch_in',
                'pacra_attendance_edit_request.attachment', 'pacra_attendance_edit_request.status',
                'pacra_attendance_edit_reason.title as reason', 'pacra_attendance.date'
            )
            ->leftJoin('og_users', 'og_users.id', '=', 'pacra_attendance_edit_request.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->leftJoin('pacra_attendance', 'pacra_attendance.id', '=', 'pacra_attendance_edit_request.attendance_record')
            ->leftJoin('pacra_attendance_edit_reason', 'pacra_attendance_edit_reason.id', '=', 'pacra_attendance_edit_request.attendance_edit_reason')
            ->orderBY('pacra_attendance_edit_request.id', 'DESC')
            ->get();

        //dd($getAttendanceEditRequestListHR);

        return view('attendance_edit_approval_list', $this->viewData)
            ->with('getAttendanceEditRequestList', $getAttendanceEditRequestList)
            ->with('user_rights', $user_rights);


    }


    public function attendance(Request $request)

    {
        $this->viewData['meta_title'] = 'Attendance Report Admin';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());

        $from = date('2021-01-01');
        $to = date('2021-01-31');


        $getAttendanceDetails = UsersModel::where('og_users.is_active', 1)
            ->select('og_users.display_name', 'og_users.avatar_file', 'og_users.designation_id', 'og_designations.title as designation',
                'og_users.id', 'pacra_attendance.status', 'pacra_attendance.date')
            ->leftJoin('og_designations', 'og_designations.id', '=', 'og_users.designation_id')
            ->leftJoin('pacra_attendance', 'pacra_attendance.user_id', '=', 'og_users.id')
            //->whereBetween('pacra_attendance.date', [$from, $to])
            ->whereMonth('pacra_attendance.date', Carbon::now()->month)
            ->whereYear('pacra_attendance.date', Carbon::now()->year)
            ->orderBy('og_users.display_name', 'ASC')
            ->orderBY('pacra_attendance.date')
            ->get();

        $currentMonthStart = new Carbon('first day of this month');
        $currentMonthStart = Carbon::parse($currentMonthStart)->format('Y-m-d');
        $currentMonthEnd = new Carbon('last day of this month');
        $currentMonthEnd = Carbon::parse($currentMonthEnd)->format('Y-m-d');

        $period = CarbonPeriod::create($currentMonthStart, $currentMonthEnd);
        $dates = $period->toArray();
//        dd($dates);


        return view('attendance', $this->viewData)
            ->with('getAttendanceDetails', $getAttendanceDetails)
            ->with('dates', $dates);
    }

    public function ajaxcall(Request $request)
    {
        $startDate = Carbon::now();
        $firstDay = $startDate->subDays(30)->format('Y-m-d');
        $data = AttendanceModel::where('user_id', $request->id)->whereNotIn('status', [5, 6])
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->where('date', '>=', $firstDay)
            ->orderBy('date', 'desc')
            ->get();
        return response()->json(['data' => $data]);
    }

    public function ajaxcall2(Request $request)
    {
        $customStartDate = $request->fromDate;
        $customEndDate = $request->toDate;
        $data = AttendanceModel::where('user_id', $request->id)->whereNotIn('status', [5, 6])
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->whereBetween('date', [$customStartDate, $customEndDate])
            ->orderBy('date', 'desc')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function attendanceReport(Request $request)
    {
        $this->viewData['meta_title'] = 'Attendance Report';

        $startDate = Carbon::now();
        $firstDay = $startDate->subDays(30)->format('Y-m-d');

        $customStartDate = $request->from_date;
        $customEndDate = $request->to_date;

        $getAttendanceDetails = AttendanceModel::SELECT('og_users.fname', 'og_users.lname', 'pacra_attendance.user_id', 'og_users.doj')
            ->selectRaw("SUM(CASE WHEN pacra_attendance.status = '1' AND pacra_attendance.log_in_time > '09:00:59' AND pacra_attendance.log_in_time < '10:00:59' THEN 1 ELSE 0 END) AS Late,
            SUM(CASE WHEN pacra_attendance.status = '1' AND pacra_attendance.log_in_time > '10:00:59'  THEN 1 ELSE 0 END) AS DeductibleLate,
        SUM(CASE WHEN pacra_attendance.status = '2' THEN 1 ELSE 0 END) AS OnTime,
        SUM(CASE WHEN pacra_attendance.status = '3' THEN 1 ELSE 0 END) AS OnLeave,
        SUM(CASE WHEN pacra_attendance.status = '4' THEN 1 ELSE 0 END) AS Absent,
        SUM(CASE WHEN (pacra_attendance.ip_address_login = '125.209.73.138' or pacra_attendance.ip_address_login = '110.37.226.186' or pacra_attendance.ip_address_login = '175.107.239.42' or pacra_attendance.ip_address_login = '202.141.241.58' or pacra_attendance.ip_address_login = '110.39.42.115') THEN 1 ELSE 0 END) AS InOffice,
        SUM(CASE WHEN (pacra_attendance.ip_address_login != '125.209.73.138' or pacra_attendance.ip_address_login != '110.37.226.186' or pacra_attendance.ip_address_login != '175.107.239.42' or pacra_attendance.ip_address_login != '202.141.241.58' or pacra_attendance.ip_address_login != '110.39.42.115') THEN 0 ELSE 1 END) AS Anywhere
        ")
            ->LeftJoin('og_users', 'og_users.id', 'pacra_attendance.user_id')
            ->whereNotIn('pacra_attendance.user_id', [48, 243, 297, 298, 372, 344, 10])
            ->where('pacra_attendance.date', '>=', $firstDay)
            ->where('og_users.is_active', 1)
            ->orwhereBetween('pacra_attendance.date', [$customStartDate, $customEndDate])
            ->GROUPBY('og_users.id')
            ->GROUPBY('og_users.fname')
            ->GROUPBY('og_users.lname')
            ->GROUPBY('pacra_attendance.user_id')
            ->GROUPBY('og_users.doj')
            ->ORDERBY('og_users.doj', 'desc')
            ->get();

        foreach ($getAttendanceDetails as $getAtt) {
            $getAtt->current_balance = pacraLeavesBalance::where('user_id', $getAtt->user_id)->pluck('current_balance')->first();
        }

        $getUsers = UsersModel::where('is_active', 1)->WhereNotIN('id', [48, 243, 297, 298, 372, 344, 10])->orderBy('fname', 'asc')
            ->get();
        $spam = array('current_balance', '"', ':', '{', '}', '[', ']', ';');


        return view('attendanceReport', $this->viewData)
            ->with('getAttendanceDetails', $getAttendanceDetails)
            ->with('spam', $spam)
            ->with('getUsers', $getUsers);

    }

    public function attendanceReportSingleUser(Request $request)
    {
        $customStartDate = $request->from_date;
        $customEndDate = $request->to_date;

        $getAttendanceDetails = AttendanceModel::SELECT('og_users.fname', 'og_users.lname', 'pacra_attendance.user_id')
            ->selectRaw("SUM(CASE WHEN pacra_attendance.status = '1' AND pacra_attendance.log_in_time > '09:00:59' AND pacra_attendance.log_in_time < '10:00:59' THEN 1 ELSE 0 END) AS Late,
            SUM(CASE WHEN pacra_attendance.status = '1' AND pacra_attendance.log_in_time > '10:00:59'  THEN 1 ELSE 0 END) AS DeductibleLate,
        SUM(CASE WHEN pacra_attendance.status = '2' THEN 1 ELSE 0 END) AS OnTime,
        SUM(CASE WHEN pacra_attendance.status = '3' THEN 1 ELSE 0 END) AS OnLeave,
        SUM(CASE WHEN pacra_attendance.status = '4' THEN 1 ELSE 0 END) AS Absent,
        SUM(CASE WHEN (pacra_attendance.ip_address_login = '125.209.73.138' or pacra_attendance.ip_address_login = '110.37.226.186' or pacra_attendance.ip_address_login = '175.107.239.42' or pacra_attendance.ip_address_login = '202.141.241.58' or pacra_attendance.ip_address_login = '110.39.42.115') THEN 1 ELSE 0 END) AS InOffice,
        SUM(CASE WHEN (pacra_attendance.ip_address_login != '125.209.73.138' or pacra_attendance.ip_address_login != '110.37.226.186' or pacra_attendance.ip_address_login != '175.107.239.42' or pacra_attendance.ip_address_login != '202.141.241.58' or pacra_attendance.ip_address_login != '110.39.42.115') THEN 1 ELSE 0 END) AS Anywhere
        ")
            ->LeftJoin('og_users', 'og_users.id', 'pacra_attendance.user_id')
//            ->where('og_users.is_active', 1)
            ->whereBetween('pacra_attendance.date', [$customStartDate, $customEndDate])
            ->whereNotIn('pacra_attendance.user_id', [48, 243, 297, 298, 372, 344, 10])
            ->GROUPBY('og_users.id')
            ->GROUPBY('og_users.fname')
            ->GROUPBY('og_users.lname')
            ->GROUPBY('pacra_attendance.user_id')
            ->ORDERBY('og_users.fname')
            ->ORDERBY('og_users.lname')
            ->get();

        foreach ($getAttendanceDetails as $getAtt) {
            $getAtt->current_balance = pacraLeavesBalance::where('user_id', $getAtt->user_id)->pluck('current_balance')->first();
        }

        $getUsers = UsersModel::where('is_active', 1)->WhereNotIN('id', [48, 243, 297, 298, 372, 344, 10])->orderBy('fname', 'asc')
            ->get();
        $spam = array('current_balance', '"', ':', '{', '}', '[', ']', ';');

        return view('attendanceReportSingleUser', compact('getAttendanceDetails', 'getUsers', 'customStartDate', 'customEndDate', 'spam'));
    }

    public function attendanceExcelExportSummary(Request $request)
    {
        $this->viewData['meta_title'] = 'Attendance Summary Report';
        $customStartDate = $request->from_date;
        $customEndDate = $request->to_date;

        $getAttendanceDetails = AttendanceModel::SELECT('og_users.display_name', 'pacra_attendance.user_id', 'pacra_leaves_balance.current_balance', 'og_users.doj')
            ->selectRaw("SUM(CASE WHEN pacra_attendance.status = '1' AND pacra_attendance.log_in_time > '09:00:59' AND pacra_attendance.log_in_time < '10:00:59' THEN 1 ELSE 0 END) AS Late,
            SUM(CASE WHEN pacra_attendance.status = '1' AND pacra_attendance.log_in_time > '10:00:59'  THEN 1 ELSE 0 END) AS DeductibleLate,
        SUM(CASE WHEN pacra_attendance.status = '2' THEN 1 ELSE 0 END) AS OnTime,
        SUM(CASE WHEN pacra_attendance.status = '3' THEN 1 ELSE 0 END) AS OnLeave,
        SUM(CASE WHEN pacra_attendance.status = '4' THEN 1 ELSE 0 END) AS Absent,
        SUM(CASE WHEN (pacra_attendance.ip_address_login = '125.209.73.138' or pacra_attendance.ip_address_login = '110.37.226.186' or pacra_attendance.ip_address_login = '175.107.239.42' or pacra_attendance.ip_address_login = '202.141.241.58' or pacra_attendance.ip_address_login = '110.39.42.115') THEN 1 ELSE 0 END) AS InOffice,
        SUM(CASE WHEN (pacra_attendance.ip_address_login = '125.209.73.138' or pacra_attendance.ip_address_login = '110.37.226.186' or pacra_attendance.ip_address_login = '175.107.239.42' or pacra_attendance.ip_address_login = '202.141.241.58' or pacra_attendance.ip_address_login = '110.39.42.115') THEN 0 ELSE 1 END) AS Anywhere
        ")
            ->LeftJoin('og_users', 'og_users.id', 'pacra_attendance.user_id')
            ->LeftJoin('pacra_leaves_balance', 'pacra_leaves_balance.user_id', 'pacra_attendance.user_id')
            ->where('og_users.is_active', 1)
            ->whereNotIn('pacra_attendance.user_id', [48, 243, 297, 298, 372, 344, 10])
            ->whereBetween('pacra_attendance.date', [$customStartDate, $customEndDate])
            ->GROUPBY('og_users.id')
            ->GROUPBY('og_users.display_name')
            ->GROUPBY('pacra_attendance.user_id')
            ->GROUPBY('pacra_leaves_balance.current_balance')
            ->GROUPBY('og_users.doj')
            ->ORDERBY('og_users.doj', 'desc')
            ->get();

        foreach ($getAttendanceDetails as $getAtt) {
            $getAtt->current_balance = pacraLeavesBalance::select('current_balance')->where('user_id', $getAtt->user_id)->get();
        }

        $getUsers = UsersModel::where('is_active', 1)->WhereNotIN('id', [48, 243, 297, 298, 372, 344, 10])->orderBy('fname', 'asc')
            ->get();
        $spam = array('current_balance', '"', ':', '{', '}', '[', ']', ';');


        return view('attendanceExcelView', $this->viewData)
            ->with('getAttendanceDetails', $getAttendanceDetails)
            ->with('spam', $spam)
            ->with('customStartDate', $customStartDate)
            ->with('customEndDate', $customEndDate)
            ->with('getUsers', $getUsers);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function customExcel(Request $request)
    {
        $employee_attendance = $this->getRecordForRecord($request);
        return Excel::download(new UsersExport($employee_attendance), 'users.xlsx');
    }

    public function presentEmp(Request $request)

    {
        $today_attendance = DB::table('og_users')
            ->select('og_users.id', 'og_users.display_name', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance_status.title as attendanceStatus')
            ->leftJoin('pacra_attendance',
                function ($join) {
                    $join->on('og_users.id', '=', 'pacra_attendance.user_id')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
                })
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344, 10])
            ->whereNotIn('pacra_attendance.status', [4, 3])
            ->orderBy('og_users.display_name', 'ASC')
            ->get();

        return view('present-emp')
            ->with('today_attendance', $today_attendance);

    }

    public function absentees()
    {
//        $today_attendance = DB::table('og_users')
//            ->select('og_users.id', 'og_users.display_name', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
//                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance_status.title as attendanceStatus')
//            ->leftJoin('pacra_attendance',
//                function ($join) {
//                    $join->on('og_users.id', '=', 'pacra_attendance.user_id')
//                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
//                })
//            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
//            ->where('is_active', '1')
//            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344])
//            ->whereNotIn('pacra_attendance.status', [3, 5, 6])
//            ->whereNull('pacra_attendance.log_in_time')
//            ->orderBy('og_users.display_name', 'ASC')
//            ->get();

        $today_attendance = DB::table('og_users')
            ->select('og_users.id', 'og_users.display_name', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance_status.title as attendanceStatus')
            ->leftJoin('pacra_attendance',
                function ($join) {
                    $join->on('og_users.id', '=', 'pacra_attendance.user_id')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
                })
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344, 10])
            ->whereNull('pacra_attendance.log_in_time')
            ->whereNull('pacra_attendance.status')
            ->orderBy('og_users.display_name', 'ASC')
            ->get();

        $ifAbsent = DB::table('og_users')
            ->select('og_users.id', 'og_users.display_name', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance_status.title as attendanceStatus')
            ->leftJoin('pacra_attendance',
                function ($join) {
                    $join->on('og_users.id', '=', 'pacra_attendance.user_id')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
                })
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344, 10])
            ->where('pacra_attendance.status', 4)
            ->orderBy('og_users.display_name', 'ASC')
            ->get();

        return view('absentees')
            ->with('ifAbsent', $ifAbsent)
            ->with('today_attendance', $today_attendance);
    }

    public function LateComers()
    {
        $today_attendance = DB::table('og_users')
            ->select('og_users.id', 'og_users.display_name', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance_status.title as attendanceStatus')
            ->leftJoin('pacra_attendance',
                function ($join) {
                    $join->on('og_users.id', '=', 'pacra_attendance.user_id')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
                })
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344, 10])
            ->where('pacra_attendance.status', 1)
            ->orderBy('og_users.display_name', 'ASC')
            ->get();

        return view('late-comers')
            ->with('today_attendance', $today_attendance);
    }

    public function OnLeave()
    {
        $today_attendance = DB::table('og_users')
            ->select('og_users.id', 'og_users.display_name', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance_status.title as attendanceStatus')
            ->leftJoin('pacra_attendance',
                function ($join) {
                    $join->on('og_users.id', '=', 'pacra_attendance.user_id')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
                })
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344, 10])
            ->where('pacra_attendance.status', 3)
            ->orderBy('og_users.display_name', 'ASC')
            ->get();

        $getUptoDate = DB::table('pacra_leaves')->select('pacra_leaves.*', 'og_users.display_name', 'pacra_leaves_type.name as leaveType')
            ->leftJoin('og_users', 'og_users.id', 'pacra_leaves.user_id')
            ->leftJoin('pacra_leaves_type', 'pacra_leaves_type.id', 'pacra_leaves.leave_type')
            ->where('pacra_leaves.from_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where('pacra_leaves.to_date', '>=', Carbon::now()->format('Y-m-d'))
            ->where('pacra_leaves.leave_type', '!=', 8)
            ->where('pacra_leaves.status', '=', 'Approved')
            ->orderBy('og_users.display_name', 'ASC')
            ->get();

        return view('on-leave')
            ->with('today_attendance', $today_attendance)
            ->with('getUptoDate', $getUptoDate);
    }

    public function OnTime()
    {
        $today_attendance = DB::table('og_users')
            ->select('og_users.id', 'og_users.display_name', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance_status.title as attendanceStatus')
            ->leftJoin('pacra_attendance',
                function ($join) {
                    $join->on('og_users.id', '=', 'pacra_attendance.user_id')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
                })
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344, 10])
            ->where('pacra_attendance.status', 2)
            ->orderBy('og_users.display_name', 'ASC')
            ->get();

        return view('on-time')
            ->with('today_attendance', $today_attendance);
    }

    public function InOffice()
    {
        $ipAddresses = array('202.141.241.58', '125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58', '110.39.42.115', '37.120.148.134', '202.47.36.144', '110.93.217.146');

        $today_attendance = DB::table('og_users')
            ->select('og_users.id', 'og_users.display_name', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance_status.title as attendanceStatus')
            ->leftJoin('pacra_attendance',
                function ($join) {
                    $join->on('og_users.id', '=', 'pacra_attendance.user_id')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
                })
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344, 10])
            ->whereNotNull('pacra_attendance.log_in_time')
            ->whereNull('pacra_attendance.log_out_time')
            ->whereIn('ip_address_login', $ipAddresses)
            ->orderBy('og_users.display_name', 'ASC')
            ->get();

        return view('in-office')
            ->with('today_attendance', $today_attendance);
    }

    public function AnywhereEmp()
    {
        $ipAddresses = array('202.141.241.58', '125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58', '110.39.42.115', '37.120.148.134', '202.47.36.144', '110.93.217.146');

        $today_attendance = DB::table('og_users')
            ->select('og_users.id', 'og_users.display_name', 'pacra_attendance.date', 'pacra_attendance.log_in_time',
                'pacra_attendance.log_out_time', 'pacra_attendance.ip_address_login', 'pacra_attendance_status.title as attendanceStatus')
            ->leftJoin('pacra_attendance',
                function ($join) {
                    $join->on('og_users.id', '=', 'pacra_attendance.user_id')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
                })
            ->leftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344, 10])
            ->whereNotNull('pacra_attendance.log_in_time')
            ->whereNull('pacra_attendance.log_out_time')
            ->whereNotIn('ip_address_login', $ipAddresses)
            ->orderBy('og_users.display_name', 'ASC')
            ->get();

        return view('anywhere-emp')
            ->with('today_attendance', $today_attendance);
    }

    public function monthlyAttandance(Request $request)
    {
//        $firstDay = '2021-11-21';
//        $lastDay = '2021-12-20';
        $firstDay = $request->from_date;
        $lastDay = $request->to_date;

        $getAttendanceDetails = AttendanceModel::SELECT(
            'og_users.fname',
            'og_users.lname',
//            'og_users.id',
            'pacra_attendance.date',
            'pacra_attendance.office_hours',
            'pacra_attendance.log_in_time',
            'pacra_attendance.log_out_time',
            'pacra_attendance.punch_out_status',
            'pacra_attendance_status.title'
        )
//            ->selectRaw("SUM(CASE WHEN pacra_attendance.status = '1' THEN 1 ELSE 0 END) AS Late,
//            SUM(CASE WHEN pacra_attendance.status = '2' THEN 1 ELSE 0 END) AS OnTime,
//            SUM(CASE WHEN pacra_attendance.status = '3' THEN 1 ELSE 0 END) AS OnLeave,
//            SUM(CASE WHEN pacra_attendance.status = '4' THEN 1 ELSE 0 END) AS Absent,
//            SUM(CASE WHEN pacra_attendance.status = '5' THEN 1 ELSE 0 END) AS Weekend,
//            SUM(CASE WHEN pacra_attendance.status = '6' THEN 1 ELSE 0 END) AS Holiday")
            ->LeftJoin('og_users', 'og_users.id', 'pacra_attendance.user_id')
            ->LeftJoin('pacra_attendance_status', 'pacra_attendance_status.id', 'pacra_attendance.status')
            ->whereBetween('pacra_attendance.date', [$firstDay, $lastDay])
            ->where('pacra_attendance.status', '!=', 5)
            ->where('og_users.is_active', '=', 1)
            ->whereNotIn('pacra_attendance.user_id', [48, 243, 297, 298, 372, 344, 10])
            ->GROUPBY('og_users.fname')
            ->GROUPBY('og_users.lname')
            ->GROUPBY('pacra_attendance.date')
            ->GROUPBY('pacra_attendance.office_hours')
            ->GROUPBY('pacra_attendance_status.title')
            ->GROUPBY('pacra_attendance.log_in_time')
            ->GROUPBY('pacra_attendance.log_out_time')
            ->GROUPBY('pacra_attendance.punch_out_status')
            ->get();
        return view('monthlyAttendanceReport', compact('getAttendanceDetails'));
    }

}
