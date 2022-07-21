
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
                            <h5 class="modal-title">Add Job Title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form method="POST" action="<?php echo e(route('addHiringRequest')); ?>" class="needs-validation"
                                  novalidate>
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="recordID" value="<?php echo e($hiringRequests->first()->id); ?>">
                                <div class="form-group">
                                    <label>Position (Nature)<span class="text-danger">*</span></label>
                                    <select class="form-control" name="hiringType" required="required">
                                        <option value="">Select Position (Nature)</option>
                                        <?php if($hiringRequests->first()->hiringType): ?>
                                            <option
                                                value="<?php echo e($hiringRequests->first()->hiringType); ?>" selected><?php echo e($hiringRequests->first()->positionNature); ?></option>
                                        <?php endif; ?>
                                        <?php $__currentLoopData = $positionNatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($nature->id); ?>"><?php echo e($nature->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <label>Experience <span class="text-danger">*</span></label>
                                    <select class="form-control" name="experience" required="required">
                                        <option value="">Select Experience</option>
                                        <?php if($hiringRequests->first()->experience): ?>
                                            <option
                                                value="<?php echo e($hiringRequests->first()->experience); ?>" selected><?php echo e($hiringRequests->first()->experience); ?></option>
                                        <?php endif; ?>
                                        <option value="Fresh">Fresh</option>
                                        <option value="Less than 1 Year">Less than 1 Year</option>
                                        <option value="Up to 2 Years">Up to 2 Years</option>
                                        <option value="3+ Years">3+ Years</option>
                                        <option value="5+ Years">5+ Years</option>
                                    </select>

                                    <label>Location <span class="text-danger">*</span></label>

                                    <select class="form-control" name="location" required="required">
                                        <option value="">Select Hiring Location</option>
                                        <?php if($hiringRequests->first()->location): ?>
                                            <option
                                                value="<?php echo e($hiringRequests->first()->location); ?>" selected><?php echo e($hiringRequests->first()->location); ?></option>
                                        <?php endif; ?>
                                        <option value="Lahore">Lahore</option>
                                        <option value="Karachi">Karachi</option>
                                    </select>

                                    <label>Number of Vacancy <span class="text-danger">*</span></label>
                                    <input class="form-control" name="vacancy"
                                           value="<?php echo e($hiringRequests->first()->vacancies); ?>" type="int"
                                           required="required">


                                </div>

                                <div class="form-group row">
                                    <label>Period of Engagement <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <?php if($hiringRequests->first()->engagementPeriodType == 'Perpetual'): ?>
                                            <input type="radio" id="Perpetual" name="engagementPeriodType"
                                                   value="Perpetual" checked="checked">
                                            <label for="Perpetual">Perpetual</label>
                                            <input type="radio" id="Probation to Perpetual" name="engagementPeriodType"
                                                   value="Probation to Perpetual">
                                            <label for="Probation to Perpetual">Probation to Perpetual</label>
                                            <input type="radio" id="Period Specific" name="engagementPeriodType"
                                                   value="Period Specific">
                                            <label for="Period Specific">Period Specific</label>
                                            <input type="radio" id="Probation Duration" name="engagementPeriodType"
                                                   value="Probation Duration">
                                            <label for="Probation Duration">Probation Duration</label> <br>
                                            <label for="engagementPeriod">Engagement Period</label>
                                            <input type="text" id="engagementPeriod" name="engagementPeriod"
                                                   class="form-control"
                                                   placeholder="Please type Engagement Period in case of Period Specific or Probation Duration ">
                                        <?php elseif($hiringRequests->first()->engagementPeriodType == 'Probation to Perpetual'): ?>
                                            <input type="radio" id="Probation to Perpetual" name="engagementPeriodType"
                                                   value="Probation to Perpetual" checked="checked">
                                            <label for="Probation to Perpetual">Probation to Perpetual</label>
                                            <input type="radio" id="Perpetual" name="engagementPeriodType"
                                                   value="Perpetual">
                                            <label for="Perpetual">Perpetual</label>
                                            <input type="radio" id="Probation to Perpetual" name="engagementPeriodType"
                                                   value="Probation to Perpetual">
                                            <label for="Period Specific">Period Specific</label>
                                            <input type="radio" id="Probation Duration" name="engagementPeriodType"
                                                   value="Probation Duration">
                                            <label for="Probation Duration">Probation Duration</label> <br>
                                            <label for="engagementPeriod">Engagement Period</label>
                                            <input type="text" id="engagementPeriod" name="engagementPeriod"
                                                   class="form-control"
                                                   placeholder="Please type Engagement Period in case of Period Specific or Probation Duration ">
                                        <?php elseif($hiringRequests->first()->engagementPeriodType == 'Period Specific'): ?>

                                            <input type="radio" id="Probation to Perpetual" name="engagementPeriodType"
                                                   value="Probation to Perpetual">
                                            <label for="Probation to Perpetual">Probation to Perpetual</label>
                                            <input type="radio" id="Perpetual" name="engagementPeriodType"
                                                   value="Perpetual">
                                            <label for="Perpetual">Perpetual</label>
                                            <input type="radio" id="Probation to Perpetual" name="engagementPeriodType"
                                                   value="Probation to Perpetual">
                                            <label for="Period Specific">Period Specific</label>
                                            <input type="radio" id="Probation Duration" name="engagementPeriodType"
                                                   value="Probation Duration" checked="checked">
                                            <label for="Probation Duration">Probation Duration</label> <br>
                                            <label for="engagementPeriod">Engagement Period</label>
                                            <input type="text" id="engagementPeriod" name="engagementPeriod"
                                                   class="form-control"
                                                   placeholder="Please type Engagement Period in case of Period Specific or Probation Duration ">
                                        <?php elseif($hiringRequests->first()->engagementPeriodType == 'Probation Duration'): ?>

                                            <input type="radio" id="Probation to Perpetual" name="engagementPeriodType"
                                                   value="Probation to Perpetual">
                                            <label for="Probation to Perpetual">Probation to Perpetual</label>
                                            <input type="radio" id="Perpetual" name="engagementPeriodType"
                                                   value="Perpetual">
                                            <label for="Perpetual">Perpetual</label>
                                            <input type="radio" id="Probation to Perpetual" name="engagementPeriodType"
                                                   value="Probation to Perpetual">
                                            <label for="Period Specific">Period Specific</label>
                                            <input type="radio" id="Probation Duration" name="engagementPeriodType"
                                                   value="Probation Duration" checked>
                                            <label for="Probation Duration">Probation Duration</label> <br>
                                            <label for="engagementPeriod">Engagement Period</label>
                                            <input type="text" id="engagementPeriod" name="engagementPeriod"
                                                   class="form-control"
                                                   value=<?php echo e($hiringRequests->first()->engagementPeriod); ?>>
                                        <?php else: ?>
                                            <input type="radio" id="Perpetual" name="engagementPeriodType"
                                                   value="Perpetual">
                                            <label for="Perpetual">Perpetual</label>

                                            <input type="radio" id="Probation to Perpetual" name="engagementPeriodType"
                                                   value="Probation to Perpetual">
                                            <label for="Probation to Perpetual">Probation to Perpetual</label>

                                            <input type="radio" id="Period Specific" name="engagementPeriodType"
                                                   value="Period Specific">
                                            <label for="Period Specific">Period Specific</label>

                                            <input type="radio" id="Probation Duration" name="engagementPeriodType"
                                                   value="Probation Duration">
                                            <label for="Probation Duration">Probation Duration</label> <br>

                                            <label for="engagementPeriod">Engagement Period</label>
                                            <input type="text" id="engagementPeriod" name="engagementPeriod"
                                                   class="form-control"
                                                   placeholder="Please type Engagement Period in case of Period Specific or Probation Duration ">
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label col-md-2">HR Policy Grade <span
                                            class="text-danger">*</span></label>

                                    <select name="grade" id="cars" class="form-control">
                                        <option value="">Select HR Policy Grade</option>
                                        <?php if($hiringRequests->first()->grade): ?>
                                        <option
                                            value="<?php echo e($hiringRequests->first()->grade); ?>" selected><?php echo e($hiringRequests->first()->policyName); ?></option>
                                        <?php endif; ?>
                                        <?php $__currentLoopData = $allGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allGrades): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($allGrades->id); ?>"><?php echo e($allGrades->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <label class="col-form-label col-md-2">Function / Team <span
                                            class="text-danger">*</span></label>

                                    <select name="department" class="form-control">
                                        
                                        <option
                                            value="<?php echo e($getDepartments->departmentID); ?>"><?php echo e($getDepartments->department); ?></option>
                                        
                                    </select>

                                    
                                    

                                    
                                    
                                    
                                    
                                    
                                    
                                    


                                    <label>Job Description <span class="text-danger">*</span></label>
                                    <select class="form-control" name="job_title" onchange="fetchData(this)"
                                            required="required">
                                        <option
                                            value="<?php echo e($hiringRequests->first()->title); ?>"><?php echo e($hiringRequests->first()->jobTitles); ?></option>
                                    </select>


                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea id="description" class="summernote"
                                              name="description"><?php echo e($hiringRequests->first()->description); ?></textarea>



                                    <label>Requirements <span class="text-danger">*</span></label>
                                    <textarea id="requirement" class="summernote"
                                              name="requirements"><?php echo e($hiringRequests->first()->requirements); ?></textarea>

                                    <label>What we expect from you <span class="text-danger">*</span></label>
                                    <textarea id="expectation" class="summernote"
                                              name="jobExpectations"><?php echo e($hiringRequests->first()->jobExpectations); ?></textarea>





                                    <label>Salary Bracket<span class="text-danger">*</span></label>
                                    <select class="form-control" name="salary" required="required">
                                        <option value="">Select Salary Range</option>
                                        <?php if($hiringRequests->first()->salary): ?>
                                        <option
                                            value="<?php echo e($hiringRequests->first()->salary); ?>" selected><?php echo e($hiringRequests->first()->salary); ?></option>
                                        <?php endif; ?>
                                        <option value="35000 - 50000">35000 - 50000</option>
                                        <option value="50000 - 70000">50000 - 70000</option>
                                        <option value="70000 - 90000">70000 - 90000</option>
                                        <option value="90000 - 150000">90000 - 150000</option>
                                        <option value="150000 - 225000">150000 - 225000</option>
                                    </select>
                                    <br>
                                    <label>Job Expiry Date </label>
                                    <input type="date" class="form-control" name="lastDate"
                                           value="<?php echo e($hiringRequests->first()->lastDate ?? ''); ?>">
                                </div>

                                <div class="submit-section">

                                    <?php if($hiringRequests->first()->amID == $userId ): ?>
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="recommended">Recommended
                                        </button>

                                        <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                type="submit" value="decline"> Decline
                                        </button>
                                    <?php elseif(in_array('6', $user_rights)): ?>
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="authenticate"> Authenticate
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


<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/hiringRequestFormHRapproval.blade.php ENDPATH**/ ?>