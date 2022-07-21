<?php $__env->startSection('content'); ?>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Attendance Report / <?php echo e($employee_attendance->first()->display_name); ?></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

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
                                <th>Location</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $__currentLoopData = $employee_attendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index +1); ?></td>
                                    <td><?php echo e($attendance->date); ?></td>
                                    <td><?php echo e($attendance->log_in_time); ?></td>
                                    <?php if($attendance->punch_out_status == 'Auto Punch Out'): ?>
                                        <td style="color: red"><?php echo e($attendance->log_out_time); ?></td>
                                    <?php else: ?>
                                        <td><?php echo e($attendance->log_out_time); ?></td>
                                    <?php endif; ?>                                    <?php    $log_in_time = $attendance->log_in_time;
                                    $Interval = (strtotime($attendance->log_out_time) - strtotime($log_in_time)); ?>
                                    <td><?php echo e(!empty($attendance->log_out_time) ? gmdate("H:i", $Interval): ''); ?></td>
                                    <td><?php echo e($attendance->Astatus); ?></td>
                                    <?php $ipAddresses = array('202.141.241.58', '125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58');?>
                                    <?php if($attendance->log_in_time == ''): ?>
                                        <td></td>
                                    <?php elseif(in_array($attendance->ip_address_login, $ipAddresses)): ?>
                                        <td><?php echo e('Office'); ?></td>
                                    <?php else: ?>
                                        <td><?php echo e('Any Where'); ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Attendance Modal -->
        <div class="modal custom-modal fade" id="attendance_info" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attendance Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card punch-status">
                                    <div class="card-body">
                                        <h5 class="card-title">Timesheet <small class="text-muted">11 Mar 2019</small>
                                        </h5>
                                        <div class="punch-det">
                                            <h6>Punch In at</h6>
                                            <p>Wed, 11th Mar 2019 10.00 AM</p>
                                        </div>
                                        <div class="punch-info">
                                            <div class="punch-hours">
                                                <span>3.45 hrs</span>
                                            </div>
                                        </div>
                                        <div class="punch-det">
                                            <h6>Punch Out at</h6>
                                            <p>Wed, 20th Feb 2019 9.00 PM</p>
                                        </div>
                                        <div class="statistics">
                                            <div class="row">
                                                <div class="col-md-6 col-6 text-center">
                                                    <div class="stats-box">
                                                        <p>Break</p>
                                                        <h6>1.21 hrs</h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-6 text-center">
                                                    <div class="stats-box">
                                                        <p>Overtime</p>
                                                        <h6>3 hrs</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card recent-activity">
                                    <div class="card-body">
                                        <h5 class="card-title">Activity</h5>
                                        <ul class="res-activity-list">
                                            <li>
                                                <p class="mb-0">Punch In at</p>
                                                <p class="res-activity-time">
                                                    <i class="fa fa-clock-o"></i>
                                                    10.00 AM.
                                                </p>
                                            </li>
                                            <li>
                                                <p class="mb-0">Punch Out at</p>
                                                <p class="res-activity-time">
                                                    <i class="fa fa-clock-o"></i>
                                                    11.00 AM.
                                                </p>
                                            </li>
                                            <li>
                                                <p class="mb-0">Punch In at</p>
                                                <p class="res-activity-time">
                                                    <i class="fa fa-clock-o"></i>
                                                    11.15 AM.
                                                </p>
                                            </li>
                                            <li>
                                                <p class="mb-0">Punch Out at</p>
                                                <p class="res-activity-time">
                                                    <i class="fa fa-clock-o"></i>
                                                    1.30 PM.
                                                </p>
                                            </li>
                                            <li>
                                                <p class="mb-0">Punch In at</p>
                                                <p class="res-activity-time">
                                                    <i class="fa fa-clock-o"></i>
                                                    2.00 PM.
                                                </p>
                                            </li>
                                            <li>
                                                <p class="mb-0">Punch Out at</p>
                                                <p class="res-activity-time">
                                                    <i class="fa fa-clock-o"></i>
                                                    7.30 PM.
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Attendance Modal -->

    </div>
    <!-- Page Wrapper -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/employee_attendance_report.blade.php ENDPATH**/ ?>