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


            <?php if(session()->has('message')): ?>
                <div class="alert alert-success">
                    <?php echo e(session()->get('message')); ?>

                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12">

                    <!-- Add Leave Modal -->

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Job Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php if(!isset($jobTitles)): ?>
                                <form method="POST" action="<?php echo e(route('addJobTitles')); ?>" class="needs-validation"
                                      novalidate>
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        <select class="form-control" name="job_title" required="required">
                                            <option value="">Select Designation</option>
                                            <?php $__currentLoopData = $getDesignations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getDesignation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($getDesignation->id); ?>"><?php echo e($getDesignation->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                        </select>


                                        <label>Description <span class="text-danger">*</span></label>
                                        <textarea class="summernote" name="description" required="required"></textarea>

                                        <label>Requirements <span class="text-danger">*</span></label>
                                        <textarea class="summernote" name="requirements" required></textarea>

                                        <label>What we expect from you <span class="text-danger">*</span></label>
                                        <textarea class="summernote" name="jobExpectations" required></textarea>

                                        
                                        

                                        <label>Salary Bracket<span class="text-danger">*</span></label>
                                        
                                        <select class="form-control" name="salary" required="required">
                                            <option value="">Select Salary Range</option>
                                            <option value="35000 - 50000">35000 - 50000</option>
                                            <option value="50000 - 70000">50000 - 70000</option>
                                            <option value="70000 - 90000">70000 - 90000</option>
                                            <option value="90000 - 150000">90000 - 150000</option>
                                            <option value="150000 - 225000">150000 - 225000</option>                                        </select>


                                    </div>

                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="entered"> Submit
                                        </button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="<?php echo e(route('addJobTitles')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php echo e($jobTitles->first()->id); ?>">
                                        <label>Job Title <span class="text-danger">*</span></label>
                                        <select class="form-control" name="job_title" required="required">
                                            <option
                                                value="<?php echo e($jobTitles->first()->title); ?>"><?php echo e($jobTitles->first()->jobTitle); ?></option>

                                            <option value="">Select Job Title</option>
                                            <?php $__currentLoopData = $getDesignations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getDesignation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($getDesignation->id); ?>"><?php echo e($getDesignation->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                        <label>Description <span class="text-danger">*</span></label>
                                        <textarea class="summernote"
                                                  name="description"><?php echo e($jobTitles->first()->description); ?></textarea>

                                        <label>Requirements <span class="text-danger">*</span></label>
                                        <textarea class="summernote"
                                                  name="requirements"><?php echo e($jobTitles->first()->requirements); ?></textarea>

                                        <label>What we expect from you <span class="text-danger">*</span></label>
                                        <textarea class="summernote"
                                                  name="jobExpectations"><?php echo e($jobTitles->first()->jobExpectations); ?></textarea>

                                        
                                        
                                        

                                        <label>Salary Bracket<span class="text-danger">*</span></label>
                                        <select class="form-control" name="salary" required="required">
                                            <option
                                                value="<?php echo e($jobTitles->first()->salary); ?>"><?php echo e($jobTitles->first()->salary); ?></option>
                                            <option value="">Select Salary Range</option>
                                            <option
                                                value="<?php echo e($jobTitles->first()->salary ?? ''); ?>"><?php echo e($jobTitles->first()->salary ?? ''); ?></option>
                                            <option value="35000 - 50000">35000 - 50000</option>
                                            <option value="50000 - 70000">50000 - 70000</option>
                                            <option value="70000 - 90000">70000 - 90000</option>
                                            <option value="90000 - 150000">90000 - 150000</option>
                                            <option value="150000 - 225000">150000 - 225000</option>
                                        </select>


                                    </div>

                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="update">Update
                                        </button>
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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/jobTitlesForm.blade.php ENDPATH**/ ?>