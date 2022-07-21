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
                            <form method="POST" action="<?php echo e(route('addScheduleInterview')); ?>"
                                  enctype="multipart/form-data" files="true">
                                <?php echo csrf_field(); ?>

                                <div class="form-group">
                                    <label>Job Title<span class="text-danger">*</span></label>
                                    <div class="">

                                        <input class="form-control" type="text" name="jobTitle"
                                               value="<?php echo e($jobDetails->first()->jobTitles); ?>" readonly="readonly">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Candidate Name <span class="text-danger">*</span></label>
                                    <div class="">

                                        <input class="form-control" type="text" name="candidateName"
                                               value="<?php echo e($userProfile->first()->fname); ?> <?php echo e($userProfile->first()->lname); ?>"
                                               required="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Interview Round<span class="text-danger">*</span></label>
                                    <select name="interviewRound" id="interviewRound" required="required"
                                            class="select">
                                        <option value=""> <?php echo e('Select Interview Round'); ?></option>
                                        <option value="HR/TL"> HR / Team Lead</option>
                                        <option value="Unit Head"> Unit Head</option>
                                        <option value="CEO/Final"> CEO / Final</option>
                                    </select>
                                </div>

                                <div class="form-group" id="HRTL" style="display: none">
                                    <label>Upload Test</label>
                                    <input type="file" name="candidatesTest" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid file of
                                        scanned test.</small>

                                    <label>Marks Obtained </label>
                                    <input type="number" class="form-control" name="marks">

                                    <label>Upload Miscellaneous Document </label>
                                    <input type="file" name="miscellaneousDoc" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid
                                        file.</small>
                                </div>

                                <div class="form-group" id="UH" style="display: none">
                                    <label>Upload Interview Sheet HR <span class="text-danger">*</span></label>
                                    <input type="file" name="interviewSheetHR" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid file of
                                        scanned HR Interview Sheet for UH.</small>

                                    <label>Upload Interview Sheet TL <span class="text-danger">*</span></label>
                                    <input type="file" name="interviewSheetTL" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid file of
                                        scanned TL Interview Sheet for UH.</small>
                                </div>

                                <div class="form-group" id="CEO" style="display: none">
                                    <label>Upload Interview Sheet UH <span class="text-danger">*</span></label>
                                    <input type="file" name="interviewSheetUH" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid file of
                                        scanned UH Interview Sheet for CEO.</small>
                                </div>

                                <div class="form-group">
                                    <label>Interview Date <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input class="form-control " type="date" name="date" required="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Interview Time <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input class="form-control " type="time" name="time" required="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Interview Location<span class="text-danger">*</span></label>
                                    <select name="interviewLocation" required="required" class="select">
                                        <option value=""> <?php echo e('Select Interview Location'); ?></option>
                                        <option value="online"> Online</option>
                                        <option value="office"> In Office</option>

                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Interviewers<span class="text-danger">*</span></label>
                                    <select name="interviewers[]" required="required" class="select"
                                            multiple="multiple">
                                        <option value=""> <?php echo e('Select Interviewers'); ?></option>
                                        <?php $__currentLoopData = $allActiveUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allActiveUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($allActiveUser->id); ?>"> <?php echo e($allActiveUser->display_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Email Text for Candidate</label>
                                    <textarea class="summernote"
                                              name="candidateEmailText">Dear <?php echo e($userProfile->first()->fname); ?> <?php echo e($userProfile->first()->lname); ?> <br>Your Test Time:<br>Thank You</textarea>

                                </div>

                                <div class="form-group">
                                    <label>Email Text for Interviewers</label>
                                    <textarea class="summernote" name="conductorEmailText"></textarea>

                                </div>

                                <input type="hidden" name="userID" value="<?php echo e($userProfile->first()->userID); ?>">
                                <input type="hidden" name="candidateID" value="<?php echo e($candidateID); ?>">
                                <input type="hidden" name="jobID" value="<?php echo e($jobDetails->first()->id); ?>">


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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/scheduleInterviewForm.blade.php ENDPATH**/ ?>