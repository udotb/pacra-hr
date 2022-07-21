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

            <!-- Leave Statistics -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Annual Leaves</h6>
                        <h4><?php echo e($getLeaveBalance); ?></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Entitled/Month Leaves</h6>
                        <h4><?php echo e($leavesPerMonth); ?></h4>
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

                    </div>
                </div>
            </div>
            <!-- /Leave Statistics -->

            <?php if(session()->has('message')): ?>
                <div class="alert alert-success">
                    <?php echo e(session()->get('message')); ?>

                </div>
            <?php endif; ?>
            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session()->get('error')); ?>

                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <h4><?php echo e($errors->first()); ?></h4>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12">

                    <!-- Add Leave Modal -->

                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Add Leave</h3>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?php echo e(route('add_leaves')); ?>" enctype="multipart/form-data"
                                  files="true">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <input type="hidden" , name="uid" value="<?php echo e($userId); ?>">
                                    <label>Leave Type <span class="text-danger">*</span></label>
                                    <select name="leave_type" required="required" class="select" id="type">
                                        <option value=""> <?php echo e('Select Leave Type'); ?></option>
                                        <?php $__currentLoopData = $leaves_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaves_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <option value="<?php echo e($leaves_type->id); ?>"> <?php echo e($leaves_type->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>From <span class="text-danger">*</span></label>
                                    <div class="">

                                        <input type="date" name="from_date"
                                               min="<?php echo e(\Carbon\Carbon::now()->subDays(15)->format('Y-m-d')); ?>"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>To <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input class="form-control " type="date" name="to_date" required="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Leave Reason <span class="text-danger">*</span></label>
                                    <textarea rows="4" class="form-control" name="reason"
                                              required="required"></textarea>
                                </div>
                                <div class="form-group" id="fileproof" style="display: none">
                                    <label>File Attachment <span class="text-danger">*</span></label>
                                    <input type="file" name="file" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid file.</small>
                                    <div class="alert alert-info" role="alert">
                                        <strong>Heads up!</strong> If Your Sick/ Maternity/ Paternity Leave Greater Than
                                        3
                                        Days Attachment is Compulsory.
                                    </div>
                                </div>


                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn btn-success" name="submit" type="submit"
                                            value="Entered"> Submit
                                    </button>
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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/leave_application.blade.php ENDPATH**/ ?>