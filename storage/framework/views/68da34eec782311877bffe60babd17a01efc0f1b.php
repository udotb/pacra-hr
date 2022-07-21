<?php $__env->startSection('content'); ?>
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="welcome-box">
                        <div class="welcome-img">
                            <img src="<?php echo e(asset('users/')); ?>/<?php echo e($userDP); ?>" alt="">
                        </div>
                        <div class="welcome-det">
                            <h3>Welcome, <?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?></h3>
                            <p><?php echo e(date("l, ")); ?> <?php echo e(date("d M Y")); ?> </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <section class="dash-section">
                        <h1 class="dash-sec-title">Today</h1>
                        <div class="dash-sec-content">


                            <div class="dash-info-list">
                                <a href="#" class="dash-card">
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class="fa fa-building-o"></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <?php if($check_ip == NULL): ?>
                                                <p>You are working from home today</p>
                                            <?php else: ?>
                                                <p>You are working from office today</p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="dash-card-avatars">
                                            <div class="e-avatar"><img src="<?php echo e(asset('users/')); ?>/<?php echo e($userDP); ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            


                        </div>
                    </section>

                    <section class="dash-section">
                        <h1 class="dash-sec-title">Tomorrow</h1>
                        <div class="dash-sec-content">
                            <div class="dash-info-list">
                                <div class="dash-card">
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class="fa fa-suitcase"></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <p><?php echo e($getEmpOnLeaveTomorrow->count()); ?> people will be away tomorrow</p>
                                        </div>
                                        <div class="dash-card-avatars">
                                            <?php $__currentLoopData = $getEmpOnLeaveTomorrow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getEmpOnLeave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(url('profile')); ?>/<?php echo e($getEmpOnLeave->user_id); ?>"
                                                   target="_blank" class="e-avatar"><img
                                                        src="<?php echo e(asset('users/')); ?>/<?php echo e($getEmpOnLeave->avatar_file); ?>"
                                                        alt=""></a>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="dash-section">
                        
                        <div class="dash-sec-content">


                            <div class="dash-info-list">
                                <div class="dash-card">
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <h3>Reporting To</h3>
                                        </div>
                                    </div>


                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class=""></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <h4><a href="<?php echo e(url('profile')); ?>/<?php echo e($reportingTo->first()->amID); ?>"
                                                   target="_blank"
                                                   style="color: #1f1f1f"><?php echo e($reportingTo->first()->AmName); ?></a></h4>

                                            
                                        </div>

                                        <div class="dash-card-avatars">
                                            <div class="e-avatar"><img
                                                    src="<?php echo e(asset('users/')); ?>/<?php echo e($reportingTo->first()->avatar_file); ?>"
                                                    alt=""></div>
                                        </div>

                                    </div>


                                    <br>
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <h3>Reportees </h3>
                                        </div>
                                    </div>


                                    <?php $__currentLoopData = $reportees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reportee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <div class="dash-card-container">
                                            <div class="dash-card-icon">
                                                <i class=""></i>
                                            </div>
                                            <div class="dash-card-content">
                                                <h4><a href="<?php echo e(url('profile')); ?>/<?php echo e($reportee->id); ?>" target="_blank"
                                                       style="color: #1f1f1f"><?php echo e($reportee->display_name); ?></a></h4>

                                                
                                            </div>

                                            <div class="dash-card-avatars">
                                                <div class="e-avatar"><img
                                                        src="<?php echo e(asset('users/')); ?>/<?php echo e($reportee->avatar_file); ?>" alt="">
                                                </div>
                                            </div>

                                        </div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </div>
                            </div>

                        </div>
                    </section>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="dash-sidebar">
                        <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                        <?php if(in_array('9', $user_rights) ): ?>
                            <section>
                                <h5 class="dash-title">Employees</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4><a href="<?php echo e(url('employees')); ?>" target="_blank"
                                                       style="color: #1f1f1f"><?php echo e($getActiveEmployee); ?></a></h4>
                                                <p>Total</p>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4><a href="<?php echo e(url('present-employees')); ?>" target="_blank"
                                                       style="color: #1f1f1f"><?php echo e($presentEmployees); ?></a></h4>
                                                <p>Present</p>
                                            </div>
                                        </div>
                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4><a href="<?php echo e(url('on-time')); ?>" target="_blank"
                                                       style="color: #1f1f1f"><?php echo e($onTimeEmployees); ?></a></h4>
                                                <p>On Time</p>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4><a href="<?php echo e(url('late-comers')); ?>" target="_blank"
                                                       style="color: #1f1f1f"><?php echo e($lateComersEmployees); ?></a></h4>
                                                <p>Late Comers</p>
                                            </div>
                                        </div>

                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <?php if($absentEmployeesIf == 0): ?>
                                                    <h4><a href="<?php echo e(url('absentees')); ?>" target="_blank"
                                                           style="color: #1f1f1f"><?php echo e($absentEmployees); ?></a></h4>
                                                <?php else: ?>
                                                    <h4><a href="<?php echo e(url('absentees')); ?>" target="_blank"
                                                           style="color: #1f1f1f"><?php echo e($absentEmployeesIf); ?></a></h4>
                                                <?php endif; ?>
                                                <p>Absent</p>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4><a href="<?php echo e(url('on-leave')); ?>" target="_blank"
                                                       style="color: #1f1f1f"><?php echo e($onLeaveEmployees); ?></a></h4>
                                                <p>On Leave</p>
                                            </div>
                                        </div>

                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4><a href="<?php echo e(url('in-office')); ?>" target="_blank"
                                                       style="color: #1f1f1f"><?php echo e($getEmployeesInOffice); ?></a></h4>
                                                <p>In Office</p>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4><a href="<?php echo e(url('anywhere-emp')); ?>" target="_blank"
                                                       style="color: #1f1f1f"><?php echo e($getAnywhereEmployees); ?></a></h4>
                                                <p>Anywhere</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>                            <?php endif; ?>


                                <h5 class="dash-title">Your Annual Leave Balanve</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4>
                                                    <?php echo e(!empty($getLeaveTaken) ? $getLeaveTaken: '0'); ?>

                                                </h4>
                                                <p>Leaves Taken</p>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4>
                                                    <?php echo e(!empty($getLeaveBalance->first()->current_balance) ? $getLeaveBalance->first()->current_balance: '0'); ?>

                                                </h4>
                                                <p>Remaining</p>
                                            </div>
                                        </div>
                                        <div class="request-btn">
                                            <a class="btn btn-primary" href="<?php echo e(route('leave_application')); ?>">Apply
                                                Leave</a>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section>
                                <h5 class="dash-title">Upcoming Holiday</h5>
                                <div class="card">
                                    <div class="card-body text-left">
                                        <?php $__currentLoopData = $upcomingHoliday; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$holiday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <h4><a href="<?php echo e(url('holidays')); ?>" target="_blank"
                                                   style="color: #1f1f1f"><?php echo e(1+$index); ?> - <?php echo e($holiday->holiday_name); ?>

                                                    - <?php echo e(date('d M Y', strtotime($holiday->from_date))); ?></a></h4>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </section>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/employee_dashboard.blade.php ENDPATH**/ ?>