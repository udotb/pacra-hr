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
                            <h3 class="page-title">Leaves</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                                <li class="breadcrumb-item active">Leaves</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- /Page Header -->
                
                <!-- Leave Statistics -->
                <div class="row">
                    <div class="col-md-3">
                        @if (Str::contains(Request::url(), 'leavesReport'))
                        <div class="stats-info">
                            <h6>Today Presents</h6>
                            <h4>{{$presentEmployees}}/{{$getActiveEmployee}}</h4>
                        </div>
                            @else
                            <div class="stats-info">
                                <h6>Absent</h6>
                                <h4>{{$absentStatus}}</h4>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3">

                        @if (Str::contains(Request::url(), 'leavesReport'))
                            <div class="stats-info">
                                <h6>Planned Leaves</h6>
                                <h4>{{$onLeaves}}</h4>
                            </div>
                        @else
                            <div class="stats-info">
                                <h6>Planned Leaves</h6>
                                <h4>{{$plannedLeaves}}</h4>
                            </div>
                        @endif

                    </div>
                    <div class="col-md-3">
                        @if (Str::contains(Request::url(), 'leavesReport'))
                            <div class="stats-info">
                                <h6>Unplanned Leaves</h6>
                                <h4>{{$absentemployees}}</h4>
                            </div>
                        @else
                            <div class="stats-info">
                                <h6>Unplanned Leaves</h6>
                                <h4>{{$unplannedLeaves}}</h4>
                            </div>
                        @endif


                    </div>
                    <div class="col-md-3">
                        <div class="stats-info">
                            <h6>Pending Requests</h6>
                            <h4>{{$pendingApprovedLeave}}</h4>
                        </div>
                    </div>
                </div>
                <!-- /Leave Statistics -->
                
                <!-- Search Filter -->
                <form method="POST" action="{{ route('leavesReportFilter') }}">
                    @csrf
                <div class="row filter-row">

                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">

                        <div class="form-group form-focus select-focus">
                            <select name="empId"  class="select floating">
                                <option value=""> -- Select -- </option>
                                @foreach($getActiveEmployeeNames as $emp)
                                    <option value="{{$emp->id}}">{{$emp->display_name}}</option>
                                @endforeach
                            </select>
                            <label class="focus-label">Employee Name</label>
                        </div>
                   </div>
                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                        <div class="form-group form-focus select-focus">
                            <select name="leaveType"  class="select floating">
                                <option value=""> -- Select -- </option>
                                @foreach($getLeaveTypes as $leaveType)
                                <option value="{{$leaveType->id}}">{{$leaveType->name}}</option>
                                @endforeach
                            </select>
                            <label class="focus-label">Leave Type</label>
                        </div>
                   </div>
                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12"> 
                        <div class="form-group form-focus select-focus">
                            <select name="leaveStatus" class="select floating">
                                <option value=""> -- Select -- </option>
                                @foreach($getLeaveStatus as $status)
                                    <option value="{{$status->status}}">{{$status->status}}</option>
                                @endforeach
                            </select>
                            <label class="focus-label">Leave Status</label>
                        </div>
                   </div>
                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                        <div class="form-group form-focus">
                            <div class="">
                                <input class="form-control floating " name="from_date" type="date">
                            </div>
                            <label class="focus-label">From</label>
                        </div>
                    </div>
                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
                        <div class="form-group form-focus">
                            <div class="">
                                <input class="form-control floating " name="to_date" type="date">
                            </div>
                            <label class="focus-label">To</label>
                        </div>
                    </div>
                   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                       <button  class="btn btn-success btn-block" name="submit" type="submit" value="Entered"> Search</button>
                   </div>

                </div>
                </form>
                <!-- /Search Filter -->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Leave Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>No of Days</th>
                                        <th>Existing Balance</th>
                                        <th>New Balance</th>
                                        <th>Reason</th>
                                        <th class="text-center">Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($pendingApprovals as $approvals)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="{{ url('profile') }}/{{$approvals->user_id}}" class="avatar" target="_blank"><img alt="" src="users/{{$approvals->avatar_file}}"></a>
                                                <a href="{{ url('profile') }}/{{$approvals->user_id}}" target="_blank">{{$approvals->display_name}} <span>{{$approvals->designation}}</span></a>
                                            </h2>
                                        </td>
                                        <td>{{$approvals->leaveType}}</td>
                                        <td>{{$approvals->from_date}}</td>
                                        <td>{{$approvals->to_date}}</td>
                                        <td>{{$approvals->leave_days}}</td>
                                        <td>{{$approvals->existing_balance}}</td>
                                        <td>{{$approvals->new_balance}}</td>
                                        <td>{{$approvals->reason}}</td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                @if($approvals->status == 'Entered')

                                                    <a class="dropdown-item" href="{{ url('leave_edit') }}/{{$approvals->leaveID}}" target="_blank"><i class="fa fa-dot-circle-o text-info"></i> Pending</a>
                                                @elseif($approvals->status == 'Recommend')

                                                    <a class="dropdown-item" href="{{ url('leave_edit') }}/{{$approvals->leaveID}}" target="_blank"><i class="fa fa-dot-circle-o text-info"></i>Recommended</a>

                                                @else
                                                    <a class="dropdown-item" href="{{ url('leave_edit') }}/{{$approvals->leaveID}}"><i class="fa fa-dot-circle-o text-success"></i> Approved</a>
                                                @endif
                                            </div>
                                        </td>

                                    </tr>

                                 @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->

            
        </div>
        <!-- /Page Wrapper -->
@endsection