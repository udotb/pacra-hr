<?php

namespace App\Http\Controllers;

use App\Helpers\helpers;
use App\Models\Attendance\AttendanceModel;
use App\Models\Employees\UsersModel;
use App\Models\holidaysModel;
use App\Models\Leaves\pacraLeavesBalance;
use App\Models\Leaves\PacraLeavesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $viewData = array();

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {


        $userId = helpers::get_orignal_id(Auth::id());
        $userDP = helpers::get_dp(Auth::id());
        session(['userData' => $userId]);

        //dd($request->session()->all());
        $this->viewData['meta_title'] = 'My Dashboard';

        $today_attendance = AttendanceModel::where('date', '=', date('Y-m-d'))
            ->where('user_id', '=', $userId)
            ->get();
        //  dd($today_attendance);


        if ($today_attendance->isEmpty()) {
            $check_ip = '';
            // dd('Empty');
        } else {
            $check_ip = DB::table('pacra_ips')
                ->where('ip_address', '=', $today_attendance[0]->ip_address_login)
                ->get();
            //dd('Not Empty');

        };

        $getActiveEmployee = UsersModel::whereNotIn('id', [48, 243, 297, 298, 372, 344, 10])
            ->where('is_active', '=', 1)
            ->count();

//        $presentEmployees = AttendanceModel::where('date', '=', date('Y-m-d'))
//            ->whereIn('status', [1, 2])
//            ->whereNotIn('user_id', [48, 243, 297, 298, 372, 344])
//            ->count();

        $presentEmployees = DB::table('og_users')
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
            ->count();

//        $onTimeEmployees = AttendanceModel::where('date', '=', date('Y-m-d'))
//            ->where('status', '=', 2)
//            ->whereNotIn('user_id', [48, 243, 297, 298, 372, 344])
//            ->count();

        $onTimeEmployees = DB::table('og_users')
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
            ->count();

        $lateComersEmployees = AttendanceModel::where('date', '=', date('Y-m-d'))
            ->where('status', '=', 1)
            ->whereNotIn('user_id', [48, 243, 297, 298, 372, 344, 10])
            ->count();

        $onLeaveEmployees = AttendanceModel::where('date', '=', date('Y-m-d'))
            ->where('status', '=', 3)
            ->whereNotIn('user_id', [48, 243, 297, 298, 372, 344, 10])
            ->count();

        $absentEmployeesIf = AttendanceModel::where('date', '=', date('Y-m-d'))
            ->whereNotIn('user_id', [48, 243, 297, 298, 372, 344, 10])
            ->where('status', '=', 4)
            ->count();

        $allEmployees = UsersModel::select('og_users.id', 'og_users.fname', 'og_users.lname', 'pacra_attendance.id', 'pacra_attendance.status')
            ->leftjoin('pacra_attendance', 'pacra_attendance.id', 'og_users.id')
            ->where('og_users.is_active', 1)
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344, 10])
//            ->whereNotIn('pacra_attendance.status', [1, 2, 3, 5, 6])
            ->count();

        $absentEmployees = $allEmployees - $presentEmployees - $onLeaveEmployees;

//        $absentEmployees = DB::table('og_users')
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
//            ->whereNull('pacra_attendance.log_in_time')
//            ->orderBy('og_users.display_name', 'ASC')
//            ->count();

        $getLeaveBalance = pacraLeavesBalance::where('user_id', '=', $userId)
            ->get();

        $ipAddresses = array('202.141.241.58', '125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58', '110.39.42.115', '37.120.148.134', '202.47.36.144', '110.93.217.146');

//        $getEmployeesInOffice = AttendanceModel::where('date', '=', date('Y-m-d'))
//            ->whereNull('log_out_time')
//            ->whereNotIn('user_id', [48, 243, 297, 298, 372, 344])
//            ->whereIn('status', [1, 2])
//            ->whereIn('ip_address_login', $ipAddresses)
//            ->count();

        $getEmployeesInOffice = DB::table('og_users')
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
            ->count();

        $getAnywhereEmployees = AttendanceModel::where('date', '=', date('Y-m-d'))
            ->whereNull('log_out_time')
            ->whereNotIn('user_id', [48, 243, 297, 298, 372, 344, 10])
            ->whereIn('status', [1, 2])
            ->whereNotIn('ip_address_login', $ipAddresses)
            ->count();

//        dd($getEmployeesInOffice);

//        $getLeaveTaken = PacraLeavesModel::where('user_id', '=', $userId)
//            ->whereday('from_date',21 )
//            ->whereMonth('from_date',Carbon::now()->month )
//            ->whereYear('from_date',Carbon::now()->year )
//            ->get()->sum('leave_days');
        // dd(Carbon::now()->year );
        //dd($getLeaveBalance);
        // dd($getLeaveBalance->first()->current_balance);

        $currentYear = Carbon::now()->year;
        $previousMonth = Carbon::now()->previous()->month;
        $currentMonth = Carbon::now()->month;
        $fromDate = $currentYear . '-' . $previousMonth . '-' . '21';
        $toDate = $currentYear . '-' . $currentMonth . '-' . '20';
        $getLeaveTaken = PacraLeavesModel::where('user_id', '=', $userId)
            ->where('from_date', 'LIKE', '%' . $currentYear . '%')
//            ->whereBetween('from_date', [$fromDate, $toDate])
            ->get()
            ->sum('leave_days');

        $reportingTo = UsersModel::where('og_users.id', $userId)
            ->select('AM.display_name as AmName', 'AM.avatar_file', 'og_users.avatar_file as userPic',
                'AM.id as amID')
            ->leftJoin('og_users as AM', 'AM.id', '=', 'og_users.am_id')
            ->get();


        $reportees = UsersModel::where('am_id', $userId)
            ->where('is_active', 1)
            ->orderBy('display_name')
            ->get();


        $upcomingHoliday = holidaysModel::where('from_date', '>=', carbon::now())
            ->get();

        $getEmpOnLeaveTomorrow = PacraLeavesModel::whereDate('from_date', '<=', carbon::now()->addDay())->whereDate('to_date', '>=', carbon::now()->addDay())
            ->where('leave_type', '<>', 8)
            ->where('pacra_leaves.status', '<>', 'Decline')
            ->leftJoin('og_users', 'og_users.id', 'pacra_leaves.user_id')
            ->where('og_users.am_id', $userId)
            ->get();

        //dd($getEmpOnLeaveTomorrow);


        //dd($presentEmployees);
        return view('employee_dashboard', $this->viewData)
            ->with('check_ip', $check_ip)
            ->with('absentEmployeesIf', $absentEmployeesIf)
            ->with('getActiveEmployee', $getActiveEmployee)
            ->with('presentEmployees', $presentEmployees)
            ->with('onTimeEmployees', $onTimeEmployees)
            ->with('lateComersEmployees', $lateComersEmployees)
            ->with('onLeaveEmployees', $onLeaveEmployees)
            ->with('absentEmployees', $absentEmployees)
            ->with('getLeaveBalance', $getLeaveBalance)
            ->with('getLeaveTaken', $getLeaveTaken)
            ->with('getEmployeesInOffice', $getEmployeesInOffice)
            ->with('reportingTo', $reportingTo)
            ->with('userDP', $userDP)
            ->with('reportees', $reportees)
            ->with('getAnywhereEmployees', $getAnywhereEmployees)
            ->with('upcomingHoliday', $upcomingHoliday)
            ->with('getEmpOnLeaveTomorrow', $getEmpOnLeaveTomorrow);


    }
}
