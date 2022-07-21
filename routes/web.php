<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/*Route::get('logout', function () {
    dd('logout');
    //return view('employee-dashboard');
});*/


Route::get('/', 'HomeController@index')->name('home');
Route::get('/index', 'HomeController@index')->name('home');
Route::get('/index', 'HomeController@index')->name('page');

Route::group(['middleware' => ['beforeLogin']], function () {
    /*Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/index', 'HomeController@index')->name('home');
    Route::get('/index', 'HomeController@index')->name('page');*/
});


Route::group(['middleware' => ['afterLogin']], function () {

    Route::get('attendance_employee', 'Attendance\AttendanceController@attendanceEmployee')->name('attendance_employee');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::Post('mark_attendance', 'Attendance\AttendanceController@addMarkAttendance')->name('mark_attendance');
    Route::Post('mark_presence', 'Attendance\AttendanceController@addMarkPresence')->name('mark_presence');
    Route::Post('get_employee_attendance_report', 'Attendance\AttendanceController@getEmployeeAttendanceReport')
        ->name('get_employee_attendance_report');
    Route::Post('custom/excel', 'Attendance\AttendanceController@customExcel')
        ->name('custom/excel');

    Route::get('export', 'Attendance\AttendanceController@export')->name('export');
    Route::get('holidays', 'Attendance\AttendanceController@holidays')->name('holidays');
    Route::get('holiday_form/{id?}', 'Attendance\AttendanceController@holidayForm')->name('holiday_form');
    Route::Post('add_holiday', 'Attendance\AttendanceController@addHoliday')->name('add_holiday');
    Route::get('MbAttendance', 'Attendance\AttendanceController@MbAttendance')->name('MbAttendance');
    Route::Post('markMbAttendance', 'Attendance\AttendanceController@markMbAttendance')->name('markMbAttendance');
    Route::get('editAttendanceRequest/{id?}', 'Attendance\AttendanceController@editAttendanceRequest')->name('editAttendanceRequest');
    Route::Post('editAttendanceRequest', 'Attendance\AttendanceController@addeditAttendanceRequest')->name('editAttendanceRequest');
    Route::get('editAttendanceRequestList', 'Attendance\AttendanceController@editAttendanceRequestList')->name('editAttendanceRequestList');
    Route::get('editAttendanceRequestListHR', 'Attendance\AttendanceController@editAttendanceRequestListHR')->name('editAttendanceRequestListHR');
    Route::get('editAttendanceRequestApproval/{id?}', 'Attendance\AttendanceController@editAttendanceRequestApproval')->name('editAttendanceRequestApproval');
    Route::get('attendance', 'Attendance\AttendanceController@attendance')->name('attendance');
    Route::any('attendanceReport', 'Attendance\AttendanceController@attendanceReport')->name('attendanceReport');
    Route::any('attendanceReportSingleUser', 'Attendance\AttendanceController@attendanceReportSingleUser')->name('attendanceReportSingleUser');
    Route::any('monthly-attendance-report', 'Attendance\AttendanceController@monthlyAttandance')->name('monthlyAttandance');

    Route::post('ajaxcall', 'Attendance\AttendanceController@ajaxcall');
    Route::post('ajaxcall2', 'Attendance\AttendanceController@ajaxcall2');


    Route::get('/get_departments', 'Employees\EmployeeController@getDeparment')->name('get_departments');
    Route::post('/update_departments', 'Employees\EmployeeController@updateDeparment')->name('update_departments');
    Route::post('/create_departments', 'Employees\EmployeeController@createDeparment')->name('create_departments');


    Route::get('/get_designations', 'Employees\EmployeeController@getDesignations')->name('get_designations');
    Route::post('/update_designations', 'Employees\EmployeeController@updateDesignations')->name('update_designations');
    Route::post('/create_designations', 'Employees\EmployeeController@createDesignations')->name('create_designations');

    Route::get('/employees', 'Employees\EmployeeController@getEmployees')->name('employees');
    Route::get('/leavers', 'Employees\EmployeeController@getLeavers')->name('leavers');
    Route::get('/employees_approval', 'Employees\EmployeeController@getEmployeesApproval')->name('employees_approval');
    Route::post('/edit_employee', 'Employees\EmployeeController@editEmployees')->name('edit_employee');

    Route::any('/update_employee', 'Employees\EmployeeController@updateEmployees')->name('update_employee');
    Route::get('/add_employee', 'Employees\EmployeeController@addEmployees')->name('add_employee');
    Route::POST('/add_employee', 'Employees\EmployeeController@addNewEmployees')->name('add_employee');

    Route::get('/profile/{id}', 'Employees\EmployeeController@profile');
    Route::get('/approvalProfile/{id}', 'Employees\EmployeeController@approvalProfile');
    Route::post('/employeeSearch', 'Employees\EmployeeController@employeeSearch')->name('employeeSearch');
    Route::get('attendance_report', 'Attendance\AttendanceController@attendance_report')->name('attendance_report');
    Route::get('/leave_application', 'Leaves\pacraLeavesController@leaveApplication')->name('leave_application');
    Route::Post('add_leaves', 'Leaves\pacraLeavesController@addLeaves')->name('add_leaves');
    Route::get('leave_approvals', 'Leaves\pacraLeavesController@leaveApprovals')->name('leave_approvals');
    Route::get('leave_approvalsHr', 'Leaves\pacraLeavesController@leave_approvalsHr')->name('leave_approvalsHr');
    Route::get('leave_edit/{id}', 'Leaves\pacraLeavesController@leaveEditApprove')->name('leave_edit/{id}');
    Route::Post('leave_approvals', 'Leaves\pacraLeavesController@empLeaveEditApprovals')->name('leave_approvals');
    Route::get('leave_history', 'Leaves\pacraLeavesController@leaveHistory')->name('leave_history');
    Route::get('leave_balances_all_emp', 'Leaves\pacraLeavesController@leaveBalancesAllEmp')->name('leave_balances_all_emp');
    Route::get('leavesReport', 'Leaves\pacraLeavesController@leavesReport')->name('leavesReport');
    Route::post('leavesReportFilter', 'Leaves\pacraLeavesController@leavesReportFilter')->name('leavesReportFilter');

    Route::get('/hr-trainings', 'HrTrainingsController@createTrainingHr')->name('HrTrainings');
    Route::post('/hr-trainings/store', 'HrTrainingsController@storeTrainingHr')->name('storeHrTrainings');

    Route::get('absentees', 'Attendance\AttendanceController@absentees')->name('absentees');
    Route::get('present-employees', 'Attendance\AttendanceController@presentEmp')->name('presentEmp');
    Route::get('on-leave', 'Attendance\AttendanceController@onLeave')->name('onLeave');
    Route::get('late-comers', 'Attendance\AttendanceController@LateComers')->name('LateComers');
    Route::get('on-time', 'Attendance\AttendanceController@OnTime')->name('onTime');
    Route::get('in-office', 'Attendance\AttendanceController@InOffice')->name('InOffice');
    Route::get('anywhere-emp', 'Attendance\AttendanceController@AnywhereEmp')->name('AnywhereEmp');


    /* Route::get('/leaves', function () {
         return view('leaves');
     });*/


    Route::get('test', 'Leaves\pacraLeavesController@test')->name('test');


    Route::get('policies', 'Employees\EmployeeController@policies')->name('policies');
    Route::get('add_policy_form/{id?}', 'Employees\EmployeeController@policyForm')->name('add_policy_form');
    Route::Post('add_policy', 'Employees\EmployeeController@addPolicy')->name('add_policy');

    Route::get('wfh', 'Leaves\pacraLeavesController@workFromHome')->name('wfh');
    Route::get('/wfh_application/{id?}', 'Leaves\pacraLeavesController@workFromHomeApplication')->name('wfh_application');
    Route::Post('/add_wfh', 'Leaves\pacraLeavesController@addWFH')->name('add_wfh');
    Route::get('/delete_wfh/{id?}', 'Leaves\pacraLeavesController@deleteWFH')->name('delete_wfh');
    Route::get('wfh_approvals_list', 'Leaves\pacraLeavesController@wfhApprovalsList')->name('wfh_approvals_list');
    Route::get('pacrawfh', 'Leaves\pacraLeavesController@pacrawfh')->name('pacrawfh');


    Route::get('siteVisit', 'Leaves\pacraLeavesController@siteVisit')->name('siteVisit');
    Route::get('/siteVisitApplication/{id?}', 'Leaves\pacraLeavesController@siteVisitApplication')->name('siteVisitApplication');
    Route::Post('/addSiteVisit', 'Leaves\pacraLeavesController@addSiteVisit')->name('addSiteVisit');

    Route::get('siteVisit_approvals_list', 'Leaves\pacraLeavesController@siteVisitApprovalsList')->name('siteVisit_approvals_list');

    Route::get('resignation', 'Resignation\empResignationController@resignation')->name('resignation');
    Route::get('resignationForm/{id?}', 'Resignation\empResignationController@resignationForm')->name('resignationForm');
    Route::Post('addResignation', 'Resignation\empResignationController@addResignation')->name('addResignation');
    Route::get('resignationApprovals', 'Resignation\empResignationController@resignationApprovals')->name('resignationApprovals');
    Route::get('empSeparationForm/{id?}', 'Resignation\empResignationController@empSeparationForm')->name('empSeparationForm');
    Route::Post('addSeparation', 'Resignation\empResignationController@addSeparation')->name('addSeparation');
    Route::get('TlSeparationList', 'Resignation\empResignationController@TlSeparationList')->name('TlSeparationList');
    Route::get('TLempSeparationForm/{id?}', 'Resignation\empResignationController@TLempSeparationForm')->name('TLempSeparationForm');


    Route::get('reimbursement', 'Reimbursement\ReimbursementController@reimbursementIndex')->name('reimbursement');
    Route::get('reimbursement-approval', 'Reimbursement\ReimbursementController@reimbursementApproval')->name('reimbursement-approval');
    Route::any('store-reimbursement-approval/{id?}', 'Reimbursement\ReimbursementController@storeReimbursementApproval')->name('store-reimbursement-approval');
    Route::get('reimbursement-form', 'Reimbursement\ReimbursementController@reimbursementForm')->name('reimbursement-form');
    Route::get('edit-reimbursement-form/{id}', 'Reimbursement\ReimbursementController@editReimbursementForm')->name('edit-reimbursement-form');
    Route::any('store-reimbursement-form', 'Reimbursement\ReimbursementController@storeReimbursementForm')->name('store-reimbursement-form');


    Route::get('separationList', 'Resignation\empResignationController@separationList')->name('separationList');
    Route::get('ResignationReport', 'Resignation\empResignationController@ResignationReport')->name('ResignationReport');
    Route::get('separationReport', 'Resignation\empResignationController@separationReport')->name('separationReport');
    Route::get('SeparationFormPreview/{id?}', 'Resignation\empResignationController@SeparationFormPreview')->name('SeparationFormPreview');


    Route::get('separationMIT', 'Resignation\empResignationController@separationMIT')->name('separationMIT');
    Route::get('MITempSeparationForm/{id?}', 'Resignation\empResignationController@MITempSeparationForm')->name('MITempSeparationForm');
    Route::get('separationAdmin', 'Resignation\empResignationController@separationAdmin')->name('separationAdmin');
    Route::get('AdminEmpSeparationForm/{id?}', 'Resignation\empResignationController@AdminEmpSeparationForm')->name('AdminEmpSeparationForm');
    Route::get('separationHR', 'Resignation\empResignationController@separationHR')->name('separationHR');
    Route::get('HREmpSeparationForm/{id?}', 'Resignation\empResignationController@HREmpSeparationForm')->name('HREmpSeparationForm');
    Route::get('separationFinance', 'Resignation\empResignationController@separationFinance')->name('separationFinance');
    Route::get('settlementFinance', 'Resignation\empResignationController@settlementFinance')->name('settlementFinance');
    Route::get('FinanceEmpSeparationForm/{id?}', 'Resignation\empResignationController@FinanceEmpSeparationForm')->name('FinanceEmpSeparationForm');
    Route::any('clearFinalSettlement/{id}', 'Resignation\empResignationController@clearFinalSettlement')->name('clearFinalSettlement');
    Route::get('separationCEO', 'Resignation\empResignationController@separationCEO')->name('separationCEO');
    Route::get('CEOEmpSeparationForm/{id?}', 'Resignation\empResignationController@CEOEmpSeparationForm')->name('CEOEmpSeparationForm');


    Route::get('editAttendanceRequestReport', 'Attendance\AttendanceController@editAttendanceRequestReport')->name('editAttendanceRequestReport');
    Route::any('attendanceExcelExportSummary', 'Attendance\AttendanceController@attendanceExcelExportSummary')->name('attendanceExcelExportSummary');


    Route::get('jobTitles', 'jobPortal\jobPortals@jobTitles')->name('jobTitles');
    Route::any('jobTitles/delete/{id}', 'jobPortal\jobPortals@deleteJobDesc')->name('deleteJobDesc');
    Route::get('jobTitlesForm/{id?}', 'jobPortal\jobPortals@jobTitlesForm')->name('jobTitlesForm');
    Route::post('addJobTitles', 'jobPortal\jobPortals@addJobTitles')->name('addJobTitles');
    Route::get('hiringRequest', 'jobPortal\jobPortals@hiringRequest')->name('hiringRequest');
    Route::any('hiringRequest/delete/{id}', 'jobPortal\jobPortals@deleteHiringRequest')->name('deleteHiringRequest');
    Route::get('hiringRequestApprovel', 'jobPortal\jobPortals@hiringRequestApprovel')->name('hiringRequestApprovel');
    Route::get('hiringRequestAuthenticate', 'jobPortal\jobPortals@hiringRequestAuthenticate')->name('hiringRequestAuthenticate');
    Route::get('hiringRequestAuthenticateForm/{id?}', 'jobPortal\jobPortals@hiringRequestAuthenticateForm')->name('hiringRequestAuthenticateForm');
    Route::get('hiringRequestForm/{id?}', 'jobPortal\jobPortals@hiringRequestForm')->name('hiringRequestForm');
    Route::get('hiringRequestFormDetails/{id}', 'jobPortal\jobPortals@hiringRequestFormDetails')->name('hiringRequestFormDetails');
    Route::post('addHiringRequest', 'jobPortal\jobPortals@addHiringRequest')->name('addHiringRequest');
    Route::get('jobApplicants', 'jobPortal\jobPortals@jobApplicants')->name('jobApplicants');
    Route::get('rejected-applicants', 'jobPortal\jobPortals@rejectedJobApplicants')->name('rejectedJobApplicants');
    Route::get('initialShortlist', 'jobPortal\jobPortals@initialShortlist')->name('initialShortlist');
    Route::any('addInitialShortlist/{userID?}/{candidateID?}/{jobID?}/{status?}', 'jobPortal\jobPortals@addInitialShortlist')->name('addInitialShortlist');
    Route::any('rejectApplicants/{id?}', 'jobPortal\jobPortals@rejectApplicants')->name('rejectApplicants');
    Route::post('jobApplicantsSearch', 'jobPortal\jobPortals@jobApplicantsSearch')->name('jobApplicantsSearch');
    Route::get('scheduleTest/{userID?}/{candidateID?}/{jobID?}', 'jobPortal\jobPortals@scheduleTest')->name('scheduleTest');
    Route::post('addScheduleTest', 'jobPortal\jobPortals@addScheduleTest')->name('addScheduleTest');
    Route::get('shortListedForTest', 'jobPortal\jobPortals@shortListedForTest')->name('shortListedForTest');

    Route::get('myInterViewList', 'jobPortal\jobPortals@myInterViewList')->name('myInterViewList');
    Route::get('scheduleInterview/{userID?}/{candidateID?}/{jobID?}', 'jobPortal\jobPortals@scheduleInterview')->name('scheduleInterview');
    Route::get('reScheduleInterview/{userID?}/{candidateID?}/{jobID?}/{interviewID?}', 'jobPortal\jobPortals@reScheduleInterview')->name('reScheduleInterview');
    Route::get('reScheduleInterview/{userID?}/{candidateID?}/{jobID?}/{interviewID?}', 'jobPortal\jobPortals@reScheduleInterview')->name('reScheduleInterview');

    Route::get('scheduleInterviewCEO/{userID?}/{candidateID?}/{jobID?}', 'jobPortal\jobPortals@scheduleInterviewCEO')->name('scheduleInterviewCEO');
    Route::post('addScheduleInterview', 'jobPortal\jobPortals@addScheduleInterview')->name('addScheduleInterview');
    Route::post('addReScheduleInterview', 'jobPortal\jobPortals@addReScheduleInterview')->name('addReScheduleInterview');

    Route::get('shortListedForInterview', 'jobPortal\jobPortals@shortListedForInterview')->name('shortListedForInterview');
    Route::get('engagementApproval', 'jobPortal\jobPortals@engagementApproval')->name('engagementApproval');
    Route::get('engagementForm/{userID?}/{candidateID?}/{jobID?}', 'jobPortal\jobPortals@engagementForm')->name('engagementForm');
    Route::get('appointmentForm/{userID?}/{candidateID?}/{jobID?}', 'jobPortal\jobPortals@appointmentForm')->name('appointmentForm');
    Route::post('addEngagementForm', 'jobPortal\jobPortals@addEngagementForm')->name('addEngagementForm');
    Route::post('addAppointmentForm', 'jobPortal\jobPortals@addAppointmentForm')->name('addAppointmentForm');
    Route::get('appointmentLetter/{userID?}/{jobID?}', 'jobPortal\jobPortals@appointmentLetter')->name('appointmentLetter');
    Route::get('shortListedForFinalInterview', 'jobPortal\jobPortals@shortListedForFinalInterview')->name('shortListedForFinalInterview');
    Route::get('hiringDecision/{userID?}/{candidateID?}/{jobID?}/{decision?}', 'jobPortal\jobPortals@hiringDecision')->name('hiringDecision');
    Route::post('hiringDecisionSalary/{userID?}/{candidateID?}/{jobID?}/{decision?}', 'jobPortal\jobPortals@hiringDecisionSalary')->name('hiringDecisionSalary');
    Route::get('ShortListByCEO', 'jobPortal\jobPortals@ShortListByCEO')->name('ShortListByCEO');
    Route::get('finalSalaryForm/{userID?}/{candidateID?}/{jobID?}', 'jobPortal\jobPortals@finalSalaryForm')->name('finalSalaryForm');
    Route::post('addfinalSalaryForm', 'jobPortal\jobPortals@addfinalSalaryForm')->name('addfinalSalaryForm');


    Route::get('appointmentList', 'jobPortal\jobPortals@appointmentList')->name('appointmentList');
    Route::get('makeEmployee/{userID?}/{candidateID?}/{jobID?}', 'jobPortal\jobPortals@makeEmployee')->name('makeEmployee');
    Route::Post('makeEmployee', 'jobPortal\jobPortals@makeNewEmployee')->name('makeEmployee');
    Route::get('/candidateProfile/{id?}/{jobID?}', 'jobPortal\jobPortals@candidateProfile')->name('candidateProfile');


    Route::get('quiz', 'jobPortal\jobPortals@quiz')->name('quiz');
    Route::get('quizForm/{id?}', 'jobPortal\jobPortals@quizForm')->name('quizForm');
    Route::post('addQuiz', 'jobPortal\jobPortals@addQuiz')->name('addQuiz');

    Route::get('questions', 'jobPortal\jobPortals@questions')->name('questions');
    Route::get('questionsList/{id?}', 'jobPortal\jobPortals@questionsList')->name('questionsList');
    Route::get('questionsForm/{id?}', 'jobPortal\jobPortals@questionsForm')->name('questionsForm');
    Route::post('addQuestion', 'jobPortal\jobPortals@addQuestion')->name('addQuestion');
    Route::get('search', 'jobPortal\jobPortals@search')->name('search');

    Route::get('instituteList', 'jobPortal\jobPortals@instituteList')->name('instituteList');
    Route::get('institutesForm', 'jobPortal\jobPortals@institutesForm')->name('institutesForm');
    Route::Post('addInstitute', 'jobPortal\jobPortals@addInstitute')->name('addInstitute');


    Route::get('/settings', function () {
        return view('settings');
    });
    Route::get('salarySettings', 'Settings\SettingController@salarySettings')->name('salarySettings');
    Route::POST('addSalarySettings', 'Settings\SettingController@addSalarySettings')->name('addSalarySettings');
    Route::get('changeStatus', 'jobPortal\jobPortals@changeStatus');
    Route::any('reject-absent/{id?}', 'jobPortal\jobPortals@rejectAbsent')->name('reject-absent');
    Route::any('terminate-employee/{id?}', 'Resignation\empResignationController@terminateEmployee')->name('terminate-employee');
    Route::any('terminationApprovals', 'Resignation\empResignationController@terminationApprovals')->name('terminationApprovals');
    Route::any('TerminationReport', 'Resignation\empResignationController@TerminationReport')->name('TerminationReport');
    Route::any('end-internship/{id?}/{status?}', 'Resignation\empResignationController@EndInternship')->name('end-internship');
    Route::any('end-internship-approval/{id?}/{status?}', 'Resignation\empResignationController@EndInternshipApprovals')->name('end-internship-approval');
    Route::any('interns-report', 'Resignation\empResignationController@InternsReport')->name('interns-report');
    Route::any('extend-internship/{id?}/{status?}', 'Resignation\empResignationController@extendInternship')->name('extend-internship');




//    Route::get('/profile', function () {
//        return view('profile');
//    });

    /*Route::get('/employees', function () {
        return view('employees');
    });*/


});


