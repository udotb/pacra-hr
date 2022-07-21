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
                    {{-- <div class="col-auto float-right ml-auto">
                        <a href="{{ route('resignationApprovals') }}" class="btn add-btn" target="_blank"><i class="fa fa-plus"></i>Separation Approvals</a>

                    </div> --}}
{{--                    <div class="col-auto float-right ml-auto">--}}

{{--                        @if ($checkSeparationProcess->isNotEmpty() )--}}

{{--                        @elseif($termination->isNotEmpty() and $termination->first()->status == 'Approved' )--}}

{{--                            <a href="{{ route('empSeparationForm') }}/{{!empty($termination->first()->resigID) ? $termination->first()->resigID: ''}}"--}}
{{--                               class="btn add-btn" target="_blank"><i class="fa fa-plus"></i> Separation Process</a>--}}
{{--                        @elseif ($termination->isNotEmpty() and $termination->first()->status == 'Entered' )--}}
{{--                            <a href="{{ route('empSeparationForm') }}/{{!empty($termination->first()->resigID) ? $termination->first()->resigID: ''}}"--}}
{{--                               class="btn add-btn" target="_blank"><i class="fa fa-plus"></i> Separation Process</a>--}}

{{--                        @else--}}


{{--                            <a href="{{ route('resignationForm') }}" class="btn add-btn" target="_blank"><i--}}
{{--                                    class="fa fa-plus"></i> Add Separation</a>--}}
{{--                        @endif--}}
{{--                    </div>--}}
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
                                <th>#</th>
                                <th>Terminated Employee</th>
                                <th>Reason</th>
                                <th>Notice Date</th>
                                <th>Termination Date</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($termination as $index => $resig)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>
                                        <h2 class="table-avatar blue-link">

                                            <a href="{{ url('profile') }}/{{$resig->user_id}}">{{$resig->display_name}} </a>
                                        </h2>
                                    </td>
                                    <td>{{$resig->reason}}</td>
                                    <td>{{$resig->last_working_day}}</td>
                                    <td>{{$resig->termination_date}}</td>
                                    <td>{{$resig->status}}</td>
                                    @if($resig->status != 'Declined')
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                               aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                   href="{{ route('resignationForm') }}/{{$resig->resigID}}"><i
                                                        class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item"
                                                   href="{{ route('resignationForm') }}/{{$resig->resigID}}"><i
                                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
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
