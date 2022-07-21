<?php

namespace App\Http\Controllers\jobPortal;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Employees\DepartmentModel;
use App\Models\Employees\DesignationsModel;
use App\Models\Employees\UsersModel;
use App\Models\Employees\UsersProfile;
use App\Models\jobPortal\ApplicantAboutYourself;
use App\Models\jobPortal\candidate_for_hiring;
use App\Models\jobPortal\CandidateSalary;
use App\Models\jobPortal\City;
use App\Models\jobPortal\hiringRequest;
use App\Models\JobPortal\HiringRequestTable;
use App\Models\jobPortal\Institute;
use App\Models\JobPortal\JobsCandidateTable;
use App\Models\jobPortal\jobTitles;
use App\Models\jobPortal\pacraApplicantEducationModel;
use App\Models\jobPortal\pacraApplicantEmergencyContactModel;
use App\Models\jobPortal\pacraApplicantExperienceModel;
use App\Models\jobPortal\pacraApplicantInfoPersonalModel;
use App\Models\jobPortal\pacraApplicantProfileModel;
use App\Models\jobPortal\pacraAppointmentLetterModel;
use App\Models\jobPortal\pacraCandidateForHiring;
use App\Models\jobPortal\pacraEngagementApprovalModel;
use App\Models\jobPortal\pacraJobsCandidateModel;
use App\Models\jobPortal\pacraPositionNatureModel;
use App\Models\jobPortal\pacraQuestionAnswerModel;
use App\Models\jobPortal\pacraQuestionOptionsModel;
use App\Models\jobPortal\pacraQuestionsModel;
use App\Models\jobPortal\pacraQuizModel;
use App\Models\jobPortal\pacraScheduleInterview;
use App\Models\jobPortal\pacraScheduleTest;
use App\Models\jobPortal\RejectionCommentsTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class jobPortals extends Controller
{
    public function jobTitles(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Job Description';
        $user_rights = helpers::get_user_rights(Auth::id());


        $jobTitles = jobTitles::select('job_titles.*', 'og_designations.title as jobTitle')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->get();
        //dd($jobTitles);

        return view('jobTitles', $this->viewData)
            ->with('user_rights', $user_rights)
            ->with('userId', $userId)
            ->with('jobTitles', $jobTitles);

    }


    public function jobTitlesForm(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Job Description Form';
        $user_rights = helpers::get_user_rights(Auth::id());
        $getDesignations = DesignationsModel::where('isActive', '=', '1')
            ->orderBy('title')
            ->get();


        if ($request->id == null) {

            return view('jobTitlesForm', $this->viewData)
                ->with('getDesignations', $getDesignations)
                ->with('user_rights', $user_rights)
                ->with('userId', $userId);
        } else {
            $jobTitles = jobTitles::select('job_titles.*', 'og_designations.title as jobTitle')
                ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
                ->where('job_titles.id', '=', $request->id)->get();;

            // dd($jobTitles);

            // $jobTitles = jobTitles::where('id', '=', $request->id)->get();
            return view('jobTitlesForm', $this->viewData)
                ->with('getDesignations', $getDesignations)
                ->with('user_rights', $user_rights)
                ->with('userId', $userId)
                ->with('jobTitles', $jobTitles);

        }


    }


    public function addJobTitles(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Job Titles';
        $user_rights = helpers::get_user_rights(Auth::id());

        // dd($request->all());

        if ($request->submit == 'entered') {
            jobTitles::create(

                ['title' => $request->job_title,
                    'description' => $request->description,
                    'requirements' => $request->requirements,
                    'jobExpectations' => $request->jobExpectations,
                    'jobBenefits' => $request->jobBenefits,
                    'salary' => $request->salary,

                ]);
        } else {
            jobTitles::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'id' => $request->id,

            ], [
                'title' => $request->job_title,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'jobExpectations' => $request->jobExpectations,
                'jobBenefits' => $request->jobBenefits,
                'salary' => $request->salary,
            ]);
        }
        $jobTitles = jobTitles::all();

        return redirect()->route('jobTitles');
        //dd($request->all());
        // return view('jobTitles', $this->viewData)
        //     ->with('user_rights', $user_rights)
        //     ->with('userId', $userId)
        //     ->with('jobTitles', $jobTitles)
        ;

    }


    public function hiringRequest(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Hiring Request';
        $user_rights = helpers::get_user_rights(Auth::id());

        $hiringRequests = hiringRequest::where('requestBy', $userId)
//            ->where('hiring_request.status', 'entered')
            //->orWhere('amID',$userId )
            ->select('hiring_request.*', 'job_titles.title as jobTitle', 'og_designations.title as jobTitles', 'og_users.display_name')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftjoin('wizpac.og_users', 'og_users.id', 'hiring_request.requestBy')
            ->whereNotNull('job_titles.title')
            ->get();
        //dd($hiringRequests);


        return view('hiringRequest', $this->viewData)
            ->with('user_rights', $user_rights)
            ->with('userId', $userId)
            ->with('hiringRequests', $hiringRequests);

    }

    public function hiringRequestApprovel(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Hiring Request';
        $user_rights = helpers::get_user_rights(Auth::id());

        $hiringRequests = hiringRequest::where('amID', $userId)
//            ->where('hiring_request.status', 'entered')
            //->orWhere('amID',$userId )
            ->select('hiring_request.*', 'job_titles.title as jobTitle', 'og_designations.title as jobTitles', 'og_users.display_name')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftjoin('wizpac.og_users', 'og_users.id', 'hiring_request.requestBy')
            ->orderBy('jobportal.hiring_request.created_at', 'desc')
            ->get();

        return view('hiringRequest', $this->viewData)
            ->with('user_rights', $user_rights)
            ->with('userId', $userId)
            ->with('hiringRequests', $hiringRequests);

    }

    public function hiringRequestAuthenticate(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Hiring Request';
        $user_rights = helpers::get_user_rights(Auth::id());

        $hiringRequests = hiringRequest::where('hiring_request.status', 'recommended')
            ->orWhere('hiring_request.status', 'authenticate')
            //->orWhere('amID',$userId )
            ->select('hiring_request.*', 'job_titles.title as jobTitle', 'og_designations.title as jobTitles', 'og_users.display_name')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftjoin('wizpac.og_users', 'og_users.id', 'hiring_request.requestBy')
            ->get();
        //dd($hiringRequests);

        return view('hiringRequestHRapproval', $this->viewData)
            ->with('user_rights', $user_rights)
            ->with('userId', $userId)
            ->with('hiringRequests', $hiringRequests);

    }

    public function hiringRequestAuthenticateForm(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Hiring Request';
        $user_rights = helpers::get_user_rights(Auth::id());
        $hiringRequests = hiringRequest::where('hiring_request.id', '=', $request->id)
            ->select('hiring_request.*', 'job_titles.title as jobTitle', 'og_designations.title as jobTitles',
                'positions_nature.title as positionNature', 'pacra_employee_grade.name as policyName')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftjoin('jobportal.positions_nature', 'positions_nature.id', 'hiring_request.hiringType')
            ->leftjoin('wizpac.pacra_employee_grade', 'pacra_employee_grade.id', 'hiring_request.grade')
            ->get();

        $positionNatures = pacraPositionNatureModel::all();

        $getDepartments = UsersModel::where('og_users.id', $hiringRequests->first()->requestBy)
            ->select('pacra_teams.id as departmentID', 'pacra_teams.title as department',
                'subDPT.title as sub_dpt', 'subDPT.id as sub_dptID')
            ->leftJoin('pacra_teams', 'pacra_teams.id', 'og_users.department')
            ->leftJoin('pacra_teams as subDPT', 'subDPT.id', 'og_users.sub_dpt')
            //->orderBY('title', 'ASC')
            ->first();

        $allGrades = DB::table('pacra_employee_grade')
            ->select('id', 'name', 'description')
            ->get();


        return view('hiringRequestFormHRapproval', $this->viewData)
            ->with('user_rights', $user_rights)
            ->with('userId', $userId)
            ->with('hiringRequests', $hiringRequests)
            ->with('positionNatures', $positionNatures)
            ->with('getDepartments', $getDepartments)
            ->with('allGrades', $allGrades);

    }

    public function hiringRequestForm(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $this->viewData['meta_title'] = 'Hiring Request Form';
        $user_rights = helpers::get_user_rights(Auth::id());
        //$jobTitles = jobTitles::all();

        $jobTitles = jobTitles::select('job_titles.*', 'og_designations.title as jobTitle')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->get();

        if ($request->id == null) {
            return view('hiringRequestForm', $this->viewData)
                ->with('user_rights', $user_rights)
                ->with('userId', $userId)
                ->with('jobTitles', $jobTitles);
        } else {
            $hiringRequests = hiringRequest::where('hiring_request.id', '=', $request->id)
                ->select('hiring_request.*', 'job_titles.title as jobTitle', 'og_designations.title as jobTitles')
                ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
                ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
                ->get();

            return view('hiringRequestForm', $this->viewData)
                ->with('user_rights', $user_rights)
                ->with('userId', $userId)
                ->with('amId', $amId)
                ->with('jobTitles', $jobTitles)
                ->with('hiringRequests', $hiringRequests);
        }
    }

    public function hiringRequestFormDetails($id)
    {

        $jobTitleDetails = jobTitles::find($id);


        return response()->json(['data' => $jobTitleDetails]);

    }

    public function addHiringRequest(Request $request)
    {
//        $request->validate([
//            'job_title' => 'exists:jobportal.hiring_request,title',
////            'job_title' => Rule::unique('jobportal.hiring_request')
//        ]);


        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $teamleademail = helpers::get_teamlead_email($userId);
        $teamleadname = helpers::get_teamlead_name($userId);
        $username = helpers::get_userName($userId);
        $usermail = helpers::get_userEmail($userId);
        $hrmail = helpers::hrEmail($userId);
        $portalLink = "<a href=" . url('hiringRequestAuthenticate') . ">HRMS</a>";
        $portalLinkApproval = "<a href=" . url('hiringRequestApprovel') . ">Hiring Request Approval</a>";
        $this->viewData['meta_title'] = 'Hiring Request Form';
        $user_rights = helpers::get_user_rights(Auth::id());
        $RR = hiringRequest::all();

        if ($request->submit == 'entered') {
            hiringRequest::updateOrCreate([
                'id' => $request->recordID,
            ],
                [
                    'hiringType' => $request->hiringType,
                    'location' => $request->location,
                    'vacancies' => $request->vacancy,
                    'title' => $request->job_title,
                    'description' => $request->description,
                    'requirements' => $request->requirements,
                    'jobExpectations' => $request->jobExpectations,
                    'jobBenefits' => $request->jobBenefits,
                    'salary' => $request->salary,
                    'experience' => $request->experience,
                    'requestBy' => $userId,
                    'amID' => $amId,
                    'last_updated_by' => $userId,
                    'status' => $request->submit,

                ]);

            $jobTitleForMail = hiringRequest::select('og_designations.title as jobName')->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
                ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
                ->where('job_titles.id', $request->job_title)
                ->get();
            $jobTitleForMail = $jobTitleForMail[0]->jobName;
            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $hrmail, $username, $portalLinkApproval, $jobTitleForMail) {

                $message->to($teamleademail)
                    ->cc($hrmail)
                    ->subject($username . ' Created a Hiring Request')
                    ->setBody('<h3>Dear ' . $teamleadname . '</h3>
                        <br>' . $username . ' created a Hiring Request, please approve.
                        <br><b>Job Title: </b> ' . $jobTitleForMail . ' <br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLinkApproval, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
            return redirect()->route('hiringRequest');
        } elseif ($request->submit == 'recommended') {
            hiringRequest::updateOrCreate(['id' => $request->recordID,],
                ['hiringType' => $request->hiringType,
                    'location' => $request->location,
                    'vacancies' => $request->vacancy,
                    'title' => $request->job_title,
                    'description' => $request->description,
                    'requirements' => $request->requirements,
                    'jobExpectations' => $request->jobExpectations,
                    'jobBenefits' => $request->jobBenefits,
                    'salary' => $request->salary,
                    'experience' => $request->experience,
                    'approvedBy' => $userId,
                    'last_updated_by' => $userId,
                    'status' => $request->submit,]);

            $jobTitleForMail = hiringRequest::select('og_designations.title as jobName')->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
                ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
                ->where('job_titles.id', $request->job_title)
                ->get();
            $jobTitleForMail = $jobTitleForMail[0]->jobName;

            Mail::send([], [], function ($message) use ($request, $teamleadname, $teamleademail, $hrmail, $username, $portalLink, $jobTitleForMail) {

                $message->to($hrmail)
                    ->subject($jobTitleForMail . ' Hiring Request Recommended')
                    ->setBody('<h3>Dear HR,</h3>
                        <br>TL has recommended Hiring Request please approve.
                        <br><b>Job Title: </b> ' . $jobTitleForMail . ' <br>
                        <br>Thank you.<br>
                        <h3>URL:</h3>' . $portalLink, 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

            return redirect()->route('hiringRequestApprovel');

        } else {
            if ($request->lastDate) {
                $lastDate = $request->lastDate;
            } else {
                $lastDate = (Carbon::now()->addMonth());
            }


            hiringRequest::updateOrCreate([
                'id' => $request->recordID,

            ], [
                'hiringType' => $request->hiringType,
                'location' => $request->location,
                'vacancies' => $request->vacancy,
                'engagementPeriodType' => $request->engagementPeriodType,
                'engagementPeriod' => $request->engagementPeriod,
                'grade' => $request->grade,
                'department' => $request->department,
                'sub_department' => $request->sub_department,
                'title' => $request->job_title,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'jobExpectations' => $request->jobExpectations,
                'jobBenefits' => $request->jobBenefits,
                'salary' => $request->salary,
                'experience' => $request->experience,
                'authenticateBy' => $userId,
                'last_updated_by' => $userId,
                'status' => $request->submit,
                'jobPostingDate' => Carbon::now()->toDateTimeString(),
                'lastDate' => $lastDate,
            ]);
            return redirect()->route('hiringRequestAuthenticate');
        }
        $hiringRequests = hiringRequest::where('requestBy', $userId)->get();
        return redirect()->route('hiringRequest');
    }

    public function jobApplicants(Request $request)
    {

        $this->viewData['meta_title'] = 'Applicants';

        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle')
            ->leftJoin('job_titles', 'job_titles.id', '=', 'jobportal.hiring_request.title')
            ->where('status', 'authenticate')
            ->get();
        //dd('jobportal.');


        $jobAppliedLists = pacraJobsCandidateModel::select('applicant_profile.fname', 'applicant_profile.lname',
            'applicant_profile.cv', 'job_candidates.applyDate', 'job_candidates.candidateStatus',
            'hiring_request.id as hiringRequestID', 'job_candidates.jobID', 'hiring_request.requestBy',
            'hiring_request.title as jobTitle', 'og_designations.title as jobTitlesTable',
            'applicant_profile.userID', 'job_candidates.id as candidateID', 'og_users.fname as pfname', 'og_users.lname as plname')
            ->leftJoin('jobportal.hiring_request', 'jobportal.hiring_request.id', 'job_candidates.jobID')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', 'jobportal.hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftJoin('jobportal.applicant_profile', 'jobportal.applicant_profile.userID', 'job_candidates.userID')
            ->leftJoin('og_users', 'og_users.id', 'hiring_request.requestBy')
//            ->where('jobportal.job_candidates.candidateStatus', 'Applied')
            ->orderby('job_candidates.applyDate', 'desc')
            ->get();

        $rejectionReasons = RejectionCommentsTable::all();

        return view('jobsApplicants', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('rejectionReasons', $rejectionReasons)
            ->with('jobAppliedLists', $jobAppliedLists);

    }

    public function initialShortlist(Request $request)
    {

        $this->viewData['meta_title'] = 'Applicants';

        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle')
            ->leftJoin('job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->where('status', 'authenticate')
            ->get();


        $jobAppliedLists = pacraJobsCandidateModel::select('applicant_profile.fname', 'applicant_profile.lname',
            'applicant_profile.cv', 'job_candidates.applyDate', 'job_candidates.candidateStatus',
            'hiring_request.id as hiringRequestID', 'job_candidates.jobID', 'hiring_request.requestBy',
            'hiring_request.title as jobTitle', 'og_designations.title as jobTitlesTable',
            'applicant_profile.userID', 'job_candidates.id as candidateID', 'og_users.fname as pfname', 'og_users.lname as plname')
            ->leftJoin('jobportal.hiring_request', 'jobportal.hiring_request.id', 'job_candidates.jobID')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', 'jobportal.hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftJoin('jobportal.applicant_profile', 'jobportal.applicant_profile.userID', 'job_candidates.userID')
            ->leftJoin('og_users', 'og_users.id', 'hiring_request.requestBy')
            ->where('jobportal.job_candidates.candidateStatus', 'Shortlist')
            ->get();

        $candidateID = pacraJobsCandidateModel::where('jobportal.job_candidates.candidateStatus', 'Shortlist')->get();


//         dd($jobAppliedLists);
        return view('initialShortlist', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('candidateID', $candidateID)
            ->with('jobAppliedLists', $jobAppliedLists);

    }

    public function addInitialShortlist(Request $request)
    {
        $this->viewData['meta_title'] = 'Schedule Test';
        if ($request->status == "Rejected") {
            $input = $request->all();
            $array = array("comment" => $input['rejection_comment']);
            $input['rejection_comment'] = implode(',', $array['comment']);
            pacraJobsCandidateModel::updateOrCreate([
                'id' => $request->candidateID,
            ], [
                'candidateStatus' => $request->status,
                'rejection_comment' => $input['rejection_comment'],
            ]);
        } else {
            pacraJobsCandidateModel::updateOrCreate([
                'id' => $request->candidateID,
            ], [
                'candidateStatus' => $request->status,
            ]);
        }
        return redirect()->route('jobApplicants');
    }

    public function rejectApplicants(Request $request)
    {
        $this->viewData['meta_title'] = '';
        $input = $request->all();
//            dd($input);
//            $array = array("comment" => $input['rejection_comment']);
//            $input['rejection_comment'] = $input['rejection_comment'];
        pacraJobsCandidateModel::updateOrCreate([
            'id' => $request->recID,
        ], [
            'candidateStatus' => $request->Rejected,
            'rejection_comment' => $input['rejection_comment'],
        ]);
        return redirect()->route('jobApplicants');
    }


    public function jobApplicantsSearch(Request $request)
    {
        $this->viewData['meta_title'] = 'Applicants';
        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->where('status', 'authenticate')
            ->get();

        $jobAppliedLists = pacraJobsCandidateModel::where('jobID', $request->jobID)
            ->leftJoin('jobportal.hiring_request', 'hiring_request.id', 'job_candidates.jobID')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', 'hiring_request.title')
            ->get();

//        dd($jobAppliedLists);

        return view('jobsApplicants', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('jobAppliedLists', $jobAppliedLists);

    }


    public function scheduleTest(Request $request)
    {
        $this->viewData['meta_title'] = 'Schedule Test';
        $userProfile = pacraApplicantProfileModel::where('userID', $request->userID)->get();
        $candidateID = $request->candidateID;

        $jobDetails = hiringRequest::select('job_titles.title as jobTitle', 'hiring_request.title', 'hiring_request.id'
            , 'og_designations.title as jobTitles')
            ->leftjoin('jobportal.job_titles', 'job_titles.id', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->where('jobportal.hiring_request.id', $request->jobID)
            ->get();


        $allActiveUsers = UsersModel::select('id', 'display_name')
            ->where('is_active', 1)
            ->orderBy('display_name')
            ->get();

        //dd($allActiveUsers);
        //dd($request->userID);

        return view('scheduleTestForm', $this->viewData)
            ->with('userProfile', $userProfile)
            ->with('candidateID', $candidateID)
            ->with('jobDetails', $jobDetails)
            ->with('allActiveUsers', $allActiveUsers);

    }

    public function addScheduleTest(Request $request)
    {
        $this->viewData['meta_title'] = 'Schedule Test';
        // dd($request->all());


        pacraScheduleTest::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            'candidateID' => $request->candidateID,

        ], [
            'userID' => $request->userID,
            'candidateID' => $request->candidateID,
            'jobID' => $request->jobID,
            'testConductors' => implode(",", $request->testConductors),
            'testDate' => $request->date,
            'testTime' => $request->time,
            'candidateEmailText' => $request->candidateEmailText,
            'conductorEmailText' => $request->conductorEmailText,
        ]);


        pacraJobsCandidateModel::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            'id' => $request->candidateID,

        ], [
            'candidateStatus' => 'Select For Test',
        ]);

        $checkApplicantProfile = pacraApplicantProfileModel::where('userID', $request->userID)
            ->where('status', 1)
            ->get();


        Mail::send([], [], function ($message) use ($request, $checkApplicantProfile) {

            $message->to($checkApplicantProfile->first()->email, $checkApplicantProfile->first()->lname)
                ->subject('Test Schedule')
                ->setBody($request->candidateEmailText, 'text/html');
            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        });

        $getTestConductorsEmail = UsersModel::select('email')
            ->whereIN('id', $request->testConductors)->get();


        Mail::send([], [], function ($message) use ($request, $getTestConductorsEmail) {

            $message->to($getTestConductorsEmail->first()->email)
                ->subject('Test Schedule')
                ->setBody($request->conductorEmailText, 'text/html');
            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        });


        //dd($getTestConductorsEmail);
        return redirect()->route('jobApplicants')//return view('shortListedForTest', $this->viewData)
            ;

    }


    public function shortListedForTest(Request $request)
    {
        $this->viewData['meta_title'] = 'Short Listed For Test';
        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->where('status', 'authenticate')
            ->get();


        $candidateLists = pacraScheduleTest::select('candidate_for_test.testDate', 'candidate_for_test.testTime', 'jobportal.job_titles.title',
            'candidate_for_test.testConductors', 'candidate_for_test.userID', 'og_designations.title as jobTitlesTable',
            'candidate_for_test.jobID', 'candidate_for_test.candidateID', 'applicant_profile.fname', 'og_users.fname as conductorFname',
            'og_users.lname as conductorLname', 'candidate_for_test.id as recordId',
            'applicant_profile.lname', 'hiring_request.id', 'hiring_request.title')
            ->leftjoin('jobportal.applicant_profile', 'applicant_profile.userID', 'candidate_for_test.userID')
            ->leftjoin('wizpac.og_users', 'candidate_for_test.testConductors', 'og_users.id')
            ->leftjoin('hiring_request', 'hiring_request.id', 'candidate_for_test.jobID')
            ->leftjoin('job_titles', 'job_titles.id', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'og_designations.id', 'job_titles.title')
            ->whereNull('candidate_for_test.rejected')
            ->get();


        //dd('OK');
        return view('shortListedForTest', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('candidateLists', $candidateLists);

    }


    public function scheduleInterview(Request $request)
    {
        $this->viewData['meta_title'] = 'Schedule Interview';
        $userProfile = pacraApplicantProfileModel::where('userID', $request->userID)->get();
        $candidateID = $request->candidateID;
        $jobDetails = hiringRequest::select('job_titles.title as jobTitle', 'hiring_request.title', 'hiring_request.id', 'og_designations.title as jobTitles')
            ->leftjoin('jobportal.job_titles', 'job_titles.id', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->where('jobportal.hiring_request.id', $request->jobID)
            ->get();
        $allActiveUsers = UsersModel::select('id', 'display_name')
            ->where('is_active', 1)
            ->orderBy('display_name')
            ->get();

//        $checkInterview = pacraScheduleInterview::where('candidateID', $request->candidateID)
//            ->where('jobID', $request->jobID)
//            ->where('interviewRound', 'HR')
//            ->count();
//
//        $checkInterview2 = pacraScheduleInterview::where('candidateID', $request->candidateID)
//            ->where('jobID', $request->jobID)
//            ->where('interviewRound', '=', 'Team Lead')
//            ->count();

//        $checkInterviewHRnTL = pacraScheduleInterview::where('candidateID', $request->candidateID)
//            ->where('jobID', $request->jobID)
//            ->whereNull('interviewSheet')
//            ->count();
//
//        $checkInterviewUH = pacraScheduleInterview::where('candidateID', $request->candidateID)
//            ->where('jobID', $request->jobID)
//            ->whereNull('interviewSheet1')
//            ->count();
//
//        $checkInterviewCEO = pacraScheduleInterview::where('candidateID', $request->candidateID)
//            ->where('jobID', $request->jobID)
//            ->whereNull('interviewSheet2')
//            ->count();


        return view('scheduleInterviewForm', $this->viewData)
            ->with('userProfile', $userProfile)
            ->with('candidateID', $candidateID)
            ->with('jobDetails', $jobDetails)
            ->with('allActiveUsers', $allActiveUsers);
//            ->with('checkInterviewHRnTL', $checkInterviewHRnTL)
//            ->with('checkInterviewCEO', $checkInterviewCEO)
//            ->with('checkInterviewUH', $checkInterviewUH);

    }

    public function addScheduleInterview(Request $request)
    {
        $this->viewData['meta_title'] = 'Schedule Interview';
        $IntDate = $request->date;
        $IntTime = $request->time;

        if ($request->hasFile('candidatesTest')) {
            $path = 'candidatesTest';
            $fileNameToStore = time() . '.' . $request->candidatesTest->extension();
            $scannedTest = $request->candidatesTest->move(public_path($path), $fileNameToStore);
            $scannedTest = $path . '/' . $fileNameToStore;
        } else {
            $scannedTest = '';
        }

        if ($request->hasFile('miscellaneousDoc')) {
            $path = 'miscellaneousDoc';
            $fileNameToStore = time() . '.' . $request->miscellaneousDoc->extension();
            $miscellaneousDoc = $request->miscellaneousDoc->move(public_path($path), $fileNameToStore);
            $miscellaneousDoc = $path . '/' . $fileNameToStore;
        } else {
            $miscellaneousDoc = '';
        }

        if ($request->hasFile('interviewSheetHR')) {
            $path = 'interviewSheet';
            $fileNameToStore = time() . '.' . $request->interviewSheetHR->extension();
            $interviewSheetHR = $request->interviewSheetHR->move(public_path($path), $fileNameToStore);
            $interviewSheetHR = $path . '/' . $fileNameToStore;
        } else {
            $interviewSheetHR = '';
        }

        if ($request->hasFile('interviewSheetTL')) {
            $path = 'interviewSheet';
            $fileNameToStore = time() . '.' . $request->interviewSheetTL->extension();
            $interviewSheetTL = $request->interviewSheetTL->move(public_path($path), $fileNameToStore);
            $interviewSheetTL = $path . '/' . $fileNameToStore;
        } else {
            $interviewSheetTL = '';
        }

        if ($request->hasFile('interviewSheetUH')) {
            $path = 'interviewSheet';
            $fileNameToStore = time() . '.' . $request->interviewSheetUH->extension();
            $interviewSheetUH = $request->interviewSheetUH->move(public_path($path), $fileNameToStore);
            $interviewSheetUH = $path . '/' . $fileNameToStore;
        } else {
            $interviewSheetUH = '';
        }

        $checkApplicantProfile = pacraApplicantProfileModel::where('userID', $request->userID)
            ->where('status', 1)
            ->get();
        $getTestConductorsEmail = UsersModel::select('email')
            ->whereIN('id', $request->interviewers)->get();

        if ($request->interviewRound == 'HR/TL') {

            pacraScheduleInterview::updateOrCreate([
                'candidateID' => $request->candidateID,

            ], [
                'userID' => $request->userID,
                'candidateID' => $request->candidateID,
                'jobID' => $request->jobID,
                'interviewRound' => $request->interviewRound,
                'interviewers' => implode(",", $request->interviewers),
                'date' => $request->date,
                'time' => $request->time,
                'interviewLocation' => $request->interviewLocation,
                'candidateEmailText' => $request->candidateEmailText,
                'conductorEmailText' => $request->conductorEmailText,
                'miscellaneousDoc' => $miscellaneousDoc,
                'scannedTest' => $scannedTest,
//                'interviewSheet' => $interviewSheet,
                'obtainedMarks' => $request->marks,
                'status' => 'Entered'
            ]);

            pacraJobsCandidateModel::updateOrCreate([
                'id' => $request->candidateID,

            ], [
                'candidateStatus' => 'Selected For HR / Team Lead Interview',
            ]);

            Mail::send([], [], function ($message) use ($request, $checkApplicantProfile, $IntDate, $IntTime) {

                $message->to($checkApplicantProfile->first()->email, $checkApplicantProfile->first()->lname)
                    ->subject('Interview Schedule with PACRA')
                    ->setBody('' . $request->candidateEmailText . '
                        <br>Date: ' . $IntDate . ' . <br>
                        <br>Time: ' . $IntTime . ' . <br>
                       <br>Thank you.<br>', 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

            Mail::send([], [], function ($message) use ($request, $getTestConductorsEmail, $IntDate, $IntTime) {

                $message->to($getTestConductorsEmail->first()->email)
                    ->subject('Interview Schedule')
                    ->setBody('' . $request->candidateEmailText . '
                        <br>Date: ' . $IntDate . ' . <br>
                        <br>Time: ' . $IntTime . ' . <br>
                       <br>Thank you.<br>', 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        } elseif ($request->interviewRound == 'Unit Head') {

            pacraScheduleInterview::updateOrCreate([
                'candidateID' => $request->candidateID,

            ], [
                'userID' => $request->userID,
                'candidateID' => $request->candidateID,
                'jobID' => $request->jobID,
                'interviewRound' => $request->interviewRound,
                'interviewers' => implode(",", $request->interviewers),
                'date' => $request->date,
                'time' => $request->time,
                'interviewLocation' => $request->interviewLocation,
                'candidateEmailText' => $request->candidateEmailText,
                'conductorEmailText' => $request->conductorEmailText,
//                'miscellaneousDoc' => $miscellaneousDoc,
//                'scannedTest' => $scannedTest,
                'interviewSheetHR' => $interviewSheetHR,
                'interviewSheetTL' => $interviewSheetTL,
                'obtainedMarks' => $request->marks,
                'status' => 'Entered'
            ]);

            pacraJobsCandidateModel::updateOrCreate([
                'id' => $request->candidateID,

            ], [
                'candidateStatus' => 'Selected For Unit Head Interview',
            ]);

            Mail::send([], [], function ($message) use ($request, $checkApplicantProfile, $IntDate, $IntTime) {

                $message->to($checkApplicantProfile->first()->email, $checkApplicantProfile->first()->lname)
                    ->subject('Interview Schedule')
                    ->setBody('' . $request->candidateEmailText . '
                        <br>Date: ' . $IntDate . ' . <br>
                        <br>Time: ' . $IntTime . ' . <br>
                       <br>Thank you.<br>', 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });

            Mail::send([], [], function ($message) use ($request, $getTestConductorsEmail, $IntDate, $IntTime) {

                $message->to($getTestConductorsEmail->first()->email)
                    ->subject('Interview Schedule')
                    ->setBody('' . $request->candidateEmailText . '
                        <br>Date: ' . $IntDate . ' . <br>
                        <br>Time: ' . $IntTime . ' . <br>
                       <br>Thank you.<br>', 'text/html');
                $message->from('webmaster@pacra.com', 'Webmaster PACRA');
            });
        } elseif ($request->interviewRound == 'CEO/Final') {

            pacraScheduleInterview::updateOrCreate([
                'candidateID' => $request->candidateID,
                'interviewRound' => $request->interviewRound,

            ], [
                'userID' => $request->userID,
                'candidateID' => $request->candidateID,
                'jobID' => $request->jobID,
                'interviewRound' => $request->interviewRound,
                'interviewers' => implode(",", $request->interviewers),
                'date' => $request->date,
                'time' => $request->time,
                'interviewLocation' => $request->interviewLocation,
                'candidateEmailText' => $request->candidateEmailText,
                'conductorEmailText' => $request->conductorEmailText,
                'interviewSheetUH' => $interviewSheetUH,
            ]);


            pacraJobsCandidateModel::updateOrCreate([
                'id' => $request->candidateID,
            ], [
                'candidateStatus' => 'Selected For ' . $request->interviewRound . ' Interview',
            ]);

            CandidateSalary::updateOrCreate(
                [
                    'userID' => $request->userID,
                    'jobID' => $request->jobID,
                    'candidateID' => $request->candidateID,
                ],

                [
                    'userID' => $request->userID,
                    'jobID' => $request->jobID,
                    'candidateID' => $request->candidateID,
                    'doj' => $request->doj,
                    'candidateName' => $request->candidateName,
                    'probBasicSalaryMin' => $request->probBasicSalaryMin,
                    'probBasicSalary' => $request->probBasicSalary,
                    'confirmationSalaryMin' => $request->confirmationSalaryMin,
                    'confirmationSalary' => $request->confirmationSalary,
                    'status' => 'entered',

                ]);


            pacraAppointmentLetterModel::updateOrCreate(
                [
                    'userID' => $request->userID,
                    'jobID' => $request->jobID,
                    'candidateID' => $request->candidateID,
                ],
                [
                    'userID' => $request->userID,
                    'jobID' => $request->jobID,
                    'candidateID' => $request->candidateID,
                    'refrence' => $request->refrence,
                    'date' => $request->date,
                    'doj' => $request->date,
                    'designation' => $request->candidateDesignation,
                    'candidateEmpNo' => $request->candidateEmpNo,
                    'candidategrade' => $request->candidategrade,
                    'candidateName' => $request->candidateName,
                    'candidateEmail' => $request->candidateEmail,
                    'candidatePhone' => $request->candidatePhone,
                    'probBasicSalary' => $request->probBasicSalary,
                    'probEOBIEmployer' => $request->probEOBIEmployer,
                    'probEOBIEmployee' => $request->probEOBIEmployee,
                    'confirmationSalary' => $request->confirmationSalary,
                    'confirmationEOBIEmployer' => $request->confirmationEOBIEmployer,
                    'confirmationEOBIEmployee' => $request->confirmationEOBIEmployee,
                    'status' => 'entered',
                ]);
        } else {

            pacraScheduleInterview::updateOrCreate([
                'candidateID' => $request->candidateID,
                'interviewRound' => $request->interviewRound,

            ], [
                'userID' => $request->userID,
                'candidateID' => $request->candidateID,
                'jobID' => $request->jobID,
                'interviewRound' => $request->interviewRound,
                'interviewers' => implode(",", $request->interviewers),
                'date' => $request->date,
                'time' => $request->time,
                'interviewLocation' => $request->interviewLocation,
                'candidateEmailText' => $request->candidateEmailText,
                'conductorEmailText' => $request->conductorEmailText,
            ]);


            pacraJobsCandidateModel::updateOrCreate([
                'id' => $request->candidateID,

            ], [
                'candidateStatus' => 'Select For ' . $request->interviewRound . ' Interview',
            ]);
        }

        Mail::send([], [], function ($message) use ($request, $checkApplicantProfile, $IntDate, $IntTime) {

            $message->to($checkApplicantProfile->first()->email, $checkApplicantProfile->first()->lname)
                ->subject('Interview Schedule')
                ->setBody('' . $request->candidateEmailText . '
                        <br>Date: ' . $IntDate . ' . <br>
                        <br>Time: ' . $IntTime . ' . <br>
                       <br>Thank you.<br>', 'text/html');
            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        });

        Mail::send([], [], function ($message) use ($request, $getTestConductorsEmail, $IntDate, $IntTime) {

            $message->to($getTestConductorsEmail->first()->email)
                ->subject('Interview Schedule')
                ->setBody('' . $request->candidateEmailText . '
                        <br>Date: ' . $IntDate . ' . <br>
                        <br>Time: ' . $IntTime . ' . <br>
                       <br>Thank you.<br>', 'text/html');
            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        });

        return redirect()->route('shortListedForInterview');

    }

    public function reScheduleInterview(Request $request)
    {
        $this->viewData['meta_title'] = 'Schedule Interview';
        $userProfile = pacraApplicantProfileModel::where('userID', $request->userID)->get();
        $candidateID = $request->candidateID;
        $jobDetails = hiringRequest::select('job_titles.title as jobTitle', 'hiring_request.title', 'hiring_request.id', 'og_designations.title as jobTitles')
            ->leftjoin('jobportal.job_titles', 'job_titles.id', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->where('jobportal.hiring_request.id', $request->jobID)
            ->get();
        $allActiveUsers = UsersModel::select('id', 'display_name')
            ->where('is_active', 1)
            ->orderBy('display_name')
            ->get();

//        $checkInterviewHRnTL = pacraScheduleInterview::where('candidateID', $request->candidateID)
//            ->where('jobID', $request->jobID)
//            ->whereNull('interviewSheet')
//            ->count();
//
//        $checkInterviewUH = pacraScheduleInterview::where('candidateID', $request->candidateID)
//            ->where('jobID', $request->jobID)
//            ->whereNull('interviewSheet1')
//            ->count();
//
//        $checkInterviewCEO = pacraScheduleInterview::where('candidateID', $request->candidateID)
//            ->where('jobID', $request->jobID)
//            ->whereNull('interviewSheet2')
//            ->count();

        $getInterviewDetails = pacraScheduleInterview::where('id', $request->interviewID)->first();


        // dd($getInterviewDetails);
        //dd($request->userID);

        return view('reScheduleInterviewForm', $this->viewData)
            ->with('userProfile', $userProfile)
            ->with('candidateID', $candidateID)
            ->with('jobDetails', $jobDetails)
            ->with('allActiveUsers', $allActiveUsers)
            ->with('getInterviewDetails', $getInterviewDetails);

    }

    public function addReScheduleInterview(Request $request)
    {
        $this->viewData['meta_title'] = 'Schedule Interview';


        pacraScheduleInterview::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            'id' => $request->interviewID,
            //'candidateID'   => $request->candidateID,

        ], [
            'userID' => $request->userID,
            'candidateID' => $request->candidateID,
            'jobID' => $request->jobID,
            //'interviewRound' => $request->interviewRound,
            //'interviewers' => implode(",",$request->interviewers) ,
            'date' => $request->date,
            'time' => $request->time,
            'interviewLocation' => $request->interviewLocation,
            //'candidateEmailText' => $request->candidateEmailText,
            //'conductorEmailText' => $request->conductorEmailText,
            //'miscellaneousDoc' => $docfile_path,
            // 'scannedTest' => $file_path,
            // 'obtainedMarks'=>$request->marks,
            'status' => 'Accepted'
        ]);


        pacraJobsCandidateModel::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            'id' => $request->candidateID,

        ], [
            'candidateStatus' => 'Select For 1st Interview',
        ]);


        $checkApplicantProfile = pacraApplicantProfileModel::where('userID', $request->userID)
            ->where('status', 1)
            ->get();


        Mail::send([], [], function ($message) use ($request, $checkApplicantProfile) {

            $message->to($checkApplicantProfile->first()->email, $checkApplicantProfile->first()->lname)
                ->subject('Interview Schedule')
                ->setBody($request->candidateEmailText, 'text/html');
            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        });

        // $getTestConductorsEmail = UsersModel::select('email')
        // ->whereIN('id', $request->interviewers)->get();


        // Mail::send([], [], function ($message)use ($request, $getTestConductorsEmail) {

        //     $message->to($getTestConductorsEmail->first()->email)
        //     ->subject('Interview Schedule')

        //         ->setBody($request->conductorEmailText,  'text/html');
        //     $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        // });


        //dd('OK');
        return redirect()->route('myInterViewList')//return view('shortListedForTest', $this->viewData)
            ;

    }


    public function scheduleInterviewCEO(Request $request)
    {
        $this->viewData['meta_title'] = 'Schedule Interview';
        $userProfile = pacraApplicantProfileModel::where('userID', $request->userID)->get();
        $candidateID = $request->candidateID;
        $jobDetails = hiringRequest::select('job_titles.title as jobTitle',
            'hiring_request.title', 'hiring_request.id', 'hiring_request.grade',
            'og_designations.title as jobTitles'
        )
            ->leftjoin('jobportal.job_titles', 'job_titles.id', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->where('jobportal.hiring_request.id', $request->jobID)
            ->get();

        //dd($jobDetails);
        $allActiveUsers = UsersModel::select('id', 'display_name')
            ->where('is_active', 1)
            ->where('designation_id', 1)
            ->orderBy('display_name')
            ->get();

        $checkInterview = pacraScheduleInterview::where('candidateID', $request->candidateID)
            ->where('jobID', $request->jobID)
            ->where('interviewRound', 'Unit Head')
            ->count();


        //dd($checkInterview);
        //dd($request->userID);

        return view('scheduleInterviewFormCEO', $this->viewData)
            ->with('userProfile', $userProfile)
            ->with('candidateID', $candidateID)
            ->with('jobDetails', $jobDetails)
            ->with('allActiveUsers', $allActiveUsers)
            ->with('checkInterview', $checkInterview);

    }


    public function shortListedForInterview(Request $request)
    {
        $this->viewData['meta_title'] = 'Short Listed For Interview';
        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle'
            , 'og_designations.title as jobTitles')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->where('jobportal.hiring_request.status', 'authenticate')
            ->get();


        $candidateLists = pacraScheduleInterview::select('candidate_for_interview.date', 'candidate_for_interview.time',
            'candidate_for_interview.interviewers', 'candidate_for_interview.userID', 'candidate_for_interview.interviewRound',
            'candidate_for_interview.jobID', 'candidate_for_interview.candidateID', 'applicant_profile.fname',
            'applicant_profile.lname', 'candidate_for_interview.status', 'og_users.fname as interviewerFname', 'og_users.lname as interviewerLname',
            'og_designations.title as desTitle', 'job_titles.title', 'hiring_request.id', 'hiring_request.title')
            ->leftjoin('jobportal.applicant_profile', 'applicant_profile.userID', 'candidate_for_interview.userID')
            ->leftjoin('wizpac.og_users', 'og_users.id', 'candidate_for_interview.interviewers')
//            ->leftjoin('job_titles', 'job_titles.id', 'candidate_for_interview.jobID')
//            ->leftjoin('wizpac.og_designations', 'og_designations.id', 'job_titles.title')
            ->leftjoin('hiring_request', 'hiring_request.id', 'candidate_for_interview.jobID')
            ->leftjoin('job_titles', 'job_titles.id', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'og_designations.id', 'job_titles.title')
            ->orderBy('jobportal.candidate_for_interview.interviewRound', 'Desc')
            ->get();


        // dd($candidateLists);


        //dd('OK');
        return view('shortListedForInterview', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('candidateLists', $candidateLists);

    }

    public function engagementApproval(Request $request)
    {
        $this->viewData['meta_title'] = 'Short Listed For Final Interview';
        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->where('status', 'authenticate')
            ->get();

        $candidateLists = pacraScheduleInterview::select('candidate_for_interview.date', 'candidate_for_interview.time',
            'candidate_for_interview.interviewers', 'candidate_for_interview.userID', 'candidate_for_interview.interviewRound',
            'candidate_for_interview.jobID', 'candidate_for_interview.candidateID', 'applicant_profile.fname',
            'applicant_profile.lname')
            ->leftjoin('jobportal.applicant_profile', 'applicant_profile.userID', 'candidate_for_interview.userID')
            ->where('jobportal.candidate_for_interview.interviewers', 10)
            ->get();


        return view('engagementApproval', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('candidateLists', $candidateLists);

    }


    public function engagementForm(Request $request)
    {
        $this->viewData['meta_title'] = 'Employee Engagement Approval ';

        $getDepartments = DepartmentModel::where('isActive', '=', '1')
            ->orderBY('title', 'ASC')
            ->get();

        $getDesignations = DesignationsModel::where('isActive', '=', '1')
            ->orderBY('title', 'ASC')
            ->get();

        $positionNatures = pacraPositionNatureModel::all();

        $getCandidateName = pacraApplicantProfileModel::where('id', $request->userID)->get();

        $allGrades = DB::table('pacra_employee_grade')
            ->select('id', 'name', 'description')
            ->get();

        $getJobDetails = hiringRequest:: where('id', $request->jobID)
            ->get();


        return view('engagementForm', $this->viewData)
            ->with('getDepartments', $getDepartments)
            ->with('positionNatures', $positionNatures)
            ->with('getCandidateName', $getCandidateName)
            ->with('getDesignations', $getDesignations)
            ->with('allGrades', $allGrades)
            ->with('getJobDetails', $getJobDetails)
            ->with('userID', $request->userID)
            ->with('candidateID', $request->candidateID)
            ->with('jobID', $request->jobID);

    }


    public function addEngagementForm(Request $request)
    {
        $this->viewData['meta_title'] = 'Employee Engagement Approval ';

        pacraEngagementApprovalModel::create(
            [
                'userID' => $request->userID,
                'jobID' => $request->jobID,
                'candidateID' => $request->candidateID,
                'reference' => $request->reference,
                'department' => $request->department,
                'engagementPeriodType' => $request->engagementPeriodType,
                'engagementPeriod' => $request->engagementPeriod,
                'candidateName' => $request->candidateName,
                'designation' => $request->designation,
                'grade' => $request->grade,
                'doj' => $request->doj,
                'probSalary' => $request->probSalary,
                'afterProbSalary' => $request->afterProbSalary,
                'benifits' => $request->benifits,
                'status' => 'entered',

            ]);

        return redirect()->route('shortListedForFinalInterview');
    }

    public function appointmentForm(Request $request)
    {
        $this->viewData['meta_title'] = 'Appointment Letter ';


        $getCandidateName = pacraApplicantProfileModel::where('id', $request->userID)->get();

        $allGrades = DB::table('pacra_employee_grade')
            ->select('id', 'name', 'description')
            ->get();

        $getJobDetails = hiringRequest:: where('id', $request->jobID)
            ->get();

        return view('appointmentForm', $this->viewData)
            ->with('getCandidateName', $getCandidateName)
            ->with('allGrades', $allGrades)
            ->with('getJobDetails', $getJobDetails)
            ->with('userID', $request->userID)
            ->with('candidateID', $request->candidateID)
            ->with('jobID', $request->jobID);

    }


    public function addAppointmentForm(Request $request)
    {
        $this->viewData['meta_title'] = 'Employee Engagement Approval ';

        //dd($request->all());


        pacraAppointmentLetterModel::updateOrCreate(
            [
                'userID' => $request->userID,
                'jobID' => $request->jobID,
                'candidateID' => $request->candidateID,
            ],

            [
                'userID' => $request->userID,
                'jobID' => $request->jobID,
                'candidateID' => $request->candidateID,
                'refrence' => $request->refrence,
                'date' => $request->date,
                'candidateEmpNo' => $request->candidateEmpNo,
                'candidategrade' => $request->candidategrade,
                'candidateName' => $request->candidateName,
                'candidateEmail' => $request->candidateEmail,
                'candidatePhone' => $request->candidatePhone,
                'probBasicSalary' => $request->probBasicSalary,
                'probEOBIEmployer' => $request->probEOBIEmployer,
                'probEOBIEmployee' => $request->probEOBIEmployee,
                'confirmationSalary' => $request->confirmationSalary,
                'confirmationEOBIEmployer' => $request->confirmationEOBIEmployer,
                'confirmationEOBIEmployee' => $request->confirmationEOBIEmployee,
                'status' => 'entered',

            ]);

        // dd('ok');


        return redirect()->route('shortListedForFinalInterview');

    }


    public function appointmentLetter(Request $request)
    {
        $this->viewData['meta_title'] = 'Appointment Letter';
        $getProfileDetails = pacraApplicantProfileModel::select('applicant_profile.fname',
            'applicant_profile.lname', 'applicant_profile.email', 'applicant_profile.contactNumber',
            'appointment_letter.refrence', 'appointment_letter.date', 'appointment_letter.candidateEmpNo',
            'appointment_letter.candidategrade', 'appointment_letter.designation'
            , 'appointment_letter.probBasicSalary', 'appointment_letter.probEOBIEmployer'
            , 'appointment_letter.probEOBIEmployee'
            , 'appointment_letter.confirmationSalary'
            , 'appointment_letter.confirmationEOBIEmployer'
            , 'appointment_letter.confirmationEOBIEmployee'
            , 'appointment_letter.status'
            , 'wizpac.pacra_employee_grade.name as gradeTitle'
            , 'wizpac.og_designations.title as desigTitle'
            , 'jobportal.appointment_letter.doj as dateJoining'
        )
            ->leftJoin('jobportal.appointment_letter', 'appointment_letter.userID', 'applicant_profile.userID')
            ->leftJoin('jobportal.engagement_approval', 'engagement_approval.userID', 'applicant_profile.userID')
            ->leftJoin('wizpac.pacra_employee_grade', 'wizpac.pacra_employee_grade.id', 'appointment_letter.candidategrade')
            ->leftJoin('wizpac.og_designations', 'wizpac.og_designations.id', 'appointment_letter.designation')
            ->where('jobportal.applicant_profile.userID', $request->userID)
            ->get();

        $eobiEmployer = $getProfileDetails[0]->probEOBIEmployer;
        $eobiEmployee = $getProfileDetails[0]->probEOBIEmployee;
        $probEmployerPF = '-';
        $probMedical = '-';
        $confirmMedical = 10 / 100 * $getProfileDetails->first()->confirmationSalary;
        $confirmEmployerPF = 5 / 100 * $getProfileDetails->first()->confirmationSalary;

        return view('appointmentLetter', $this->viewData)
            ->with('getProfileDetails', $getProfileDetails)
            ->with('probMedical', $probMedical)
            ->with('confirmMedical', $confirmMedical)
            ->with('eobiEmployer', $eobiEmployer)
            ->with('eobiEmployee', $eobiEmployee)
            ->with('probEmployerPF', $probEmployerPF)
            ->with('confirmEmployerPF', $confirmEmployerPF)//->with('candidateLists', $candidateLists)
            ;

    }


    public function shortListedForFinalInterview(Request $request)
    {
        $this->viewData['meta_title'] = 'Short Listed For Final Interview';
        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->where('status', 'authenticate')
            ->get();


        $candidateLists = pacraScheduleInterview::select('candidate_for_interview.date', 'candidate_for_interview.time',
            'candidate_for_interview.interviewers', 'candidate_for_interview.userID', 'candidate_for_interview.interviewRound',
            'candidate_for_interview.jobID', 'candidate_for_interview.candidateID', 'applicant_profile.fname',
            'applicant_profile.lname', 'og_users.fname as Fname', 'og_users.lname as Lname', 'og_designations.title as desTitle', 'job_titles.title')
            ->leftjoin('jobportal.applicant_profile', 'applicant_profile.userID', 'candidate_for_interview.userID')
            ->leftJoin('jobportal.engagement_approval', 'engagement_approval.candidateID', 'candidate_for_interview.candidateID')
            ->leftJoin('wizpac.og_users', 'og_users.id', 'candidate_for_interview.interviewers')
            ->leftjoin('job_titles', 'job_titles.id', 'candidate_for_interview.jobID')
            ->leftjoin('wizpac.og_designations', 'og_designations.id', 'job_titles.title')
            ->where('jobportal.candidate_for_interview.interviewers', 10)
            //->where('engagement_approval.status', 'entered')
            ->get();
        $approvalCheck = CandidateSalary::where('userID', $candidateLists[0]->userID ?? '')->where('jobID', $candidateLists[0]->jobID ?? '')->where('status', 'approved')->count();

        return view('shortListedForFinalInterview', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('approvalCheck', $approvalCheck)
            ->with('candidateLists', $candidateLists);

    }

//

    public function hiringDecision(Request $request)
    {
//        dd('ddsa');
        $this->viewData['meta_title'] = 'Short Listed For Final Interview';
        CandidateSalary::updateOrCreate(
            [
                'userID' => $request->userID,
                'jobID' => $request->jobID,
                'candidateID' => $request->candidateID,
            ],
            [
                'status' => 'approved',
            ]);

        pacraCandidateForHiring::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            'candidateID' => $request->candidateID,
            'jobID' => $request->jobID,

        ], [
            'userID' => $request->userID,
            'candidateID' => $request->candidateID,
            'jobID' => $request->jobID,
            'decision' => $request->decision,
        ]);


        return back();

    }

    public function hiringDecisionSalary(Request $request)
    {
        // dd($request->all());
        $this->viewData['meta_title'] = 'Short Listed For Final Interview';

        CandidateSalary::updateOrCreate(
            [
                'userID' => $request->userID,
                'jobID' => $request->jobID,
                'candidateID' => $request->candidateID,
            ],

            [
                'userID' => $request->userID,
                'jobID' => $request->jobID,
                'candidateID' => $request->candidateID,
                //'doj'=> $request->date,
                // 'candidateName' => $request->candidateName,
                'probBasicSalaryMin' => $request->probBasicSalaryMin,
                'probBasicSalary' => $request->probBasicSalary,
                'confirmationSalaryMin' => $request->confirmationSalaryMin,
                'confirmationSalary' => $request->confirmationSalary,
                'status' => 'approved',

            ]);


        pacraCandidateForHiring::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            'candidateID' => $request->candidateID,
            'jobID' => $request->jobID,

        ], [
            'userID' => $request->userID,
            'candidateID' => $request->candidateID,
            'jobID' => $request->jobID,
            'decision' => $request->submit,
        ]);

        pacraAppointmentLetterModel::updateOrCreate(
            [
                'userID' => $request->userID,
                'jobID' => $request->jobID,
                'candidateID' => $request->candidateID,
            ],
            [
                'status' => 'approved',
            ]);

        return back();

    }

    public function ShortListByCEO(Request $request)
    {
        $this->viewData['meta_title'] = 'Short Listed For Hiring';
        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->where('status', 'authenticate')
            ->get();

        $candidateLists = pacraCandidateForHiring::Where('candidate_for_hiring.decision', 'Shortlist By CEO')
            ->select('candidate_for_hiring.userID', 'candidate_for_hiring.candidateID', 'candidate_for_hiring.jobID',
                'candidate_for_hiring.decision', 'applicant_profile.fname', 'applicant_profile.lname', 'candidate_salary.status',
                'candidate_salary.doj', 'candidate_salary.probBasicSalary', 'candidate_salary.confirmationSalary')
            ->leftJoin('jobportal.applicant_profile', 'jobportal.applicant_profile.userID', 'candidate_for_hiring.userID')
            ->leftJoin('candidate_salary', 'candidate_salary.userID', 'candidate_for_hiring.userID')
            ->where('candidate_salary.status', 'approved')
            ->get();

        return view('ShortListByCEO', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('candidateLists', $candidateLists);

    }


    public function finalSalaryForm(Request $request)
    {
        $this->viewData['meta_title'] = 'Final Salary';
        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->where('status', 'authenticate')
            ->get();


        $candidateLists = pacraCandidateForHiring::Where('candidate_for_hiring.decision', 'Shortlist By CEO')
            ->select('candidate_for_hiring.userID', 'candidate_for_hiring.candidateID', 'candidate_for_hiring.jobID',
                'candidate_for_hiring.decision', 'applicant_profile.fname', 'applicant_profile.lname',
                'candidate_salary.doj', 'candidate_salary.probBasicSalaryMin', 'candidate_salary.probBasicSalary',
                'candidate_salary.confirmationSalaryMin', 'candidate_salary.confirmationSalary'
            )
            ->leftJoin('jobportal.applicant_profile', 'jobportal.applicant_profile.userID', 'candidate_for_hiring.userID')
            ->leftJoin('candidate_salary', 'candidate_salary.userID', 'candidate_for_hiring.userID')
            ->where('candidate_for_hiring.userID', $request->userID)
            ->where('candidate_for_hiring.candidateID', $request->candidateID)
            ->where('candidate_for_hiring.jobID', $request->jobID)
            ->first();


        //dd($candidateLists);


        //dd('OK');
        return view('finalSalaryForm', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('candidateLists', $candidateLists);

    }

    public function addfinalSalaryForm(Request $request)
    {
        $this->viewData['meta_title'] = 'Final Salary';
        $candidateSalary = CandidateSalary::where('userID', $request->userID)
            ->where('jobID', $request->jobID)
            ->where('candidateID', $request->candidateID)
            ->where('probBasicSalaryMin', '>=', $request->probBasicSalaryMin)
            ->where('probBasicSalary', '>=', $request->probBasicSalary)
            ->where('confirmationSalaryMin', '>=', $request->confirmationSalaryMin)
            ->where('confirmationSalary', '>=', $request->confirmationSalary)//            ->where('doj', '>=', $request->doj)
        ;


        if (!$candidateSalary->first()) {
            CandidateSalary::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'userID' => $request->userID,
                'candidateID' => $request->candidateID,
                'jobID' => $request->jobID,

            ], [
                'probBasicSalaryMin' => $request->probBasicSalaryMin,
                'probBasicSalary' => $request->probBasicSalary,
                'confirmationSalaryMin' => $request->confirmationSalaryMin,
                'confirmationSalary' => $request->confirmationSalary,
                'doj' => $request->doj,
                'status' => 'entered'
            ]);

            $updateCandidateSalary = ['probBasicSalaryMin' => $request->probBasicSalaryMin,
                'probBasicSalary' => $request->probBasicSalary,
                'confirmationSalaryMin' => $request->confirmationSalaryMin,
                'confirmationSalary' => $request->confirmationSalary,
                'doj' => $request->doj,
                'status' => 'entered'];
            $candidateSalary->update($updateCandidateSalary);

            pacraCandidateForHiring::updateOrCreate([
                'userID' => $request->userID,
                'candidateID' => $request->candidateID,
                'jobID' => $request->jobID,

            ], [
                'decision' => 'Select For Final Interview',
            ]);

        } else {
            pacraAppointmentLetterModel::updateOrCreate(
                [
                    'userID' => $request->userID,
                    'jobID' => $request->jobID,
                    'candidateID' => $request->candidateID,
                ],
                [
                    'status' => 'approved',
                ]);

        }

        return redirect()->route('appointmentList');


    }


    public function appointmentList(Request $request)
    {
        $this->viewData['meta_title'] = 'Short Listed For Hiring';

        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->where('status', 'authenticate')
            ->get();


        $candidateLists = pacraScheduleInterview::select('candidate_for_interview.date', 'candidate_for_interview.time',
            'candidate_for_interview.interviewers', 'candidate_for_interview.userID', 'candidate_for_interview.interviewRound',
            'candidate_for_interview.jobID', 'candidate_for_interview.candidateID', 'applicant_profile.*',
            'applicant_profile.lname')
            ->leftjoin('jobportal.applicant_profile', 'applicant_profile.userID', 'candidate_for_interview.userID')
            ->where('jobportal.candidate_for_interview.interviewers', 10)
            ->get();

        $empCheck = UsersProfile::where('pemail', $candidateLists[0]->email ?? '')->count();

        $approvalCheck = CandidateSalary::where('userID', $candidateLists[0]->userID ?? '')->where('jobID', $candidateLists[0]->jobID ?? '')->where('status', 'approved')->count();

        return view('appointmentList', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('empCheck', $empCheck)
            ->with('approvalCheck', $approvalCheck)
            ->with('candidateLists', $candidateLists);

    }

    public function makeEmployee(Request $request)
    {
        $this->viewData['meta_title'] = 'Make Employee';
        $user_rights = helpers::get_user_rights(Auth::id());
        $applicantUserID = $request->userID;

        $all_users = UsersModel::where('is_active', '=', 1)
            ->get();
        $getProfileDetails = pacraApplicantProfileModel::where('userID', $request->userID)->first();
        $getDOJ = CandidateSalary::where('userID', $request->userID)->first();
        $getPersonalInfo = pacraApplicantInfoPersonalModel::where('userID', $request->userID)->first();
        $getEmgInfo = pacraApplicantEmergencyContactModel::where('userID', $request->userID)->first();
        $getExperienceInfo = pacraApplicantExperienceModel::where('userID', $request->userID)->latest()->first();

        $departments = DepartmentModel::where('isActive', '=', 1)
            ->get();
        $designations = DesignationsModel::where('isActive', '=', 1)
            ->get();
        $nationality = DB::table('pacra_nationality')->where('id', $getPersonalInfo->nationality)->get();
        $religions = DB::table('pacra_religion')->where('id', $getPersonalInfo->religion)->get();
        $genders = DB::table('pacra_gender')->where('id', $getPersonalInfo->gender)->get();
        $maritals = DB::table('pacra_marital_status')->where('id', $getPersonalInfo->maritalStatus)->get();
        $relatives = DB::table('pacra_emp_relatives')->get();
        $grades = DB::table('pacra_employee_grade')->get();
        $num = UsersModel::where('is_active', 1)->orderBy('id', 'desc')->latest('employee_id')->pluck('employee_id')->first();
        $num = substr($num, 0, 4);
        $num = substr($num, 1);
        $num = $num + 1;
        $year = Carbon::now()->format('y');
        $month = Carbon::now()->format('m');
        $empNum = 'P' . $num . '-' . $year . $month;

        return view('makeEmployee', $this->viewData)
            ->with('departments', $departments)
            ->with('designations', $designations)
            ->with('nationality', $nationality)
            ->with('empNum', $empNum)
            ->with('getDOJ', $getDOJ)
            ->with('getEmgInfo', $getEmgInfo)
            ->with('getPersonalInfo', $getPersonalInfo)
            ->with('religions', $religions)
            ->with('genders', $genders)
            ->with('maritals', $maritals)
            ->with('relatives', $relatives)
            ->with('user_rights', $user_rights)
            ->with('getExperienceInfo', $getExperienceInfo)
            ->with('grades', $grades)
            ->with('all_users', $all_users)
            ->with('getProfileDetails', $getProfileDetails)
            ->with('applicantUserID', $applicantUserID);


    }


    public function makeNewEmployee(Request $request)

    {

        //dd($request->all());
        $char = substr(str_shuffle("!@_#$%^&*"), 0, 1);
        $num = rand(500, 1000);
        $simplePassword = 'PACRA' . $char . $num;
        $password = Hash::make('PACRA' . $char . $num);
        $this->viewData['meta_title'] = 'Employee Details';
        $userId = helpers::get_orignal_id(Auth::id());


        $getProfileDetails = pacraApplicantProfileModel::find($request->applicantID);

        $getPersonalInfo = pacraApplicantInfoPersonalModel::where('applicant_info_personal.userID', $request->applicantID)
            ->select('applicant_info_personal.*', 'nationality.title as national', 'religion.title as ureligion',
                'gender.title as ugender', 'marital_status.title as marital')
            ->leftJoin('nationality', 'nationality.id', '=', 'applicant_info_personal.nationality')
            ->leftJoin('religion', 'religion.id', '=', 'applicant_info_personal.religion')
            ->leftJoin('gender', 'gender.id', '=', 'applicant_info_personal.gender')
            ->leftJoin('marital_status', 'marital_status.id', '=', 'applicant_info_personal.maritalStatus')
            ->get();


        $getEmergencyContacts = pacraApplicantEmergencyContactModel::where('applicant_emg_contact.userID', $request->applicantID)
            ->select('applicant_emg_contact.*', 'emp_relatives.name as relativeOne', 'secondRelative.name as relativeTwo')
            ->leftJoin('emp_relatives', 'emp_relatives.id', '=', 'applicant_emg_contact.relationshipOne')
            ->leftJoin('emp_relatives as secondRelative', 'secondRelative.id', '=', 'applicant_emg_contact.relationshipTwo')
            ->get();

        $getEducations = pacraApplicantEducationModel::where('userID', $request->applicantID)
            ->where('status', 1)
            ->get();

        $getExperience = pacraApplicantExperienceModel::where('userID', $request->applicantID)
            ->where('status', 1)
            ->get();
        // dd($getPersonalInfo->first()->cnic);


        DB::table('users')->insert(
            ['first_name' => $request->fname,
                'first_name' => $request->fname,
                'last_name' => $request->lname,
                'email' => $request->email,
                'avatar_location' => $getProfileDetails->image,
                'password' => $password,
                'active' => '1']
        );

        $newu_id = DB::table('users')->where('email', $request->email)->pluck('id');


        DB::table('model_has_roles')->insert(
            ['role_id' => '2',
                'model_type' => 'App\Models\Auth\User',
                'model_id' => $newu_id[0]
            ]
        );

        $signature = $request->file('signature');
        $signature = $signature->openFile()->fread($signature->getSize());


        UsersModel::create([
            'employee_id' => $request->emp_id,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->uname,
            'email' => $request->email,
            'pemail' => $getProfileDetails->email,
            'doj' => $request->doj,
            'confirmation_date' => $request->c_date,
            'fit_proper_date' => $request->fnp_date,
            'department' => $request->dpt,
            'sub_dpt' => $request->sub_dpt,
            'grade' => $request->grade,
            'cnic' => $getPersonalInfo->first()->cnic,
            'phone' => $getProfileDetails->contactNumber,
            'birthday' => $getProfileDetails->dob,
            'nationality' => $getPersonalInfo->first()->nationality,
            'religion' => $getPersonalInfo->first()->religion,
            'marital_status' => $getPersonalInfo->first()->maritalStatus,
            'address' => $getProfileDetails->address,
            'gender' => $getPersonalInfo->first()->gender,
            'display_name' => $request->fname . ' ' . $request->lname,
            'avatar_file' => $getProfileDetails->image,
            'cv' => $getProfileDetails->cv,
            'created_by_id' => $userId,
            'designation_id' => $request->desg,
            'team_id' => $request->dpt,
            'am_id' => $request->report_to,
            'is_active' => '1',
            'password' => $simplePassword,
            'newu_id' => $newu_id[0],
            'linkedin' => $getProfileDetails->linkedin,
            'profile_on_web' => $request->web_check,

            'status' => 'Entered']);

        $ogUsers_id = DB::table('og_users')->where('email', $request->email)->pluck('id');

        UsersProfile::create([
            'user_id' => $ogUsers_id[0],
            'emp_id' => $request->emp_id,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'uname' => $request->uname,
            'display_name' => $request->fname . ' ' . $request->lname,
            'email' => $request->email,
            'pemail' => $getProfileDetails->email,
            'doj' => $request->doj,
            'c_date' => $request->c_date,
            'fnp_date' => $request->fnp_date,
            'dpt' => $request->dpt,
            'sub_dpt' => $request->sub_dptl,
            'desg' => $request->desg,
            'grade' => $request->grade,
            'cnic' => $getPersonalInfo->first()->cnic,
            'phone' => $getProfileDetails->contactNumber,
            'dob' => $getProfileDetails->dob,
            'nationality' => $getPersonalInfo->first()->nationality,
            'religion' => $getPersonalInfo->first()->religion,
            'gender' => $getPersonalInfo->first()->gender,
            'marital' => $getPersonalInfo->first()->maritalStatus,
            'report_to' => $request->report_to,
            'linkedin' => $getProfileDetails->linkedin,
            'web_check' => $request->web_check,
            'address' => $getProfileDetails->address,
            'sign' => $signature,
            'status' => 'Entered',
            'reason' => 'New Joiner',
            'created_by_id' => $userId]);

        $hrLink = "<a href='hr.pacra.com'>HRMS</a>";
        $wizpacLink = "<a href='wizpac.pacra.com'>wizPAC</a>";


        Mail::send([], [], function ($message) use ($request, $simplePassword, $hrLink, $wizpacLink) {

            $message->to($request->email, $request->lname)->subject
            ('User Credentials')
                ->setBody('<h1>Hi ' . $request->lname . ' ! </h1>
                        <br>Welcome To PACRA</br>
                        <br>Following are your wizPAC/HRMS Credentials:</br>
                        <br><h3>Email:</h3>' . $request->email . '</br>
                        <br><h3>Password:</h3>' . $simplePassword . '</br>
                        <br>Please use these to log into wizPAC/HRMS.</br>
                        <br><h3>HRMS:</h3>' . $hrLink . '</br>
                        <br><h3>wizPAC:</h3>' . $wizpacLink . '</br>
                        <br>Thank you.<br>
                        <br>', 'text/html');
            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        });


        return redirect()->route('employees');

    }


    public function candidateProfile(Request $request)
    {
        $this->viewData['meta_title'] = 'Profile';

        $getProfileDetails = pacraApplicantProfileModel::where('userID', $request->id)->get();

        $getDesignation = pacraJobsCandidateModel::select('job_candidates.*', 'job_titles.title as jobTitle', 'og_designations.title as jobTitlesTable')
            ->where('userID', $request->id)
            ->leftJoin('hiring_request', 'hiring_request.id', 'job_candidates.jobID')
            ->leftJoin('job_titles', 'job_titles.id', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->get();

        $getDOJ = CandidateSalary::where('userID', $request->id)->get();
        $getPersonalInfo = pacraApplicantInfoPersonalModel::where('applicant_info_personal.userID', $request->id)
            ->select('applicant_info_personal.*', 'nationality.title as national', 'religion.title as ureligion',
                'gender.title as ugender', 'marital_status.title as marital')
            ->leftJoin('nationality', 'nationality.id', '=', 'applicant_info_personal.nationality')
            ->leftJoin('religion', 'religion.id', '=', 'applicant_info_personal.religion')
            ->leftJoin('gender', 'gender.id', '=', 'applicant_info_personal.gender')
            ->leftJoin('marital_status', 'marital_status.id', '=', 'applicant_info_personal.maritalStatus')
            ->get();


        $getEmergencyContacts = pacraApplicantEmergencyContactModel::where('applicant_emg_contact.userID', $request->id)
            ->select('applicant_emg_contact.*', 'emp_relatives.name as relativeOne', 'secondRelative.name as relativeTwo')
            ->leftJoin('emp_relatives', 'emp_relatives.id', '=', 'applicant_emg_contact.relationshipOne')
            ->leftJoin('emp_relatives as secondRelative', 'secondRelative.id', '=', 'applicant_emg_contact.relationshipTwo')
            ->get();


        $getEducations = pacraApplicantEducationModel::where('applicant_education.userID', $request->id)
            ->where('status', 1)
            ->leftJoin('institutes', 'applicant_education.institution', 'institutes.id')
            ->orderBy('completeDate', 'desc')
            ->get();

        $getOtherInstitute = pacraApplicantEducationModel::select('other')->whereNotNull('other')->where('applicant_education.userID', $request->id)->get();


//        $getExperience = pacraApplicantExperienceModel::where('userID', $request->id)
//            ->where('status', 1)
//            ->get();

        $getExperience = pacraApplicantExperienceModel::where('userID', $request->id)
            ->where('status', 1)
            ->orderBy('periodTo', 'DESC')
            ->get();


        $nationality = DB::table('pacra_nationality')->get();
        $religions = DB::table('pacra_religion')->get();
        $genders = DB::table('pacra_gender')->get();
        $maritals = DB::table('pacra_marital_status')->get();
        $relatives = DB::table('pacra_emp_relatives')->get();

        $getCandidateTest = pacraScheduleInterview::where('userID', $request->id)
            ->where('jobID', $request->jobID)
            ->where('scannedTest', '!=', null)
            ->get();

//        dd($getCandidateTest);

//        $getCandidateInterviewSheets = pacraScheduleInterview::where('userID', $request->id)
//            ->where('jobID', $request->jobID)
//            ->where('interviewSheet', '!=', null)
//            ->get();

        $getCandidateInterviewSheetsHR = pacraScheduleInterview::where('userID', $request->id)
            ->where('jobID', $request->jobID)
            ->where('interviewSheetHR', '!=', null)
            ->get();

        $getCandidateInterviewSheetsTL = pacraScheduleInterview::where('userID', $request->id)
            ->where('jobID', $request->jobID)
            ->where('interviewSheetTL', '!=', null)
            ->get();

        $getCandidateInterviewSheetsUH = pacraScheduleInterview::where('userID', $request->id)
            ->where('jobID', $request->jobID)
            ->where('interviewSheetUH', '!=', null)
            ->get();

        $getCandidateMiscellaneousDocs = pacraScheduleInterview::where('userID', $request->id)
            ->where('jobID', $request->jobID)
            ->where('miscellaneousDoc', '!=', null)
            ->get();

        $getEngagementData = pacraEngagementApprovalModel::where('userID', $request->id)
            ->where('jobID', $request->jobID)
            ->get();

        $getJobIDHiringRequest = hiringRequest::where('id', $request->jobID)->first();

        $getJobAd = jobTitles::select('job_titles.*', 'og_designations.title as jobTitle')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftJoin('jobportal.hiring_request', 'hiring_request.title', 'job_titles.id')
            ->where('jobportal.hiring_request.title', $getJobIDHiringRequest->title)
            ->first();

        $finalJobAd = hiringRequest::
        select('hiring_request.*', 'hiring_request.id as JobID', 'job_titles.title as jobTitle', 'og_designations.title as jobTitlesTable',
            'positions_nature.title as jobType', 'positions_nature.id')
            ->leftJoin('job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftjoin('positions_nature', 'positions_nature.id', 'hiring_request.hiringType')
            ->where('hiring_request.id', $request->jobID)
            ->get();

        //dd($request->jobID);
        $getJobApplyDate = pacraJobsCandidateModel::where('jobID', $request->jobID)
            ->where('userID', $request->id)
            ->first();

        $getSelectTest = pacraScheduleTest::where('jobID', $request->jobID)
            ->where('userID', $request->id)
            ->first();

        $getInterviewRounds = pacraScheduleInterview::where('jobID', $request->jobID)
            ->select('interviewRound', 'date', 'time', 'fname', 'lname')
            ->where('userID', $request->id)
            ->leftJoin('wizpac.og_users', 'wizpac.og_users.id', 'candidate_for_interview.interviewers')
            ->get();

        $getCandidateSalary = CandidateSalary::where('jobID', $request->jobID)
            ->where('userID', $request->id)
            ->first();

        $getAboutYourself = ApplicantAboutYourself::where('userID', $request->id)->get();

        $getEmpAllAppliedJobs = pacraJobsCandidateModel::select('job_candidates.*', 'job_titles.title as jobTitle', 'og_designations.title as jobTitlesTable')
            ->where('userID', $request->id)
            ->leftJoin('hiring_request', 'hiring_request.id', 'job_candidates.jobID')
            ->leftJoin('job_titles', 'job_titles.id', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->get();

        foreach ($getEmpAllAppliedJobs as $rejectionReasons) {
            $rejectionReasons->title = RejectionCommentsTable::select('rejection_reasons.title')->whereIn('id', explode(',', $rejectionReasons->rejection_comment))->get();
        }
        $spam = array('title', '"', ':', '{', '}', '[', ']', ';');

        $getPacraCheck = UsersModel::select('cnic')->where('is_active', 1)->get();
        $getPacraCheck = array("cnic" => $getPacraCheck);


        $getIfPacra = UsersModel::select('og_designations.title as designation', 'og_users.am_id as team', 'pacra_resignations.last_working_day', 'og_users.doj')
            ->leftjoin('og_designations', 'og_designations.id', 'og_users.designation_id')
            ->leftjoin('pacra_resignations', 'pacra_resignations.user_id', 'og_users.id')
            ->where('og_users.cnic', $getPersonalInfo[0]->cnic ?? '')
            ->get();


        return view('candidateProfile', $this->viewData)
            ->with('jobID', $request->jobID)
            ->with('userID', $request->id)
            ->with('getOtherInstitute', $getOtherInstitute)
            ->with('getProfileDetails', $getProfileDetails)
            ->with('getDOJ', $getDOJ)
            ->with('getDesignation', $getDesignation)
            ->with('nationality', $nationality)
            ->with('religions', $religions)
            ->with('genders', $genders)
            ->with('maritals', $maritals)
            ->with('relatives', $relatives)
            ->with('finalJobAd', $finalJobAd)
            ->with('getPersonalInfo', $getPersonalInfo)
            ->with('getEmergencyContacts', $getEmergencyContacts)
            ->with('getEducations', $getEducations)
            ->with('getExperience', $getExperience)
            ->with('getCandidateTest', $getCandidateTest)
            ->with('getCandidateInterviewSheetsHR', $getCandidateInterviewSheetsHR)
            ->with('getCandidateInterviewSheetsTL', $getCandidateInterviewSheetsTL)
            ->with('getCandidateInterviewSheetsUH', $getCandidateInterviewSheetsUH)
            ->with('getCandidateMiscellaneousDocs', $getCandidateMiscellaneousDocs)
            ->with('getEngagementData', $getEngagementData)
            ->with('getJobAd', $getJobAd)
            ->with('getJobApplyDate', $getJobApplyDate)
            ->with('getSelectTest', $getSelectTest)
            ->with('getInterviewRounds', $getInterviewRounds)
            ->with('getAboutYourself', $getAboutYourself)
            ->with('getEmpAllAppliedJobs', $getEmpAllAppliedJobs)
            ->with('getPacraCheck', $getPacraCheck)
            ->with('getIfPacra', $getIfPacra)
            ->with('spam', $spam)
            ->with('getCandidateSalary', $getCandidateSalary);


    }


    public function quiz(Request $request)
    {
        $this->viewData['meta_title'] = 'Quiz';
        $user_rights = helpers::get_user_rights(Auth::id());

        $activeQuizes = pacraQuizModel::where('isActive', 1)->get();

        return view('quiz', $this->viewData)
            ->with('activeQuizes', $activeQuizes)//->with('getProfileDetails', $getProfileDetails)
            ;

    }


    public function quizForm(Request $request)
    {
        $this->viewData['meta_title'] = 'Quiz';
        $user_rights = helpers::get_user_rights(Auth::id());

        //dd($request->id);

        if ($request->id == null) {
            return view('quizForm', $this->viewData)
                // ->with('getProfile', $getProfile)
                //->with('getProfileDetails', $getProfileDetails)
                ;
        } else {

            $quizData = pacraQuizModel::where('id', $request->id)->get();
            return view('quizForm', $this->viewData)
                ->with('quizData', $quizData)//->with('getProfileDetails', $getProfileDetails)
                ;
        }


    }

    public function addQuiz(Request $request)
    {
        $this->viewData['meta_title'] = 'Quiz';
        pacraQuizModel::updateOrCreate(
            [
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'id' => $request->quizID,


            ], [
            'title' => $request->title,
            'marks' => $request->marks,
            'time' => $request->time,
            'description' => $request->description,
            'status' => $request->submit,
            'isActive' => 1,
        ]);
        return redirect()->route('quiz');

    }


    public function questions(Request $request)
    {
        $this->viewData['meta_title'] = 'Quiz Questions';

        $activeQuizes = pacraQuizModel::where('isActive', 1)->get();

        return view('questions', $this->viewData)
            ->with('activeQuizes', $activeQuizes)//->with('getProfileDetails', $getProfileDetails)
            ;
    }


    public function questionsList(Request $request)
    {


        $this->viewData['meta_title'] = 'Quiz Questions';

        $activeQuestions = pacraQuestionsModel::where('isActive', 1)
            ->with('options')
            ->leftJoin('jobportal.question_answers', 'question_answers.questionID', 'quiz_questions.id')
            ->where('jobportal.quiz_questions.quizID', $request->id)
            ->get();
        //dd($activeQuestions);

        return view('questionsList', $this->viewData)
            ->with('activeQuestions', $activeQuestions)//->with('getProfileDetails', $getProfileDetails)
            ;
    }

    public function questionsForm(Request $request)
    {
        $this->viewData['meta_title'] = 'Quiz Questions';
        $quizID = $request->id;

        return view('questionForm', $this->viewData)
            ->with('quizID', $quizID)//->with('getProfileDetails', $getProfileDetails)
            ;
    }


    public function addQuestion(Request $request)
    {
        //dd($request->all());

        $question = pacraQuestionsModel::updateOrCreate(
            [
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'id' => $request->ID,


            ], [
            'quizID' => $request->quizID,
            'question' => $request->question,
            'isActive' => 1,
        ]);


        foreach ($request->options as $index => $key) {


            pacraQuestionOptionsModel::updateOrCreate(
                [
                    //Add unique field combo to match here
                    //For example, perhaps you only want one entry per user:
                    'id' => $request->ID,


                ], [
                'quizID' => $request->quizID,
                'questionID' => $question->id,
                'options' => $index,
                'optionsTitle' => $key,

            ]);

        }

        pacraQuestionAnswerModel::updateOrCreate(
            [
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'id' => $request->ID,


            ], [
            'quizID' => $request->quizID,
            'questionID' => $question->id,
            'correctAnswer' => $request->correctAnswer,

        ]);

        return redirect()->route('questions');
    }


    public function myInterViewList(Request $request)
    {
        $this->viewData['meta_title'] = 'My Interview List';
        $userId = helpers::get_orignal_id(Auth::id());


        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status',
            'job_titles.title as jobTitle'
            , 'og_designations.title as jobTitles')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', '=', 'hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->where('jobportal.hiring_request.status', 'authenticate')
            ->get();

        $candidateLists = pacraScheduleInterview::select('candidate_for_interview.date', 'candidate_for_interview.time',
            'candidate_for_interview.interviewers', 'candidate_for_interview.userID', 'candidate_for_interview.interviewRound',
            'candidate_for_interview.jobID', 'candidate_for_interview.candidateID',
            'jobportal.applicant_profile.fname',
            'jobportal.applicant_profile.lname',
            'og_users.fname as Fname',
            'og_users.lname as Lname',
            'candidate_for_interview.status', 'candidate_for_interview.id as interviewID')
            ->leftjoin('jobportal.applicant_profile', 'jobportal.applicant_profile.userID', 'candidate_for_interview.userID')
            ->leftjoin('wizpac.og_users', 'og_users.id', 'candidate_for_interview.interviewers')
            ->whereIn('interviewers', [$userId])
            ->Orwhere('date', '=', Carbon::now())
            ->Orwhere('date', '>', Carbon::now())
            ->where('candidate_for_interview.status', 'Entered')
            ->orderBy('candidate_for_interview.interviewRound', 'Desc')
            ->get();

        return view('myInterViewList', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('candidateLists', $candidateLists);
    }

    public function instituteList(Request $request)
    {
        $this->viewData['meta_title'] = 'Institutes';
        $Institute = Institute::orderBY('title', 'ASC')
            ->select('institutes.*', 'city.city')
            ->leftJoin('wizpac.city', 'city.id', 'institutes.city')
            ->get();

        // dd($Institute);
        return view('instituteList', $this->viewData)
            ->with('Institute', $Institute);
    }

    public function institutesForm(Request $request)
    {
        $this->viewData['meta_title'] = 'Add New Institute';
        $Cities = City::orderBY('city', 'ASC')
            ->get();

        // dd($Cities);
        return view('institutesForm', $this->viewData)
            ->with('Cities', $Cities);
    }

    public function addInstitute(Request $request)
    {
        //dd($request->all());
        $this->viewData['meta_title'] = 'Add New Institute';
        Institute::updateOrCreate(
            [
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'id' => $request->id,


            ], [
            'title' => $request->title,
            'city' => $request->city,
            //'province' => $request->province,
            'isActive' => 1
        ]);
        return redirect()->route('institutesForm');
    }


    public function search(Request $request)
    {

        return view('search1');
    }

    public function rejectedJobApplicants()
    {
        $this->viewData['meta_title'] = 'Rejected Applicants';

        $JobLists = hiringRequest::select('hiring_request.id as jobID', 'hiring_request.title', 'hiring_request.status', 'job_titles.title as jobTitle')
            ->leftJoin('job_titles', 'job_titles.id', '=', 'jobportal.hiring_request.title')
            ->where('status', 'authenticate')
            ->get();

        $jobAppliedLists = pacraJobsCandidateModel::select('applicant_profile.fname', 'applicant_profile.lname', 'rejection_reasons.title',
            'applicant_profile.cv', 'job_candidates.applyDate', 'job_candidates.candidateStatus',
            'hiring_request.id as hiringRequestID', 'job_candidates.jobID', 'hiring_request.requestBy',
            'hiring_request.title as jobTitle', 'og_designations.title as jobTitlesTable', 'job_candidates.rejection_comment',
            'applicant_profile.userID', 'job_candidates.id as candidateID', 'og_users.fname as pfname', 'og_users.lname as plname')
            ->leftJoin('jobportal.hiring_request', 'jobportal.hiring_request.id', 'job_candidates.jobID')
            ->leftJoin('jobportal.job_titles', 'job_titles.id', 'jobportal.hiring_request.title')
            ->leftjoin('wizpac.og_designations', 'wizpac.og_designations.id', 'job_titles.title')
            ->leftJoin('jobportal.applicant_profile', 'jobportal.applicant_profile.userID', 'job_candidates.userID')
            ->leftJoin('og_users', 'og_users.id', 'hiring_request.requestBy')
            ->leftJoin('jobportal.rejection_reasons', 'rejection_reasons.id', 'job_candidates.rejection_comment')
            ->where('jobportal.job_candidates.candidateStatus', 'Rejected')
            ->orderby('job_candidates.applyDate', 'desc')
            ->get();


//        foreach ($jobAppliedLists as $rejectionReasons) {
//            dd($rejectionReasons);
//            $rejectionReasons->title = RejectionCommentsTable::select('rejection_reasons.title')->whereIn('id', explode(',', $jobAppliedLists[0]->rejection_comment))->get();
//        }
        $spam = array('title', '"', ':', '{', '}', '[', ']', ';');
//        dd($jobAppliedLists);

        return view('rejectedApplicants', $this->viewData)
            ->with('JobLists', $JobLists)
            ->with('spam', $spam)
            ->with('jobAppliedLists', $jobAppliedLists);
    }

    public function changeStatus(Request $request)
    {
        $job = hiringRequest::find($request->id);
        $job->is_active = $request->is_active;
        $job->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function deleteJobDesc($id)
    {
        $rt = new jobTitles();
        $ids = $rt->find($id);
        $ids->delete();
        return back()->with('message', 'Job Description Deleted Successfully!');
    }

    public function deleteHiringRequest($id)
    {
        $rt = new hiringRequest();
        $ids = $rt->find($id);
        $ids->delete();
        return back()->with('message', 'Hiring Request Deleted Successfully!');
    }

    public function rejectAbsent($id)
    {
        $testCandidates = new pacraScheduleTest();
        $ids = $testCandidates->find($id);
        $ids->rejected = 1;
        $ids->save();
        return back()->with('message', 'Rejected Successfully!');
    }

//    public function candidateHistoryOnCnic()
//    {
//        $info = pacraApplicantInfoPersonalModel::all();
//        $ogUsers = UsersModel::pluck('cnic ')
//    }
}
