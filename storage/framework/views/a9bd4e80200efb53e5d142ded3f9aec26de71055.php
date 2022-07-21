
<?php $__env->startSection('content'); ?>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <?php if(\Session::has('success')): ?>
                <div class="alert alert-success">
                    <ul>
                        <li><?php echo \Session::get('success'); ?></li>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profile</h3>
                        <?php if(in_array('10', $user_rights)): ?>
                            <?php if($userDetails[0]->designation_id == 29): ?>
                                <?php if($EndInternshipCheck > 0): ?>
                                    <a style="display: flex; float: right" disabled
                                       class="btn-secondary btn btn-sm">Internship Ended</a>
                                <?php elseif($ExtendInternshipCheck > 0): ?>
                                    <a style="display: flex; float: right" type="button" data-toggle="modal"
                                       class="btn-danger btn btn-sm"
                                       href="<?php echo e('#modalLongEndInternship' . $userDetails[0]->ID); ?>">End Internship</a>
                                    <a style="display: flex; float: right; margin-right: 8px !important;" type="button"
                                       data-toggle="modal"
                                       class="btn-success btn btn-sm"
                                       href="<?php echo e('#modalLong' . $userDetails[0]->ID); ?>">Make Employee</a>
                                    <a style="display: flex; float: right; margin-right: 8px" disabled
                                       class="btn-secondary btn btn-sm">Internship Extended</a>
                                <?php else: ?>
                                    <a style="display: flex; float: right" type="button" data-toggle="modal"
                                       class="btn-danger btn btn-sm"
                                       href="<?php echo e('#modalLongEndInternship' . $userDetails[0]->ID); ?>">End Internship</a>
                                    <a style="display: flex; float: right; margin-right: 8px !important;" type="button"
                                       data-toggle="modal"
                                       class="btn-primary btn btn-sm"
                                       href="<?php echo e('#modalLongExtendInternship' . $userDetails[0]->ID); ?>">Extend Internship</a>
                                    <a style="display: flex; float: right; margin-right: 8px !important;" type="button"
                                       data-toggle="modal"
                                       class="btn-success btn btn-sm"
                                       href="<?php echo e('#modalLong' . $userDetails[0]->ID); ?>">Make Employee</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($terminationCheck ?? '' > 0): ?>
                                    <a style="display: flex; float: right" disabled
                                       class="btn-secondary btn btn-sm">Employment End Process Initiated</a>
                                <?php else: ?>
                                    <a style="display: flex; float: right" type="button" data-toggle="modal"
                                       class="btn-danger btn btn-sm"
                                       href="<?php echo e('#modalLong' . $userDetails[0]->ID); ?>">End Employment</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#"><img alt="" src="<?php echo e(asset('users/'.$userDetails[0]->avatar_file)); ?>"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0"><?php echo e(!empty($userDetails[0]->display_name) ? $userDetails[0]->display_name: ''); ?></h3>
                                                <h6 class="text-muted"><?php echo e(!empty($userDetails[0]->team) ? $userDetails[0]->team: ''); ?></h6>
                                                <small
                                                    class="text-muted"><?php echo e(!empty($userDetails[0]->designation) ? $userDetails[0]->designation: ''); ?></small>
                                                <div class="staff-id">Employee ID
                                                    : <?php echo e(!empty($userDetails[0]->employee_id) ? $userDetails[0]->employee_id: ''); ?></div>
                                                <div class="small doj text-muted">Date of Join
                                                    : <?php echo e(!empty($userDetails[0]->doj) ? date("d-M-Y", strtotime($userDetails[0]->doj)): ''); ?></div>
                                                <div
                                                    class="staff-msg"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a
                                                            href=""><?php echo e(!empty($userDetails[0]->phone) ? $userDetails[0]->phone: ''); ?></a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a
                                                            href=""><?php echo e(!empty($userDetails[0]->email) ? $userDetails[0]->email: ''); ?></a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Birthday:</div>
                                                    <div
                                                        class="text"><?php echo e(!empty($userDetails[0]->birthday) ? date("d-M", strtotime($userDetails[0]->birthday)): ''); ?></div>
                                                </li>


                                                <li>
                                                    <div class="title">Gender:</div>
                                                    <div
                                                        class="text"><?php echo e(!empty($userDetails[0]->genderTitle) ? $userDetails[0]->genderTitle: ''); ?> </div>
                                                </li>
                                                <li>
                                                    <div class="title">Reports to:</div>
                                                    <div class="text">
                                                        <div class="avatar-box">
                                                            <div class="avatar avatar-xs">
                                                                <img
                                                                    src="<?php echo e(asset('users/'.$userDetails[0]->managerpic)); ?>"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <a href="<?php echo e(url('profile')); ?>/<?php echo e($userDetails[0]->am_id); ?>"
                                                           target="_blank">
                                                            <?php echo e(!empty($userDetails[0]->managerName) ? $userDetails[0]->managerName: ''); ?>

                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-edit">

                                    <?php if(in_array('10', $user_rights) or  $userId == $userDetails[0]->ID): ?>
                                        <a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i
                                                class="fa fa-pencil"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(in_array('10', $user_rights) or  $userId == $userDetails[0]->ID): ?>
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">Profile</a>
                                </li>
                                <li class="nav-item"><a href="#cv" data-toggle="tab" class="nav-link">CV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tab-content">

                    <!-- Profile Info Tab -->
                    <div id="emp_profile" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        <h3 class="card-title">Personal
                                            Information </h3>
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Employment Confirmation Date</div>
                                                <div
                                                    class="text"><?php echo e(!empty($userDetails[0]->confirmation_date) ? date("d-M-Y", strtotime($userDetails[0]->confirmation_date)): ''); ?></div>
                                            </li>
                                            <li>
                                                <div class="title">CNIC</div>
                                                <div
                                                    class="text"><?php echo e(!empty($userDetails[0]->cnic) ? $userDetails[0]->cnic: ''); ?></div>
                                            </li>
                                            <li>
                                                <div class="title">Birthday</div>
                                                <div
                                                    class="text"><?php echo e(!empty($userDetails[0]->birthday) ? date("d-M-Y", strtotime($userDetails[0]->birthday)): ''); ?></div>
                                            </li>
                                            <li>
                                                <div class="title">Emergancy Contact Number</div>
                                                <div class="text"><a
                                                        href=""><?php echo e(!empty($userDetails[0]->emergency_contact) ? $userDetails[0]->emergency_contact: ''); ?></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Nationality</div>
                                                <div
                                                    class="text"><?php echo e(!empty($userDetails[0]->national) ? $userDetails[0]->national: ''); ?></div>
                                            </li>
                                            <li>
                                                <div class="title">Religion</div>
                                                <div
                                                    class="text"><?php echo e(!empty($userDetails[0]->religions) ? $userDetails[0]->religions: ''); ?></div>
                                            </li>
                                            <li>
                                                <div class="title">Marital status</div>
                                                <div
                                                    class="text"><?php echo e(!empty($userDetails[0]->marital) ? $userDetails[0]->marital: ''); ?></div>
                                            </li>
                                            <li>
                                                <div class="title">Address</div>
                                                <div
                                                    class="text"><?php echo e(!empty($userDetails[0]->address) ? $userDetails[0]->address: ''); ?></div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <!-- /Profile Info Tab -->

                    <!-- CV Tab -->
                    <div class="tab-pane fade" id="cv">
                        <div class="row">
                            <object
                                
                                data="<?php echo e('https://209.97.168.200/hr/storage/app/' .$userDetails[0]->cv ?? ''); ?>"
                                type="application/pdf" width="100%"
                                align="middle" height="800px">
                            </object>
                            
                            

                            
                            
                            
                            

                            </object>

                        </div>
                    </div>
                    <!-- /Projects Tab -->


                </div>
        </div>
    <?php endif; ?>
    <!-- /Page Content -->

        <!-- Profile Modal -->
        <div id="profile_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Profile Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="user" method="POST" action="<?php echo e(route('update_employee')); ?>"
                              enctype="multipart/form-data" files="true">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-img-wrap edit-img">
                                        <img class="inline-block" src="<?php echo e(asset('users/'.$userDetails[0]->avatar_file)); ?>"
                                             alt="user">
                                        <div class="fileupload btn">
                                            <span class="btn-text">edit</span>
                                            <input class="upload" type="file" name="image" id="image">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input class="form-control" name="fname" type="text"
                                                       value="<?php echo e(!empty($userDetails[0]->fname) ? $userDetails[0]->fname: ''); ?>"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input class="form-control" name="lname" type="text"
                                                       value="<?php echo e(!empty($userDetails[0]->lname) ? $userDetails[0]->lname: ''); ?>"
                                                       required="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Username <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="uname" type="text"
                                                       value="<?php echo e(!empty($userDetails[0]->uname) ? $userDetails[0]->uname: ''); ?>"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Officail Email <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="email" type="email"
                                                       value="<?php echo e(!empty($userDetails[0]->email) ? $userDetails[0]->email: ''); ?>"
                                                       required="required">
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Personal Email <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="pemail" type="email"
                                                       value="<?php echo e(!empty($userDetails[0]->pemail) ? $userDetails[0]->pemail: ''); ?>"
                                                       required="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Employee ID <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="emp_id" class="form-control"
                                                       value="<?php echo e(!empty($userDetails[0]->employee_id) ? $userDetails[0]->employee_id: ''); ?>"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Joining Date <span
                                                        class="text-danger">*</span></label>
                                                <div class=""><input class="form-control" name="doj" type="date"
                                                                     value="<?php echo e(!empty($userDetails[0]->doj) ? $userDetails[0]->doj: ''); ?>"
                                                                     required="required"></div>
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Confirmation Date </label>
                                                <div class=""><input class="form-control" name="c_date"
                                                                     value="<?php echo e(!empty($userDetails[0]->confirmation_date) ? $userDetails[0]->confirmation_date: ''); ?>"
                                                                     type="date"></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Fit & Proper Date</label>
                                                <div class=""><input class="form-control" name="fnp_date"
                                                                     value="<?php echo e(!empty($userDetails[0]->fnp_date) ? $userDetails[0]->fnp_date: ''); ?>"
                                                                     type="date"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Verticals <span class="text-danger">*</span></label>
                                                <select class="select" name="dpt" required="required">
                                                    <option
                                                        value="<?php echo e(!empty($userDetails[0]->team_id) ? $userDetails[0]->team_id: ''); ?>"><?php echo e(!empty($userDetails[0]->team) ? $userDetails[0]->team: ''); ?></option>
                                                    <option value="">Select Vertical</option>
                                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option value="<?php echo e($dep->id); ?>"><?php echo e($dep->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Function <span class="text-danger">*</span></label>

                                                <select class="select" name="sub_dpt" required="required">
                                                    <option
                                                        value="<?php echo e(!empty($userDetails[0]->function) ? $userDetails[0]->function: ''); ?>"><?php echo e(!empty($userDetails[0]->functionTitle) ? $userDetails[0]->functionTitle: ''); ?></option>
                                                    <option value="">Select Function</option>
                                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option value="<?php echo e($dep->id); ?>"><?php echo e($dep->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Grade <span class="text-danger">*</span></label>
                                                <select class="select" name="grade" required="required">
                                                    <option
                                                        value="<?php echo e(!empty($userDetails[0]->grade) ? $userDetails[0]->grade: ''); ?>"><?php echo e(!empty($userDetails[0]->gradeTitle) ? $userDetails[0]->gradeTitle: ''); ?></option>

                                                    <option value="">Select Grade</option>
                                                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option value="<?php echo e($grade->id); ?>"><?php echo e($grade->name); ?>

                                                            (<?php echo e($grade->description); ?>)
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Designation <span class="text-danger">*</span></label>
                                                <select class="select" name="desg" id="designation" required="required">
                                                    <option
                                                        value="<?php echo e(!empty($userDetails[0]->designation_id) ? $userDetails[0]->designation_id: ''); ?>"><?php echo e(!empty($userDetails[0]->designation) ? $userDetails[0]->designation: ''); ?></option>
                                                    <option value="">Select Designation</option>
                                                    <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($desg->id); ?>"><?php echo e($desg->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6" id="internshipTenureDiv" style="display: none">
                                            <div class="form-group">
                                                <label>Internship Tenure <span class="text-danger">*</span></label>
                                                <select class="select" name="internship_tenure" id="internshipTenure">
                                                    <option
                                                        value="<?php echo e(!empty($userDetails[0]->tenure) ? $userDetails[0]->tenure: ''); ?>"><?php echo e(!empty($userDetails[0]->tenure) ? $userDetails[0]->tenure: ''); ?></option>
                                                    <option value="">Select Tenure</option>
                                                    <option value="2 Weeks">2 Weeks</option>
                                                    <option value="1 Month">1 Month</option>
                                                    <option value="2 Month">2 Month</option>
                                                    <option value="3 Month">3 Month</option>
                                                </select>
                                            </div>
                                        </div>

                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        

                                        <div class="col-md-6" id="stipendDiv" style="display: none">
                                            <div class="form-group">
                                                <label>Stipend Amount <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text"
                                                       name="stipend"
                                                       value="<?php echo e(!empty($userDetails[0]->stipend) ? $userDetails[0]->stipend: ''); ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6" id="gradDateDiv" style="display: none">
                                            <div class="form-group">
                                                <label class="col-form-label">Expected Graduation Date</label>
                                                <div class=""><input class="form-control" name="grad_date"
                                                                     value="<?php echo e(!empty($userDetails[0]->expected_grad_date) ? $userDetails[0]->expected_grad_date: ''); ?>"
                                                                     type="date"></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">CNIC <span
                                                        class="text-danger">*</span></label>
                                                <div class="">

                                                    <input class="form-control" type="text"
                                                           placeholder="XXXXX-XXXXXXX-X" name="cnic"
                                                           value="<?php echo e(!empty($userDetails[0]->cnic) ? $userDetails[0]->cnic: ''); ?>"
                                                           required="required">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Contact </label>
                                                <div class=""><input class="form-control" name="phone" type="tel"
                                                                     pattern="[0-9]{4}[0-9]{7}"
                                                                     value="<?php echo e(!empty($userDetails[0]->phone) ? $userDetails[0]->phone: ''); ?>"
                                                                     placeholder="0321-1234567" required="required">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Emergency Contact <span
                                                        class="text-danger">*</span> </label>
                                                <div class=""><input class="form-control" name="emg_phone" type="tel"
                                                                     pattern="[0-9]{4}[0-9]{7}"
                                                                     value="<?php echo e(!empty($userDetails[0]->emergency_contact) ? $userDetails[0]->emergency_contact: ''); ?>"
                                                                     placeholder="0321-1234567" required="required">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Name of Emergency Contact <span
                                                        class="text-danger">*</span> </label>
                                                <div class="">
                                                    <input type="text" name="emg_name" class="form-control"
                                                           value="<?php echo e(!empty($userDetails[0]->emg_name) ? $userDetails[0]->emg_name: ''); ?>"
                                                           required="required">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Relationship with Emergency Contact <span
                                                        class="text-danger">*</span> </label>
                                                <div class="">
                                                    <select class="select" name="emg_relation" required="required">
                                                        <option
                                                            value="<?php echo e(!empty($userDetails[0]->emg_relation) ? $userDetails[0]->emg_relation: ''); ?>"><?php echo e(!empty($userDetails[0]->relationTitle) ? $userDetails[0]->relationTitle: ''); ?></option>

                                                        <option value="">Select Relationship</option>
                                                        <?php $__currentLoopData = $relatives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relative): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option
                                                                value="<?php echo e($relative->id); ?>"><?php echo e($relative->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Birthday </label>
                                                <div class=""><input class="form-control" name="dob" type="date"
                                                                     value="<?php echo e(!empty($userDetails[0]->birthday) ? $userDetails[0]->birthday: ''); ?>"
                                                                     required="required"></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Nationality <span
                                                        class="text-danger">*</span></label>

                                                <select class="select" name="nationality" required="required">
                                                    <option
                                                        value="<?php echo e(!empty($userDetails[0]->nationality) ? $userDetails[0]->nationality: ''); ?>"><?php echo e(!empty($userDetails[0]->national) ? $userDetails[0]->national: ''); ?></option>

                                                    <option value="">Select Nationality</option>
                                                    <?php $__currentLoopData = $nationality; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($nation->id); ?>"><?php echo e($nation->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Religion <span
                                                        class="text-danger">*</span></label>
                                                <select class="select" name="religion" required="required">
                                                    <option
                                                        value="<?php echo e(!empty($userDetails[0]->religion) ? $userDetails[0]->religion: ''); ?>"><?php echo e(!empty($userDetails[0]->religions) ? $userDetails[0]->religions: ''); ?></option>

                                                    <option value="">Select Religion</option>
                                                    <?php $__currentLoopData = $religions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $religion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($religion->id); ?>"><?php echo e($religion->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Gender </label>
                                                <select class="select" name="gender" required="required">
                                                    <option
                                                        value="<?php echo e(!empty($userDetails[0]->gender) ? $userDetails[0]->gender: ''); ?>"><?php echo e(!empty($userDetails[0]->genderTitle) ? $userDetails[0]->genderTitle: ''); ?></option>

                                                    <option value="">Select Gender</option>
                                                    <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($gender->id); ?>"><?php echo e($gender->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Marital Status <span
                                                        class="text-danger">*</span></label>
                                                <select class="select" name="marital" required="required">
                                                    <option
                                                        value="<?php echo e(!empty($userDetails[0]->marital_status) ? $userDetails[0]->marital_status: ''); ?>"><?php echo e(!empty($userDetails[0]->marital) ? $userDetails[0]->marital: ''); ?></option>

                                                    <option value="">Select Marital Status</option>
                                                    <?php $__currentLoopData = $maritals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marital): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($marital->id); ?>"><?php echo e($marital->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Reports To </label>
                                                <select class="select" name="report_to" required="required">
                                                    <option
                                                        value="<?php echo e(!empty($userDetails[0]->am_id) ? $userDetails[0]->am_id: ''); ?>"><?php echo e(!empty($userDetails[0]->managerName) ? $userDetails[0]->managerName: ''); ?></option>

                                                    <option value="">Select Reports to</option>
                                                    <?php $__currentLoopData = $all_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($users->id); ?>"><?php echo e($users->display_name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Linkedin </label>
                                                <input class="form-control" name="linkedin"
                                                       value="<?php echo e(!empty($userDetails[0]->linkedin) ? $userDetails[0]->linkedin: ''); ?>"
                                                       type="text">
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Show on Website </label>

                                                <select class="select" name="web_check" required="required">

                                                    <?php if($userDetails[0]->profile_on_web == 0): ?>
                                                        <option value="0">No</option>
                                                    <?php else: ?>
                                                        <option value="1">Yes</option>
                                                    <?php endif; ?>


                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Latest Qualification <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="last_qualification"
                                                       value="<?php echo e(!empty($userDetails[0]->last_qualification) ? $userDetails[0]->last_qualification: ''); ?>"
                                                       type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Exp. Outside PACRA<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="exp_outside_pacra"
                                                       value="<?php echo e(!empty($userDetails[0]->exp_outside_pacra) ? $userDetails[0]->exp_outside_pacra: ''); ?>"
                                                       type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Exp. In PACRA<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="exp_in_pacra"
                                                       
                                                       value="<?php echo e(!empty($experienceInPacra) ? $experienceInPacra: ''); ?>"
                                                       
                                                       type="text" readonly>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Last Employer<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="last_employer"
                                                       value="<?php echo e(!empty($userDetails[0]->last_employer) ? $userDetails[0]->last_employer: ''); ?>"
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Address </label>
                                                <input class="form-control" name="address" type="text"
                                                       value="<?php echo e(!empty($userDetails[0]->address) ? $userDetails[0]->address: ''); ?>"
                                                       required="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Current Leave Balance </label>
                                                <input class="form-control" type="text" name="c_leaves"
                                                       value="<?php echo e(!empty($get_cleaves_bal[0]->current_balance) ? $get_cleaves_bal[0]->current_balance: ''); ?>"
                                                       required="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label"> - Leave Balance (c/f) </label>
                                                <input class="form-control" type="text" name="n_leaves"
                                                       value="<?php echo e(!empty($getnLeaves_bal[0]->negative_balance) ? $getnLeaves_bal[0]->negative_balance: ''); ?>">
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label"> CV </label>
                                                <?php if(empty($userDetails[0]->cv)): ?>
                                                    <input type="file" name="file" id="file">
                                                    <small id="fileHelp" class="form-text text-muted">Please upload a
                                                        valid file.</small>
                                                <?php else: ?>

                                                    <input type="file" name="file" id="file">
                                                    <small id="fileHelp" class="form-text text-muted">Please upload New
                                                        CV.</small>
                                                    <a href="<?php echo e(url($userDetails[0]->cv)); ?>" target="_blank">View
                                                        Existing CV</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="hidden" name="old_image"
                                                       value="<?php echo e(!empty($userDetails[0]->avatar_file) ? $userDetails[0]->avatar_file: ''); ?>"
                                                       required="required">
                                                <input class="form-control" type="hidden" name="old_cv"
                                                       value="<?php echo e(!empty($userDetails[0]->cv) ? $userDetails[0]->cv: ''); ?>"
                                                       required="required">
                                                <input class="form-control" type="hidden" name="recordID"
                                                       value="<?php echo e(!empty($userDetails[0]->ID) ? $userDetails[0]->ID: ''); ?>"
                                                       required="required">
                                                <input class="form-control" type="hidden" name="user_id"
                                                       value="<?php echo e(!empty($userDetails[0]->ID) ? $userDetails[0]->ID: ''); ?>"
                                                       required="required">
                                                
                                                
                                                


                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" name="submit" type="submit" value="submit">
                                    Submit
                                </button>
                                <?php if(in_array('6', $user_rights) ): ?>
                                    <button class="btn btn-primary submit-btn btn-success" name="submit" type="submit"
                                            value="approve"> Approve
                                    </button>
                                <?php endif; ?>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Profile Modal -->


    </div>
    <!-- /Page Wrapper -->

    <div class="modal fade"
         id=<?php echo e('modalLong' . $userDetails[0]->ID); ?> tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Termination Reason of
                        : <?php echo e($userDetails[0]->display_name); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST"
                          action="<?php echo e(route('terminate-employee', ['id' => $userDetails[0]->ID])); ?>"
                          enctype="multipart/form-data" files="true">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="reason" class="col-form-label">Reason:</label>
                            <textarea cols="5" rows="10" class="form-control" id="reason"
                                      required="required"
                                      name="termination_reason"
                                      placeholder="Enter termination reason..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="reason" class="col-form-label">Termination Date:</label>
                            <input class="form-control" type="date"
                                   min=<?php echo e($userDetails[0]->doj); ?> name="termination_date">
                        </div>
                        <div class="form-group">
                            <label for="reason" class="col-form-label">Last Working Date:</label>
                            <input class="form-control" type="date" min=<?php echo e($userDetails[0]->doj); ?> name="last_date">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn btn-success btn-sm" name="submit"
                                    value="entered"
                                    type="submit">Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade"
         id=<?php echo e('modalLongEndInternship' . $userDetails[0]->ID); ?> tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">End Internship Reason of
                        : <?php echo e($userDetails[0]->display_name); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST"
                          action="<?php echo e(route('end-internship', ['id' => $userDetails[0]->ID, 'status' => 'Entered'])); ?>"
                          enctype="multipart/form-data" files="true">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="reason" class="col-form-label">Reason:</label>
                            <textarea cols="5" rows="10" class="form-control" id="reason"
                                      required="required"
                                      name="reason"
                                      placeholder="Enter End Internship reason..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="reason" class="col-form-label">End Internship Date:</label>
                            <input class="form-control" type="date"
                                   min=<?php echo e($userDetails[0]->doj); ?> name="end_date">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn btn-success btn-sm" name="submit"
                                    value="entered"
                                    type="submit">Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade"
         id=<?php echo e('modalLongExtendInternship' . $userDetails[0]->ID); ?> tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Extend Internship Reason of
                        : <?php echo e($userDetails[0]->display_name); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST"
                          action="<?php echo e(route('extend-internship', ['id' => $userDetails[0]->ID, 'status' => 'Entered'])); ?>"
                          enctype="multipart/form-data" files="true">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="reason" class="col-form-label">Reason:</label>
                            <textarea cols="5" rows="10" class="form-control" id="reason"
                                      required="required"
                                      name="reason"
                                      placeholder="Enter Extend Internship reason..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="reason" class="col-form-label">Extended Internship Date:</label>
                            <input class="form-control" type="date"
                                   min=<?php echo e($userDetails[0]->doj); ?> name="extended_date">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn btn-success btn-sm" name="submit"
                                    value="entered"
                                    type="submit">Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/profile.blade.php ENDPATH**/ ?>