Route::get('/employee-dashboard', function () {
    return view('employee-dashboard');
});

Route::get('/chat', function () {
    return view('chat');
});

Route::get('/voice-call', function () {
    return view('voice-call');
});


Route::get('/video-call', function () {
    return view('video-call');
});
Route::get('/outgoing-call', function () {
    return view('outgoing-call');
});
Route::get('/incoming-call', function () {
    return view('incoming-call');
});
Route::get('/events', function () {
    return view('events');
});
Route::get('/contacts', function () {
    return view('contacts');
});
Route::get('/inbox', function () {
    return view('inbox');
});
Route::get('/file-manager', function () {
    return view('file-manager');
});


Route::get('/leaves-employee', function () {
    return view('leaves-employee');
});
Route::get('/leave-settings', function () {
    return view('leave-settings');
});

Route::get('/attendance-employee', function () {
    return view('attendance-employee');
});
Route::get('/departments', function () {
    return view('departments');
});
Route::get('/designations', function () {
    return view('designations');
});
Route::get('/timesheet', function () {
    return view('timesheet');
});
Route::get('/overtime', function () {
    return view('overtime');
});
Route::get('/clients', function () {
    return view('clients');
});
Route::get('/projects', function () {
    return view('projects');
});
Route::get('/tasks', function () {
    return view('tasks');
});
Route::get('/task-board', function () {
    return view('task-board');
});
Route::get('/leads', function () {
    return view('leads');
});
Route::get('/tickets', function () {
    return view('tickets');
});
Route::get('/estimates', function () {
    return view('estimates');
});
Route::get('/invoices', function () {
    return view('invoices');
});
Route::get('/payments', function () {
    return view('payments');
});
Route::get('/expenses', function () {
    return view('expenses');
});
Route::get('/provident-fund', function () {
    return view('provident-fund');
});
Route::get('/taxes', function () {
    return view('taxes');
});
Route::get('/salary', function () {
    return view('salary');
});
Route::get('/salary-view', function () {
    return view('salary-view');
});
Route::get('/payroll-items', function () {
    return view('payroll-items');
});

