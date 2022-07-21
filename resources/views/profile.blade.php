@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profile</h3>
                        @if(in_array('10', $user_rights))
                            @if($userDetails[0]->designation_id == 29)
                                @if($EndInternshipCheck > 0)
                                    <a style="display: flex; float: right" disabled
                                       class="btn-secondary btn btn-sm">Internship Ended</a>
                                @elseif($ExtendInternshipCheck > 0)
                                    <a style="display: flex; float: right" type="button" data-toggle="modal"
                                       class="btn-danger btn btn-sm"
                                       href="{{ '#modalLongEndInternship' . $userDetails[0]->ID}}">End Internship</a>
                                    <a style="display: flex; float: right; margin-right: 8px !important;" type="button"
                                       data-toggle="modal"
                                       class="btn-success btn btn-sm"
                                       href="{{ '#modalLong' . $userDetails[0]->ID}}">Make Employee</a>
                                    <a style="display: flex; float: right; margin-right: 8px" disabled
                                       class="btn-secondary btn btn-sm">Internship Extended</a>
                                @else
                                    <a style="display: flex; float: right" type="button" data-toggle="modal"
                                       class="btn-danger btn btn-sm"
                                       href="{{ '#modalLongEndInternship' . $userDetails[0]->ID}}">End Internship</a>
                                    <a style="display: flex; float: right; margin-right: 8px !important;" type="button"
                                       data-toggle="modal"
                                       class="btn-primary btn btn-sm"
                                       href="{{ '#modalLongExtendInternship' . $userDetails[0]->ID}}">Extend Internship</a>
                                    <a style="display: flex; float: right; margin-right: 8px !important;" type="button"
                                       data-toggle="modal"
                                       class="btn-success btn btn-sm"
                                       href="{{ '#modalLong' . $userDetails[0]->ID}}">Make Employee</a>
                                @endif
                            @else
                                @if($terminationCheck ?? '' > 0)
                                    <a style="display: flex; float: right" disabled
                                       class="btn-secondary btn btn-sm">Employment End Process Initiated</a>
                                @else
                                    <a style="display: flex; float: right" type="button" data-toggle="modal"
                                       class="btn-danger btn btn-sm"
                                       href="{{ '#modalLong' . $userDetails[0]->ID}}">End Employment</a>
                                @endif
                            @endif
                        @endif
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
                                        <a href="#"><img alt="" src="{{asset('users/'.$userDetails[0]->avatar_file)}}"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{!empty($userDetails[0]->display_name) ? $userDetails[0]->display_name: ''}}</h3>
                                                <h6 class="text-muted">{{!empty($userDetails[0]->team) ? $userDetails[0]->team: ''}}</h6>
                                                <small
                                                    class="text-muted">{{!empty($userDetails[0]->designation) ? $userDetails[0]->designation: ''}}</small>
                                                <div class="staff-id">Employee ID
                                                    : {{!empty($userDetails[0]->employee_id) ? $userDetails[0]->employee_id: ''}}</div>
                                                <div class="small doj text-muted">Date of Join
                                                    : {{!empty($userDetails[0]->doj) ? date("d-M-Y", strtotime($userDetails[0]->doj)): ''}}</div>
                                                <div
                                                    class="staff-msg">{{--<a class="btn btn-custom" href="chat">Send Message</a>--}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a
                                                            href="">{{!empty($userDetails[0]->phone) ? $userDetails[0]->phone: ''}}</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a
                                                            href="">{{!empty($userDetails[0]->email) ? $userDetails[0]->email: ''}}</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Birthday:</div>
                                                    <div
                                                        class="text">{{!empty($userDetails[0]->birthday) ? date("d-M", strtotime($userDetails[0]->birthday)): ''}}</div>
                                                </li>


                                                <li>
                                                    <div class="title">Gender:</div>
                                                    <div
                                                        class="text">{{!empty($userDetails[0]->genderTitle) ? $userDetails[0]->genderTitle: ''}} </div>
                                                </li>
                                                <li>
                                                    <div class="title">Reports to:</div>
                                                    <div class="text">
                                                        <div class="avatar-box">
                                                            <div class="avatar avatar-xs">
                                                                <img
                                                                    src="{{asset('users/'.$userDetails[0]->managerpic)}}"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <a href="{{ url('profile') }}/{{$userDetails[0]->am_id}}"
                                                           target="_blank">
                                                            {{!empty($userDetails[0]->managerName) ? $userDetails[0]->managerName: ''}}
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-edit">

                                    @if(in_array('10', $user_rights) or  $userId == $userDetails[0]->ID)
                                        <a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i
                                                class="fa fa-pencil"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(in_array('10', $user_rights) or  $userId == $userDetails[0]->ID)
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
                                            Information {{--<a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a>--}}</h3>
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Employment Confirmation Date</div>
                                                <div
                                                    class="text">{{!empty($userDetails[0]->confirmation_date) ? date("d-M-Y", strtotime($userDetails[0]->confirmation_date)): ''}}</div>
                                            </li>
                                            <li>
                                                <div class="title">CNIC</div>
                                                <div
                                                    class="text">{{!empty($userDetails[0]->cnic) ? $userDetails[0]->cnic: ''}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Birthday</div>
                                                <div
                                                    class="text">{{!empty($userDetails[0]->birthday) ? date("d-M-Y", strtotime($userDetails[0]->birthday)): ''}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Emergancy Contact Number</div>
                                                <div class="text"><a
                                                        href="">{{!empty($userDetails[0]->emergency_contact) ? $userDetails[0]->emergency_contact: ''}}</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Nationality</div>
                                                <div
                                                    class="text">{{!empty($userDetails[0]->national) ? $userDetails[0]->national: ''}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Religion</div>
                                                <div
                                                    class="text">{{!empty($userDetails[0]->religions) ? $userDetails[0]->religions: ''}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Marital status</div>
                                                <div
                                                    class="text">{{!empty($userDetails[0]->marital) ? $userDetails[0]->marital: ''}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Address</div>
                                                <div
                                                    class="text">{{!empty($userDetails[0]->address) ? $userDetails[0]->address: ''}}</div>
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
                                {{--                                {{dd('https://209.97.168.200/hr/storage/app/cv' .$userDetails[0]->cv ?? '')}}--}}
                                data="{{'https://209.97.168.200/hr/storage/app/' .$userDetails[0]->cv ?? ''}}"
                                type="application/pdf" width="100%"
                                align="middle" height="800px">
                            </object>
                            {{--                            <object data="{{url($userDetails[0]->cv)}}" type="application/pdf"--}}
                            {{--                                    width="100%" align="middle" height="800px">--}}

                            {{--                                <p>It appears you don't have a PDF plugin for this browser.--}}
                            {{--                                    No biggie... you can <a--}}
                            {{--                                        href="{{url($userDetails[0]->cv)}}">click here to--}}
                            {{--                                        download the PDF file.</a></p>--}}

                            </object>

                        </div>
                    </div>
                    <!-- /Projects Tab -->


                </div>
        </div>
    @endif
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
                        <form id="user" method="POST" action="{{ route('update_employee') }}"
                              enctype="multipart/form-data" files="true">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-img-wrap edit-img">
                                        <img class="inline-block" src="{{asset('users/'.$userDetails[0]->avatar_file)}}"
                                             alt="user">
                                        <div class="fileupload btn">
                                            <span class="btn-text">edit</span>
                                            <input class="upload" type="file" name="image" id="image">
                                            {{--<input class="upload" type="file">--}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input class="form-control" name="fname" type="text"
                                                       value="{{!empty($userDetails[0]->fname) ? $userDetails[0]->fname: ''}}"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input class="form-control" name="lname" type="text"
                                                       value="{{!empty($userDetails[0]->lname) ? $userDetails[0]->lname: ''}}"
                                                       required="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Username <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="uname" type="text"
                                                       value="{{!empty($userDetails[0]->uname) ? $userDetails[0]->uname: ''}}"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Officail Email <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="email" type="email"
                                                       value="{{!empty($userDetails[0]->email) ? $userDetails[0]->email: ''}}"
                                                       required="required">
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Personal Email <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="pemail" type="email"
                                                       value="{{!empty($userDetails[0]->pemail) ? $userDetails[0]->pemail: ''}}"
                                                       required="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Employee ID <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="emp_id" class="form-control"
                                                       value="{{!empty($userDetails[0]->employee_id) ? $userDetails[0]->employee_id: ''}}"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Joining Date <span
                                                        class="text-danger">*</span></label>
                                                <div class=""><input class="form-control" name="doj" type="date"
                                                                     value="{{!empty($userDetails[0]->doj) ? $userDetails[0]->doj: ''}}"
                                                                     required="required"></div>
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Confirmation Date </label>
                                                <div class=""><input class="form-control" name="c_date"
                                                                     value="{{!empty($userDetails[0]->confirmation_date) ? $userDetails[0]->confirmation_date: ''}}"
                                                                     type="date"></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Fit & Proper Date</label>
                                                <div class=""><input class="form-control" name="fnp_date"
                                                                     value="{{!empty($userDetails[0]->fnp_date) ? $userDetails[0]->fnp_date: ''}}"
                                                                     type="date"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Verticals <span class="text-danger">*</span></label>
                                                <select class="select" name="dpt" required="required">
                                                    <option
                                                        value="{{!empty($userDetails[0]->team_id) ? $userDetails[0]->team_id: ''}}">{{!empty($userDetails[0]->team) ? $userDetails[0]->team: ''}}</option>
                                                    <option value="">Select Vertical</option>
                                                    @foreach($departments as $dep)

                                                        <option value="{{$dep->id}}">{{$dep->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Function <span class="text-danger">*</span></label>

                                                <select class="select" name="sub_dpt" required="required">
                                                    <option
                                                        value="{{!empty($userDetails[0]->function) ? $userDetails[0]->function: ''}}">{{!empty($userDetails[0]->functionTitle) ? $userDetails[0]->functionTitle: ''}}</option>
                                                    <option value="">Select Function</option>
                                                    @foreach($departments as $dep)

                                                        <option value="{{$dep->id}}">{{$dep->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Grade <span class="text-danger">*</span></label>
                                                <select class="select" name="grade" required="required">
                                                    <option
                                                        value="{{!empty($userDetails[0]->grade) ? $userDetails[0]->grade: ''}}">{{!empty($userDetails[0]->gradeTitle) ? $userDetails[0]->gradeTitle: ''}}</option>

                                                    <option value="">Select Grade</option>
                                                    @foreach($grades as $grade)

                                                        <option value="{{$grade->id}}">{{$grade->name }}
                                                            ({{$grade->description}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Designation <span class="text-danger">*</span></label>
                                                <select class="select" name="desg" id="designation" required="required">
                                                    <option
                                                        value="{{!empty($userDetails[0]->designation_id) ? $userDetails[0]->designation_id: ''}}">{{!empty($userDetails[0]->designation) ? $userDetails[0]->designation: ''}}</option>
                                                    <option value="">Select Designation</option>
                                                    @foreach($designations as $desg)
                                                        <option value="{{$desg->id}}">{{$desg->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6" id="internshipTenureDiv" style="display: none">
                                            <div class="form-group">
                                                <label>Internship Tenure <span class="text-danger">*</span></label>
                                                <select class="select" name="internship_tenure" id="internshipTenure">
                                                    <option
                                                        value="{{!empty($userDetails[0]->tenure) ? $userDetails[0]->tenure: ''}}">{{!empty($userDetails[0]->tenure) ? $userDetails[0]->tenure: ''}}</option>
                                                    <option value="">Select Tenure</option>
                                                    <option value="2 Weeks">2 Weeks</option>
                                                    <option value="1 Month">1 Month</option>
                                                    <option value="2 Month">2 Month</option>
                                                    <option value="3 Month">3 Month</option>
                                                </select>
                                            </div>
                                        </div>

                                        {{--                                        <div class="col-md-6" id="stipendDiv" style="display: none">--}}
                                        {{--                                            <div class="form-group">--}}
                                        {{--                                                <label>Stipend Amount <span class="text-danger">*</span></label>--}}
                                        {{--                                                <input class="form-control" type="text" readonly--}}
                                        {{--                                                       name="stipend" id="stipend1"--}}
                                        {{--                                                       value="{{!empty($userDetails[0]->stipend) ? $userDetails[0]->stipend: '10000'}}"--}}
                                        {{--                                                       style="display: none">--}}
                                        {{--                                                <input class="form-control" type="text" readonly--}}
                                        {{--                                                       name="stipend" id="stipend2"--}}
                                        {{--                                                       value="{{!empty($userDetails[0]->stipend) ? $userDetails[0]->stipend: '15000'}}"--}}
                                        {{--                                                       style="display: none">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}

                                        <div class="col-md-6" id="stipendDiv" style="display: none">
                                            <div class="form-group">
                                                <label>Stipend Amount <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text"
                                                       name="stipend"
                                                       value="{{!empty($userDetails[0]->stipend) ? $userDetails[0]->stipend: ''}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6" id="gradDateDiv" style="display: none">
                                            <div class="form-group">
                                                <label class="col-form-label">Expected Graduation Date</label>
                                                <div class=""><input class="form-control" name="grad_date"
                                                                     value="{{!empty($userDetails[0]->expected_grad_date) ? $userDetails[0]->expected_grad_date: ''}}"
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
                                                           value="{{!empty($userDetails[0]->cnic) ? $userDetails[0]->cnic: ''}}"
                                                           required="required">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Contact </label>
                                                <div class=""><input class="form-control" name="phone" type="tel"
                                                                     pattern="[0-9]{4}[0-9]{7}"
                                                                     value="{{!empty($userDetails[0]->phone) ? $userDetails[0]->phone: ''}}"
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
                                                                     value="{{!empty($userDetails[0]->emergency_contact) ? $userDetails[0]->emergency_contact: ''}}"
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
                                                           value="{{!empty($userDetails[0]->emg_name) ? $userDetails[0]->emg_name: ''}}"
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
                                                            value="{{!empty($userDetails[0]->emg_relation) ? $userDetails[0]->emg_relation: ''}}">{{!empty($userDetails[0]->relationTitle) ? $userDetails[0]->relationTitle: ''}}</option>

                                                        <option value="">Select Relationship</option>
                                                        @foreach($relatives as $relative)
                                                            <option
                                                                value="{{$relative->id}}">{{$relative->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Birthday </label>
                                                <div class=""><input class="form-control" name="dob" type="date"
                                                                     value="{{!empty($userDetails[0]->birthday) ? $userDetails[0]->birthday: ''}}"
                                                                     required="required"></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Nationality <span
                                                        class="text-danger">*</span></label>

                                                <select class="select" name="nationality" required="required">
                                                    <option
                                                        value="{{!empty($userDetails[0]->nationality) ? $userDetails[0]->nationality: ''}}">{{!empty($userDetails[0]->national) ? $userDetails[0]->national: ''}}</option>

                                                    <option value="">Select Nationality</option>
                                                    @foreach($nationality as $nation)
                                                        <option value="{{$nation->id}}">{{$nation->title}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Religion <span
                                                        class="text-danger">*</span></label>
                                                <select class="select" name="religion" required="required">
                                                    <option
                                                        value="{{!empty($userDetails[0]->religion) ? $userDetails[0]->religion: ''}}">{{!empty($userDetails[0]->religions) ? $userDetails[0]->religions: ''}}</option>

                                                    <option value="">Select Religion</option>
                                                    @foreach($religions as $religion)
                                                        <option value="{{$religion->id}}">{{$religion->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Gender </label>
                                                <select class="select" name="gender" required="required">
                                                    <option
                                                        value="{{!empty($userDetails[0]->gender) ? $userDetails[0]->gender: ''}}">{{!empty($userDetails[0]->genderTitle) ? $userDetails[0]->genderTitle: ''}}</option>

                                                    <option value="">Select Gender</option>
                                                    @foreach($genders as $gender)
                                                        <option value="{{$gender->id}}">{{$gender->title}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Marital Status <span
                                                        class="text-danger">*</span></label>
                                                <select class="select" name="marital" required="required">
                                                    <option
                                                        value="{{!empty($userDetails[0]->marital_status) ? $userDetails[0]->marital_status: ''}}">{{!empty($userDetails[0]->marital) ? $userDetails[0]->marital: ''}}</option>

                                                    <option value="">Select Marital Status</option>
                                                    @foreach($maritals as $marital)
                                                        <option value="{{$marital->id}}">{{$marital->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Reports To </label>
                                                <select class="select" name="report_to" required="required">
                                                    <option
                                                        value="{{!empty($userDetails[0]->am_id) ? $userDetails[0]->am_id: ''}}">{{!empty($userDetails[0]->managerName) ? $userDetails[0]->managerName: ''}}</option>

                                                    <option value="">Select Reports to</option>
                                                    @foreach($all_users as $users)
                                                        <option value="{{$users->id}}">{{$users->display_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Linkedin </label>
                                                <input class="form-control" name="linkedin"
                                                       value="{{!empty($userDetails[0]->linkedin) ? $userDetails[0]->linkedin: ''}}"
                                                       type="text">
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Show on Website </label>

                                                <select class="select" name="web_check" required="required">

                                                    @if($userDetails[0]->profile_on_web == 0)
                                                        <option value="0">No</option>
                                                    @else
                                                        <option value="1">Yes</option>
                                                    @endif


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
                                                       value="{{!empty($userDetails[0]->last_qualification) ? $userDetails[0]->last_qualification: ''}}"
                                                       type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Exp. Outside PACRA<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="exp_outside_pacra"
                                                       value="{{!empty($userDetails[0]->exp_outside_pacra) ? $userDetails[0]->exp_outside_pacra: ''}}"
                                                       type="text">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Exp. In PACRA<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="exp_in_pacra"
                                                       {{--                                                       value="{{!empty($experienceInPacra) ? $userDetails[0]->exp_in_pacra: ''}}"--}}
                                                       value="{{!empty($experienceInPacra) ? $experienceInPacra: ''}}"
                                                       {{--                                                       value="1"--}}
                                                       type="text" readonly>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Last Employer<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="last_employer"
                                                       value="{{!empty($userDetails[0]->last_employer) ? $userDetails[0]->last_employer: ''}}"
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Address </label>
                                                <input class="form-control" name="address" type="text"
                                                       value="{{!empty($userDetails[0]->address) ? $userDetails[0]->address: ''}}"
                                                       required="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Current Leave Balance </label>
                                                <input class="form-control" type="text" name="c_leaves"
                                                       value="{{!empty($get_cleaves_bal[0]->current_balance) ? $get_cleaves_bal[0]->current_balance: ''}}"
                                                       required="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label"> - Leave Balance (c/f) </label>
                                                <input class="form-control" type="text" name="n_leaves"
                                                       value="{{!empty($getnLeaves_bal[0]->negative_balance) ? $getnLeaves_bal[0]->negative_balance: ''}}">
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label"> CV </label>
                                                @if(empty($userDetails[0]->cv))
                                                    <input type="file" name="file" id="file">
                                                    <small id="fileHelp" class="form-text text-muted">Please upload a
                                                        valid file.</small>
                                                @else

                                                    <input type="file" name="file" id="file">
                                                    <small id="fileHelp" class="form-text text-muted">Please upload New
                                                        CV.</small>
                                                    <a href="{{url($userDetails[0]->cv)}}" target="_blank">View
                                                        Existing CV</a>
                                                @endif
                                            </div>
                                        </div>
                                        {{--                                        <div class="col-sm-6">--}}
                                        {{--                                            <div class="form-group">--}}
                                        {{--                                                <form id="user" method="POST"--}}
                                        {{--                                                      enctype="multipart/form-data" files="true">--}}
                                        {{--                                                    @csrf--}}
                                        {{--                                                    @if(!empty($userDetails[0]->empsign))--}}
                                        {{--                                                        <label class="col-form-label"> Add Signature </label>--}}
                                        {{--                                                        <input type="file" name="sign" id="sign">--}}
                                        {{--                                                        <small id="fileHelp" class="form-text text-muted">Please upload--}}
                                        {{--                                                            a valid file.</small>--}}
                                        {{--                                                        <button class="btn btn-primary btn-sm" name="submit"--}}
                                        {{--                                                                type="submit" value="submit">--}}
                                        {{--                                                            Upload Signatures--}}
                                        {{--                                                        </button>--}}
                                        {{--                                                    @else--}}
                                        {{--                                                        <h6>Signatures already Exists.</h6>--}}
                                        {{--                                                    @endif--}}
                                        {{--                                                </form>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="hidden" name="old_image"
                                                       value="{{!empty($userDetails[0]->avatar_file) ? $userDetails[0]->avatar_file: ''}}"
                                                       required="required">
                                                <input class="form-control" type="hidden" name="old_cv"
                                                       value="{{!empty($userDetails[0]->cv) ? $userDetails[0]->cv: ''}}"
                                                       required="required">
                                                <input class="form-control" type="hidden" name="recordID"
                                                       value="{{!empty($userDetails[0]->ID) ? $userDetails[0]->ID: ''}}"
                                                       required="required">
                                                <input class="form-control" type="hidden" name="user_id"
                                                       value="{{!empty($userDetails[0]->ID) ? $userDetails[0]->ID: ''}}"
                                                       required="required">
                                                {{--                                                <input class="form-control" type="hidden" name="old_sign"--}}
                                                {{--                                                       value="{{!empty($userDetails[0]->empsign) ? $userDetails[0]->empsign: ''}}"--}}
                                                {{--                                                       required="required">--}}


                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" name="submit" type="submit" value="submit">
                                    Submit
                                </button>
                                @if(in_array('6', $user_rights) )
                                    <button class="btn btn-primary submit-btn btn-success" name="submit" type="submit"
                                            value="approve"> Approve
                                    </button>
                                @endif
                                {{--<button class="btn btn-primary submit-btn" >Submit</button>--}}
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
         id={{ 'modalLong' . $userDetails[0]->ID }} tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Termination Reason of
                        : {{$userDetails[0]->display_name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST"
                          action="{{ route('terminate-employee', ['id' => $userDetails[0]->ID]) }}"
                          enctype="multipart/form-data" files="true">
                        @csrf
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
                                   min={{$userDetails[0]->doj}} name="termination_date">
                        </div>
                        <div class="form-group">
                            <label for="reason" class="col-form-label">Last Working Date:</label>
                            <input class="form-control" type="date" min={{$userDetails[0]->doj}} name="last_date">
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
         id={{ 'modalLongEndInternship' . $userDetails[0]->ID }} tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">End Internship Reason of
                        : {{$userDetails[0]->display_name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST"
                          action="{{ route('end-internship', ['id' => $userDetails[0]->ID, 'status' => 'Entered']) }}"
                          enctype="multipart/form-data" files="true">
                        @csrf
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
                                   min={{$userDetails[0]->doj}} name="end_date">
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
         id={{ 'modalLongExtendInternship' . $userDetails[0]->ID }} tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Extend Internship Reason of
                        : {{$userDetails[0]->display_name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST"
                          action="{{ route('extend-internship', ['id' => $userDetails[0]->ID, 'status' => 'Entered']) }}"
                          enctype="multipart/form-data" files="true">
                        @csrf
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
                                   min={{$userDetails[0]->doj}} name="extended_date">
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

@endsection

