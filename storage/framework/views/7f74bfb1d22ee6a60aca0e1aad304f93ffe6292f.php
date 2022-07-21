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
        
        <!-- /Leave Statistics -->

            <!-- Search Filter -->
        
        <!-- /Search Filter -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable"
                               id="data_table">
                            <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>No of Days</th>
                                <th>Reason</th>
                                <th class="text-center">Status</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php if(\Illuminate\Support\Facades\Auth::id() == 9): ?>
                                <?php echo e(dd('dd')); ?>

                                <?php $__currentLoopData = $ceoApproval; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$approvals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index+1); ?></td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="<?php echo e(url('profile')); ?>/<?php echo e($approvals->user_id); ?>" class="avatar"
                                                   target="_blank"><img alt="" src="users/<?php echo e($approvals->avatar_file); ?>"></a>
                                                <a href="<?php echo e(url('profile')); ?>/<?php echo e($approvals->user_id); ?>"
                                                   target="_blank"><?php echo e($approvals->display_name); ?>

                                                    <span><?php echo e($approvals->designation); ?></span></a>
                                            </h2>
                                        </td>
                                        <td><?php echo e($approvals->leaveType); ?></td>
                                        <td><?php echo e($approvals->from_date); ?></td>
                                        <td><?php echo e($approvals->to_date); ?></td>
                                        <td><?php echo e($approvals->leave_days); ?></td>
                                        <td><?php echo e($approvals->reason); ?></td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                <?php if($approvals->status == 'Entered'): ?>
                                                    <a class="dropdown-item"
                                                       href="<?php echo e(url('leave_edit')); ?>/<?php echo e($approvals->leaveID); ?>"
                                                       target="_blank"><i class="fa fa-dot-circle-o text-info"></i>
                                                        Pending</a>
                                                <?php elseif($approvals->status == 'Recommend'): ?>

                                                    <a class="dropdown-item"
                                                       href="<?php echo e(url('leave_edit')); ?>/<?php echo e($approvals->leaveID); ?>"
                                                       target="_blank"><i class="fa fa-dot-circle-o text-info"></i>Recommended</a>
                                                <?php else: ?>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-success"></i> Approved</a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <?php $__currentLoopData = $pendingApprovals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$approvals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index+1); ?></td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="<?php echo e(url('profile')); ?>/<?php echo e($approvals->user_id); ?>" class="avatar"
                                                   target="_blank"><img alt="" src="users/<?php echo e($approvals->avatar_file); ?>"></a>
                                                <a href="<?php echo e(url('profile')); ?>/<?php echo e($approvals->user_id); ?>"
                                                   target="_blank"><?php echo e($approvals->display_name); ?>

                                                    <span><?php echo e($approvals->designation); ?></span></a>
                                            </h2>
                                        </td>
                                        <td><?php echo e($approvals->leaveType); ?></td>
                                        <td><?php echo e($approvals->from_date); ?></td>
                                        <td><?php echo e($approvals->to_date); ?></td>
                                        <td><?php echo e($approvals->leave_days); ?></td>
                                        <td><?php echo e($approvals->reason); ?></td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                <?php if($approvals->status == 'Entered'): ?>
                                                    <a class="dropdown-item"
                                                       href="<?php echo e(url('leave_edit')); ?>/<?php echo e($approvals->leaveID); ?>"
                                                       target="_blank"><i class="fa fa-dot-circle-o text-info"></i>
                                                        Pending</a>
                                                <?php elseif($approvals->status == 'Recommend'): ?>
                                                    <a class="dropdown-item"
                                                       href="<?php echo e(url('leave_edit')); ?>/<?php echo e($approvals->leaveID); ?>"
                                                       target="_blank"><i class="fa fa-dot-circle-o text-info"></i>Recommended</a>
                                                <?php else: ?>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-success"></i> Approved</a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/leavesApprovals.blade.php ENDPATH**/ ?>