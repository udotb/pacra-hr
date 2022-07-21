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
                        <h3 class="page-title">Leaves (Year: 2022)</h3>
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


            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable"
                               id="data_table">
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
                                            <a href="{{ url('profile') }}/{{$approvals->user_id}}" class="avatar"
                                               target="_blank"><img alt="" src="users/{{$approvals->avatar_file}}"></a>
                                            <a href="{{ url('profile') }}/{{$approvals->user_id}}"
                                               target="_blank">{{$approvals->display_name}}
                                                <span>{{$approvals->designation}}</span></a>
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

                                                <a class="dropdown-item"
                                                   href="{{ url('leave_edit') }}/{{$approvals->leaveID}}"
                                                   target="_blank"><i class="fa fa-dot-circle-o text-info"></i> Pending</a>
                                            @elseif($approvals->status == 'Recommend')

                                                <a class="dropdown-item"
                                                   href="{{ url('leave_edit') }}/{{$approvals->leaveID}}"
                                                   target="_blank"><i class="fa fa-dot-circle-o text-info"></i>Recommended</a>

                                            @elseif($approvals->status == 'Decline')

                                                <a class="dropdown-item"
                                                   href="{{ url('leave_edit') }}/{{$approvals->leaveID}}"
                                                   target="_blank"><i class="fa fa-dot-circle-o text-danger"></i>Decline</a>

                                            @else
                                                <a class="dropdown-item"
                                                   href="{{ url('leave_edit') }}/{{$approvals->leaveID}}"><i
                                                        class="fa fa-dot-circle-o text-success"></i> Approved</a>
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
