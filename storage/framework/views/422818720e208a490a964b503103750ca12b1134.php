
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

            <div class="row">
                <div class="col-md-12">
                    <div class="modal-content">

                        <!-- Employee Separation Form -->

                        <?php if(in_array('25', $userRights)): ?>
                        <!-- Employee Separation Form | Accounts  Section 7-->
                            <div class="card">
                                <div class="card-header">
                                    <h1 class="card-title mb-0">EMPLOYEE SEPARATION FORM</h1>
                                    <p class="card-text">Please respond to all statements, ‘✔’ if applicable / affirmative and ‘❌’ if not applicable / negative.</p>
                                </div>

                                <div class="card-header">
                                    <h4>Section - 5	| Accounts Function  | To be affirmed by respective Head </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm">


                                            <form method="POST" action="<?php echo e(route('addSeparation')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="validationDefault01">Name</label>
                                                        <input type="text" class="form-control" name="empName" value="<?php echo e($seprationDetails->first()->display_name); ?>" readonly>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="validationDefault02">Designation</label>
                                                        <input type="text" class="form-control" name="empDesignation" value="<?php echo e($seprationDetails->first()->designation); ?>" readonly>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="validationDefault02">Resignee Leave Balance</label>
                                                        <input type="text" class="form-control" name="leave" value="<?php echo e($leaveBalance->first()); ?>" readonly>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="validationDefault02">Tentative Dates of Settlement</label>
                                                        <input type="date" class="form-control" name="settlement_date" required>
                                                    </div>

                                                </div>
                                                <div class="form-row">

                                                    <div class="col-md-12 mb-3">
                                                        <label for="validationDefault02">Comments (if any):</label>
                                                        <textarea  class="form-control" name="comments"></textarea>
                                                    </div>

                                                </div>
                                                <div class="form-row">

                                                    <input type="hidden" name="regisID" value="<?php echo e($resignation->first()->id); ?>">

                                                    <input type="hidden" name="userID" value="<?php echo e($userId); ?>">
                                                    <input type="hidden" name="DesigID" value="<?php echo e($seprationDetails->first()->designation_id); ?>">

                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">



                                                        <?php $__currentLoopData = $seprattionCheckList->where('attribute', 'finance'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $chkList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <input class="form-check-input" type="checkbox" value="<?php echo e($chkList->id); ?>" name="chklist[]" id="invalidCheck<?php echo e($key); ?>" required >
                                                            <label class="form-check-label" for="invalidCheck<?php echo e($key); ?>">
                                                                <?php echo e($chkList->checkList); ?></label><br>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            </label>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit" name="submit" value="finance_submit">Submit form</button>
                                            </form>


                                        </div>
                                    </div>
                                </div>
                            </div>

                    
                            <?php endif; ?>







                    </div>

                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- /Page Wrapper -->




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/FinanceSeparationForm.blade.php ENDPATH**/ ?>