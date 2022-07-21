<?php $__env->startSection('content'); ?>
    <style>
        .headline h4, .headline p {
            display: inline;
            vertical-align: top;
            /*font-family: 'Open Sans', sans-serif;*/
            /*font-size: 16px;*/
            line-height: 15px;
        }
    </style>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->

            <?php if(session()->has('message')): ?>
                <div class="alert alert-success">
                    <?php echo e(session()->get('message')); ?>

                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="card punch-status">
                        <div class="card-body">
                            <h5 class="card-title">Timesheet <small
                                    class="text-muted"><?php echo e(date("d-M-Y")); ?> <?php echo e(date("g:i:s A")); ?></small></h5>
                            <div class="stats-list">
                                <form method="POST" action="<?php echo e(route('mark_attendance')); ?>">
                                    <?php echo csrf_field(); ?>


                                    <?php if($attendanceActivity->isEmpty()): ?>
                                        <?php $ipAddresses = array('202.141.241.58', '125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58', '110.39.42.115', '37.120.148.134', '202.47.36.144', '110.93.217.146');?>
                                        <?php if(!in_array($ip_address, $ipAddresses)): ?>
                                            <div class="punch-det">
                                                <h6 class="alert alert-danger" role="alert">You are not in
                                                    Pacra...!!!</h6>

                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>

                                        <div class="punch-det">
                                            <h6>Punch In at</h6>
                                            <p><?php echo e(date("D, ")); ?> <?php echo e(date("d-M-Y")); ?>


                                                <?php echo e(!empty($today_attendance[0]->log_in_time) ? $today_attendance[0]->log_in_time: ''); ?>


                                            </p>
                                        </div>
                                    <?php endif; ?>






                                    <?php if($attendanceActivity->isEmpty()): ?>

                                        <div class="punch-info">
                                            <div class="punch-hours">
                                                <span>0.00 hrs</span>
                                            </div>
                                        </div>
                                        <div class="punch-btn-section">

                                            <input type="hidden" name="punch_in_value" value="punch_in"/>

                                            <?php $ipAddresses = array('202.141.241.58', '125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58', '110.39.42.115', '37.120.148.134', '202.47.36.144', '110.93.217.146', '127.0.0.1');?>

                                            <?php if(in_array($ip_address, $ipAddresses) ): ?>
                                                <button type="submit" name="punch_in"
                                                        class="btn btn-primary punch-btn">
                                                    Punch In
                                                </button>
                                            <?php elseif(!in_array($ip_address, $ipAddresses)and $chkWFH == null and $chkClientVsit == null and $chkClientVsitTeam == null): ?>
                                                <h6 class="alert alert-danger" role="alert">You are not allowed to
                                                    mark
                                                    attendance from home...!!!</h6>
                                            <?php elseif(!in_array($ip_address, $ipAddresses)and ($chkWFH <> null or $chkClientVsit <> null or $chkClientVsitTeam <> null)): ?>
                                                <button type="submit" name="punch_in"
                                                        class="btn btn-primary punch-btn">
                                                    Punch In
                                                </button>
                                            <?php else: ?>
                                                <h6 class="alert alert-danger" role="alert">You are not allowed to
                                                    mark
                                                    attendance from home...!!!</h6>
                                            <?php endif; ?>
                                        </div>

                                    <?php elseif($attendanceActivity[0]->activity=='punch_out'): ?>

                                        <div class="punch-info">
                                            <div class="punch-hours">
                                                <span>0.00 hrs</span>
                                            </div>
                                        </div>
                                        <div class="punch-btn-section">
                                            
                                            <input type="hidden" name="punch_in_value" value="punch_in"/>
                                            <button type="submit" name="punch_in" class="btn btn-primary punch-btn">
                                                Punch In
                                            </button>
                                        </div>

                                    <?php else: ?>

                                        <div class="punch-info">
                                            <div class="punch-hours">
                                                <?php $__currentLoopData = $maxPunchIn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                    $log_in_time = $attendance->time;
                                                    $current_time = date("H:i:s ");

                                                    $Interval = (strtotime($current_time) - strtotime($log_in_time)); ?>

                                                    <span><?php echo e(gmdate("H:i", $Interval)); ?> hrs</span>
                                                    <input type="hidden" name="office_hours"
                                                           value=<?php echo e(gmdate("H:i:s", $Interval)); ?> />
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                        <div class="punch-btn-section">
                                            <?php $ipAddresses = array('202.141.241.58', '125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58', '110.39.42.115', '37.120.148.134', '202.47.36.144', '110.93.217.146');?>

                                            <?php if(in_array($ip_address, $ipAddresses) || count($chkWFH) > 0 || count($chkClientVsit) > 0 || count($chkClientVsitTeam) > 0 ): ?>
                                                <input type="hidden" name="punch_in_value" value="punch_out"/>
                                                <button type="submit" name="punch_out"
                                                        class="btn btn-primary punch-btn">
                                                    Punch Out
                                                </button>
                                            <?php else: ?>
                                                <h6 class="alert alert-danger" role="alert">You are only allowed to
                                                    Punch Out within PACRA</h6>
                                            <?php endif; ?>
                                            
                                        </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card recent-activity">
                        <div class="card-body">
                            <h5 class="card-title">Today Activity</h5>
                            <ul class="res-activity-list">

                                <?php $__currentLoopData = $todayAttendanceActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <p class="mb-0">
                                            <?php if($activity->activity == 'punch_in'): ?>
                                                <?php echo e('Punch In at'); ?>

                                            <?php else: ?>
                                                <?php echo e('Punch Out at'); ?>

                                            <?php endif; ?>
                                        </p>
                                        <p class="res-activity-time">
                                            <i class="fa fa-clock-o"></i>
                                            <?php echo e(date("g:i A", strtotime($activity->time))); ?>


                                        </p>
                                    </li>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card att-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Statistics (Month to Date)</h5>
                            <div class="stats-list">
                                <div class="stats-info">
                                    <p>On Time <strong><?php echo e($ontime_statistics); ?> <small>/ <?php echo e($diffInMonthdays); ?>

                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                             style="width: <?php echo e($ontime_statistics/$diffInMonthdays*100); ?>%"
                                             aria-valuenow="<?php echo e($ontime_statistics/365*100); ?>" aria-valuemin="0"
                                             aria-valuemax="365"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Late Coming <strong><?php echo e($late_statistics); ?> <small>/ <?php echo e($diffInMonthdays); ?>

                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                             style="width: <?php echo e($late_statistics/$diffInMonthdays*100); ?>%"
                                             aria-valuenow="<?php echo e($late_statistics/365*100); ?>" aria-valuemin="0"
                                             aria-valuemax="50"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Leaves <strong><?php echo e($leave_statistics); ?> <small>/ <?php echo e($diffInMonthdays); ?>

                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             style="width: <?php echo e($leave_statistics/$diffInMonthdays*100); ?>%"
                                             aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Absent <strong><?php echo e($absent_statistics); ?> <small>/ <?php echo e($diffInMonthdays); ?>

                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                             style="width: <?php echo e($absent_statistics/$diffInMonthdays*100); ?>%"
                                             aria-valuenow="<?php echo e($absent_statistics/365*100); ?>" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Public Holiday | Weekend <strong><?php echo e($holiday_statistics); ?>

                                            | <?php echo e($weekend_statistics); ?></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: <?php echo e($holiday_statistics+$weekend_statistics/$diffInMonthdays*100); ?>%"
                                             aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card att-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Statistics (Year to Date)</h5>
                            <div class="stats-list">
                                <div class="stats-info">
                                    <p>On Time <strong><?php echo e($ontime_statisticsYear); ?> <small>/ <?php echo e($yearToDateDays); ?>

                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                             style="width: <?php echo e($ontime_statisticsYear/$yearToDateDays*100); ?>%"
                                             aria-valuenow="<?php echo e($ontime_statistics/365*100); ?>" aria-valuemin="0"
                                             aria-valuemax="365"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Late Coming <strong><?php echo e($late_statisticsYear); ?> <small>/ <?php echo e($yearToDateDays); ?>

                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                             style="width: <?php echo e($late_statisticsYear/$yearToDateDays*100); ?>%"
                                             aria-valuenow="<?php echo e($late_statistics/365*100); ?>" aria-valuemin="0"
                                             aria-valuemax="50"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Leaves <strong><?php echo e($leave_statisticsYear); ?> <small>/ <?php echo e($yearToDateDays); ?>

                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             style="width: <?php echo e($leave_statisticsYear/$yearToDateDays*100); ?>%"
                                             aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Absent <strong><?php echo e($absent_statisticsYear); ?> <small>/ <?php echo e($yearToDateDays); ?>

                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                             style="width: <?php echo e($absent_statisticsYear/$yearToDateDays*100); ?>%"
                                             aria-valuenow="<?php echo e($absent_statistics/365*100); ?>" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Public Holiday | Weekend <strong><?php echo e($holiday_statisticsYear); ?>

                                            | <?php echo e($weekend_statisticsYear); ?></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: <?php echo e($holiday_statisticsYear+$weekend_statisticsYear/$yearToDateDays*100); ?>%"
                                             aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card recent-activity">
                        <div class="card-body">
                            <div class="card-title headline" style="white-space: nowrap">
                                <h4>Your Leave</h4>
                                <p style="color: #777777; display: inline;vertical-align: top;">
                                    from: <?php echo e(date('d-M', strtotime($currentMonthStart ?? ''))); ?> - Up Till Now
                                </p>
                            </div>
                            <div class="time-list">
                                <div class="dash-stats-list">
                                    <h4><?php echo e(number_format((float)$leavesPerMonth, 2, '.', '')); ?></h4>
                                    <p>Entitled</p>
                                </div>
                                <div class="dash-stats-list">
                                    <h4><?php echo e($getLeaveTaken); ?></h4>
                                    <p>Taken</p>
                                </div>
                                <div class="dash-stats-list">
                                    <h4><?php echo e(number_format((float)$getLeaveBalance, 2, '.', '')); ?></h4>
                                    
                                    <p>Remaining</p>
                                </div>
                            </div>
                            <div class="request-btn">
                                <a href="<?php echo e(route('leave_application')); ?>" class="btn btn-primary punch-btn">
                                    <i class="fa fa-plus"></i>Apply Leave</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Filter -->


            <form method="POST" action="<?php echo e(route('get_employee_attendance_report')); ?>">
                <?php echo csrf_field(); ?>
                <div class="row filter-row">
                    <div class="col-sm-4">
                        <div class="form-group form-focus">
                            <div class="form-group">

                                <input class="form-control " type="date" name="from_date" required="required">
                            </div>
                            <label class="focus-label">Select Start Date</label>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group form-focus">
                            <div class="form-group">

                                <input class="form-control " type="date" name="to_date" required="required">
                            </div>
                            <label class="focus-label">Select End Date</label>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo e($userId); ?>">


                    <div class="col-sm-4">
                        <button class="btn btn-success btn-block ">Get Report</button>


                    </div>
                </div>
            </form>


            <!-- /Search Filter -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Punch In</th>
                                <th>Punch Out</th>
                                <th>Office Hours</th>
                                <th>Status</th>
                                
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php $__currentLoopData = $last_two_days_attendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index +1); ?></td>
                                    <td><?php echo e($attendance->date); ?></td>
                                    <td><?php echo e($attendance->log_in_time); ?></td>
                                    <?php if($attendance->punch_out_status == 'Auto Punch Out'): ?>
                                        <td style="color: red"><?php echo e($attendance->log_out_time); ?></td>
                                    <?php else: ?>
                                        <td><?php echo e($attendance->log_out_time); ?></td>
                                    <?php endif; ?>
                                    <?php    $log_in_time = $attendance->log_in_time;
                                    $Interval = (strtotime($attendance->log_out_time) - strtotime($log_in_time)); ?>

                                    <td>
                                        <?php echo e(!empty($attendance->log_out_time) ? gmdate("H:i", $Interval): ''); ?>

                                    </td>
                                    <td><?php echo e($attendance->title); ?></td>
                                    
                                    <td>

                                        
                                        <?php if($attendance->date == carbon\carbon::now()->toDateString() and (empty($checkEditAttendanceApp->first()->id)) ): ?>
                                            <a href="<?php echo e(route('editAttendanceRequest')); ?>/<?php echo e($attendance->attendanceRecordID); ?>"
                                               target="_blank"><?php echo e('Edit'); ?></a>

                                        <?php endif; ?>
                                    </td>


                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- Page Wrapper -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/attendance_employee.blade.php ENDPATH**/ ?>