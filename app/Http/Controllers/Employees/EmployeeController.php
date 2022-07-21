<?php

namespace App\Http\Controllers\Employees;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Employees\DepartmentModel;
use App\Models\Employees\DesignationsModel;
use App\Models\Employees\PacraInterns;
use App\Models\Employees\UsersModel;
use App\Models\Employees\UsersProfile;
use App\Models\Leaves\pacraLeavesBalance;
use App\Models\Leaves\pacraNegativeLeavesBalance;
use App\Models\Resignation\Pacraresignations;
use App\Models\Resignation\PacraTerminations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;


class EmployeeController extends Controller
{
    public function getDeparment(Request $request)

    {
        $this->viewData['meta_title'] = 'Departments';
        $user_rights = helpers::get_user_rights(Auth::id());
        $userId = helpers::get_orignal_id(Auth::id());

        $getDepartments = DepartmentModel::where('isActive', '=', '1')
            ->orderBY('title')
            ->get();

        $employees = UsersModel::where('is_active', 1)->get();
        return view('departments', $this->viewData)
            ->with('getDepartments', $getDepartments)
            ->with('user_rights', $user_rights)
            ->with('userId', $userId)
            ->with('employees', $employees);

    }

    public function updateDeparment(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());

        // dd($request->all());

        DepartmentModel::where('id', '=', $request->dpt_id)
            ->update(['title' => $request->dpt_name, 'status' => $request->submit, 'last_updated_by' => $userId]);
        return redirect()->back()->with('message', 'Record Updated Successfully.');
    }


    public function createDeparment(Request $request)

    {
        $userId = helpers::get_orignal_id(Auth::id());
        DepartmentModel::create(['title' => $request->dpt_name, 'status' => 'Entered',
            'isActive' => 1, 'last_updated_by' => $userId]);
        return redirect()->back()->with('message', 'Record Updated Successfully.');
    }


    public function getDesignations(Request $request)
    {
        $user_rights = helpers::get_user_rights(Auth::id());
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Designation';
        $getDesignation = DesignationsModel::where('isActive', '=', '1')
            ->orderBY('title')
            ->get();
        // dd($userId);
        $employees = UsersModel::where('is_active', 1)->get();
        return view('designations', $this->viewData)
            ->with('getDesignation', $getDesignation)
            ->with('user_rights', $user_rights)
            ->with('userId', $userId)
            ->with('employees', $employees);


    }

    public function updateDesignations(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());

        // dd($request->all());

        DesignationsModel::where('id', '=', $request->desg_id)
            ->update(['title' => $request->desg_name, 'status' => $request->submit, 'last_updated_by' => $userId]);
        return redirect()->back()->with('message', 'Record Updated Successfully.');
    }

    public function createDesignations(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        DesignationsModel::create(['title' => $request->desg_name, 'status' => 'Entered',
            'isActive' => 1, 'last_updated_by' => $userId]);
        return redirect()->back()->with('message', 'Record Edit Successfully.');
    }

    public function getEmployees(Request $request)
    {
        $this->viewData['meta_title'] = 'Personnel ';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());

        $all_users = UsersModel::where('is_active', '=', 1)
            ->where('og_users.status', '=', 'Approved')
            ->select('og_users.*', 'og_designations.title as desig')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'designation_id')
            ->whereNotIn('og_users.id', ['48', '243', '297', '298'])
            ->orderBY('og_users.display_name')
            ->get();

        $all_users2 = UsersModel::where('is_active', '=', 1)
            ->where('og_users.status', '=', 'Approved')
            ->select('og_users.*', 'og_designations.title as desig')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'designation_id')
            ->whereNotIn('og_users.id', ['48', '243', '297', '298'])
            ->orderBY('og_users.display_name')
            ->get();

        $allDesignations = DesignationsModel::where('isActive', 1)
            ->orderBy('title')
            ->get();
        $allDepartments = DepartmentModel::where('isActive', 1)
            ->orderBy('title')
            ->get();
        $allGrades = DB::table('pacra_employee_grade')
            ->select('id', 'name', 'description')
            ->get();

        return view('employees', $this->viewData)
            ->with('all_users', $all_users)
            ->with('all_users2', $all_users2)
            ->with('allDesignations', $allDesignations)
            ->with('allDepartments', $allDepartments)
            ->with('user_rights', $user_rights)
            ->with('allGrades', $allGrades);
    }


    public function getLeavers(Request $request)
    {
        $this->viewData['meta_title'] = 'Leavers';
        $userId = helpers::get_orignal_id(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());

        $all_users = UsersModel::where('is_active', '=', 0)
            ->where('og_users.status', '=', 'Approved')
            ->select('og_users.*', 'og_designations.title as desig')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'designation_id')
            ->get();

        $allDesignations = DesignationsModel::where('isActive', 1)->get();
        $allDepartments = DepartmentModel::where('isActive', 1)->get();
        $allGrades = DB::table('pacra_employee_grade')
            ->select('id', 'name', 'description')
            ->get();

        return view('employees', $this->viewData)
            ->with('all_users', $all_users)
            ->with('allDesignations', $allDesignations)
            ->with('allDepartments', $allDepartments)
            ->with('allGrades', $allGrades)
            ->with('user_rights', $user_rights);
    }


    public function getEmployeesApproval(Request $request)
    {
        $this->viewData['meta_title'] = 'Employee Approval';
        $user_rights = helpers::get_user_rights(Auth::id());

        /* $all_users = UsersModel::where('is_active', '=', 1)
             ->where('og_users.status', '=', 'Entered')
             ->select('og_users.*','og_designations.title as desig')
             ->leftjoin('og_designations', 'og_designations.id', '=', 'designation_id' )
             ->get();*/
        $allDesignations = DesignationsModel::where('isActive', 1)->get();
        $allDepartments = DepartmentModel::where('isActive', 1)->get();
        $allGrades = DB::table('pacra_employee_grade')
            ->select('id', 'name', 'description')
            ->get();

        $all_users = UsersProfile:://where('is_active', '=', 1)
        where('pacra_users_profile.status', '=', 'Entered')
            ->select('pacra_users_profile.*', 'og_designations.title as desig')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'pacra_users_profile.desg')
            ->get();
        return view('approvalEmployees', $this->viewData)
            ->with('all_users', $all_users)
            ->with('allDesignations', $allDesignations)
            ->with('allDepartments', $allDepartments)
            ->with('allGrades', $allGrades);
    }


    public function addEmployees(Request $request)
    {


        $this->viewData['meta_title'] = 'Add Employee';
        $user_rights = helpers::get_user_rights(Auth::id());

        $all_users = UsersModel::where('is_active', '=', 1)
            ->get();
        $gender = DB::table('users')->get();


        $departments = DepartmentModel::where('isActive', '=', 1)
            ->get();
        $designations = DesignationsModel::where('isActive', '=', 1)
            ->get();
        $nationality = DB::table('pacra_nationality')->get();
        $religions = DB::table('pacra_religion')->get();
        $genders = DB::table('pacra_gender')->get();
        $maritals = DB::table('pacra_marital_status')->get();
        $relatives = DB::table('pacra_emp_relatives')->get();
        $grades = DB::table('pacra_employee_grade')->get();

        return view('add_employee', $this->viewData)
            ->with('departments', $departments)
            ->with('designations', $designations)
            ->with('nationality', $nationality)
            ->with('religions', $religions)
            ->with('genders', $genders)
            ->with('maritals', $maritals)
            ->with('relatives', $relatives)
            ->with('user_rights', $user_rights)
            ->with('grades', $grades)
            ->with('all_users', $all_users);

    }


    public function addNewEmployees(Request $request)

    {

//        dd($request->all());
        $char = substr(str_shuffle("!@_#$%^&*"), 0, 1);
        $num = rand(500, 1000);
        $simplePassword = 'PACRA' . $char . $num;
        $password = Hash::make('PACRA' . $char . $num);

        $this->viewData['meta_title'] = 'Employee Details';
        $userId = helpers::get_orignal_id(Auth::id());


        if ($request->hasFile('file')) {
            // Get filename with extension

            $filenameWithExt = $request->file('file')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('file')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload File
            $file_path = $request->file('file')->storeAs('cv/', $fileNameToStore);

            //dd($file_path);

        }


        if ($request->hasFile('image')) {

            // Get filename with extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $filename = $request->file('image')->getClientOriginalName();
            $imageObj = $request->file('image');
            $process_Image = Image::make($imageObj);
            $process_Image->resize(300, 300);
            $process_Image->greyscale();
            $process_Image->save('users/' . $fileNameToStore);
            $image_path = $process_Image->filename . '.' . $process_Image->extension;
        }

        DB::table('users')->updateOrInsert([
            'email' => $request->email,
        ],
            ['first_name' => $request->fname,
                'last_name' => $request->lname,
                'email' => $request->email,
                'avatar_location' => $image_path,
                'password' => $password,
                'active' => '1']
        );

        $newu_id = DB::table('users')->where('email', $request->email)->pluck('id');


        DB::table('model_has_roles')->updateOrInsert([
            'model_id' => $newu_id[0]
        ],
            ['role_id' => '2',
                'model_type' => 'App\Models\Auth\User',
                'model_id' => $newu_id[0]
            ]
        );

        $signature = $request->file('signature');
        $signature = $signature->openFile()->fread($signature->getSize());

        UsersModel::updateOrCreate([
            'email' => $request->email,
        ],
            [
                'employee_id' => $request->emp_id,
                'fname' => $request->fname,
                'lname' => $request->lname,
                'username' => $request->uname,
                'email' => $request->email,
                'pemail' => $request->pemail,
                'doj' => $request->doj,
                'confirmation_date' => $request->c_date,
                'fit_proper_date' => $request->fnp_date,
                'department' => $request->dpt,
                'sub_dpt' => $request->sub_dpt,
                'grade' => $request->grade,
                'cnic' => $request->cnic,
                'phone' => $request->phone,
                'emergency_contact' => $request->emg_phone,
                'emg_name' => $request->emg_name,
                'emg_relation' => $request->emg_relation,
                'birthday' => $request->dob,
                'nationality' => $request->nationality,
                'religion' => $request->religion,
                'marital_status' => $request->marital,
                'address' => $request->address,
                'gender' => $request->gender,
                'display_name' => $request->fname . ' ' . $request->lname,
                'avatar_file' => $image_path,
                'cv' => $file_path,
                'created_by_id' => $userId,
                'designation_id' => $request->desg,
                'team_id' => $request->dpt,
                'am_id' => $request->report_to,
                'is_active' => '1',
                'password' => $simplePassword,
                'newu_id' => $newu_id[0],
                'linkedin' => $request->linkedin,
                'profile_on_web' => $request->web_check,
                'last_qualification' => $request->last_qualification,
                'exp_outside_pacra' => $request->exp_outside_pacra,
                'exp_in_pacra' => $request->exp_in_pacra,
                'last_employer' => $request->last_employer,
                'display_name2' => $request->fname,
                'status' => 'Entered']);

        $ogUsers_id = DB::table('og_users')->where('email', $request->email)->pluck('id');

        UsersProfile::updateOrCreate([
            'email' => $request->email,
        ],
            [
                'user_id' => $ogUsers_id[0],
                'emp_id' => $request->emp_id,
                'fname' => $request->fname,
                'lname' => $request->lname,
                'uname' => $request->uname,
                'display_name' => $request->fname . ' ' . $request->lname,
                'email' => $request->email,
                'pemail' => $request->pemail,
                'doj' => $request->doj,
                'c_date' => $request->c_date,
                'fnp_date' => $request->fnp_date,
                'dpt' => $request->dpt,
                'sub_dpt' => $request->sub_dpt,
                'desg' => $request->desg,
                'grade' => $request->grade,
                'cnic' => $request->cnic,
                'phone' => $request->phone,
                'emp_phone' => $request->emg_phone,
                'emp_relation' => $request->emg_relation,
                'emp_name' => $request->emg_name,
                'dob' => $request->dob,
                'nationality' => $request->nationality,
                'religion' => $request->religion,
                'gender' => $request->gender,
                'marital' => $request->marital,
                'report_to' => $request->report_to,
                'linkedin' => $request->linkedin,
                'web_check' => $request->web_check,
                'last_qualification' => $request->last_qualification,
                'exp_outside_pacra' => $request->exp_outside_pacra,
                'exp_in_pacra' => $request->exp_in_pacra,
                'last_employer' => $request->last_employer,
                'address' => $request->address,
                'avatar_file' => $image_path,
                'cv' => $file_path,
                'sign' => $signature,
                'status' => 'Entered',
                'reason' => 'New Joiner',
                'created_by_id' => $userId]);

        pacraLeavesBalance::updateOrCreate([
            'user_id' => $ogUsers_id[0],
        ], [
            'user_id' => $ogUsers_id[0],
            'current_balance' => 0,
            'last_updated_by' => $userId,

        ]);

        DB::table('sign')->updateOrInsert([
            'u_id' => $ogUsers_id[0]
        ], [
            'name' => $request->fname . $request->lname,
            'designation' => $request->grade,
            'sign' => $signature,
            'u_id' => $ogUsers_id[0]
        ]);

        if ($request->desg == 29) {
            if ($request->internship_tenure == '2 Weeks') {
                $stipendAmount = $request->stipend;
                $lastDate = Carbon::now()->addWeeks(2)->format('Y-m-d');
            } elseif ($request->internship_tenure == '1 Month') {
                $stipendAmount = 15000;
                $lastDate = Carbon::now()->addMonth()->format('Y-m-d');
            } elseif ($request->internship_tenure == '2 Month') {
                $stipendAmount = 30000;
                $lastDate = Carbon::now()->addMonths(2)->format('Y-m-d');
            } elseif ($request->internship_tenure == '3 Month') {
                $stipendAmount = 45000;
                $lastDate = Carbon::now()->addMonths(3)->format('Y-m-d');
            }
            PacraInterns::updateOrCreate([
                'user_id' => $ogUsers_id[0],
            ], [
                'user_id' => $ogUsers_id[0],
                'tenure' => $request->internship_tenure,
                'stipend' => $stipendAmount,
                'last_date' => $lastDate,
                'expected_grad_date' => $request->grad_date,
                'action' => 'Initial',
                'is_active' => 1,
            ]);
        }


        Mail::send([], [], function ($message) use ($request, $simplePassword) {

            $message->to($request->email, $request->lname)->subject
            ('User Credentials')
                ->setBody('<h1>Hi, welcome ' . $request->lname . ' ! </h1>
                        <br>Welcome To PACRA<br> Here is your WizPac Credentials<br>
                        <h3>Email:</h3>' . $request->email . '<br> <h3>Password:</h3>' . $simplePassword . '<br> <br>', 'text/html');
            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
        });


        /*$userDetails = UsersModel::Where('email', '=', $request->email )->get();*/
        return redirect()->route('employees');


        // dd($request->all());


    }


    public function profile($id)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $userDetails = UsersModel::select('og_users.id as ID',
            'og_users.employee_id',
            'og_users.fname',
            'og_users.lname',
            'og_users.username as uname',
            'og_users.email',
            'og_users.pemail',
            'og_users.doj',
            'og_users.department',
            'og_users.phone',
            'og_users.birthday',
            'og_users.address',
            'og_users.gender',
            'og_users.display_name',
            'og_users.avatar_file',
            'og_users.designation_id',
            'og_users.team_id',
            'og_users.sub_dpt as function',
            'og_users.am_id',
            'og_users.linkedin',
            'og_users.profile_on_web',
            'og_users.cv',
            'og_users.cnic',
            'og_users.emergency_contact',
            'og_users.emg_name',
            'og_users.emg_relation',
            'pacra_emp_relatives.name as relationTitle',
            'og_users.nationality',
            'og_users.religion',
            'og_users.marital_status',
            'og_users.confirmation_date',
            'og_users.last_qualification',
            'og_users.exp_outside_pacra',
            'og_users.exp_in_pacra',
            'og_users.last_employer',
            'og_users.fit_proper_date as fnp_date',
            'teams.title as team',
            'function.title as functionTitle',
            'desig.title as designation',
            'genders.title as genderTitle',
            'manager.display_name  as managerName',
            'manager.avatar_file as managerpic',
            'pacranational.title as national',
            'pacra_religion.title as religions',
            'pacra_marital_status.title as marital',
            'og_users.grade',
            'pacra_employee_grade.name as gradeTitle',
            'pacra_interns.*'

        )
            ->leftJoin('pacra_teams as teams', 'teams.id', '=', 'og_users.team_id')
            ->leftJoin('pacra_teams as function', 'function.id', '=', 'og_users.sub_dpt')
            ->leftJoin('og_designations as desig', 'desig.id', '=', 'og_users.designation_id')
            ->leftJoin('pacra_gender as genders', 'genders.id', '=', 'og_users.gender')
            ->leftJoin('og_users as manager', 'manager.id', '=', 'og_users.am_id')
            ->leftJoin('pacra_nationality as pacranational', 'pacranational.id', '=', 'og_users.nationality')
            ->leftJoin('pacra_religion', 'pacra_religion.id', '=', 'og_users.religion')
            ->leftJoin('pacra_employee_grade', 'pacra_employee_grade.id', '=', 'og_users.grade')
            ->leftJoin('pacra_marital_status', 'pacra_marital_status.id', '=', 'og_users.marital_status')
            ->leftJoin('pacra_emp_relatives', 'pacra_emp_relatives.id', '=', 'og_users.emg_relation')
            ->leftJoin('pacra_interns', 'pacra_interns.user_id', '=', 'og_users.id')
            ->Where('og_users.id', '=', $id)
            ->get();

        $terminationCheck = Pacraresignations::where('user_id', $userDetails[0]->ID)->whereNotNull('terminated')->count();
        $EndInternshipCheck = PacraInterns::where('user_id', $userDetails[0]->ID)->whereNotNull('end_date')->count();
        $ExtendInternshipCheck = PacraInterns::where('user_id', $userDetails[0]->ID)->whereNotNull('extension_date')->count();

        $this->viewData['meta_title'] = $userDetails[0]->display_name;

        $all_users = UsersModel::where('is_active', '=', 1)
            ->get();
        $gender = DB::table('users')->get();

        $grades = DB::table('pacra_employee_grade')->get();
        $relatives = DB::table('pacra_emp_relatives')->get();
        $departments = DepartmentModel::where('isActive', '=', 1)
            ->get();
        $designations = DesignationsModel::where('isActive', '=', 1)
            ->get();
        $nationality = DB::table('pacra_nationality')->get();
        $religions = DB::table('pacra_religion')->get();
        $genders = DB::table('pacra_gender')->get();
        $maritals = DB::table('pacra_marital_status')->get();

        $get_cleaves_bal = pacraLeavesBalance::where('user_id', '=', $id)
            ->get();
        $getnLeaves_bal = pacraNegativeLeavesBalance::where('user_id', '=', $id)
            ->get();
        $user_rights = helpers::get_user_rights(Auth::id());

        $date1 = $userDetails->first()->doj;
        $date2 = date("H:i:s ");
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $experienceInPacra = $years . '.' . $months;


        return view('profile', $this->viewData)
            ->with('userDetails', $userDetails)
            ->with('departments', $departments)
            ->with('designations', $designations)
            ->with('nationality', $nationality)
            ->with('religions', $religions)
            ->with('genders', $genders)
            ->with('maritals', $maritals)
            ->with('all_users', $all_users)
            ->with('get_cleaves_bal', $get_cleaves_bal)
            ->with('getnLeaves_bal', $getnLeaves_bal)
            ->with('grades', $grades)
            ->with('relatives', $relatives)
            ->with('user_rights', $user_rights)
            ->with('experienceInPacra', $experienceInPacra)
            ->with('terminationCheck', $terminationCheck)
            ->with('ExtendInternshipCheck', $ExtendInternshipCheck)
            ->with('EndInternshipCheck', $EndInternshipCheck)
            ->with('userId', $userId);


    }


    public function approvalProfile($id)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $userDetails = UsersProfile::select('pacra_users_profile.id as ID',
            'pacra_users_profile.user_id as user_id',
            'pacra_users_profile.fname',
            'pacra_users_profile.lname',
            'pacra_users_profile.uname',
            'pacra_users_profile.display_name',
            'pacra_users_profile.email',
            'pacra_users_profile.pemail',
            'pacra_users_profile.emp_id as employee_id',
            'pacra_users_profile.doj',
            'pacra_users_profile.c_date',
            'pacra_users_profile.fnp_date',
            'pacra_users_profile.dpt',
            'pacra_users_profile.sub_dpt as function',
            'pacra_users_profile.desg as designation_id',
            'pacra_users_profile.grade',
            'pacra_users_profile.cnic',
            'pacra_users_profile.phone',
            'pacra_users_profile.emp_phone as emergency_contact',
            'pacra_users_profile.emp_relation as emg_relation',
            'pacra_users_profile.emp_name as emg_name',
            'pacra_users_profile.dob as birthday',
            'pacranational.title as national',
            'pacranational.id as nationality',
            'pacra_religion.title as religions',
            'pacra_religion.id as religion',
            'genders.title as genderTitle',
            'genders.id as gender',
            'pacra_marital_status.title as marital',
            'pacra_marital_status.id as marital_status',
            'pacra_users_profile.report_to as am_id',
            'pacra_users_profile.linkedin',
            'pacra_users_profile.web_check',
            'pacra_users_profile.last_qualification',
            'pacra_users_profile.exp_outside_pacra',
            'pacra_users_profile.exp_in_pacra',
            'pacra_users_profile.last_employer',
            'pacra_users_profile.address',
            'pacra_users_profile.status',
            'pacra_users_profile.reason',
            'pacra_users_profile.cv',
            'pacra_users_profile.avatar_file',
            'teams.title as team',
            'teams.id as team_id',
            'function.title as functionTitle',
            'function.id as function',
            'desig.title as designation',
            'manager.avatar_file as managerpic',
            'manager.display_name as managerName',
            'pacra_employee_grade.name as gradeTitle',
            'pacra_emp_relatives.name as relationTitle',
            'pacra_interns.*'

        )
            ->leftJoin('pacra_teams as teams', 'teams.id', '=', 'pacra_users_profile.dpt')
            ->leftJoin('pacra_teams as function', 'function.id', '=', 'pacra_users_profile.sub_dpt')
            ->leftJoin('og_designations as desig', 'desig.id', '=', 'pacra_users_profile.desg')
            ->leftJoin('pacra_gender as genders', 'genders.id', '=', 'pacra_users_profile.gender')
            ->leftJoin('og_users as manager', 'manager.id', '=', 'pacra_users_profile.report_to')
            ->leftJoin('pacra_nationality as pacranational', 'pacranational.id', '=', 'pacra_users_profile.nationality')
            ->leftJoin('pacra_religion', 'pacra_religion.id', '=', 'pacra_users_profile.religion')
            ->leftJoin('pacra_marital_status', 'pacra_marital_status.id', '=', 'pacra_users_profile.marital')
            ->leftJoin('pacra_employee_grade', 'pacra_employee_grade.id', '=', 'pacra_users_profile.grade')
            ->leftJoin('pacra_emp_relatives', 'pacra_emp_relatives.id', '=', 'pacra_users_profile.emp_relation')
            ->leftJoin('pacra_interns', 'pacra_interns.user_id', '=', 'pacra_users_profile.id')
            ->Where('pacra_users_profile.id', '=', $id)
            ->get();

        //dd($userDetails);
        $this->viewData['meta_title'] = $userDetails[0]->display_name;

        $all_users = UsersModel::where('is_active', '=', 1)
            ->get();
        $gender = DB::table('users')->get();
        $grades = DB::table('pacra_employee_grade')->get();
        $relatives = DB::table('pacra_emp_relatives')->get();

        $departments = DepartmentModel::where('isActive', '=', 1)
            ->get();
        $designations = DesignationsModel::where('isActive', '=', 1)
            ->get();
        $nationality = DB::table('pacra_nationality')->get();
        $religions = DB::table('pacra_religion')->get();
        $genders = DB::table('pacra_gender')->get();
        $maritals = DB::table('pacra_marital_status')->get();

        $get_cleaves_bal = pacraLeavesBalance::where('user_id', '=', $id)
            ->get();
        $getnLeaves_bal = pacraNegativeLeavesBalance::where('user_id', '=', $id)
            ->get();
        $user_rights = helpers::get_user_rights(Auth::id());

        $date1 = $userDetails->first()->doj;
        $date2 = date("H:i:s ");
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $experienceInPacra = $years . '.' . $months;

        return view('profile', $this->viewData)
            ->with('userDetails', $userDetails)
            ->with('departments', $departments)
            ->with('designations', $designations)
            ->with('nationality', $nationality)
            ->with('religions', $religions)
            ->with('genders', $genders)
            ->with('maritals', $maritals)
            ->with('all_users', $all_users)
            ->with('get_cleaves_bal', $get_cleaves_bal)
            ->with('getnLeaves_bal', $getnLeaves_bal)
            ->with('grades', $grades)
            ->with('relatives', $relatives)
            ->with('user_rights', $user_rights)
            ->with('experienceInPacra', $experienceInPacra)
            ->with('userId', $userId);


    }


    public function updateEmployees(Request $request)
    {
        $userId = helpers::get_orignal_id(Auth::id());
        $this->viewData['meta_title'] = 'Edit Employee';

        if ($request->hasFile('file')) {
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $file_path = $request->file('file')->storeAs('cv/', $fileNameToStore);
        } else {
            $file_path = $request->old_cv;
        }

        // dd($file_path);


        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $filename = $request->file('image')->getClientOriginalName();
            $imageObj = $request->file('image');
            $process_Image = Image::make($imageObj);
            $process_Image->resize(300, 300);
            $process_Image->greyscale();
            $process_Image->save('users/' . $fileNameToStore);
            $image_path = $process_Image->filename . '.' . $process_Image->extension;
        } else {
            $image_path = $request->old_image;
        }


        if ($request->submit == 'submit') {
            UsersProfile::updateOrCreate([
                'id' => $request->recordID,
            ],
                [
                    'emp_id' => $request->emp_id,
                    'user_id' => $request->user_id,
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'uname' => $request->uname,
                    'display_name' => $request->fname . ' ' . $request->lname,
                    'email' => $request->email,
                    'pemail' => $request->pemail,
                    'doj' => $request->doj,
                    'c_date' => $request->c_date,
                    'fnp_date' => $request->fnp_date,
                    'dpt' => $request->dpt,
                    'sub_dpt' => $request->sub_dpt,
                    'desg' => $request->desg,
                    'grade' => $request->grade,
                    'cnic' => $request->cnic,
                    'phone' => $request->phone,
                    'emp_phone' => $request->emg_phone,
                    'emp_relation' => $request->emg_relation,
                    'emp_name' => $request->emg_name,
                    'dob' => $request->dob,
                    'nationality' => $request->nationality,
                    'religion' => $request->religion,
                    'gender' => $request->gender,
                    'marital' => $request->marital,
                    'report_to' => $request->report_to,
                    'linkedin' => $request->linkedin,
                    'web_check' => $request->web_check,
                    'last_qualification' => $request->last_qualification,
                    'exp_outside_pacra' => $request->exp_outside_pacra,
                    'exp_in_pacra' => $request->exp_in_pacra,
                    'last_employer' => $request->last_employer,
                    'address' => $request->address,
                    'avatar_file' => $image_path,
                    'cv' => $file_path,
                    'status' => 'Entered',
                    'reason' => 'New Joiner',
                    'created_by_id' => $userId]);


            $leaveBalance = pacraLeavesBalance::where('user_id', '=', $request->user_id)
                ->get();

            if (empty($leaveBalance[0])) {

                pacraLeavesBalance::create(['user_id' => $request->user_id, 'current_balance' => $request->c_leaves,
                    'last_updated_by' => $userId]);

                if ($request->n_leaves != '') {
                    pacraNegativeLeavesBalance::create(['user_id' => $request->user_id, 'negative_balance' => $request->n_leaves]);
                }
            } else {
                pacraLeavesBalance::where('user_id', '=', $request->og_users_id)
                    ->update(['current_balance' => $request->c_leaves, 'last_updated_by' => $userId]);
                if ($request->n_leaves != '') {
                    pacraNegativeLeavesBalance::where('user_id', '=', $request->og_users_id)
                        ->update(['negative_balance' => $request->n_leaves]);
                }
            }

        } else {
            UsersProfile::updateOrCreate([
                'id' => $request->recordID,
            ],
                [
                    'emp_id' => $request->emp_id,
                    'user_id' => $request->user_id,
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'uname' => $request->uname,
                    'display_name' => $request->fname . ' ' . $request->lname,
                    'email' => $request->email,
                    'pemail' => $request->pemail,
                    'doj' => $request->doj,
                    'c_date' => $request->c_date,
                    'fnp_date' => $request->fnp_date,
                    'dpt' => $request->dpt,
                    'sub_dpt' => $request->sub_dpt,
                    'desg' => $request->desg,
                    'grade' => $request->grade,
                    'cnic' => $request->cnic,
                    'phone' => $request->phone,
                    'emp_phone' => $request->emg_phone,
                    'emp_relation' => $request->emg_relation,
                    'emp_name' => $request->emg_name,
                    'dob' => $request->dob,
                    'nationality' => $request->nationality,
                    'religion' => $request->religion,
                    'gender' => $request->gender,
                    'marital' => $request->marital,
                    'report_to' => $request->report_to,
                    'linkedin' => $request->linkedin,
                    'web_check' => $request->web_check,
                    'last_qualification' => $request->last_qualification,
                    'exp_outside_pacra' => $request->exp_outside_pacra,
                    'exp_in_pacra' => $request->exp_in_pacra,
                    'last_employer' => $request->last_employer,
                    'address' => $request->address,
                    'avatar_file' => $image_path,
                    'cv' => $file_path,
                    'status' => 'Approved',
                    'reason' => 'New Joiner',
                    'created_by_id' => $userId]);

            $profileId = DB::table('pacra_users_profile')->where('id', $request->recordID)->get();

            UsersModel::updateOrCreate(
                [
                    'id' => $profileId[0]->user_id,
                ],
                ['employee_id' => $request->emp_id,
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'username' => $request->uname,
                    'grade' => $request->grade,
                    'email' => $request->email,
                    'pemail' => $request->pemail,
                    'doj' => $request->doj,
                    'confirmation_date' => $request->c_date,
                    'department' => $request->dpt,
                    'cnic' => $request->cnic,
                    'phone' => $request->phone,
                    'emergency_contact' => $request->emg_phone,
                    'emg_name' => $request->emg_name,
                    'emg_relation' => $request->emg_relation,
                    'birthday' => $request->dob,
                    'nationality' => $request->nationality,
                    'religion' => $request->religion,
                    'marital_status' => $request->marital,
                    'last_qualification' => $request->last_qualification,
                    'exp_outside_pacra' => $request->exp_outside_pacra,
                    'exp_in_pacra' => $request->exp_in_pacra,
                    'last_employer' => $request->last_employer,
                    'address' => $request->address,
                    'gender' => $request->gender,
                    'display_name' => $request->fname . ' ' . $request->lname,
                    'avatar_file' => $image_path,
                    'cv' => $file_path,
                    'created_by_id' => $userId,
                    'designation_id' => $request->desg,
                    'team_id' => $request->dpt,
                    'sub_dpt' => $request->sub_dpt,
                    'am_id' => $request->report_to,
                    'is_active' => '1',
                    'updated_by_id' => $userId,
                    'linkedin' => $request->linkedin,
                    'profile_on_web' => $request->web_check,
                    'fit_proper_date' => $request->fnp_date,
                    'status' => 'Approved'
                ]);


            pacraLeavesBalance::where('user_id', '=', $request->og_users_id)
                ->update(['current_balance' => $request->c_leaves, 'last_updated_by' => $userId]);
            if ($request->n_leaves != '') {
                pacraNegativeLeavesBalance::where('user_id', '=', $request->og_users_id)
                    ->update(['negative_balance' => $request->n_leaves]);
            }
            if ($request->desg == 29) {

                if ($request->internship_tenure == '2 Weeks') {
                    $stipendAmount = $request->stipend;
                    $lastDate = Carbon::now()->addWeeks(2)->format('Y-m-d');
                } elseif ($request->internship_tenure == '1 Month') {
                    $stipendAmount = 15000;
                    $lastDate = Carbon::now()->addMonth()->format('Y-m-d');
                } elseif ($request->internship_tenure == '2 Month') {
                    $stipendAmount = 30000;
                    $lastDate = Carbon::now()->addMonths(2)->format('Y-m-d');
                } elseif ($request->internship_tenure == '3 Month') {
                    $stipendAmount = 45000;
                    $lastDate = Carbon::now()->addMonths(3)->format('Y-m-d');
                }
                PacraInterns::updateOrCreate([
                    'user_id' => $profileId[0]->user_id,
                ], [
                    'user_id' => $profileId[0]->user_id,
                    'tenure' => $request->internship_tenure,
                    'stipend' => $stipendAmount,
                    'last_date' => $lastDate,
                    'expected_grad_date' => $request->grad_date,
                    'action' => 'Initial',
                    'is_active' => 1,
                ]);
            }
        }
        return redirect()->route('employees');
    }


    public function policies(Request $request)
    {
        $this->viewData['meta_title'] = 'Policies';
        $user_rights = helpers::get_user_rights(Auth::id());
        return view('policies', $this->viewData)
            ->with('user_rights', $user_rights);
    }


    public function policyForm(Request $request)
    {
        $this->viewData['meta_title'] = 'Policies';
        $user_rights = helpers::get_user_rights(Auth::id());

        return view('add_policy', $this->viewData)
            ->with('user_rights', $user_rights);
    }


    public function addPolicy(Request $request)
    {
        $this->viewData['meta_title'] = 'Policies';
        $user_rights = helpers::get_user_rights(Auth::id());
        if ($request->hasFile('file')) {
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $file_path = $request->file('file')->storeAs('cv/', $fileNameToStore);
        } else {
            $file_path = $request->old_cv;
        }


        return view('add_policy', $this->viewData)
            ->with('user_rights', $user_rights);
    }


    public function profileUpdate(Request $request)
    {
        $input = $request->all();
        dd($input);
        // $updateUserDetails =
        return response()->json($input);
    }

    public function employeeSearch(Request $request)
    {
        //dd($request->all());

        $userId = helpers::get_orignal_id(Auth::id());
        $amId = helpers::get_team_lead(Auth::id());
        $user_rights = helpers::get_user_rights(Auth::id());
        $this->viewData['meta_title'] = 'Employees';

        $allEmployee = UsersModel::select('id')
            ->where('is_active', 1)
            ->whereNotIn('og_users.id', [48, 297, 298])
            ->get()->pluck('id')->toarray();

        $allDesignations = DesignationsModel::where('isActive', 1)->get()->pluck('id')->toarray();
        $allDepartments = DepartmentModel::where('isActive', 1)->get()->pluck('id')->toarray();
        $allGrades = DB::table('pacra_employee_grade')
            ->select('id', 'name', 'description')
            ->get()->pluck('id')->toarray();

        $all_users2 = UsersModel::where('is_active', '=', 1)
            ->where('og_users.status', '=', 'Approved')
            ->select('og_users.*', 'og_designations.title as desig')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'designation_id')
            ->whereNotIn('og_users.id', ['48', '243', '297', '298'])
            ->orderBY('og_users.display_name')
            ->get();

        // dd($user_rights);

        if ($request->empId == null) {
            $empID = $allEmployee;
        } else {
            $empID = explode(',', (int)$request->empId);
            $empID = array_map('intval', $empID);
        }

        if ($request->desig_id == null) {
            $desig = $allDesignations;
        } else {
            $desig = explode(',', $request->desig_id);
            //$desig = array_map('intval',$desig);
        }

        if ($request->dept_id == null) {
            $dpt = $allDepartments;
        } else {
            $dpt = explode(',', $request->dept_id);
            //$status = array_map('intval',$status);
        }

        if ($request->grade_id == null) {
            $grade = $allGrades;
        } else {
            $grade = explode(',', $request->grade_id);
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


        $all_users = UsersModel::where('is_active', '=', 1)
            ->select('og_users.id', 'og_users.display_name', 'og_users.avatar_file', 'og_users.fname', 'og_users.lname',
                'og_users.department', 'og_designations.title as designation')
            ->where('og_users.status', '=', 'Approved')
            ->leftjoin('og_designations', 'og_designations.id', '=', 'designation_id')
            ->leftjoin('pacra_teams', 'pacra_teams.id', '=', 'department')
            //->leftjoin('pacra_employee_grade', 'pacra_employee_grade.id', '=', 'department' )
            ->whereIn('og_users.id', $empID)
            ->whereIn('og_users.department', $dpt)
            ->whereIn('og_users.designation_id', $desig)
            ->whereIn('og_users.grade', $grade)
            // ->whereBetween('doj', [$to_date, $from_date])
            ->get();

        $allDesignations = DesignationsModel::where('isActive', 1)->get();
        $allDepartments = DepartmentModel::where('isActive', 1)->get();
        $allGrades = DB::table('pacra_employee_grade')
            ->select('id', 'name', 'description')
            ->get();

        return view('employees', $this->viewData)
            ->with('all_users', $all_users)
            ->with('all_users2', $all_users2)
            ->with('allDesignations', $allDesignations)
            ->with('allDepartments', $allDepartments)
            ->with('allGrades', $allGrades)
            ->with('user_rights', $user_rights);
    }
}
