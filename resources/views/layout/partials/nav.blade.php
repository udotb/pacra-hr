<div class="main-wrapper">
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li class="{{ Request::is('index') ? 'active' : '' }}">
                                <a href="{{ url('index') }}">My Dashboard</a></li>
                            <li>

                        </ul>
                    </li>

                    <li class="menu-title">
                        <span>Employees</span>
                    </li>
                    <li class="submenu">
                        <a href="#" class=""><i class="la la-user"></i> <span> Employees</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li>
                                <a class="{{ Request::is('attendance_employee') ? 'active' : '' }}"
                                   href="{{ url('attendance_employee') }}">Attendance (Employee)</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('wfh') ? 'active' : '' }}" href="{{ url('wfh') }}">WFH
                                    Application</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('siteVisit') ? 'active' : '' }}" href="{{ url('siteVisit') }}">Client
                                    Visit Application</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('attendance_report') ? 'active' : '' }}"
                                   href="{{ url('attendance_report') }}">Today Attendance Report</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('leave_application') ? 'active' : '' }}"
                                   href="{{ url('leave_application') }}">Leave Application</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('leave_history') ? 'active' : '' }}"
                                   href="{{ url('leave_history') }}">Leave History</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('holidays') ? 'active' : '' }}" href="{{ url('holidays') }}">Holidays</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('employees') ? 'active' : '' }}" href="{{ url('employees') }}">Personnel</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('resignation') ? 'active' : '' }}"
                                   href="{{ url('resignation') }}">Separation</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('reimbursement') ? 'active' : '' }}"
                                   href="{{ url('reimbursement') }}">Reimbursement</a>
                            </li>
                        </ul>
                    </li>

                    <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                    @if(in_array('10', $user_rights) || in_array('36', $user_rights))
                        <li class="menu-title">
                            <span>HR</span>
                        </li>
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-user"></i> <span> Human Resource</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                                @if(in_array('10', $user_rights) )
                                    <li>
                                        <a class="{{ Request::is('leavers') ? 'active' : '' }}"
                                           href="{{ url('leavers') }}">Leavers</a></li>
                                    <li>
                                        <a class="{{ Request::is('get_departments') ? 'active' : '' }}"
                                           href="{{ url('get_departments') }}">Departments</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('get_designations') ? 'active' : '' }}"
                                           href="{{ url('get_designations') }}">Designations</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('MbAttendance') ? 'active' : '' }}"
                                           href="{{ url('MbAttendance') }}">Mark MB Attendance</a>
                                    </li>
                                @endif
                                @if(in_array('36', $user_rights) )
                                    <li>
                                        <a class="{{ Request::is('hr-trainings') ? 'active' : '' }}"
                                           href="{{ route('HrTrainings') }}">HR Trainings</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                    @if(in_array('16', $user_rights) )
                        <li class="menu-title">
                            <span>Approvals</span>
                        </li>
                        {{--                        <li class="submenu">--}}
                        <?php $hrLeaveApprovals = \App\Helpers\helpers::hrLeaveApprovals(Auth::id());
                        $hrEmployeeApprovals = \App\Helpers\helpers::hrEmployeeApprovals(Auth::id());
                        $hrWFHApprovals = \App\Helpers\helpers::hrWFHApprovals(Auth::id());
                        $hrSeparationApprovals = \App\Helpers\helpers::hrSeparationApprovals(Auth::id());
                        $hrEditAttendanceApprovals = \App\Helpers\helpers::hrEditAttendanceApprovals(Auth::id());
                        $tlLeaveApprovals = \App\Helpers\helpers::tlLeaveApprovals(Auth::id());
                        $tlWFHApprovals = \App\Helpers\helpers::tlWFHApprovals(Auth::id());
                        $tlClientVisitpprovals = \App\Helpers\helpers::tlClientVisitpprovals(Auth::id());
                        $tlResignationAprovals = \App\Helpers\helpers::tlResignationAprovals(Auth::id());
                        $tlTerminationAprovals = \App\Helpers\helpers::tlTerminationAprovals(Auth::id());
                        $tlEndInternshipAprovals = \App\Helpers\helpers::tlEndInternshipAprovals(Auth::id());
                        $tlSeparationAprovals = \App\Helpers\helpers::tlSeparationAprovals(Auth::id());
                        $tlEditAttendanceApprovals = \App\Helpers\helpers::tlEditAttendanceApprovals(Auth::id());
                        $mitSeparationAprovals = \App\Helpers\helpers::mitSeparationAprovals(Auth::id());
                        $adminSeparationAprovals = \App\Helpers\helpers::adminSeparationAprovals(Auth::id());
                        $financeSeparationAprovals = \App\Helpers\helpers::financeSeparationAprovals(Auth::id());
                        $financeSettlementAprovals = \App\Helpers\helpers::financeSettlementAprovals(Auth::id());
                        $ceoSeparationAprovals = \App\Helpers\helpers::ceoSeparationAprovals(Auth::id());
                        $TlHiringRequestApproval = \App\Helpers\helpers::TlHiringRequestApproval(Auth::id());
                        $HRHiringRequestApproval = \App\Helpers\helpers::HRHiringRequestApproval(Auth::id());
                        $TlReimbursementApproval = \App\Helpers\helpers::TlReimbursementApproval(Auth::id());
                        $FinanceReimbursementApproval = \App\Helpers\helpers::FinanceReimbursementApproval(Auth::id());
                        $myInterviews = \App\Helpers\helpers::MyInterviewsApproval(Auth::id());

                        $sumOfHrApproval = $hrLeaveApprovals + $hrEmployeeApprovals + $hrWFHApprovals + $hrSeparationApprovals + $hrEditAttendanceApprovals + $HRHiringRequestApproval;
                        $sumOfTlAllroval = $tlLeaveApprovals + $tlWFHApprovals + $tlClientVisitpprovals + $tlResignationAprovals + $tlSeparationAprovals + $tlEditAttendanceApprovals + $TlHiringRequestApproval + $TlReimbursementApproval + $tlTerminationAprovals + $tlEndInternshipAprovals;
                        ?>
                        {{--                            @if($sumOfHrApproval ==  0)--}}
                        {{--                                <a href="#" class=""><i class="la la-user"></i> <span> All Approvals</span> <span--}}
                        {{--                                        class="menu-arrow"></span></a>--}}
                        {{--                            @else--}}
                        {{--                                <a href="#" class="noti-dot"><i class="la la-user"></i> <span> All Approvals</span>--}}
                        {{--                                    <span--}}
                        {{--                                        class="menu-arrow"></span></a>--}}

                        {{--                            @endif--}}
                        {{--                            <ul style="display: none;">--}}
                        <li class="submenu">
                            <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                            @if(in_array('6', $user_rights) )
                                <a href="#" class=""><i class="la la-user"></i> <span>HR Approvals</span> <span
                                        class="badge badge-pill bg-primary float-left"> {{$sumOfHrApproval}}</span>
                                    <span class="menu-arrow"></span> </a>
                                <ul style="display: none;">
                                    <li>
                                        <a class="{{ Request::is('employees_approval') ? 'active' : '' }}"
                                           href="{{ url('employees_approval') }}">Employees Approval <span
                                                class="badge badge-pill bg-primary float-right"> {{$hrEmployeeApprovals}}</span></a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('leave_approvalsHr') ? 'active' : '' }}"
                                           href="{{ url('leave_approvalsHr') }}">Leaves Approval <span
                                                class="badge badge-pill bg-primary float-right"> {{$hrLeaveApprovals}}</span></a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('wfh_approvals_list') ? 'active' : '' }}"
                                           href="{{ url('wfh_approvals_list') }}">WFH Approval <span
                                                class="badge badge-pill bg-primary float-right"> {{$hrWFHApprovals}}</span></a>
                                    </li>
                                    {{--                                            <li>--}}
                                    {{--                                                <a class="{{ Request::is('separationList') ? 'active' : '' }}"--}}
                                    {{--                                                   href="{{ url('separationList') }}">Separation <span--}}
                                    {{--                                                        class="badge badge-pill bg-primary float-right"> {{$hrSeparationApprovals}}</span>--}}
                                    {{--                                                </a>--}}
                                    {{--                                            </li>--}}
                                    <li>
                                        <a class="{{ Request::is('editAttendanceRequestListHR') ? 'active' : '' }}"
                                           href="{{ url('editAttendanceRequestListHR') }}">Attendance Edit <span
                                                class="badge badge-pill bg-primary float-right"> {{$hrEditAttendanceApprovals}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('separationHR') ? 'active' : '' }}"
                                           href="{{ url('separationHR') }}">Separation HR <span
                                                class="badge badge-pill bg-primary float-right"> {{$hrSeparationApprovals}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('hiringRequestAuthenticate') ? 'active' : '' }}"
                                           href="{{ url('hiringRequestAuthenticate') }}">Hiring Request <span
                                                class="badge badge-pill bg-primary float-right"> {{$HRHiringRequestApproval}} </span>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </li>
                        <li class="submenu">
                            <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                            @if(in_array('16', $user_rights) )
                                <a href="#" class=""><i class="la la-user"></i> <span>TL Approvals</span> <span
                                        class="menu-arrow"></span>
                                    <span
                                        class="badge badge-pill bg-primary float-left">
												@if(in_array('22', $user_rights) )
                                            {{$sumOfTlAllroval + $mitSeparationAprovals}}
                                        @elseif(in_array('23', $user_rights) )
                                            {{$sumOfTlAllroval + $adminSeparationAprovals}}
                                        @elseif(in_array('25', $user_rights) )
                                            {{$sumOfTlAllroval + $financeSeparationAprovals + $financeSettlementAprovals}}
                                        @elseif(in_array('26', $user_rights) )
                                            {{$sumOfTlAllroval + $ceoSeparationAprovals}}
                                        @else
                                            {{$sumOfTlAllroval}}
                                        @endif
											</span>
                                </a>
                                <ul style="display: none;">
                                    <li>
                                        <a class="{{ Request::is('leave_approvals') ? 'active' : '' }}"
                                           href="{{ url('leave_approvals') }}">Leaves Approval <span
                                                class="badge badge-pill bg-primary float-right"> {{$tlLeaveApprovals}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('wfh_approvals_list') ? 'active' : '' }}"
                                           href="{{ url('wfh_approvals_list') }}">WFH Approval <span
                                                class="badge badge-pill bg-primary float-right"> {{$tlWFHApprovals}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('siteVisit_approvals_list') ? 'active' : '' }}"
                                           href="{{ url('siteVisit_approvals_list') }}">Client Visit Approval
                                            <span
                                                class="badge badge-pill bg-primary float-right"> {{$tlClientVisitpprovals}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('resignationApprovals') ? 'active' : '' }}"
                                           href="{{ url('resignationApprovals') }}">Resignation <span
                                                class="badge badge-pill bg-primary float-right"> {{$tlResignationAprovals}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('terminationApprovals') ? 'active' : '' }}"
                                           href="{{ url('terminationApprovals') }}">End Employment <span
                                                class="badge badge-pill bg-primary float-right"> {{$tlTerminationAprovals}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('end-internship-approval') ? 'active' : '' }}"
                                           href="{{ url('end-internship-approval') }}">Internships <span
                                                class="badge badge-pill bg-primary float-right"> {{$tlEndInternshipAprovals}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('TlSeparationList') ? 'active' : '' }}"
                                           href="{{ url('TlSeparationList') }}">Separation <span
                                                class="badge badge-pill bg-primary float-right"> {{$tlSeparationAprovals}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('editAttendanceRequestList') ? 'active' : '' }}"
                                           href="{{ url('editAttendanceRequestList') }}">Attendance Edit <span
                                                class="badge badge-pill bg-primary float-right"> {{$tlEditAttendanceApprovals}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('hiringRequestApprovel') ? 'active' : '' }}"
                                           href="{{ url('hiringRequestApprovel') }}">Hiring Request <span
                                                class="badge badge-pill bg-primary float-right"> {{$TlHiringRequestApproval}}</span></a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('reimbursement-approval') ? 'active' : '' }}"
                                           href="{{ url('reimbursement-approval') }}">Reimbursement <span
                                                class="badge badge-pill bg-primary float-right"> {{$TlReimbursementApproval}}</span></a>
                                    </li>
                                    <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                                    @if(in_array('22', $user_rights) )
                                        <li>
                                            <a class="{{ Request::is('separationMIT') ? 'active' : '' }}"
                                               href="{{ url('separationMIT') }}">Separation MIT <span
                                                    class="badge badge-pill bg-primary float-right"> {{$mitSeparationAprovals}}</span></a>
                                        </li>

                                    @elseif (in_array('23', $user_rights))
                                        <li>
                                            <a class="{{ Request::is('separationAdmin') ? 'active' : '' }}"
                                               href="{{ url('separationAdmin') }}">Separation Admin <span
                                                    class="badge badge-pill bg-primary float-right"> {{$adminSeparationAprovals}}</span></a>
                                        </li>
                                    @elseif (in_array('25', $user_rights))
                                        <li>
                                            <a class="{{ Request::is('separationFinance') ? 'active' : '' }}"
                                               href="{{ url('separationFinance') }}">Separation Finance <span
                                                    class="badge badge-pill bg-primary float-right"> {{$financeSeparationAprovals}}</span></a>
                                        </li>
                                        <li>
                                            <a class="{{ Request::is('separationFinancesettlementFinance') ? 'active' : '' }}"
                                               href="{{ url('settlementFinance') }}">Settlement <span
                                                    class="badge badge-pill bg-primary float-right"> {{$financeSettlementAprovals}}</span></a>
                                        </li>
                                        <li>
                                            <a class="{{ Request::is('reimbursement-approval') ? 'active' : '' }}"
                                               href="{{ url('reimbursement-approval') }}">Reimbursement Finance <span
                                                    class="badge badge-pill bg-primary float-right"> {{$FinanceReimbursementApproval}}</span></a>
                                        </li>
                                    @elseif (in_array('26', $user_rights))
                                        <li>
                                            <a class="{{ Request::is('separationCEO') ? 'active' : '' }}"
                                               href="{{ url('separationCEO') }}">Separation CEO <span
                                                    class="badge badge-pill bg-primary float-right"> {{$ceoSeparationAprovals}}</span></a>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </li>
                        {{--                            </ul>--}}
                        {{--                        </li>--}}
                    @endif

                    <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                    @if(in_array('16', $user_rights) )
                        <li class="menu-title">
                            <span>Recruitment</span>
                        </li>
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-user"></i> <span> Recruitment</span> <span
                                    class="menu-arrow"></span>
                                <span class="badge badge-pill bg-primary float-left">{{$myInterviews}}</span>
                            </a>
                            <ul style="display: none;">
                                <li class="submenu">
                                <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                                @if(in_array('16', $user_rights) )
                                    <li>
                                        <a class="{{ Request::is('hiringRequest') ? 'active' : '' }}"
                                           href="{{ url('hiringRequest') }}">Hiring Request</a>
                                    </li>

                                    <li>
                                        <a class="{{ Request::is('myInterViewList') ? 'active' : '' }}"
                                           href="{{ url('myInterViewList') }}">My Interviews <span
                                                class="badge badge-pill bg-primary float-right">{{$myInterviews}}</span>
                                        </a>
                                    </li>
                                @endif
                                <li class="submenu">
                                    <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                                    @if(in_array('6', $user_rights) )
                                        <a href="#" class=""><i class="la la-user"></i> <span>On Boarding</span>
                                            <span
                                                class="menu-arrow"></span></a>
                                        <ul style="display: none;">
                                            <li>
                                                <a class="{{ Request::is('jobTitles') ? 'active' : '' }}"
                                                   href="{{ url('jobTitles') }}">Job Description</a>
                                            </li>
                                            <li>
                                                <a class="{{ Request::is('jobApplicants') ? 'active' : '' }}"
                                                   href="{{ url('jobApplicants') }}">Applicants</a>
                                            </li>
                                            <li>
                                                <a class="{{ Request::is('rejectedJobApplicants') ? 'active' : '' }}"
                                                   href="{{ url('rejected-applicants') }}">Rejected</a>
                                            </li>
                                            <li>
                                                <a class="{{ Request::is('initialShortlist') ? 'active' : '' }}"
                                                   href="{{ url('initialShortlist') }}">Short Listed</a>
                                            </li>
                                            <li>
                                                <a class="{{ Request::is('shortListedForTest') ? 'active' : '' }}"
                                                   href="{{ url('shortListedForTest') }}">Short Listed - Test</a>
                                            </li>
                                            <li>
                                                <a class="{{ Request::is('shortListedForInterview') ? 'active' : '' }}"
                                                   href="{{ url('shortListedForInterview') }}">Short Listed -
                                                    Interview</a>
                                            </li>
                                            @if(\Illuminate\Support\Facades\Auth::id() == 9)
                                                <li>
                                                    <a class="{{ Request::is('shortListedForFinalInterview') ? 'active' : '' }}"
                                                       href="{{ url('shortListedForFinalInterview') }}">Short Listed -
                                                        Final
                                                        Interview (CEO)</a>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="{{ Request::is('ShortListByCEO') ? 'active' : '' }}"
                                                   href="{{ url('ShortListByCEO') }}">ShortList By CEO</a>
                                            </li>
                                            <li>
                                                <a class="{{ Request::is('appointmentList') ? 'active' : '' }}"
                                                   href="{{ url('appointmentList') }}">Appointment</a>
                                            </li>
                                            @endif
                                        </ul>
                                </li>
                            </ul>
                        </li>

                        <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                        @if(in_array('31', $user_rights) )
                            <li class="menu-title">
                                <span>Reports</span>
                            </li>
                            <li class="submenu">
                                <a href="#" class=""><i class="la la-user"></i> <span>HR Reports</span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li>
                                        <a class="{{ Request::is('editAttendanceRequestReport') ? 'active' : '' }}"
                                           href="{{ url('editAttendanceRequestReport') }}">Edit Attendance</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('attendance') ? 'active' : '' }}"
                                           href="{{ url('attendance') }}">Monthly Attendance View</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('attendanceReport') ? 'active' : '' }}"
                                           href="{{ url('attendanceReport') }}">Attendance Data</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('monthly-attendance-report') ? 'active' : '' }}"
                                           href="{{ url('monthly-attendance-report') }}">Monthly Attendance Report</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('leavesReport') ? 'active' : '' }}"
                                           href="{{ url('leavesReport') }}">Leaves (Admin)</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('ResignationReport') ? 'active' : '' }}"
                                           href="{{ url('ResignationReport') }}">Resignation</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('TerminationReport') ? 'active' : '' }}"
                                           href="{{ url('TerminationReport') }}">End Employment</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('interns-report') ? 'active' : '' }}"
                                           href="{{ url('interns-report') }}">Internships</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('separationReport') ? 'active' : '' }}"
                                           href="{{ url('separationReport') }}">Separation</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>


