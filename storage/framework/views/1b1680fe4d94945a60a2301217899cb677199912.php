<?php $__env->startSection('content'); ?>
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title"><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?></li>
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
                                        <?php if(empty($getProfileDetails->first()->image)): ?>
                                            <a href="#">

                                                <img alt="" src="<?php echo e(asset('candidates/')); ?>">
                                            </a>
                                        <?php else: ?>
                                            <a href="#">

                                                <img alt=""
                                                     src="<?php echo e(url('https://209.97.168.200/pacra-job-portal/public/users/'.$getProfileDetails->first()->image)); ?>">
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0"><?php echo e($getProfileDetails->first()->fname); ?> <?php echo e($getProfileDetails->first()->lname); ?></h3>
                                                <small class="text-muted"><?php echo e($getJobAd->jobTitle); ?></small>

                                                <div
                                                    class="small doj text-muted">Expected
                                                    DOJ: <?php echo e(($getJobApplyDate->expected_doj == '')?('N/A'):($getJobApplyDate->expected_doj)); ?></div>
                                                <div
                                                    class="small doj text-muted">Expected
                                                    Salary: <?php echo e($getJobApplyDate->expected_salary ?? 'N/A'); ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a
                                                            href=""><?php echo e(!empty($getProfileDetails->first()->contactNumber) ? $getProfileDetails->first()->contactNumber: ''); ?></a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a
                                                            href=""><?php echo e($getProfileDetails->first()->email); ?></a></div>
                                                </li>
                                                <li>
                                                    <div class="title">DOB:</div>
                                                    <div
                                                        class="text"><?php echo e(($getProfileDetails->first()->dob == '')?('N/A'):(date('d-M-y', strtotime($getProfileDetails->first()->dob)))); ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Address:</div>
                                                    <div
                                                        class="text"><?php echo e(!empty($getProfileDetails->first()->address) ? $getProfileDetails->first()->address: ''); ?></div>
                                                </li>
                                                

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-edit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card tab-box">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item"><a href="#emp_history" data-toggle="tab" class="nav-link">History</a>
                            </li>
                            <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">Profile</a>
                            </li>
                            <li class="nav-item"><a href="#cv" data-toggle="tab" class="nav-link">CV</a></li>
                            <li class="nav-item"><a href="#JobAd" data-toggle="tab" class="nav-link">Job Ad</a></li>
                            <li class="nav-item"><a href="#progress" data-toggle="tab" class="nav-link">Progress</a>
                            </li>
                            <li class="nav-item"><a href="#eduDocs" data-toggle="tab" class="nav-link">Educational
                                    Docs</a></li>
                            <li class="nav-item"><a href="#aboutYourself" data-toggle="tab" class="nav-link">About
                                    Yourself</a></li>
                            

                            <?php if($getCandidateTest->count() >= 1): ?>
                                <li class="nav-item"><a href="#candidateTest" data-toggle="tab"
                                                        class="nav-link">Test</a>
                                </li>
                            <?php endif; ?>

                            <?php if($getCandidateInterviewSheetsHR->count() >= 1 && $getCandidateInterviewSheetsTL->count() >= 1): ?>
                                <li class="nav-item"><a href="#candidateInterviewSheetHR"
                                                        data-toggle="tab"
                                                        class="nav-link">Interview Sheet HR</a></li>

                                <li class="nav-item"><a href="#candidateInterviewSheetTL"
                                                        data-toggle="tab"
                                                        class="nav-link">Interview Sheet TL</a></li>
                            <?php endif; ?>

                            <?php if($getCandidateInterviewSheetsUH->count() >= 1): ?>
                                <li class="nav-item"><a href="#candidateInterviewSheetUH"
                                                        data-toggle="tab"
                                                        class="nav-link">Interview Sheet VC</a></li>
                            <?php endif; ?>

                            <?php if($getCandidateMiscellaneousDocs->count() >= 1): ?>
                                <?php $__currentLoopData = $getCandidateMiscellaneousDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$getCandidateMiscellaneousDoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item"><a href="#candidateMiscDoc<?php echo e($index+1); ?>" data-toggle="tab"
                                                            class="nav-link">Misc. Doc<?php echo e($index+1); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php if(\Illuminate\Support\Facades\Auth::id() == 103 || \Illuminate\Support\Facades\Auth::id() == 9): ?>
                                <li class="nav-item"><a href="#salary" data-toggle="tab" class="nav-link">Salary</a>
                                </li>
                                <li class="nav-item"><a target="_blank"
                                                        href="<?php echo e(route ('appointmentLetter', ['userID' => $userID, 'jobID' => $jobID ])); ?>"
                                                        class="nav-link">Appointment Letter</a></li>
                            <?php endif; ?>


                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content">


                <div class="tab-pane fade" id="emp_history">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">History with PACRA</h3>
                                    <?php if($getIfPacra == []): ?>
                                        <div class="card-body table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Position</th>
                                                    <th>Team</th>
                                                    <th>Joining Date</th>
                                                    <th>Leaving Date</th>
                                                </tr>
                                                </thead>
                                                <?php $__currentLoopData = $getIfPacra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $IfPacra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tbody>
                                                    <tr>
                                                        <td><?php echo e($IfPacra->designation); ?></td>
                                                        <?php $teamName = \App\Models\Employees\UsersModel::select('display_name')->where('id', $IfPacra->team)->get(); ?>
                                                        <td><?php echo e($teamName[0]->display_name); ?></td>

                                                        <td><?php echo e(date('d-M-y', strtotime($IfPacra->doj))); ?></td>
                                                        <td><?php echo e($IfPacra->last_working_day ? date('d-M-y', strtotime($IfPacra->last_working_day)) : 'Still at PACRA'); ?></td>
                                                    </tr>
                                                    </tbody>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <p>No History with PACRA</p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title">Jobs Applied</h3>
                                    <div class="card-body table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Position</th>
                                                <th>Applied On</th>
                                                <th>Status</th>
                                                <th>Rejected (if)</th>
                                            </tr>
                                            </thead>
                                            <?php $__currentLoopData = $getEmpAllAppliedJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobsApplied): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tbody>
                                                <tr>
                                                    <td><?php echo e($jobsApplied->jobTitlesTable); ?></td>
                                                    <td><?php echo e(date('d-M-y', strtotime($jobsApplied->applyDate))); ?></td>
                                                    <td><?php echo e($jobsApplied->candidateStatus); ?></td>
                                                    <td class="truncate"
                                                        title="<?php echo e(str_replace($spam, ' ', $jobsApplied->title)); ?>"><?php echo e(str_replace($spam, ' ', $jobsApplied->title)); ?></td>
                                                </tr>
                                                </tbody>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Info Tab -->
                <div id="emp_profile" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Personal Information</h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">CNIC</div>
                                            <div
                                                class="text"><?php echo e(!empty($getPersonalInfo->first()->cnic) ? $getPersonalInfo->first()->cnic: ''); ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Gender</div>
                                            <div
                                                class="text"><?php echo e(!empty($getPersonalInfo->first()->ugender) ? $getPersonalInfo->first()->ugender: ''); ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Nationality</div>
                                            <div
                                                class="text"><?php echo e(!empty($getPersonalInfo->first()->national) ? $getPersonalInfo->first()->national: ''); ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Religion</div>
                                            <div
                                                class="text"><?php echo e(!empty($getPersonalInfo->first()->ureligion) ? $getPersonalInfo->first()->ureligion: ''); ?></div>
                                        </li>

                                        <li>
                                            <div class="title">Marital status</div>
                                            <div
                                                class="text"><?php echo e(!empty($getPersonalInfo->first()->marital) ? $getPersonalInfo->first()->marital: ''); ?></div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Emergency Contact</h3>
                                    <h5 class="section-title">Primary</h5>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Name</div>
                                            <div
                                                class="text"><?php echo e(!empty($getEmergencyContacts->first()->contactNameOne) ? $getEmergencyContacts->first()->contactNameOne: ''); ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Relationship</div>
                                            <div
                                                class="text"><?php echo e(!empty($getEmergencyContacts->first()->relativeOne) ? $getEmergencyContacts->first()->relativeOne: ''); ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Phone</div>
                                            <div
                                                class="text"><?php echo e(!empty($getEmergencyContacts->first()->phoneOne) ? $getEmergencyContacts->first()->phoneOne: ''); ?></div>
                                        </li>
                                    </ul>
                                    <hr>
                                    <h5 class="section-title">Secondary</h5>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Name</div>
                                            <div
                                                class="text"><?php echo e(!empty($getEmergencyContacts->first()->contactNameTwo) ? $getEmergencyContacts->first()->contactNameTwo: ''); ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Relationship</div>
                                            <div
                                                class="text"><?php echo e(!empty($getEmergencyContacts->first()->relativeTwo) ? $getEmergencyContacts->first()->relativeTwo: ''); ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Phone</div>
                                            <div
                                                class="text"><?php echo e(!empty($getEmergencyContacts->first()->phoneTwo) ? $getEmergencyContacts->first()->phoneTwo: ''); ?></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Education Information</h3>
                                    <div class="experience-box">
                                        <ul class="experience-list">
                                            <?php $__currentLoopData = $getEducations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $education): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            <?php if($education->title == 'Other'): ?>
                                                                <a href="#/" class="name"><?php echo e($education->other); ?></a>
                                                            <?php else: ?>
                                                                <a href="#/" class="name"><?php echo e($education->title); ?></a>
                                                            <?php endif; ?>
                                                            <div><?php echo e($education->degree); ?></div>
                                                            <span
                                                                class="time"><?php echo e($education->startingDate); ?> - <?php echo e($education->completeDate); ?></span>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Experience</h3>
                                    <div class="experience-box">
                                        <ul class="experience-list">
                                            <?php $__currentLoopData = $getExperience; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $experience): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>

                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            <?php if($experience->fresh == 1): ?>
                                                                <a href="#/" class="name">Fresh / No Experience</a>
                                                            <?php else: ?>
                                                                <a href="#/"
                                                                   class="name"><?php echo e($experience->jobPosition); ?>

                                                                    at <?php echo e($experience->companyName); ?></a>
                                                                <span class="time"><?php echo e(date('d-M-y',strtotime($experience->periodFrom))); ?> -- <?php echo e(date('d-M-y', strtotime($experience->periodTo))); ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </li>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </ul>
                                    </div>
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
                            data="<?php echo e('https://209.97.168.200/pacra-job-portal/public/' . $getProfileDetails[0]->cv); ?>"
                            type="application/pdf" width="100%"
                            align="middle" height="800px">
                        </object>

                    </div>
                </div>
                <!-- /CV Tab -->

                <div class="tab-pane fade" id="JobAd">
                    <div id="emp_profile" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        
                                        <div class="form-group">
                                            
                                            

                                            <h3>Description</h3>
                                            <?php echo $finalJobAd[0]->description; ?>


                                            <h3>Requirements</h3>
                                            <?php echo $finalJobAd[0]->requirements; ?>


                                            <h3>What we expect from you</h3>
                                            <?php echo $finalJobAd[0]->jobExpectations; ?>


                                            
                                            

                                            <h3>Salary Bracket</h3>
                                            <p><?php echo e($finalJobAd[0]->salary); ?></p>


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <!-- /JobAd Tab -->

                <div class="tab-pane fade" id="progress">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Progress</h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Job Applied Date</div>
                                            <div
                                                class="text"><?php echo e(!empty($getJobApplyDate->applyDate) ? date('d-M-Y', strtotime($getJobApplyDate->applyDate)): ''); ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Test Date & Time</div>
                                            <div
                                                class="text"><?php echo e(!empty($getSelectTest->testDate) ? date('d-M-Y', strtotime($getSelectTest->testDate)) : ''); ?>

                                                <?php echo e(!empty($getSelectTest->testTime) ? \Carbon\Carbon::createFromFormat('H:i:s',$getSelectTest->testTime)->format('h:i:A'): ''); ?>

                                            </div>
                                        </li>

                                        <?php $__currentLoopData = $getInterviewRounds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getInterviewRound): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <div
                                                    class="title"><?php echo e(!empty($getInterviewRound->interviewRound) ? $getInterviewRound->interviewRound: ''); ?> <?php echo e('Interview'); ?></div>
                                                <div class="text"> <?php echo e('By'); ?>

                                                    <?php echo e(!empty($getInterviewRound->fname) ? $getInterviewRound->fname: ''); ?>

                                                    <?php echo e(!empty($getInterviewRound->lname) ? $getInterviewRound->lname: ''); ?>

                                                    <?php echo e('On'); ?>

                                                    <?php echo e(!empty($getInterviewRound->date) ? date('d-M-Y', strtotime($getInterviewRound->date)) : ''); ?>

                                                    <?php echo e(!empty($getInterviewRound->time) ? \Carbon\Carbon::createFromFormat('H:i:s',$getInterviewRound->time)->format('h:i:A'): ''); ?>

                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tab-pane fade" id="aboutYourself">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">About Yourself <span class="text-danger">*</span>
                                    </h3>
                                    <ul class="personal-info">
                                        <li>

                                            <div
                                                class="text"><?php echo e(!empty($getAboutYourself->first()->aboutYourSelf) ? $getAboutYourself->first()->aboutYourSelf: ''); ?></div>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /Progress Tab -->

                <!-- candidateTest Tab -->
                <div class="tab-pane fade" id="candidateTest">
                    <div class="row">

                        
                        
                        

                        <?php if(($getCandidateTest->first()->scannedTest ?? '0') != 0): ?>
                            <object
                                data="<?php echo e(asset($getCandidateTest->first()->scannedTest ?? '')); ?>"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        <?php else: ?>
                            <h4>NO Data Available.</h4>
                        <?php endif; ?>


                    </div>
                </div>
                <!-- /CV Tab -->

                <!-- EngagementForm Tab -->
            
            <!-- /EngagementForm -->

                
                
                
                
                
                
                

                
                

                
                <div class="tab-pane fade" id="candidateInterviewSheetHR">
                    <div class="row">
                        
                        
                        

                        <?php if($getCandidateInterviewSheetsHR[0]->interviewSheetHR ?? ''): ?>
                            <object
                                data="<?php echo e(asset($getCandidateInterviewSheetsHR[0]->interviewSheetHR ?? '')); ?>"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        <?php else: ?>
                            <h4>NO Data Available.</h4>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="tab-pane fade" id="candidateInterviewSheetTL">
                    <div class="row">
                        
                        
                        

                        <?php if($getCandidateInterviewSheetsTL[0]->interviewSheetTL ?? ''): ?>
                            <object
                                data="<?php echo e(asset($getCandidateInterviewSheetsTL[0]->interviewSheetTL ?? '')); ?>"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        <?php else: ?>
                            <h4>NO Data Available.</h4>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="tab-pane fade" id="candidateInterviewSheetUH">
                    <div class="row">
                        
                        
                        

                        
                        <?php if($getCandidateInterviewSheetsUH[0]->interviewSheetUH ?? ''): ?>
                            <object
                                data="<?php echo e(asset($getCandidateInterviewSheetsUH[0]->interviewSheetUH ?? '')); ?>"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        <?php else: ?>
                            <h4>NO Data Available.</h4>
                        <?php endif; ?>

                    </div>
                </div>
                <?php $__currentLoopData = $getEducations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getEducation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tab-pane fade" id="eduDocs">
                        <div class="row">
                            <object
                                data="<?php echo e('https://209.97.168.200/pacra-job-portal/public/' . $getEducation->degreeFile); ?>"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                
                
                
                
                
                
                

                
                

                

                <?php $__currentLoopData = $getExperience; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getExperiences): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tab-pane fade" id="eduDocs">
                        <div class="row">
                            <object
                                data="<?php echo e(asset($getExperiences->degreeFile)); ?>"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        </div>
                    </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php $__currentLoopData = $getCandidateMiscellaneousDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$getCandidateMiscellaneousDoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- candidateTest Tab -->
                    <div class="tab-pane fade" id="candidateMiscDoc<?php echo e($index+1); ?>">
                        <div class="row">
                            <?php if($getCandidateMiscellaneousDoc->miscellaneousDoc): ?>
                                <object
                                    data="<?php echo e(asset($getCandidateMiscellaneousDoc->miscellaneousDoc)); ?>"
                                    type="application/pdf" width="100%" align="middle" height="800px"></object>
                            <?php else: ?>
                                <h4>NO Data Available.</h4>
                            <?php endif; ?>
                        </div>
                    </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Salary Tab -->
                <div class="tab-pane fade" id="salary">

                    
                    <form method="POST" action="<?php echo e(route('hiringDecisionSalary')); ?>" enctype="multipart/form-data"
                          files="true">
                        <?php echo csrf_field(); ?>
                        <?php if(\Illuminate\Support\Facades\Auth::id() == 103 || \Illuminate\Support\Facades\Auth::id() == 9): ?>
                            <div class="row">

                                <div class="col-md-6 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title">During Probation</h3>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Gross Salary (Minimum)</div>

                                                    <div class="text">
                                                        <input type="number" name="probBasicSalaryMin"
                                                               value="<?php echo e(!empty($getCandidateSalary->probBasicSalaryMin) ? $getCandidateSalary->probBasicSalaryMin: ''); ?>"
                                                               class="form-control">
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Gross Salary (Maximum)</div>
                                                    <div class="text">
                                                        <input type="number" name="probBasicSalary"
                                                               value="<?php echo e(!empty($getCandidateSalary->probBasicSalary) ? $getCandidateSalary->probBasicSalary: ''); ?>"
                                                               class="form-control">


                                                    </div>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title">On Confirmation</h3>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Gross Salary (Minimum)</div>
                                                    <div class="text">
                                                        <input type="number" name="confirmationSalaryMin"
                                                               value="<?php echo e(!empty($getCandidateSalary->confirmationSalaryMin) ? $getCandidateSalary->confirmationSalaryMin: ''); ?>"
                                                               class="form-control">


                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Gross Salary (Maximum)</div>
                                                    <div class="text">
                                                        <input type="number" name="confirmationSalary"
                                                               value="<?php echo e(!empty($getCandidateSalary->confirmationSalary) ? $getCandidateSalary->confirmationSalary: ''); ?>"
                                                               class="form-control">


                                                    </div>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php else: ?>
                            <div class="row">

                                <div class="col-md-6 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title">During Probation</h3>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Gross Salary (Minimum)</div>

                                                    <div class="text">
                                                        <input type="number" name="probBasicSalaryMin"
                                                               value="<?php echo e(!empty($getCandidateSalary->probBasicSalaryMin) ? $getCandidateSalary->probBasicSalaryMin: ''); ?>"
                                                               class="form-control" readonly>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Gross Salary (Maximum)</div>
                                                    <div class="text">
                                                        <input type="number" name="probBasicSalary"
                                                               value="<?php echo e(!empty($getCandidateSalary->probBasicSalary) ? $getCandidateSalary->probBasicSalary: ''); ?>"
                                                               class="form-control" readonly>


                                                    </div>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title">On Confirmation</h3>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Gross Salary (Minimum)</div>
                                                    <div class="text">
                                                        <input type="number" name="confirmationSalaryMin"
                                                               value="<?php echo e(!empty($getCandidateSalary->confirmationSalaryMin) ? $getCandidateSalary->confirmationSalaryMin: ''); ?>"
                                                               class="form-control" readonly>


                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Gross Salary (Maximum)</div>
                                                    <div class="text">
                                                        <input type="number" name="confirmationSalary"
                                                               value="<?php echo e(!empty($getCandidateSalary->confirmationSalary) ? $getCandidateSalary->confirmationSalary: ''); ?>"
                                                               class="form-control" readonly>


                                                    </div>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="userID"
                               value="<?php echo e(!empty($getCandidateSalary->userID) ? $getCandidateSalary->userID: ''); ?>">
                        <input type="hidden" name="candidateID"
                               value="<?php echo e(!empty($getCandidateSalary->candidateID) ? $getCandidateSalary->candidateID: ''); ?>">
                        <input type="hidden" name="jobID"
                               value="<?php echo e(!empty($getCandidateSalary->jobID) ? $getCandidateSalary->jobID: ''); ?>">
                        <?php if(\Illuminate\Support\Facades\Auth::id() == 9): ?>
                            <button class="btn btn-primary submit-btn btn-success" name="submit" type="submit"
                                    value="Shortlist By CEO">Appoint
                            </button>
                            <button class="btn btn-primary submit-btn btn-info" name="submit" type="submit"
                                    value="hold">
                                Hold
                            </button>
                            <button class="btn btn-primary submit-btn btn-danger" name="submit" type="submit"
                                    value="reject">Reject
                            </button>
                        <?php endif; ?>

                    </form>
                </div>
                <!-- /Salary Tab -->

            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- /Page Wrapper -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/candidateProfile.blade.php ENDPATH**/ ?>