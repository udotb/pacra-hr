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

                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('wfh_application') }}" target="_blank" class="btn add-btn"><i
                                class="fa fa-plus"></i>Add WFH</a>
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
                                <th>#</th>
                                <th>Dates</th>
                                <th>Reason</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($allWFHs as $index=>$allWFH)

                                @if($allWFH->status == 'Approve' or $allWFH->status == 'Decline' )
                                    <tr class="holiday-completed">
                                        <td>{{$index +1}}</td>
                                        <td>{{$allWFH->dates}}</td>

                                        <td>{{$allWFH->reason}}</td>
                                        <td></td>

                                        @else
                                            <td>{{$index +1}}</td>
                                            <td>{{$allWFH->dates}}</td>
                                            <td>{{$allWFH->reason}}</td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle"
                                                       data-toggle="dropdown" aria-expanded="false"><i
                                                            class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                           href="{{ route('wfh_application') }}/{{$allWFH->id}}"
                                                           target="_blank"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('delete_wfh') }}/{{$allWFH->id}}"><i
                                                                class="fa fa-pencil m-r-5"></i> Delete</a>

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
