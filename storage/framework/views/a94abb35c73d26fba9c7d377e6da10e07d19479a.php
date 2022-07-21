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
            <?php if(count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12">

                    <!-- Add Leave Modal -->

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Job Title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php if(!isset($hiringRequests)): ?>
                                <form method="POST" action="<?php echo e(route('addHiringRequest')); ?>" class="needs-validation"
                                      novalidate>
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label>Job Description <span class="text-danger">*</span></label>
                                        <select class="form-control" name="job_title" onchange="fetchData(this)"
                                                required="required">
                                            <option value="">Select Job Description</option>
                                            <?php $__currentLoopData = $jobTitles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($jobTitle->id); ?>"><?php echo e($jobTitle->jobTitle); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>


                                        <label>
                                            Description
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="description" class="summernote" name="description">
                                        </textarea>
                                        <label>
                                            Requirements
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="requirement" class="summernote" name="requirements">
                                        </textarea>
                                        <label>
                                            What we expect from you
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="expectation" class="summernote" name="jobExpectations">
                                        </textarea>
                                        
                                        
                                        
                                        
                                        
                                        </textarea>
                                        <label>
                                            Number of Vacancy
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" name="vacancy" type="number" min="1"
                                               required="required">
                                    </div>

                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="entered">
                                            Submit
                                        </button>
                                    </div>
                                </form>

                            <?php else: ?>

                                <form method="POST" action="<?php echo e(route('addHiringRequest')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="recordID" value="<?php echo e($hiringRequests->first()->id); ?>">
                                    <div class="form-group">

                                        <label>
                                            Job Description
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" name="job_title" onchange="fetchData(this)"
                                                required="required">
                                            <option
                                                value="<?php echo e($hiringRequests->first()->title); ?>"><?php echo e($hiringRequests->first()->jobTitles); ?></option>
                                        </select>
                                        <label>Description
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="description" class="summernote" name="description"><?php echo e($hiringRequests->first()->description); ?>

                                            </textarea>
                                        <label>Requirements
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="requirement" class="summernote" name="requirements"><?php echo e($hiringRequests->first()->requirements); ?>

                                            </textarea>
                                        <label>
                                            What we expect from you
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="expectation" class="summernote" name="jobExpectations">
                                                <?php echo e($hiringRequests->first()->jobExpectations); ?>

                                            </textarea>
                                        
                                        
                                        
                                        </textarea>
                                        <label>Number of Vacancy
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" name="vacancy"
                                               value="<?php echo e($hiringRequests->first()->vacancies); ?>" type="int"
                                               required="required">
                                    </div>
                                    <?php if($hiringRequests->first()->status != 'authenticate'): ?>
                                        <div class="submit-section">
                                            <?php if($hiringRequests->first()->amID == $userId ): ?>
                                                <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                        type="submit" value="recommended">Recommended
                                                </button>
                                                <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                        type="submit" value="decline"> Decline
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                        type="submit" value="entered"> Submit
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
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

    <script>

        function fetchData(el) {
            var id = el.value;
            console.log(id);
            var html = '';
            $.ajax({
                url: '<?php echo e(url('hiringRequestFormDetails')); ?>/' + id,
                type: "GET",
                success: function (data) {
                    console.log(data);
                    $('#description').summernote('code', data.data.description);
                    $('#requirement').summernote('code', data.data.requirements);
                    $('#expectation').summernote('code', data.data.jobExpectations);
                    $('#benefits').summernote('code', data.data.jobBenefits);
                    $('#salary').summernote('code', data.data.salary);
                }
            });


        }
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/hiringRequestForm.blade.php ENDPATH**/ ?>