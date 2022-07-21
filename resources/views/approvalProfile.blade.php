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
                        <h3 class="page-title">Profile</h3>
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
                                                            {{!empty($userDetails[0]->report_to) ? $userDetails[0]->report_to: ''}}
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
                                        Informations {{--<a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a>--}}</h3>
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
                        <object data="{{ asset('../storage/app/').'/'.$userDetails[0]->cv}}" type="application/pdf"
                                width="100%" align="middle" height="800px">

                            <p>It appears you don't have a PDF plugin for this browser.
                                No biggie... you can <a href="{{ asset('../storage/app/').'/'.$userDetails[0]->cv }}">click
                                    here to
                                    download the PDF file.</a></p>

                        </object>

                    </div>
                </div>
                <!-- /Projects Tab -->


            </div>
        </div>
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
                                                       value="{{!empty($userDetails[0]->username) ? $userDetails[0]->username: ''}}"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="email" type="email"
                                                       value="{{!empty($userDetails[0]->email) ? $userDetails[0]->email: ''}}"
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

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Function <span class="text-danger">*</span></label>
                                                <select class="select" name="dpt" required="required">
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
                                                <label>Designation <span class="text-danger">*</span></label>
                                                <select class="select" name="desg" required="required">
                                                    <option
                                                        value="{{!empty($userDetails[0]->designation_id) ? $userDetails[0]->designation_id: ''}}">{{!empty($userDetails[0]->designation) ? $userDetails[0]->designation: ''}}</option>

                                                    <option value="">Select Designation</option>
                                                    @foreach($designations as $desg)

                                                        <option value="{{$desg->id}}">{{$desg->title}}</option>
                                                    @endforeach
                                                </select>
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
                                                        value="{{!empty($userDetails[0]->am_id) ? $userDetails[0]->am_id: ''}}">{{!empty($userDetails[0]->report_to) ? $userDetails[0]->report_to: ''}}</option>

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
                                                    <a href="../../storage/app/{{$userDetails[0]->cv}}" target="_blank">View
                                                        Existing CV</a>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                @if(empty($userDetails[0]->empsign))
                                                    <label class="col-form-label"> Add Signature </label>
                                                    <input type="file" name="sign" id="sign">
                                                    <small id="fileHelp" class="form-text text-muted">Please upload a
                                                        valid file.</small>
                                                @else
                                                    <label class="col-form-label"> Update Signature </label>
                                                    <input type="file" name="sign" id="sign">
                                                    <small id="fileHelp" class="form-text text-muted">Please upload New
                                                        Signatures.</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="hidden" name="old_image"
                                                       value="{{!empty($userDetails[0]->avatar_file) ? $userDetails[0]->avatar_file: ''}}"
                                                       required="required">
                                                <input class="form-control" type="hidden" name="old_cv"
                                                       value="{{!empty($userDetails[0]->cv) ? $userDetails[0]->cv: ''}}"
                                                       required="required">
                                                <input class="form-control" type="hidden" name="user_id"
                                                       value="{{!empty($userDetails[0]->ID) ? $userDetails[0]->ID: ''}}"
                                                       required="required">
                                                <input class="form-control" type="hidden" name="old_sign"
                                                       value="{{!empty($userDetails[0]->empsign) ? $userDetails[0]->empsign: ''}}"
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


    {{-- <script>
         function update () {

             var data = $('#user').serializeArray();
             var request = $.ajax({
                 url: "{{url('/api/profileUpdate')}}",
                 type: "POST",
                 data: data,
             });

             request.done(function (msg) {
                 $('#address').html(msg.address);
                 console.log(msg.address);
             });
         }
     </script>--}}
@endsection

