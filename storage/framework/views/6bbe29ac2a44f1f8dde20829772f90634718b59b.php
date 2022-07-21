<?php $__env->startSection('content'); ?>
<!-- Page Wrapper -->
<div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title"><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?></h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                                <li class="breadcrumb-item active"><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?></li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- /Page Header -->
                <!-- Leave Statistics -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="stats-info">
                            <h6>Annual Leaves</h6>
                            <h4>N/A</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-info">
                            <h6>Entitled/Month Leaves</h6>
                            <h4><?php echo e(number_format((float)$leavesPerMonth, 2, '.', '')); ?></h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-info">
                            <h6>Taken Leaves</h6>
                            <h4><?php echo e($getLeaveTaken); ?></h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-info">
                            <h6>Remaining Leaves</h6>
                            <h4><?php echo e($getLeaveBalance->first()->current_balance); ?></h4>
                        </div>
                    </div>
                </div>
                <!-- /Leave Statistics -->

                <div class="row">
                    <div class="col-md-12">

                        <!-- Add Leave Modal -->

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Add Leave</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="<?php echo e(route('leave_approvals')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-group">
                                                <label>Leave Type <span class="text-danger">*</span></label>
                                                <select name="leave_type" required="required" class="select">
                                                    <option value="<?php echo e($leaveDetails[0]->id); ?>"> <?php echo e($leaveDetails[0]->name); ?></option>
                                                    <option value=""> <?php echo e('Select Leave Type'); ?></option>
                                                    <?php $__currentLoopData = $leaves_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaves_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option value="<?php echo e($leaves_type->id); ?>"> <?php echo e($leaves_type->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>From <span class="text-danger">*</span></label>
                                                <div class="">

                                                    <input class="form-control " type="date" name="from_date" value="<?php echo e(!empty($leaveDetails[0]->from_date) ? $leaveDetails[0]->from_date: ''); ?>" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>To <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input class="form-control " type="date" name="to_date" value="<?php echo e(!empty($leaveDetails[0]->to_date) ? $leaveDetails[0]->to_date: ''); ?>" required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Leave Reason <span class="text-danger">*</span></label>
                                                <textarea rows="4" class="form-control" name="reason"  required="required"><?php echo e(!empty($leaveDetails[0]->reason) ? $leaveDetails[0]->reason: ''); ?></textarea>
                                            </div>
                                            <input type="hidden" name="leaveID" value="<?php echo e(!empty($leaveID) ? $leaveID: ''); ?>">
                                            <input type="hidden" name="user_id" value="<?php echo e(!empty($leaveDetails[0]->user_id) ? $leaveDetails[0]->user_id: ''); ?>">


                                            


                                            <div class="submit-section">
                                                <?php if($leaveDetails[0]->status == 'Recommend' and (in_array('6', $user_rights)) ): ?>
                                                    <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Approve"> Approve</button>
                                                    <button  class="btn btn-primary submit-btn btn-danger" name="submit" type="submit" value="Decline"> Decline</button>

                                                <?php elseif($leaveDetails[0]->status == 'Entered' and (in_array('16', $user_rights)) ): ?>
                                                    <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Recommend"> Recommend</button>
                                                    <button  class="btn btn-primary submit-btn btn-danger" name="submit" type="submit" value="Decline"> Decline</button>

                                                <?php elseif($leaveDetails[0]->status == 'Approved' or $leaveDetails[0]->status == 'Recommend' or $leaveDetails[0]->status == 'Decline' ): ?>
                                                    <?php echo e('You already'); ?> <?php echo e($leaveDetails[0]->status); ?> <?php echo e('this application'); ?>


                                                <?php else: ?>
                                                    <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Submit</button>

                                                <?php endif; ?>
                                            </div>

                                        </form>
                                    </div>
                                </div>

                        <!-- /Add Leave Modal -->

                    </div>
                </div>
            </div>
            <!-- /Page Content -->



        </div>
        <!-- /Page Wrapper -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/leave_edit_approve.blade.php ENDPATH**/ ?>