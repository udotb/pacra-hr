
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
                            <li class="breadcrumb-item active"><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?>s</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->


            <div class="row">
                <div class="col-md-12">

                    <!-- Add Leave Modal -->

                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?></h3>
                        </div>
                        <div class="modal-body">
                            <?php if($getAttendanceApprovalDetail==null): ?>
                                <form method="POST" action="<?php echo e(route('editAttendanceRequest')); ?>"
                                      enctype="multipart/form-data" files="true">
                                    <?php echo csrf_field(); ?>

                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <div class="">

                                            <input class="form-control " type="date" name="date"
                                                   value="<?php echo e($getAttendanceDetail->first()->date); ?>" readonly
                                                   required="required">
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label>Select Reason <span class="text-danger">*</span></label>
                                        <select name="editReason" required="required" class="select">
                                            <option value=""> <?php echo e('Select Reason'); ?></option>
                                            <?php $__currentLoopData = $attendanceEditReason; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option value="<?php echo e($Reason->id); ?>"> <?php echo e($Reason->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Punch In Time <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control " type="time" name="punch_in"
                                                   required="required">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Attachment <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="file" name="file" id="file"
                                                   accept="image/x-png,image/gif,image/jpeg" required="required">
                                            <small id="fileHelp" class="form-text text-muted">Please upload only image
                                                file.</small>


                                        </div>
                                    </div>

                                    <input type="hidden" name="attendanceRecordID"
                                           value="<?php echo e($getAttendanceDetail->first()->id); ?>">
                                    <input type="hidden" name="old_punchIn"
                                           value="<?php echo e($getAttendanceDetail->first()->log_in_time); ?>">
                                    <input type="hidden" name="user_id" value="<?php echo e($userId); ?>">
                                    <input type="hidden" name="am_id" value="<?php echo e($amId); ?>">


                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="Entered"> Submit
                                        </button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="<?php echo e(route('editAttendanceRequest')); ?>">
                                    <?php echo csrf_field(); ?>

                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <div class="">

                                            <input class="form-control " type="date" name="date"
                                                   value="<?php echo e($getAttendanceApprovalDetail->first()->date); ?>" readonly
                                                   required="required">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Current Punch In Time <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control " type="time"
                                                   value="<?php echo e($getAttendanceApprovalDetail->first()->old_punch_in); ?>"
                                                   readonly required="required">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>New Punch In Time <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control " type="time" name="punch_in"
                                                   value="<?php echo e($getAttendanceApprovalDetail->first()->new_punch_in); ?>"
                                                   required="required">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label>Select Reason <span class="text-danger">*</span></label>
                                        <select name="editReason" required="required" class="select">
                                            <option
                                                value="<?php echo e($getAttendanceApprovalDetail->first()->attendance_edit_reason); ?>"> <?php echo e($getAttendanceApprovalDetail->first()->reason); ?></option>
                                            <option value=""> <?php echo e('Select Reason'); ?></option>

                                            <?php $__currentLoopData = $attendanceEditReason; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option value="<?php echo e($Reason->id); ?>"> <?php echo e($Reason->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>Attachment<span class="text-danger">*</span></label>
                                        <div class="">
                                            <a href="<?php echo e(asset('../storage/app/'.$getAttendanceApprovalDetail->first()->attachment)); ?>"
                                               target="_blank">View Attachment</a>

                                        </div>
                                    </div>


                                    <input type="hidden" name="attendanceRecordID"
                                           value="<?php echo e($getAttendanceApprovalDetail->first()->attendance_record); ?>">
                                    <input type="hidden" name="old_punchIn"
                                           value="<?php echo e($getAttendanceApprovalDetail->first()->old_punch_in); ?>">
                                    <input type="hidden" name="user_id"
                                           value="<?php echo e($getAttendanceApprovalDetail->first()->user_id); ?>">
                                    <input type="hidden" name="am_id"
                                           value="<?php echo e($getAttendanceApprovalDetail->first()->am_id); ?>">

                                    <div class="submit-section">
                                        <?php if($getAttendanceApprovalDetail->first()->status == 'Recommended' and (in_array('6', $user_rights)) ): ?>
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Approved"> Authenticate
                                            </button>
                                            <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                    type="submit" value="Declined-HR"> Decline
                                            </button>

                                        <?php elseif($getAttendanceApprovalDetail->first()->status == 'Entered' and (in_array('16', $user_rights)) ): ?>
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Recommended"> Recommend
                                            </button>
                                            <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                    type="submit" value="Declined"> Decline
                                            </button>

                                        <?php elseif($getAttendanceApprovalDetail->first()->status == 'Approved' or $getAttendanceApprovalDetail->first()->status == 'Recommended' or $getAttendanceApprovalDetail->first()->status == 'Declined' or $getAttendanceApprovalDetail->first()->status == 'Declined-HR' ): ?>
                                            <?php echo e('You already'); ?> <?php echo e($getAttendanceApprovalDetail->first()->status); ?> <?php echo e('this application'); ?>


                                        <?php else: ?>
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Entered"> Submit
                                            </button>

                                        <?php endif; ?>
                                    </div>


                                </form>
                            <?php endif; ?>
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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/editAttendance.blade.php ENDPATH**/ ?>