Route::get('/expense-reports', function () {
    return view('expense-reports');
});
Route::get('/invoice-reports', function () {
    return view('invoice-reports');
});
Route::get('/performance-indicator', function () {
    return view('performance-indicator');
});
Route::get('/performance', function () {
    return view('performance');
});
Route::get('/performance-appraisal', function () {
    return view('performance-appraisal');
});
Route::get('/goal-tracking', function () {
    return view('goal-tracking');
});
Route::get('/goal-type', function () {
    return view('goal-type');
});
Route::get('/training', function () {
    return view('training');
});
Route::get('/trainers', function () {
    return view('trainers');
});
Route::get('/training-type', function () {
    return view('training-type');
});
Route::get('/promotion', function () {
    return view('promotion');
});

Route::get('/termination', function () {
    return view('termination');
});
Route::get('/assets', function () {
    return view('assets');
});
Route::get('/jobs', function () {
    return view('jobs');
});
Route::get('/jobs-applicants', function () {
    return view('jobs-applicants');
});
Route::get('/knowledgebase', function () {
    return view('knowledgebase');
});
Route::get('/activities', function () {
    return view('activities');
});
Route::get('/users', function () {
    return view('users');
});

Route::get('/localization', function () {
    return view('localization');
});
Route::get('/theme-settings', function () {
    return view('theme-settings');
});
Route::get('/roles-permissions', function () {
    return view('roles-permissions');
});
Route::get('/email-settings', function () {
    return view('email-settings');
});
Route::get('/invoice-settings', function () {
    return view('invoice-settings');
});

