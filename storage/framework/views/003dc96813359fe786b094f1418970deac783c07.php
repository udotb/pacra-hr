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

                            <li class="<?php echo e(Request::is('index') ? 'active' : ''); ?>">
                                <a href="<?php echo e(url('index')); ?>">My Dashboard</a></li>
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
                                <a class="<?php echo e(Request::is('attendance_employee') ? 'active' : ''); ?>"
                                   href="<?php echo e(url('attendance_employee')); ?>">Attendance (Employee)</a>
                            </li>
                            <li>
                                <a class="<?php echo e(Request::is('wfh') ? 'active' : ''); ?>" href="<?php echo e(url('wfh')); ?>">WFH
                                    Application</a>
                            </li>
                            <li>
                                <a class="<?php echo e(Request::is('siteVisit') ? 'active' : ''); ?>" href="<?php echo e(url('siteVisit')); ?>">Client
                                    Visit Application</a>
                            </li>
                            <li>
                                <a class="<?php echo e(Request::is('attendance_report') ? 'active' : ''); ?>"
                                   href="<?php echo e(url('attendance_report')); ?>">Today Attendance Report</a>
                            </li>
                            <li>
                                <a class="<?php echo e(Request::is('leave_application') ? 'active' : ''); ?>"
                                   href="<?php echo e(url('leave_application')); ?>">Leave Application</a>
                            </li>
                            <li>
                                <a class="<?php echo e(Request::is('leave_history') ? 'active' : ''); ?>"
                                   href="<?php echo e(url('leave_history')); ?>">Leave History</a>
                            </li>
                            <li>
                                <a class="<?php echo e(Request::is('holidays') ? 'active' : ''); ?>" href="<?php echo e(url('holidays')); ?>">Holidays</a>
                            </li>
                            <li>
                                <a class="<?php echo e(Request::is('employees') ? 'active' : ''); ?>" href="<?php echo e(url('employees')); ?>">Personnel</a>
                            </li>
                            <li>
                                <a class="<?php echo e(Request::is('resignation') ? 'active' : ''); ?>"
                                   href="<?php echo e(url('resignation')); ?>">Separation</a>
                            </li>
                            <li>
                                <a class="<?php echo e(Request::is('reimbursement') ? 'active' : ''); ?>"
                                   href="<?php echo e(url('reimbursement')); ?>">Reimbursement</a>
                            </li>
                        </ul>
                    </li>

                    <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                    <?php if(in_array('10', $user_rights) || in_array('36', $user_rights)): ?>
                        <li class="menu-title">
                            <span>HR</span>
                        </li>
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-user"></i> <span> Human Resource</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                                <?php if(in_array('10', $user_rights) ): ?>
                                    <li>
                                        <a class="<?php echo e(Request::is('leavers') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('leavers')); ?>">Leavers</a></li>
                                    <li>
                                        <a class="<?php echo e(Request::is('get_departments') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('get_departments')); ?>">Departments</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('get_designations') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('get_designations')); ?>">Designations</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('MbAttendance') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('MbAttendance')); ?>">Mark MB Attendance</a>
                                    </li>
                                <?php endif; ?>
                                <?php if(in_array('36', $user_rights) ): ?>
                                    <li>
                                        <a class="<?php echo e(Request::is('hr-trainings') ? 'active' : ''); ?>"
                                           href="<?php echo e(route('HrTrainings')); ?>">HR Trainings</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                    <?php if(in_array('16', $user_rights) ): ?>
                        <li class="menu-title">
                            <span>Approvals</span>
                        </li>
                        
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
                        
                        
                        
                        
                        
                        
                        

                        
                        
                        <li class="submenu">
                            <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                            <?php if(in_array('6', $user_rights) ): ?>
                                <a href="#" class=""><i class="la la-user"></i> <span>HR Approvals</span> <span
                                        class="badge badge-pill bg-primary float-left"> <?php echo e($sumOfHrApproval); ?></span>
                                    <span class="menu-arrow"></span> </a>
                                <ul style="display: none;">
                                    <li>
                                        <a class="<?php echo e(Request::is('employees_approval') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('employees_approval')); ?>">Employees Approval <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($hrEmployeeApprovals); ?></span></a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('leave_approvalsHr') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('leave_approvalsHr')); ?>">Leaves Approval <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($hrLeaveApprovals); ?></span></a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('wfh_approvals_list') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('wfh_approvals_list')); ?>">WFH Approval <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($hrWFHApprovals); ?></span></a>
                                    </li>
                                    
                                    
                                    
                                    
                                    
                                    
                                    <li>
                                        <a class="<?php echo e(Request::is('editAttendanceRequestListHR') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('editAttendanceRequestListHR')); ?>">Attendance Edit <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($hrEditAttendanceApprovals); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('separationHR') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('separationHR')); ?>">Separation HR <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($hrSeparationApprovals); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('hiringRequestAuthenticate') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('hiringRequestAuthenticate')); ?>">Hiring Request <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($HRHiringRequestApproval); ?> </span>
                                        </a>
                                    </li>
                                </ul>
                            <?php endif; ?>
                        </li>
                        <li class="submenu">
                            <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                            <?php if(in_array('16', $user_rights) ): ?>
                                <a href="#" class=""><i class="la la-user"></i> <span>TL Approvals</span> <span
                                        class="menu-arrow"></span>
                                    <span
                                        class="badge badge-pill bg-primary float-left">
												<?php if(in_array('22', $user_rights) ): ?>
                                            <?php echo e($sumOfTlAllroval + $mitSeparationAprovals); ?>

                                        <?php elseif(in_array('23', $user_rights) ): ?>
                                            <?php echo e($sumOfTlAllroval + $adminSeparationAprovals); ?>

                                        <?php elseif(in_array('25', $user_rights) ): ?>
                                            <?php echo e($sumOfTlAllroval + $financeSeparationAprovals + $financeSettlementAprovals); ?>

                                        <?php elseif(in_array('26', $user_rights) ): ?>
                                            <?php echo e($sumOfTlAllroval + $ceoSeparationAprovals); ?>

                                        <?php else: ?>
                                            <?php echo e($sumOfTlAllroval); ?>

                                        <?php endif; ?>
											</span>
                                </a>
                                <ul style="display: none;">
                                    <li>
                                        <a class="<?php echo e(Request::is('leave_approvals') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('leave_approvals')); ?>">Leaves Approval <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($tlLeaveApprovals); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('wfh_approvals_list') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('wfh_approvals_list')); ?>">WFH Approval <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($tlWFHApprovals); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('siteVisit_approvals_list') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('siteVisit_approvals_list')); ?>">Client Visit Approval
                                            <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($tlClientVisitpprovals); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('resignationApprovals') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('resignationApprovals')); ?>">Resignation <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($tlResignationAprovals); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('terminationApprovals') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('terminationApprovals')); ?>">End Employment <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($tlTerminationAprovals); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('end-internship-approval') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('end-internship-approval')); ?>">Internships <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($tlEndInternshipAprovals); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('TlSeparationList') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('TlSeparationList')); ?>">Separation <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($tlSeparationAprovals); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('editAttendanceRequestList') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('editAttendanceRequestList')); ?>">Attendance Edit <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($tlEditAttendanceApprovals); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('hiringRequestApprovel') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('hiringRequestApprovel')); ?>">Hiring Request <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($TlHiringRequestApproval); ?></span></a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('reimbursement-approval') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('reimbursement-approval')); ?>">Reimbursement <span
                                                class="badge badge-pill bg-primary float-right"> <?php echo e($TlReimbursementApproval); ?></span></a>
                                    </li>
                                    <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                                    <?php if(in_array('22', $user_rights) ): ?>
                                        <li>
                                            <a class="<?php echo e(Request::is('separationMIT') ? 'active' : ''); ?>"
                                               href="<?php echo e(url('separationMIT')); ?>">Separation MIT <span
                                                    class="badge badge-pill bg-primary float-right"> <?php echo e($mitSeparationAprovals); ?></span></a>
                                        </li>

                                    <?php elseif(in_array('23', $user_rights)): ?>
                                        <li>
                                            <a class="<?php echo e(Request::is('separationAdmin') ? 'active' : ''); ?>"
                                               href="<?php echo e(url('separationAdmin')); ?>">Separation Admin <span
                                                    class="badge badge-pill bg-primary float-right"> <?php echo e($adminSeparationAprovals); ?></span></a>
                                        </li>
                                    <?php elseif(in_array('25', $user_rights)): ?>
                                        <li>
                                            <a class="<?php echo e(Request::is('separationFinance') ? 'active' : ''); ?>"
                                               href="<?php echo e(url('separationFinance')); ?>">Separation Finance <span
                                                    class="badge badge-pill bg-primary float-right"> <?php echo e($financeSeparationAprovals); ?></span></a>
                                        </li>
                                        <li>
                                            <a class="<?php echo e(Request::is('separationFinancesettlementFinance') ? 'active' : ''); ?>"
                                               href="<?php echo e(url('settlementFinance')); ?>">Settlement <span
                                                    class="badge badge-pill bg-primary float-right"> <?php echo e($financeSettlementAprovals); ?></span></a>
                                        </li>
                                        <li>
                                            <a class="<?php echo e(Request::is('reimbursement-approval') ? 'active' : ''); ?>"
                                               href="<?php echo e(url('reimbursement-approval')); ?>">Reimbursement Finance <span
                                                    class="badge badge-pill bg-primary float-right"> <?php echo e($FinanceReimbursementApproval); ?></span></a>
                                        </li>
                                    <?php elseif(in_array('26', $user_rights)): ?>
                                        <li>
                                            <a class="<?php echo e(Request::is('separationCEO') ? 'active' : ''); ?>"
                                               href="<?php echo e(url('separationCEO')); ?>">Separation CEO <span
                                                    class="badge badge-pill bg-primary float-right"> <?php echo e($ceoSeparationAprovals); ?></span></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                        
                        
                    <?php endif; ?>

                    <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                    <?php if(in_array('16', $user_rights) ): ?>
                        <li class="menu-title">
                            <span>Recruitment</span>
                        </li>
                        <li class="submenu">
                            <a href="#" class=""><i class="la la-user"></i> <span> Recruitment</span> <span
                                    class="menu-arrow"></span>
                                <span class="badge badge-pill bg-primary float-left"><?php echo e($myInterviews); ?></span>
                            </a>
                            <ul style="display: none;">
                                <li class="submenu">
                                <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                                <?php if(in_array('16', $user_rights) ): ?>
                                    <li>
                                        <a class="<?php echo e(Request::is('hiringRequest') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('hiringRequest')); ?>">Hiring Request</a>
                                    </li>

                                    <li>
                                        <a class="<?php echo e(Request::is('myInterViewList') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('myInterViewList')); ?>">My Interviews <span
                                                class="badge badge-pill bg-primary float-right"><?php echo e($myInterviews); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li class="submenu">
                                    <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                                    <?php if(in_array('6', $user_rights) ): ?>
                                        <a href="#" class=""><i class="la la-user"></i> <span>On Boarding</span>
                                            <span
                                                class="menu-arrow"></span></a>
                                        <ul style="display: none;">
                                            <li>
                                                <a class="<?php echo e(Request::is('jobTitles') ? 'active' : ''); ?>"
                                                   href="<?php echo e(url('jobTitles')); ?>">Job Description</a>
                                            </li>
                                            <li>
                                                <a class="<?php echo e(Request::is('jobApplicants') ? 'active' : ''); ?>"
                                                   href="<?php echo e(url('jobApplicants')); ?>">Applicants</a>
                                            </li>
                                            <li>
                                                <a class="<?php echo e(Request::is('rejectedJobApplicants') ? 'active' : ''); ?>"
                                                   href="<?php echo e(url('rejected-applicants')); ?>">Rejected</a>
                                            </li>
                                            <li>
                                                <a class="<?php echo e(Request::is('initialShortlist') ? 'active' : ''); ?>"
                                                   href="<?php echo e(url('initialShortlist')); ?>">Short Listed</a>
                                            </li>
                                            <li>
                                                <a class="<?php echo e(Request::is('shortListedForTest') ? 'active' : ''); ?>"
                                                   href="<?php echo e(url('shortListedForTest')); ?>">Short Listed - Test</a>
                                            </li>
                                            <li>
                                                <a class="<?php echo e(Request::is('shortListedForInterview') ? 'active' : ''); ?>"
                                                   href="<?php echo e(url('shortListedForInterview')); ?>">Short Listed -
                                                    Interview</a>
                                            </li>
                                            <?php if(\Illuminate\Support\Facades\Auth::id() == 9): ?>
                                                <li>
                                                    <a class="<?php echo e(Request::is('shortListedForFinalInterview') ? 'active' : ''); ?>"
                                                       href="<?php echo e(url('shortListedForFinalInterview')); ?>">Short Listed -
                                                        Final
                                                        Interview (CEO)</a>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <a class="<?php echo e(Request::is('ShortListByCEO') ? 'active' : ''); ?>"
                                                   href="<?php echo e(url('ShortListByCEO')); ?>">ShortList By CEO</a>
                                            </li>
                                            <li>
                                                <a class="<?php echo e(Request::is('appointmentList') ? 'active' : ''); ?>"
                                                   href="<?php echo e(url('appointmentList')); ?>">Appointment</a>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                </li>
                            </ul>
                        </li>

                        <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                        <?php if(in_array('31', $user_rights) ): ?>
                            <li class="menu-title">
                                <span>Reports</span>
                            </li>
                            <li class="submenu">
                                <a href="#" class=""><i class="la la-user"></i> <span>HR Reports</span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li>
                                        <a class="<?php echo e(Request::is('editAttendanceRequestReport') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('editAttendanceRequestReport')); ?>">Edit Attendance</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('attendance') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('attendance')); ?>">Monthly Attendance View</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('attendanceReport') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('attendanceReport')); ?>">Attendance Data</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('monthly-attendance-report') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('monthly-attendance-report')); ?>">Monthly Attendance Report</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('leavesReport') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('leavesReport')); ?>">Leaves (Admin)</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('ResignationReport') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('ResignationReport')); ?>">Resignation</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('TerminationReport') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('TerminationReport')); ?>">End Employment</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('interns-report') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('interns-report')); ?>">Internships</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Request::is('separationReport') ? 'active' : ''); ?>"
                                           href="<?php echo e(url('separationReport')); ?>">Separation</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php /**PATH E:\pacra-hrms\resources\views/layout/partials/nav.blade.php ENDPATH**/ ?>