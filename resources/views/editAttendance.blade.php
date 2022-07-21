@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{!empty($meta_title) ? $meta_title: 'PACRA'}}s</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->


            <div class="row">
                <div class="col-md-12">

                    <!-- Add Leave Modal -->

                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</h3>
                        </div>
                        <div class="modal-body">
                            @if($getAttendanceApprovalDetail==null)
                                <form method="POST" action="{{ route('editAttendanceRequest') }}"
                                      enctype="multipart/form-data" files="true">
                                    @csrf

                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <div class="">

                                            <input class="form-control " type="date" name="date"
                                                   value="{{$getAttendanceDetail->first()->date}}" readonly
                                                   required="required">
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label>Select Reason <span class="text-danger">*</span></label>
                                        <select name="editReason" required="required" class="select">
                                            <option value=""> {{'Select Reason'}}</option>
                                            @foreach($attendanceEditReason as $Reason)

                                                <option value="{{$Reason->id}}"> {{$Reason->title}}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Punch In Time <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control " type="time" name="punch_in"
                                                   required="required">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Attachment <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="file" name="file" id="file"
                                                   accept="image/x-png,image/gif,image/jpeg" required="required">
                                            <small id="fileHelp" class="form-text text-muted">Please upload only image
                                                file.</small>


                                        </div>
                                    </div>

                                    <input type="hidden" name="attendanceRecordID"
                                           value="{{$getAttendanceDetail->first()->id}}">
                                    <input type="hidden" name="old_punchIn"
                                           value="{{$getAttendanceDetail->first()->log_in_time}}">
                                    <input type="hidden" name="user_id" value="{{$userId}}">
                                    <input type="hidden" name="am_id" value="{{$amId}}">


                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="Entered"> Submit
                                        </button>
                                    </div>
                                </form>
                            @else
                                <form method="POST" action="{{ route('editAttendanceRequest') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <div class="">

                                            <input class="form-control " type="date" name="date"
                                                   value="{{$getAttendanceApprovalDetail->first()->date}}" readonly
                                                   required="required">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Current Punch In Time <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control " type="time"
                                                   value="{{$getAttendanceApprovalDetail->first()->old_punch_in}}"
                                                   readonly required="required">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>New Punch In Time <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control " type="time" name="punch_in"
                                                   value="{{$getAttendanceApprovalDetail->first()->new_punch_in}}"
                                                   required="required">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label>Select Reason <span class="text-danger">*</span></label>
                                        <select name="editReason" required="required" class="select">
                                            <option
                                                value="{{$getAttendanceApprovalDetail->first()->attendance_edit_reason}}"> {{$getAttendanceApprovalDetail->first()->reason}}</option>
                                            <option value=""> {{'Select Reason'}}</option>

                                            @foreach($attendanceEditReason as $Reason)

                                                <option value="{{$Reason->id}}"> {{$Reason->title}}</option>
                                            @endforeach

                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>Attachment<span class="text-danger">*</span></label>
                                        <div class="">
                                            <a href="{{ asset('../storage/app/'.$getAttendanceApprovalDetail->first()->attachment) }}"
                                               target="_blank">View Attachment</a>

                                        </div>
                                    </div>


                                    <input type="hidden" name="attendanceRecordID"
                                           value="{{$getAttendanceApprovalDetail->first()->attendance_record}}">
                                    <input type="hidden" name="old_punchIn"
                                           value="{{$getAttendanceApprovalDetail->first()->old_punch_in}}">
                                    <input type="hidden" name="user_id"
                                           value="{{$getAttendanceApprovalDetail->first()->user_id}}">
                                    <input type="hidden" name="am_id"
                                           value="{{$getAttendanceApprovalDetail->first()->am_id}}">

                                    <div class="submit-section">
                                        @if($getAttendanceApprovalDetail->first()->status == 'Recommended' and (in_array('6', $user_rights)) )
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Approved"> Authenticate
                                            </button>
                                            <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                    type="submit" value="Declined-HR"> Decline
                                            </button>

                                        @elseif($getAttendanceApprovalDetail->first()->status == 'Entered' and (in_array('16', $user_rights)) )
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Recommended"> Recommend
                                            </button>
                                            <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                    type="submit" value="Declined"> Decline
                                            </button>

                                        @elseif($getAttendanceApprovalDetail->first()->status == 'Approved' or $getAttendanceApprovalDetail->first()->status == 'Recommended' or $getAttendanceApprovalDetail->first()->status == 'Declined' or $getAttendanceApprovalDetail->first()->status == 'Declined-HR' )
                                            {{'You already'}} {{$getAttendanceApprovalDetail->first()->status}} {{'this application'}}

                                        @else
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Entered"> Submit
                                            </button>

                                        @endif
                                    </div>


                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- /Add Leave Modal -->

                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- /Page Wrapper -->

@endsection
