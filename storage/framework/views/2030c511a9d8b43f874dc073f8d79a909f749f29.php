
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
                                        <h3 class="modal-title"><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?></h3>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="<?php echo e(route('addReScheduleInterview')); ?>" enctype="multipart/form-data" files="true">
                                            <?php echo csrf_field(); ?>

                                            <div class="form-group">
                                                <label>Job Title<span class="text-danger">*</span></label>
                                                <div class="">

                                                    <input class="form-control" type="text" name="jobTitle" value="<?php echo e($jobDetails->first()->jobTitles); ?>" readonly="readonly">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Candidate Name <span class="text-danger">*</span></label>
                                                <div class="">

                                                    <input class="form-control" type="text" name="candidateName" value="<?php echo e($userProfile->first()->fname); ?> <?php echo e($userProfile->first()->lname); ?>" required="required">
                                                </div>
                                            </div>

                                           
                                            <div class="form-group">
                                                <label>Interview Date <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input class="form-control " type="date" name="date" value="<?php echo e($getInterviewDetails->date); ?>" required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Interview Time <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input class="form-control " type="time" name="time" value="<?php echo e($getInterviewDetails->time); ?>" required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Interview Location<span class="text-danger">*</span></label>
                                                <select name="interviewLocation" required="required" class="select">
                                                    <option value="<?php echo e($getInterviewDetails->interviewLocation); ?>"> <?php echo e($getInterviewDetails->interviewLocation); ?> </option>
                                                        <option value="online"> Online </option>
                                                        <option value="office"> In Office</option>
                                                        
                                                </select>
                                            </div>


                                            <input type="hidden" name="userID" value="<?php echo e($userProfile->first()->userID); ?>" >
                                            <input type="hidden" name="candidateID" value="<?php echo e($candidateID); ?>" >
                                            <input type="hidden" name="jobID" value="<?php echo e($jobDetails->first()->id); ?>" >
                                            <input type="hidden" name="interviewID" value="<?php echo e($getInterviewDetails->id); ?>" >




                                            <div class="submit-section">
                                                <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Submit</button>
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
<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/reScheduleInterviewForm.blade.php ENDPATH**/ ?>