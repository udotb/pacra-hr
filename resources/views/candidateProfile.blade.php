@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</li>
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
                                        @if(empty($getProfileDetails->first()->image))
                                            <a href="#">

                                                <img alt="" src="{{asset('candidates/')}}">
                                            </a>
                                        @else
                                            <a href="#">

                                                <img alt=""
                                                     src="{{url('https://209.97.168.200/pacra-job-portal/public/users/'.$getProfileDetails->first()->image)}}">
                                            </a>
                                        @endif

                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{$getProfileDetails->first()->fname}} {{$getProfileDetails->first()->lname}}</h3>
                                                <small class="text-muted">{{$getJobAd->jobTitle}}</small>

                                                <div
                                                    class="small doj text-muted">Expected
                                                    DOJ: {{ ($getJobApplyDate->expected_doj == '')?('N/A'):($getJobApplyDate->expected_doj) }}</div>
                                                <div
                                                    class="small doj text-muted">Expected
                                                    Salary: {{$getJobApplyDate->expected_salary ?? 'N/A'}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a
                                                            href="">{{!empty($getProfileDetails->first()->contactNumber) ? $getProfileDetails->first()->contactNumber: ''}}</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a
                                                            href="">{{$getProfileDetails->first()->email}}</a></div>
                                                </li>
                                                <li>
                                                    <div class="title">DOB:</div>
                                                    <div
                                                        class="text">{{($getProfileDetails->first()->dob == '')?('N/A'):(date('d-M-y', strtotime($getProfileDetails->first()->dob)))}}</div>
                                                </li>
                                                <li>
                                                    <div class="title">Address:</div>
                                                    <div
                                                        class="text">{{!empty($getProfileDetails->first()->address) ? $getProfileDetails->first()->address: ''}}</div>
                                                </li>
                                                {{--<li>
                                                    <div class="title">Gender:</div>
                                                    <div class="text">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</div>
                                                </li>--}}

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
                            {{--                            <li class="nav-item"><a href="#emp_docs" data-toggle="tab" class="nav-link">Employment Docs</a></li>--}}

                            @if($getCandidateTest->count() >= 1)
                                <li class="nav-item"><a href="#candidateTest" data-toggle="tab"
                                                        class="nav-link">Test</a>
                                </li>
                            @endif

                            @if($getCandidateInterviewSheetsHR->count() >= 1 && $getCandidateInterviewSheetsTL->count() >= 1)
                                <li class="nav-item"><a href="#candidateInterviewSheetHR"
                                                        data-toggle="tab"
                                                        class="nav-link">Interview Sheet HR</a></li>

                                <li class="nav-item"><a href="#candidateInterviewSheetTL"
                                                        data-toggle="tab"
                                                        class="nav-link">Interview Sheet TL</a></li>
                            @endif

                            @if($getCandidateInterviewSheetsUH->count() >= 1)
                                <li class="nav-item"><a href="#candidateInterviewSheetUH"
                                                        data-toggle="tab"
                                                        class="nav-link">Interview Sheet VC</a></li>
                            @endif

                            @if($getCandidateMiscellaneousDocs->count() >= 1)
                                @foreach($getCandidateMiscellaneousDocs as $index=>$getCandidateMiscellaneousDoc)
                                    <li class="nav-item"><a href="#candidateMiscDoc{{$index+1}}" data-toggle="tab"
                                                            class="nav-link">Misc. Doc{{$index+1}}</a></li>
                                @endforeach
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::id() == 103 || \Illuminate\Support\Facades\Auth::id() == 9)
                                <li class="nav-item"><a href="#salary" data-toggle="tab" class="nav-link">Salary</a>
                                </li>
                                <li class="nav-item"><a target="_blank"
                                                        href="{{ route ('appointmentLetter', ['userID' => $userID, 'jobID' => $jobID ]) }}"
                                                        class="nav-link">Appointment Letter</a></li>
                            @endif


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
                                    @if($getIfPacra == [])
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
                                                @foreach($getIfPacra as $IfPacra)
                                                    <tbody>
                                                    <tr>
                                                        <td>{{$IfPacra->designation}}</td>
                                                        <?php $teamName = \App\Models\Employees\UsersModel::select('display_name')->where('id', $IfPacra->team)->get(); ?>
                                                        <td>{{$teamName[0]->display_name}}</td>

                                                        <td>{{date('d-M-y', strtotime($IfPacra->doj))}}</td>
                                                        <td>{{$IfPacra->last_working_day ? date('d-M-y', strtotime($IfPacra->last_working_day)) : 'Still at PACRA'}}</td>
                                                    </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                    @else
                                        <p>No History with PACRA</p>
                                    @endif
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
                                            @foreach($getEmpAllAppliedJobs as $jobsApplied)
                                                <tbody>
                                                <tr>
                                                    <td>{{$jobsApplied->jobTitlesTable}}</td>
                                                    <td>{{date('d-M-y', strtotime($jobsApplied->applyDate))}}</td>
                                                    <td>{{$jobsApplied->candidateStatus}}</td>
                                                    <td class="truncate"
                                                        title="{{ str_replace($spam, ' ', $jobsApplied->title)}}">{{ str_replace($spam, ' ', $jobsApplied->title) }}</td>
                                                </tr>
                                                </tbody>
                                            @endforeach
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
                                                class="text">{{!empty($getPersonalInfo->first()->cnic) ? $getPersonalInfo->first()->cnic: ''}}</div>
                                        </li>
                                        <li>
                                            <div class="title">Gender</div>
                                            <div
                                                class="text">{{!empty($getPersonalInfo->first()->ugender) ? $getPersonalInfo->first()->ugender: ''}}</div>
                                        </li>
                                        <li>
                                            <div class="title">Nationality</div>
                                            <div
                                                class="text">{{!empty($getPersonalInfo->first()->national) ? $getPersonalInfo->first()->national: ''}}</div>
                                        </li>
                                        <li>
                                            <div class="title">Religion</div>
                                            <div
                                                class="text">{{!empty($getPersonalInfo->first()->ureligion) ? $getPersonalInfo->first()->ureligion: ''}}</div>
                                        </li>

                                        <li>
                                            <div class="title">Marital status</div>
                                            <div
                                                class="text">{{!empty($getPersonalInfo->first()->marital) ? $getPersonalInfo->first()->marital: ''}}</div>
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
                                                class="text">{{!empty($getEmergencyContacts->first()->contactNameOne) ? $getEmergencyContacts->first()->contactNameOne: ''}}</div>
                                        </li>
                                        <li>
                                            <div class="title">Relationship</div>
                                            <div
                                                class="text">{{!empty($getEmergencyContacts->first()->relativeOne) ? $getEmergencyContacts->first()->relativeOne: ''}}</div>
                                        </li>
                                        <li>
                                            <div class="title">Phone</div>
                                            <div
                                                class="text">{{!empty($getEmergencyContacts->first()->phoneOne) ? $getEmergencyContacts->first()->phoneOne: ''}}</div>
                                        </li>
                                    </ul>
                                    <hr>
                                    <h5 class="section-title">Secondary</h5>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Name</div>
                                            <div
                                                class="text">{{!empty($getEmergencyContacts->first()->contactNameTwo) ? $getEmergencyContacts->first()->contactNameTwo: ''}}</div>
                                        </li>
                                        <li>
                                            <div class="title">Relationship</div>
                                            <div
                                                class="text">{{!empty($getEmergencyContacts->first()->relativeTwo) ? $getEmergencyContacts->first()->relativeTwo: ''}}</div>
                                        </li>
                                        <li>
                                            <div class="title">Phone</div>
                                            <div
                                                class="text">{{!empty($getEmergencyContacts->first()->phoneTwo) ? $getEmergencyContacts->first()->phoneTwo: ''}}</div>
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
                                            @foreach($getEducations as $education)
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            @if($education->title == 'Other')
                                                                <a href="#/" class="name">{{$education->other}}</a>
                                                            @else
                                                                <a href="#/" class="name">{{$education->title}}</a>
                                                            @endif
                                                            <div>{{$education->degree}}</div>
                                                            <span
                                                                class="time">{{$education->startingDate}} - {{$education->completeDate}}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach

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
                                            @foreach($getExperience as $experience)
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>

                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            @if($experience->fresh == 1)
                                                                <a href="#/" class="name">Fresh / No Experience</a>
                                                            @else
                                                                <a href="#/"
                                                                   class="name">{{$experience->jobPosition}}
                                                                    at {{$experience->companyName}}</a>
                                                                <span class="time">{{date('d-M-y',strtotime($experience->periodFrom))}} -- {{date('d-M-y', strtotime($experience->periodTo))}}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>

                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--                    <div class="row">--}}
                    {{--                        <div class="col-md-12 d-flex">--}}
                    {{--                            <div class="card profile-box flex-fill">--}}
                    {{--                                <div class="card-body">--}}
                    {{--                                    <h3 class="card-title">About Yourself <span class="text-danger">*</span>--}}
                    {{--                                        --}}{{--                                        @if(empty($getAboutYourself[0]->userID))--}}
                    {{--                                        --}}{{--                                            <a data-target="#about_yourself_modal" data-toggle="modal"--}}
                    {{--                                        --}}{{--                                               class="edit-icon" href="#">--}}
                    {{--                                        --}}{{--                                                <svg width="18" height="20" fill="green" viewBox="0 0 1792 1792"--}}
                    {{--                                        --}}{{--                                                     xmlns="http://www.w3.org/2000/svg">--}}
                    {{--                                        --}}{{--                                                    <path--}}
                    {{--                                        --}}{{--                                                        d="M1600 736v192q0 40-28 68t-68 28h-416v416q0 40-28 68t-68 28h-192q-40 0-68-28t-28-68v-416h-416q-40 0-68-28t-28-68v-192q0-40 28-68t68-28h416v-416q0-40 28-68t68-28h192q40 0 68 28t28 68v416h416q40 0 68 28t28 68z"/>--}}
                    {{--                                        --}}{{--                                                </svg>--}}
                    {{--                                        --}}{{--                                            </a>--}}
                    {{--                                        --}}{{--                                        @else--}}
                    {{--                                        --}}{{--                                            <a data-target="#about_yourself_modal" data-toggle="modal"--}}
                    {{--                                        --}}{{--                                               class="edit-icon" href="#">--}}
                    {{--                                        --}}{{--                                                <svg width="18" height="20" fill="blue" viewBox="0 0 1792 1792"--}}
                    {{--                                        --}}{{--                                                     xmlns="http://www.w3.org/2000/svg">--}}
                    {{--                                        --}}{{--                                                    <path--}}
                    {{--                                        --}}{{--                                                        d="M888 1184l116-116-152-152-116 116v56h96v96h56zm440-720q-16-16-33 1l-350 350q-17 17-1 33t33-1l350-350q17-17 1-33zm80 594v190q0 119-84.5 203.5t-203.5 84.5h-832q-119 0-203.5-84.5t-84.5-203.5v-832q0-119 84.5-203.5t203.5-84.5h832q63 0 117 25 15 7 18 23 3 17-9 29l-49 49q-14 14-32 8-23-6-45-6h-832q-66 0-113 47t-47 113v832q0 66 47 113t113 47h832q66 0 113-47t47-113v-126q0-13 9-22l64-64q15-15 35-7t20 29zm-96-738l288 288-672 672h-288v-288zm444 132l-92 92-288-288 92-92q28-28 68-28t68 28l152 152q28 28 28 68t-28 68z"/>--}}
                    {{--                                        --}}{{--                                                </svg>--}}
                    {{--                                        --}}{{--                                            </a>--}}
                    {{--                                        --}}{{--                                        @endif--}}
                    {{--                                    </h3>--}}
                    {{--                                    <ul class="personal-info">--}}
                    {{--                                        <li>--}}

                    {{--                                            <div--}}
                    {{--                                                class="text">{{!empty($getAboutYourself->first()->aboutYourSelf) ? $getAboutYourself->first()->aboutYourSelf: ''}}</div>--}}
                    {{--                                        </li>--}}


                    {{--                                    </ul>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
                <!-- /Profile Info Tab -->

                <!-- CV Tab -->
                <div class="tab-pane fade" id="cv">
                    <div class="row">
                        <object
                            data="{{ 'https://209.97.168.200/pacra-job-portal/public/' . $getProfileDetails[0]->cv}}"
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
                                        {{-- <h3 class="card-title">Personal Informations </h3> --}}
                                        <div class="form-group">
                                            {{--                                            <h3>Job Title</h3>--}}
                                            {{--                                            <p>{{$finalJobAd[0]->jobTitle}}</p>--}}

                                            <h3>Description</h3>
                                            {!! $finalJobAd[0]->description !!}

                                            <h3>Requirements</h3>
                                            {!! $finalJobAd[0]->requirements !!}

                                            <h3>What we expect from you</h3>
                                            {!! $finalJobAd[0]->jobExpectations !!}

                                            {{--                                            <h3>What you have got</h3>--}}
                                            {{--                                            {!! $getJobAd->jobBenefits !!}--}}

                                            <h3>Salary Bracket</h3>
                                            <p>{{$finalJobAd[0]->salary}}</p>


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
                                                class="text">{{!empty($getJobApplyDate->applyDate) ? date('d-M-Y', strtotime($getJobApplyDate->applyDate)): ''}}</div>
                                        </li>
                                        <li>
                                            <div class="title">Test Date & Time</div>
                                            <div
                                                class="text">{{!empty($getSelectTest->testDate) ? date('d-M-Y', strtotime($getSelectTest->testDate)) : ''}}
                                                {{!empty($getSelectTest->testTime) ? \Carbon\Carbon::createFromFormat('H:i:s',$getSelectTest->testTime)->format('h:i:A'): ''}}
                                            </div>
                                        </li>

                                        @foreach ($getInterviewRounds as $getInterviewRound)
                                            <li>
                                                <div
                                                    class="title">{{!empty($getInterviewRound->interviewRound) ? $getInterviewRound->interviewRound: ''}} {{'Interview'}}</div>
                                                <div class="text"> {{'By'}}
                                                    {{!empty($getInterviewRound->fname) ? $getInterviewRound->fname: ''}}
                                                    {{!empty($getInterviewRound->lname) ? $getInterviewRound->lname: ''}}
                                                    {{'On'}}
                                                    {{!empty($getInterviewRound->date) ? date('d-M-Y', strtotime($getInterviewRound->date)) : ''}}
                                                    {{!empty($getInterviewRound->time) ? \Carbon\Carbon::createFromFormat('H:i:s',$getInterviewRound->time)->format('h:i:A'): ''}}
                                                </div>
                                            </li>
                                        @endforeach

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
                                                class="text">{{!empty($getAboutYourself->first()->aboutYourSelf) ? $getAboutYourself->first()->aboutYourSelf: ''}}</div>
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

                        {{--                        <object--}}
                        {{--                            data="{{asset(!empty($getCandidateTest->first()->scannedTest) ? $getCandidateTest->first()->scannedTest: '')}}"--}}
                        {{--                            type="application/pdf" width="100%" align="middle" height="800px"></object>--}}

                        @if(($getCandidateTest->first()->scannedTest ?? '0') != 0)
                            <object
                                data="{{ asset($getCandidateTest->first()->scannedTest ?? '')}}"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        @else
                            <h4>NO Data Available.</h4>
                        @endif


                    </div>
                </div>
                <!-- /CV Tab -->

                <!-- EngagementForm Tab -->
            {{-- <div class="tab-pane fade" id="EngagementForm">
               <div class="row">
                   <div class="col-md-12 d-flex">
                       <div class="card profile-box flex-fill">
                           <div class="card-body">
                               <h3 class="card-title">Employee Engagement Approval <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a></h3>
                               <ul class="personal-info">
                                   <li>
                                       <div class="title">Reference </div>
                                       <div class="text">{{!empty($getEngagementData->first()->reference) ? $getEngagementData->first()->reference: ''}}</div>
                                   </li>

                                   <li>
                                       <div class="title">Department</div>
                                       <div class="text">{{!empty($getEngagementData->first()->department) ? $getEngagementData->first()->department: ''}}</div>
                                   </li>
                                   <li>
                                       <div class="title">Position (Nature)</div>
                                       <div class="text">{{!empty($getEngagementData->first()->engagementPeriodType) ? $getEngagementData->first()->engagementPeriodType: ''}}</div>
                                   </li>

                                   <li>
                                       <div class="title">Period of Engagement</div>
                                       <div class="text">{{!empty($getEngagementData->first()->engagementPeriod) ? $getEngagementData->first()->engagementPeriod: ''}}</div>
                                   </li>

                                   <li>
                                       <div class="title">Name of Candidate</div>
                                       <div class="text">{{!empty($getEngagementData->first()->candidateName) ? $getEngagementData->first()->candidateName: ''}}</div>
                                   </li>

                                   <li>
                                       <div class="title">Designation </div>
                                       <div class="text">{{!empty($getEngagementData->first()->designation) ? $getEngagementData->first()->designation: ''}}</div>
                                   </li>

                                   <li>
                                       <div class="title">HR Policy Grade</div>
                                       <div class="text">{{!empty($getEngagementData->first()->grade) ? $getEngagementData->first()->grade: ''}}</div>
                                   </li>

                                   <li>
                                       <div class="title">Date of Joining</div>
                                       <div class="text">{{!empty($getEngagementData->first()->doj) ? $getEngagementData->first()->doj: ''}}</div>
                                   </li>

                                   <li>
                                       <div class="title">Salary Package(PKR)</div>
                                       <div class="text">{{!empty($getEngagementData->first()->probSalary) ? $getEngagementData->first()->probSalary: ''}}</div>
                                   </li>

                                   <li>
                                       <div class="title">Salary Package(PKR)</div>
                                       <div class="text">{{!empty($getEngagementData->first()->afterProbSalary) ? $getEngagementData->first()->afterProbSalary: ''}}</div>
                                   </li>

                                   <li>
                                       <div class="title">Other Benefits</div>
                                       <div class="text">
                                           @if(empty($$getEngagementData))

                                           {{'Ok'}}
                                               @else

                                           {!! $getEngagementData->first()->benifits !!}
                                           @endif
                                       </div>
                                   </li>

                               </ul>
                           </div>
                       </div>
                   </div>

               </div>
           </div> --}}
            <!-- /EngagementForm -->

                {{--            @foreach($getCandidateInterviewSheets as $index=>$getCandidateInterviewSheet)--}}
                {{--                <!-- candidateTest Tab -->--}}
                {{--                    <div class="tab-pane fade" id="candidateInterviewSheet{{$index+1}}">--}}
                {{--                        <div class="row">--}}
                {{--                            <object--}}
                {{--                                data="{{ asset($getCandidateInterviewSheet->interviewSheet)}}"--}}
                {{--                                type="application/pdf" width="100%" align="middle" height="800px"></object>--}}

                {{--                        </div>--}}
                {{--                    </div>--}}

                {{--                @endforeach--}}
                <div class="tab-pane fade" id="candidateInterviewSheetHR">
                    <div class="row">
                        {{--                        <object--}}
                        {{--                            data="{{ asset($getCandidateInterviewSheetsHR[0]->interviewSheetHR ?? '')}}"--}}
                        {{--                            type="application/pdf" width="100%" align="middle" height="800px"></object>--}}

                        @if($getCandidateInterviewSheetsHR[0]->interviewSheetHR ?? '')
                            <object
                                data="{{ asset($getCandidateInterviewSheetsHR[0]->interviewSheetHR ?? '')}}"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        @else
                            <h4>NO Data Available.</h4>
                        @endif

                    </div>
                </div>
                <div class="tab-pane fade" id="candidateInterviewSheetTL">
                    <div class="row">
                        {{--                        <object--}}
                        {{--                            data="{{ asset($getCandidateInterviewSheetsTL[0]->interviewSheetTL ?? '')}}"--}}
                        {{--                            type="application/pdf" width="100%" align="middle" height="800px"></object>--}}

                        @if($getCandidateInterviewSheetsTL[0]->interviewSheetTL ?? '')
                            <object
                                data="{{ asset($getCandidateInterviewSheetsTL[0]->interviewSheetTL ?? '')}}"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        @else
                            <h4>NO Data Available.</h4>
                        @endif

                    </div>
                </div>
                <div class="tab-pane fade" id="candidateInterviewSheetUH">
                    <div class="row">
                        {{--                        <object--}}
                        {{--                            data="{{ asset($getCandidateInterviewSheetsUH[0]->interviewSheetUH ?? '')}}"--}}
                        {{--                            type="application/pdf" width="100%" align="middle" height="800px"></object>--}}

                        {{--                        @if(($getCandidateInterviewSheetsUH[0]->interviewSheetUH ?? '0') != 0)--}}
                        @if($getCandidateInterviewSheetsUH[0]->interviewSheetUH ?? '')
                            <object
                                data="{{ asset($getCandidateInterviewSheetsUH[0]->interviewSheetUH ?? '')}}"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        @else
                            <h4>NO Data Available.</h4>
                        @endif

                    </div>
                </div>
                @foreach($getEducations as $getEducation)
                    <div class="tab-pane fade" id="eduDocs">
                        <div class="row">
                            <object
                                data="{{ 'https://209.97.168.200/pacra-job-portal/public/' . $getEducation->degreeFile}}"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        </div>
                    </div>
                @endforeach


                {{--                @foreach($getEducations as $index=>$getEducation)--}}
                {{--                <!-- candidateTest Tab -->--}}
                {{--                    <div class="tab-pane fade" id="eduDocs{{$index+1}}">--}}
                {{--                        <div class="row">--}}
                {{--                            <object--}}
                {{--                                data="{{ 'https://209.97.168.200/pacra-job-portal/public/' . $getEducation->degreeFile}}"--}}
                {{--                                type="application/pdf" width="100%" align="middle" height="800px"></object>--}}

                {{--                        </div>--}}
                {{--                    </div>--}}

                {{--                @endforeach--}}

                @foreach($getExperience as $getExperiences)
                    <div class="tab-pane fade" id="eduDocs">
                        <div class="row">
                            <object
                                data="{{asset($getExperiences->degreeFile)}}"
                                type="application/pdf" width="100%" align="middle" height="800px"></object>
                        </div>
                    </div>
            @endforeach

            @foreach($getCandidateMiscellaneousDocs as $index=>$getCandidateMiscellaneousDoc)
                <!-- candidateTest Tab -->
                    <div class="tab-pane fade" id="candidateMiscDoc{{$index+1}}">
                        <div class="row">
                            @if($getCandidateMiscellaneousDoc->miscellaneousDoc)
                                <object
                                    data="{{ asset($getCandidateMiscellaneousDoc->miscellaneousDoc)}}"
                                    type="application/pdf" width="100%" align="middle" height="800px"></object>
                            @else
                                <h4>NO Data Available.</h4>
                            @endif
                        </div>
                    </div>

            @endforeach

            <!-- Salary Tab -->
                <div class="tab-pane fade" id="salary">

                    {{--                <div id="salary" class="pro-overview tab-pane fade show active">--}}
                    <form method="POST" action="{{ route('hiringDecisionSalary') }}" enctype="multipart/form-data"
                          files="true">
                        @csrf
                        @if(\Illuminate\Support\Facades\Auth::id() == 103 || \Illuminate\Support\Facades\Auth::id() == 9)
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
                                                               value="{{!empty($getCandidateSalary->probBasicSalaryMin) ? $getCandidateSalary->probBasicSalaryMin: ''}}"
                                                               class="form-control">
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Gross Salary (Maximum)</div>
                                                    <div class="text">
                                                        <input type="number" name="probBasicSalary"
                                                               value="{{!empty($getCandidateSalary->probBasicSalary) ? $getCandidateSalary->probBasicSalary: ''}}"
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
                                                               value="{{!empty($getCandidateSalary->confirmationSalaryMin) ? $getCandidateSalary->confirmationSalaryMin: ''}}"
                                                               class="form-control">


                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Gross Salary (Maximum)</div>
                                                    <div class="text">
                                                        <input type="number" name="confirmationSalary"
                                                               value="{{!empty($getCandidateSalary->confirmationSalary) ? $getCandidateSalary->confirmationSalary: ''}}"
                                                               class="form-control">


                                                    </div>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @else
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
                                                               value="{{!empty($getCandidateSalary->probBasicSalaryMin) ? $getCandidateSalary->probBasicSalaryMin: ''}}"
                                                               class="form-control" readonly>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Gross Salary (Maximum)</div>
                                                    <div class="text">
                                                        <input type="number" name="probBasicSalary"
                                                               value="{{!empty($getCandidateSalary->probBasicSalary) ? $getCandidateSalary->probBasicSalary: ''}}"
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
                                                               value="{{!empty($getCandidateSalary->confirmationSalaryMin) ? $getCandidateSalary->confirmationSalaryMin: ''}}"
                                                               class="form-control" readonly>


                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Gross Salary (Maximum)</div>
                                                    <div class="text">
                                                        <input type="number" name="confirmationSalary"
                                                               value="{{!empty($getCandidateSalary->confirmationSalary) ? $getCandidateSalary->confirmationSalary: ''}}"
                                                               class="form-control" readonly>


                                                    </div>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif
                        <input type="hidden" name="userID"
                               value="{{!empty($getCandidateSalary->userID) ? $getCandidateSalary->userID: ''}}">
                        <input type="hidden" name="candidateID"
                               value="{{!empty($getCandidateSalary->candidateID) ? $getCandidateSalary->candidateID: ''}}">
                        <input type="hidden" name="jobID"
                               value="{{!empty($getCandidateSalary->jobID) ? $getCandidateSalary->jobID: ''}}">
                        @if(\Illuminate\Support\Facades\Auth::id() == 9)
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
                        @endif

                    </form>
                </div>
                <!-- /Salary Tab -->

            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- /Page Wrapper -->
@endsection
