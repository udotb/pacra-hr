<?php

namespace App\Helpers;

use App\Models\attendance\AttendanceEditRequest;
use App\Models\attendance\PacraClientVisit;
use App\Models\attendance\WorkFromHomeModel;
use App\Models\Employees\PacraInterns;
use App\Models\Employees\UsersProfile;
use App\Models\jobPortal\hiringRequest;
use App\Models\jobPortal\pacraScheduleInterview;
use App\Models\Leaves\PacraLeavesModel;
use App\Models\Reimbursement\AllowanceReimbursementTable;
use App\Models\Resignation\Pacraresignations;
use App\Models\Resignation\PacraTerminations;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class HtmlHelper.
 */
class helpers
{


    /**
     * Access the gravatar helper.
     */


    static function get_orignal_id($user_id)
    {
        $result = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');
        return $result[0];
    }

    static function get_userName($user_id)
    {
        $result = DB::table('og_users')->where('id', $user_id)->pluck('display_name');
        return $result[0];
    }

    static function get_userEmail($user_id)
    {
        $result = DB::table('og_users')->where('id', $user_id)->pluck('email');
        return $result[0];
    }

    static function get_user_rights($user_id)
    {
        $result = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');
        $rights = DB::table('og_users')->where('id', $result)->pluck('rights');
        $rights_array = explode(',', $rights[0]);
        return $rights_array;
    }

    static function get_user_password($user_id)
    {
        $result = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');
        $password = DB::table('og_users')->where('id', $result)->pluck('password');

        return $password[0];
    }

    static function get_team_lead($user_id)
    {
        $result = DB::table('og_users')->where('newu_id', $user_id)->pluck('am_id');
        return $result[0];
    }

    static function get_teamlead_email($user_id)
    {
        $result = DB::table('og_users')
            ->select('og_users.am_id', 'am.email', 'am.display_name')
            ->leftJoin('og_users as am', 'am.id', '=', 'og_users.am_id')
            ->where('og_users.id', $user_id)
            ->pluck('am.email');
        return $result[0];
    }

    static function get_teamlead_name($user_id)
    {
        $result = DB::table('og_users')
            ->select('og_users.am_id', 'am.email', 'am.display_name')
            ->leftJoin('og_users as am', 'am.id', '=', 'og_users.am_id')
            ->where('og_users.id', $user_id)
            ->pluck('am.display_name');
        return $result[0];
    }


    static function get_unit_head($user_id)
    {
        $result = DB::table('og_users')->where('id', $user_id)->pluck('am_id');
        return $result[0];
    }

    static function get_leave_balance($user_id)
    {
        $result = DB::table('pacra_leaves_balance')->where('user_id', $user_id)->pluck('current_balance');
        return $result[0];
    }

    static function get_designation($user_id)
    {
        $result = DB::table('og_users')->where('newu_id', $user_id)->pluck('designation_id');
        return $result[0];
    }

    static function get_grade($user_id)
    {
        $result = DB::table('og_users')->where('newu_id', $user_id)->pluck('grade');
        return $result[0];
    }

    static function get_dp($user_id)
    {
        $result = DB::table('og_users')->where('newu_id', $user_id)->pluck('avatar_file');
        return $result[0];
    }

    static function hrEmail($user_id)
    {
        //$result='muhammad.saqib@pacra.com';
        $result = 'sehar.shahid@pacra.com';
        return $result;
    }

    static function mitEmail($user_id)
    {
        $result = 'rafique@pacra.com';
        //$result='sehar.shahid@pacra.com';
        return $result;
    }

    static function adminEmail($user_id)
    {
        $result = 'shahid@pacra.com';
        //$result='sehar.shahid@pacra.com';
        return $result;
    }

    static function financeEmail($user_id)
    {
        $result = 'aamir.hussain@pacra.com';
        //$result='sehar.shahid@pacra.com';
        return $result;
    }

    static function ceoEmail($user_id)
    {
        $result = 'shahzad@pacra.com';
        //$result='sehar.shahid@pacra.com';
        return $result;
    }

    static function hrLeaveApprovals($user_id)
    {
        $result = PacraLeavesModel::where('status', '=', 'Recommend')
            ->count();
        return $result;
    }

