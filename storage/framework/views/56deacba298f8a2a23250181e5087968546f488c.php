<?php $__env->startSection('content'); ?>


    


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title"><?php echo e(!empty($meta_title) ? $meta_title: 'Employee'); ?></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo e(!empty($meta_title) ? $meta_title: 'Employee'); ?></li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->


            <form method="POST" action="<?php echo e(route('add_employee')); ?>" method="post" enctype="multipart/form-data"
                  files="true" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="fname" type="text" required="required"
                                   value="<?php echo e($getProfileDetails->fname ?? ''); ?>">
                            <div class="invalid-feedback">
                                Please provide a valid First Name.
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Last Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="lname" type="text" required="required"
                                   value="<?php echo e($getProfileDetails->lname  ?? ''); ?>">
                            <div class="invalid-feedback">
                                Please provide a valid Last Name.
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Username <span class="text-danger">*</span></label>
                            <input class="form-control" name="uname" type="text" required="required">
                            <div class="invalid-feedback">
                                Please provide a valid Username.
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Official Email <span class="text-danger">*</span></label>
                            <input class="form-control" name="email" type="email" required="required">
                            <div class="invalid-feedback">
                                Please provide a valid Official Email Address.
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Personal Email <span class="text-danger">*</span></label>
                            <input class="form-control" name="pemail" type="email" required="required"
                                   value="<?php echo e($getProfileDetails->email  ?? ''); ?>">
                            <div class="invalid-feedback">
                                Please provide a valid Personal Email Address.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                            <input type="text" name="emp_id" class="form-control" required="required"
                                   value="<?php echo e($empNum  ?? ''); ?>">
                            <div class="invalid-feedback">
                                Please provide a valid Employee ID.
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                            <div class=""><input class="form-control" name="doj" type="date" required="required"
                                                 value="<?php echo e($getDOJ->doj ?? ''); ?>">
                                <div class="invalid-feedback">
                                    Please choose a valid Joining Date.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Confirmation Date</label>
                            <div class=""><input class="form-control" name="c_date" type="date"></div>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Fit & Proper Date</label>
                            <div class=""><input class="form-control" name="fnp_date" type="date"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Verticals <span class="text-danger">*</span></label>
                            <select class="form-control" name="dpt" required>
                                <option value="">Select Function</option>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dep->id); ?>"><?php echo e($dep->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                

                            </select>
                            <div class="invalid-feedback">
                                Please choose a valid Function.
                            </div>
                        </div>
                    </div>

                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sub Function <span class="text-danger">*</span></label>
                            <select class="form-control" name="sub_dpt" required="required">
                                <option value="">Select Sub Function</option>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dep->id); ?>"><?php echo e($dep->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback">
                                Please choose a valid Sub Function.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Designation <span class="text-danger">*</span></label>
                            <select class="form-control" name="desg" required="required">
                                <option value="">Select Designation</option>
                                <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e($desg->id); ?>"><?php echo e($desg->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback">
                                Please choose a valid Designation.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Grade <span class="text-danger">*</span></label>
                            <select class="form-control" name="grade" required="required">
                                <option value="">Select Grade</option>
                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($grade->id); ?>"><?php echo e($grade->name); ?>(<?php echo e($grade->description); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback">
                                Please choose a valid Grade.
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">CNIC <span class="text-danger">*</span></label>
                            <div class="">
                                <input class="form-control" type="text" placeholder="XXXXX-XXXXXXX-X" name="cnic"
                                       required="required" value="<?php echo e($getPersonalInfo->cnic  ?? ''); ?>">
                                <div class="invalid-feedback">
                                    Please provide a valid CNIC.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Contact <span class="text-danger">*</span></label>
                            <div class="">
                                <input class="form-control" name="phone" type="tel" pattern="[0-9]{4}[0-9]{7}"
                                       placeholder="XXXX-XXXXXXX" required="required"
                                       value="<?php echo e($getProfileDetails->contactNumber  ?? ''); ?>">
                                <div class="invalid-feedback">
                                    Please provide a valid Contact Number.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Emergency Contact <span class="text-danger">*</span> </label>
                            <div class=""><input class="form-control" name="emg_phone" type="tel"
                                                 pattern="[0-9]{4}[0-9]{7}" placeholder="XXXX-XXXXXXX"
                                                 required="required" value="<?php echo e($getEmgInfo->phoneOne  ?? ''); ?>">
                                <div class="invalid-feedback">
                                    Please provide a valid Emergency Contact Number.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Name of Emergency Contact <span class="text-danger">*</span>
                            </label>
                            <div class="">
                                <input type="text" name="emg_name" class="form-control" required="required"
                                       value="<?php echo e($getEmgInfo->contactNameOne  ?? ''); ?>">
                                <div class="invalid-feedback">
                                    Please provide a valid Emergency Contact Name.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Relationship with Emergency Contact <span class="text-danger">*</span>
                            </label>
                            <div class="">
                                <select class="form-control" name="emg_relation" required="required">
                                    <option value="">Select Relationship</option>
                                    <?php $__currentLoopData = $relatives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relative): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($relative->id); ?>"><?php echo e($relative->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please choose a valid Relationship.
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">DOB <span class="text-danger">*</span></label>
                            <div class=""><input class="form-control" name="dob" type="date" required="required"
                                                 value="<?php echo e($getProfileDetails->dob  ?? ''); ?>">
                                <div class="invalid-feedback">
                                    Please choose a valid Birth Date.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Nationality <span class="text-danger">*</span></label>

                            <select class="form-control" name="nationality" required="required">
                                <option value="">Select Nationality</option>
                                <option value="<?php echo e($nationality[0]->id); ?>" selected><?php echo e($nationality[0]->title); ?></option>
                                
                                
                                
                            </select>
                            <div class="invalid-feedback">
                                Please choose a valid Nationality.
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Religion <span class="text-danger">*</span></label>
                            <select class="form-control" name="religion" required="required">
                                <option value="">Select Religion</option>
                                <option value="<?php echo e($religions[0]->id); ?>" selected><?php echo e($religions[0]->title); ?></option>
                                
                                
                                
                            </select>
                            <div class="invalid-feedback">
                                Please choose a valid Religion.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-control" name="gender" required="required">
                                <option value="">Select Gender</option>
                                <option value="<?php echo e($genders[0]->id); ?>" selected><?php echo e($genders[0]->title); ?></option>
                                
                                
                                
                            </select>
                            <div class="invalid-feedback">
                                Please choose a valid Gender.
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Marital Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="marital" required="required">
                                <option value="">Select Marital Status</option>
                                <option value="<?php echo e($maritals[0]->id); ?>" selected><?php echo e($maritals[0]->title); ?></option>
                                
                                
                                
                            </select>
                            <div class="invalid-feedback">
                                Please choose a valid Martial Status.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Reports To <span class="text-danger">*</span></label>
                            <select class="form-control" name="report_to" required="required">
                                <option value="">Select Reports to</option>
                                <?php $__currentLoopData = $all_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($users->id); ?>"><?php echo e($users->display_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback">
                                Please choose a valid Entry.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Linkedin <span class="text-danger">*</span></label>
                            <input class="form-control" name="linkedin" type="text" required
                                   value="<?php echo e($getProfileDetails->linkedin  ?? ''); ?>">
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid LinkedIn URL.
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Show on Website <span class="text-danger">*</span></label>
                            <select class="select" name="web_check" required>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Latest Qualification <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" name="last_qualification" type="text" required>
                            <div class="invalid-feedback">
                                Please provide a valid Entry.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Exp. Outside PACRA <span class="text-danger">*</span></label>
                            <input class="form-control" name="exp_outside_pacra" type="text" required value="<?php echo e($getExperienceInfo->totalExperience); ?>">
                            <div class="invalid-feedback">
                                Please provide a valid Experience.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Exp. In PACRA <span class="text-danger">*</span></label>
                            <input class="form-control" name="exp_in_pacra" type="text" required>
                            <div class="invalid-feedback">
                                Please provide a valid Experience.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Last Employer <span class="text-danger">*</span></label>
                            <input class="form-control" name="last_employer" type="text" value="<?php echo e($getExperienceInfo->companyName ?? ''); ?>" required>
                            <div class="invalid-feedback">
                                Please choose a valid Employer.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Address <span class="text-danger">*</span></label>
                            <input class="form-control" name="address" type="text" required="required"
                                   value="<?php echo e($getProfileDetails->address  ?? ''); ?>">
                            <div class="invalid-feedback">
                                Please choose a valid Address.
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Upload Image <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="image" id="image"
                                   accept="image/jpg, image/jpeg" required value="<?php echo e($getProfileDetails->image  ?? ''); ?>">
                            <div class="invalid-feedback">
                                Please upload a valid Image File.
                            </div>
                            <small id="fileHelp" class="form-text text-muted">Please upload a valid JPG/JPEG
                                file.</small>
                            <a href="<?php echo e("https://209.97.168.200/pacra-job-portal/public/users/" . $getProfileDetails->image  ?? '/'); ?>" target="_blank">View
                                Image</a>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Upload CV <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file" id="file" accept="application/pdf"
                                   required>
                            <div class="invalid-feedback">
                                Please choose a valid CV File.
                            </div>
                            <small id="fileHelp" class="form-text text-muted">Please upload a valid PDF file.</small>
                            <a href="<?php echo e("https://209.97.168.200/pacra-job-portal/public/".$getProfileDetails->cv ?? '/'); ?>" target="_blank">View
                                CV</a>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Upload Signature <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="signature" id="file" accept="image/png"
                                   required="required">
                            <div class="invalid-feedback">
                                Please upload a valid Image File.
                            </div>
                            <small id="fileHelp" class="form-text text-muted">Please upload a valid transparent PNG
                                file.</small>
                        </div>
                    </div>

                </div>

                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>

            <!-- /Page Content -->


        </div>
        <!-- /Page Wrapper -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/makeEmployee.blade.php ENDPATH**/ ?>