Route::get('/notifications-settings', function () {
    return view('notifications-settings');
});
Route::get('/change-password', function () {
    return view('change-password');
});
Route::get('/leave-type', function () {
    return view('leave-type');
});
/*Route::get('/profile', function () {
    return view('profile');
});*/
Route::get('/client-profile', function () {
    return view('client-profile');
});
/*Route::get('/login', function () {
    return view('login');
});*/
Route::get('/register', function () {
    return view('register');
});
Route::get('/forgot-password', function () {
    return view('forgot-password');
});
Route::get('/otp', function () {
    return view('otp');
});
Route::get('/lock-screen', function () {
    return view('lock-screen');
});
Route::get('/error-404', function () {
    return view('error-404');
});
Route::get('/error-500', function () {
    return view('error-500');
});
Route::get('/subscriptions', function () {
    return view('subscriptions');
});
Route::get('/subscriptions-company', function () {
    return view('subscriptions-company');
});
Route::get('/subscribed-companies', function () {
    return view('subscribed-companies');
});
// Route::get('/search', function () {
//     return view('search');
// });
Route::get('/faq', function () {
    return view('faq');
});
Route::get('/terms', function () {
    return view('terms');
});
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});
Route::get('/blank-page', function () {
    return view('blank-page');
});
Route::get('/components', function () {
    return view('components');
});
Route::get('/form-basic-inputs', function () {
    return view('form-basic-inputs');
});
Route::get('/form-input-groups', function () {
    return view('form-input-groups');
});
Route::get('/form-horizontal', function () {
    return view('form-horizontal');
});
Route::get('/form-vertical', function () {
    return view('form-vertical');
});
Route::get('/form-mask', function () {
    return view('form-mask');
});
Route::get('/form-validation', function () {
    return view('form-validation');
});
Route::get('/tables-basic', function () {
    return view('tables-basic');
});
Route::get('/data-tables', function () {
    return view('data-tables');
});
Route::get('/create-estimate', function () {
    return view('create-estimate');
});
Route::get('/create-invoice', function () {
    return view('create-invoice');
});
Route::get('/clients-list', function () {
    return view('clients-list');
});
Route::get('/compose', function () {
    return view('compose');
});
Route::get('/edit-estimate', function () {
    return view('edit-estimate');
});
Route::get('/edit-invoice', function () {
    return view('edit-invoice');
});
Route::get('/estimate-view', function () {
    return view('estimate-view');
});
Route::get('/job-view', function () {
    return view('job-view');
});
Route::get('/job-list', function () {
    return view('job-list');
});
Route::get('/job-details', function () {
    return view('job-details');
});
Route::get('/knowledgebase-view', function () {
    return view('knowledgebase-view');
});
Route::get('/mail-view', function () {
    return view('mail-view');
});
Route::get('/project-list', function () {
    return view('project-list');
});
Route::get('/project-view', function () {
    return view('project-view');
});
Route::get('/ticket-view', function () {
    return view('ticket-view');
});
Route::get('/invoice-view', function () {
    return view('invoice-view');
});
Route::get('/employees-list', function () {
    return view('employees-list');
});


