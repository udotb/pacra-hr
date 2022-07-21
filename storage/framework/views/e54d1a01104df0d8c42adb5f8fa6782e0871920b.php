
<?php $__env->startSection('content'); ?>
<!-- Page Wrapper -->
<div class="page-wrapper">
			
            <!-- Page Content -->
            <div class="content container-fluid">
            
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Leaves</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                                <li class="breadcrumb-item active">Leaves</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- /Page Header -->
                
                <!-- Leave Statistics -->
                <div class="row">
                    <div class="col-md-3">
                        <?php if(Str::contains(Request::url(), 'leavesReport')): ?>
                        <div class="stats-info">
                            <h6>Today Presents</h6>
                            <h4><?php echo e($presentEmployees); ?>/<?php echo e($getActiveEmployee); ?></h4>
                        </div>
                            <?php else: ?>
                            <div class="stats-info">
                                <h6>Absent</h6>
                                <h4><?php echo e($absentStatus); ?></h4>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">

                        <?php if(Str::contains(Request::url(), 'leavesReport')): ?>
                            <div class="stats-info">
                                <h6>Planned Leaves</h6>
                                <h4><?php echo e($onLeaves); ?></h4>
                            </div>
                        <?php else: ?>
                            <div class="stats-info">
                                <h6>Planned Leaves</h6>
                                <h4><?php echo e($plannedLeaves); ?></h4>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="col-md-3">
                        <?php if(Str::contains(Request::url(), 'leavesReport')): ?>
                            <div class="stats-info">
                                <h6>Unplanned Leaves</h6>
                                <h4><?php echo e($absentemployees); ?></h4>
                            </div>
                        <?php else: ?>
                            <div class="stats-info">
                                <h6>Unplanned Leaves</h6>
                                <h4><?php echo e($unplannedLeaves); ?></h4>
                            </div>
                        <?php endif; ?>


                    </div>
                    <div class="col-md-3">
                        <div class="stats-info">
                            <h6>Pending Requests</h6>
                            <h4><?php echo e($pendingApprovedLeave); ?></h4>
                        </div>
                    </div>
                </div>
                <!-- /Leave Statistics -->
                
                <!-- Search Filter -->
                <form method="POST" action="<?php echo e(route('leavesReportFilter')); ?>">
                    <?php echo csrf_field(); ?>
                <div class="row filter-row">

                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">

                        <div class="form-group form-focus select-focus">
                            <select name="empId"  class="select floating">
                                <option value=""> -- Select -- </option>
                                <?php $__currentLoopData = $getActiveEmployeeNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($emp->id); ?>"><?php echo e($emp->display_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label class="focus-label">Employee Name</label>
                        </div>
                   </div>
                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                        <div class="form-group form-focus select-focus">
                            <select name="leaveType"  class="select floating">
                                <option value=""> -- Select -- </option>
                                <?php $__currentLoopData = $getLeaveTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaveType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($leaveType->id); ?>"><?php echo e($leaveType->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label class="focus-label">Leave Type</label>
                        </div>
                   </div>
                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12"> 
                        <div class="form-group form-focus select-focus">
                            <select name="leaveStatus" class="select floating">
                                <option value=""> -- Select -- </option>
                                <?php $__currentLoopData = $getLeaveStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status->status); ?>"><?php echo e($status->status); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label class="focus-label">Leave Status</label>
                        </div>
                   </div>
                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                        <div class="form-group form-focus">
                            <div class="">
                                <input class="form-control floating " name="from_date" type="date">
                            </div>
                            <label class="focus-label">From</label>
                        </div>
                    </div>
                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                        <div class="form-group form-focus">
                            <div class="">
                                <input class="form-control floating " name="to_date" type="date">
                            </div>
                            <label class="focus-label">To</label>
                        </div>
                    </div>
                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                       <button  class="btn btn-success btn-block" name="submit" type="submit" value="Entered"> Search</button>
                   </div>

                </div>
                </form>
                <!-- /Search Filter -->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Leave Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>No of Days</th>
                                        <th>Existing Balance</th>
                                        <th>New Balance</th>
                                        <th>Reason</th>
                                        <th class="text-center">Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $pendingApprovals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $approvals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="<?php echo e(url('profile')); ?>/<?php echo e($approvals->user_id); ?>" class="avatar" target="_blank"><img alt="" src="users/<?php echo e($approvals->avatar_file); ?>"></a>
                                                <a href="<?php echo e(url('profile')); ?>/<?php echo e($approvals->user_id); ?>" target="_blank"><?php echo e($approvals->display_name); ?> <span><?php echo e($approvals->designation); ?></span></a>
                                            </h2>
                                        </td>
                                        <td><?php echo e($approvals->leaveType); ?></td>
                                        <td><?php echo e($approvals->from_date); ?></td>
                                        <td><?php echo e($approvals->to_date); ?></td>
                                        <td><?php echo e($approvals->leave_days); ?></td>
                                        <td><?php echo e($approvals->existing_balance); ?></td>
                                        <td><?php echo e($approvals->new_balance); ?></td>
                                        <td><?php echo e($approvals->reason); ?></td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                <?php if($approvals->status == 'Entered'): ?>

                                                    <a class="dropdown-item" href="<?php echo e(url('leave_edit')); ?>/<?php echo e($approvals->leaveID); ?>" target="_blank"><i class="fa fa-dot-circle-o text-info"></i> Pending</a>
                                                <?php elseif($approvals->status == 'Recommend'): ?>

                                                    <a class="dropdown-item" href="<?php echo e(url('leave_edit')); ?>/<?php echo e($approvals->leaveID); ?>" target="_blank"><i class="fa fa-dot-circle-o text-info"></i>Recommended</a>

                                                <?php else: ?>
                                                    <a class="dropdown-item" href="<?php echo e(url('leave_edit')); ?>/<?php echo e($approvals->leaveID); ?>"><i class="fa fa-dot-circle-o text-success"></i> Approved</a>
                                                <?php endif; ?>
                                            </div>
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
        <!-- /Page Wrapper -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/leaves.blade.php ENDPATH**/ ?>