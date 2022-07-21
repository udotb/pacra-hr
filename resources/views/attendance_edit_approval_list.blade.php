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
                        <h3 class="page-title">{{!empty($meta_title) ? $meta_title: ''}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{!empty($meta_title) ? $meta_title: ''}}</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->


            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable"
                               id="data_table">
                            <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Employee</th>
                                <th>Date</th>
                                <th>Reason</th>
                                <th class="text-center">Status</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($getAttendanceEditRequestList as $index=>$approvals)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="{{ url('profile') }}/{{$approvals->user_id}}" class="avatar"
                                               target="_blank"><img alt="" src="users/{{$approvals->avatar_file}}"></a>
                                            <a href="{{ url('profile') }}/{{$approvals->user_id}}"
                                               target="_blank">{{$approvals->display_name}}
                                                <span>{{$approvals->designation}}</span></a>
                                        </h2>
                                    </td>

                                    <td>{{$approvals->date}}</td>
                                    <td>{{$approvals->reason}}</td>
                                    <td class="text-center">
                                        <div class="dropdown action-label">
                                            @if($approvals->status == 'Entered')

                                                <a class="dropdown-item"
                                                   href="{{ url('editAttendanceRequestApproval') }}/{{$approvals->attendance_record}}"
                                                   target="_blank"><i class="fa fa-dot-circle-o text-info"></i> Pending</a>
                                            @elseif($approvals->status == 'Recommended' and (in_array('6', $user_rights) ))
                                                <a class="dropdown-item"
                                                   href="{{ url('editAttendanceRequestApproval') }}/{{$approvals->attendance_record}}"
                                                   target="_blank"><i class="fa fa-dot-circle-o text-info"></i>
                                                    Recommended</a>

                                            @else
                                                <a class="dropdown-item" href="#"><i
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