    static function hrEmployeeApprovals($user_id)
    {
        $result = UsersProfile::
        where('pacra_users_profile.status', '=', 'Entered')
            ->count();
        return $result;
    }

    static function hrWFHApprovals($user_id)
    {
        $result = WorkFromHomeModel::where('status', '=', 'Recommend')
            ->count();
        return $result;
    }

    static function hrSeparationApprovals($user_id)
    {
        $result = Pacraresignations::
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
            ->where('pacra_emp_separation.section_five_name', Null)
            ->count();
        return $result;
    }

    static function hrEditAttendanceApprovals($user_id)
    {
        $result = AttendanceEditRequest::where('status', '=', 'Recommended')
            ->count();
        return $result;
    }

    static function tlLeaveApprovals($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = PacraLeavesModel::where('pacra_leaves.status', '=', 'Entered')
            ->leftJoin('og_users', 'og_users.id', 'pacra_leaves.user_id')
            ->where('og_users.am_id', $userID)
            ->count();
        //dd($userID);
        return $result;
    }

    static function tlWFHApprovals($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = WorkFromHomeModel::where('pacra_workfromhome.status', '=', 'Entered')
            ->leftJoin('og_users', 'og_users.id', 'pacra_workfromhome.user_id')
            ->where('og_users.am_id', $userID)
            ->count();
        return $result;
    }

    static function tlClientVisitpprovals($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = PacraClientVisit::where('pacra_client_visit.status', '=', 'Entered')
            ->leftJoin('og_users', 'og_users.id', 'pacra_client_visit.user_id')
            ->where('og_users.am_id', $userID)
            ->count();
        return $result;
    }

    static function MyInterviewsApproval($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = pacraScheduleInterview::select('candidate_for_interview.date', 'candidate_for_interview.time',
            'candidate_for_interview.interviewers', 'candidate_for_interview.userID', 'candidate_for_interview.interviewRound',
            'candidate_for_interview.jobID', 'candidate_for_interview.candidateID',
            'jobportal.applicant_profile.fname',
            'jobportal.applicant_profile.lname',
            'og_users.fname as Fname',
            'og_users.lname as Lname',
            'candidate_for_interview.status', 'candidate_for_interview.id as interviewID')
            ->leftjoin('jobportal.applicant_profile', 'jobportal.applicant_profile.userID', 'candidate_for_interview.userID')
            ->leftjoin('wizpac.og_users', 'og_users.id', 'candidate_for_interview.interviewers')
            ->whereIn('interviewers', [$userID])
            ->Orwhere('date', '=', Carbon::now())
            ->Orwhere('date', '>', Carbon::now())
            ->where('candidate_for_interview.status', 'Entered')
            ->orderBy('candidate_for_interview.interviewRound', 'Desc')
            ->count();
        return $result;
    }

    static function tlResignationAprovals($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = Pacraresignations::where('pacra_resignations.am_id', $userID[0])
            ->where('pacra_resignations.status', '=', 'Entered')
            ->whereNull('pacra_resignations.terminated')
            ->whereNull('pacra_resignations.internship_ended')
            ->count();
        return $result;
    }

    static function tlTerminationAprovals($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = Pacraresignations::where('pacra_resignations.am_id', $userID[0])
            ->where('pacra_resignations.status', '=', 'Entered')
            ->where('pacra_resignations.terminated', 1)
            ->count();
        return $result;
    }

    static function tlEndInternshipAprovals($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = Pacraresignations::where('pacra_resignations.am_id', $userID[0])
            ->where('pacra_resignations.status', '=', 'Entered')
            ->where('pacra_resignations.internship_ended', 1)
            ->count();

        return $result;
    }

    static function tlSeparationAprovals($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = Pacraresignations::leftjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            ->where('pacra_resignations.am_id', $userID[0])
            ->where('pacra_resignations.status', '=', 'Approved')
            ->whereNull('pacra_emp_separation.section_two_name')
            ->count();
        return $result;
    }

