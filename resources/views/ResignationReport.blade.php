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
                            <li class="breadcrumb-item active">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table custom-table display"
                               id="data_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Resigning Employee</th>
                                <th>Reason</th>
                                <th>Notice Date</th>
                                <th>Resignation Date</th>
                                <th class="text-right">Status</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($resignations as $key=>$resignation)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>
                                        <h2 class="table-avatar blue-link">
                                            {{--
                                                                                            <a href="{{ url('profile') }}/{{!empty($resignation->first()->user_id) ? $resignation->first()->user_id: ''}}" class="avatar"><img alt="" src="{{asset('users/'.!empty($resignation->first()->avatar_file) ? $resignation->first()->avatar_file: '')}}"></a>
                                            --}}
                                            <a href="{{ url('profile') }}/{{$resignation->user_id}}">{{$resignation->display_name}} </a>
                                        </h2>
                                    </td>
                                    <td>{{$resignation->reason}}</td>
                                    <td>{{$resignation->last_working_day}}</td>
                                    <td>{{$resignation->resignation_date}}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">

                                            <a class="dropdown-item" href=""><i
                                                    class="fa fa-dot-circle-o text-success"></i>{{$resignation->resigStatus}}
                                            </a>

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