    static function tlEditAttendanceApprovals($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = AttendanceEditRequest::where('pacra_attendance_edit_request.status', '=', 'Entered')
            ->leftJoin('og_users', 'og_users.id', 'pacra_attendance_edit_request.user_id')
            ->where('pacra_attendance_edit_request.am_id', $userID)
            ->where('pacra_attendance_edit_request.status', 'Entered')
            ->count();
        return $result;
    }

    static function TlReimbursementApproval($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = AllowanceReimbursementTable::select('allowance_reimbursement.*', 'og_users.display_name', 'pacra_employee_grade.name', 'og_companies.name as clientName')
            ->leftjoin('og_users', 'og_users.id', 'allowance_reimbursement.user_id')
            ->leftjoin('pacra_employee_grade', 'pacra_employee_grade.id', 'allowance_reimbursement.user_grade')
            ->leftjoin('og_companies', 'og_companies.id', 'allowance_reimbursement.client')
            ->where('og_users.am_id', $userID)
            ->where('allowance_reimbursement.status', 'Entered')
            ->count();

        return $result;
    }

    static function FinanceReimbursementApproval($user_id)
    {
        $userID = DB::table('og_users')->where('newu_id', $user_id)->pluck('id');

        $result = AllowanceReimbursementTable::select('allowance_reimbursement.*', 'og_users.display_name', 'pacra_employee_grade.name', 'og_companies.name as clientName')
            ->leftjoin('og_users', 'og_users.id', 'allowance_reimbursement.user_id')
            ->leftjoin('pacra_employee_grade', 'pacra_employee_grade.id', 'allowance_reimbursement.user_grade')
            ->leftjoin('og_companies', 'og_companies.id', 'allowance_reimbursement.client')
            ->where('allowance_reimbursement.status', 'Recommended')
            ->count();

        return $result;
    }

    static function mitSeparationAprovals($user_id)
    {
        $result = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->rightjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            ->where('pacra_emp_separation.section_three_name', Null)
            ->count();
        return $result;
    }

    static function TlHiringRequestApproval($user_id)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());

        $result = hiringRequest::where('amID', $userId)
            ->where('hiring_request.status', 'entered')
            ->select('hiring_request.*', 'job_titles.title as jobTitle', 'og_designations.title as jobTitles', 'og_users.display_name')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftjoin('wizpac.og_users', 'og_users.id', 'hiring_request.requestBy')
            ->count();
        return $result;
    }

    static function HRHiringRequestApproval($user_id)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());

        $result = hiringRequest::where('hiring_request.status', 'recommended')
            ->select('hiring_request.*', 'job_titles.title as jobTitle', 'og_designations.title as jobTitles', 'og_users.display_name')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftjoin('wizpac.og_users', 'og_users.id', 'hiring_request.requestBy')
            ->count();
        return $result;
    }

    static function adminSeparationAprovals($user_id)
    {
        $result = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            ->whereNull('pacra_emp_separation.section_seven_name')
            ->count();
        return $result;
    }

    static function financeSeparationAprovals($user_id)
    {
        $result = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->leftjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            ->whereNull('pacra_emp_separation.section_seven_name')
            ->count();
        return $result;
    }

    static function financeSettlementAprovals($user_id)
    {
        $startDate = Carbon::now();
        $firstDay = $startDate->subMonths(6)->format('Y-m-d');

        $result = Pacraresignations::select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
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
            ->whereNull('pacra_emp_separation.paid')
            ->count();
        return $result;
    }

    static function ceoSeparationAprovals($user_id)
    {
        $result = Pacraresignations::
        select('users.display_name', 'users.avatar_file', 'og_designations.title as designation',
            'pacra_resignations.id as resigID', 'pacra_resignations.user_id', 'pacra_resignations.am_id as teamLead',
            'pacra_resignations.resignation_type', 'pacra_resignations.resignation_date', 'pacra_resignations.last_working_day',
            'pacra_resignations.reason',
            'pacra_resignations.status', 'pacra_emp_separation.*'
        )
            ->leftjoin('og_users as users', 'users.id', '=', 'pacra_resignations.user_id')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'users.designation_id')
            ->rightjoin('pacra_emp_separation', 'pacra_emp_separation.resign_id', '=', 'pacra_resignations.id')
            ->where('pacra_emp_separation.section_eight_name', Null)
            ->count();
        return $result;
    }


}
