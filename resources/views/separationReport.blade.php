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
                        <table class="table table-striped custom-table mb-0 datatable"
                               id="data_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Resigning Employee</th>
                                <th>Reason</th>
                                <th>Last Working Day</th>
                                <th>Resignation Date</th>
                                <th>Preview</th>
                                <th class="text-right">Stage</th>
                            </tr>
                            </thead>
                            <tbody>


                            @foreach($resignation as $key=>$resig)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>
                                        <h2 class="table-avatar blue-link">
                                            <a href="profile" class="avatar"><img alt=""
                                                                                  src="img/profiles/avatar-02.jpg"></a>
                                            <a href="profile">{{$resig->display_name}} </a>
                                            {{-- <a href="profile">{{!empty($resignation->first()->display_name) ? $resignation->first()->display_name: ''}} </a>--}}
                                        </h2>
                                    </td>
                                    <td>{{$resig->reason}}</td>
                                    <td>{{$resig->last_working_day}}</td>
                                    <td>{{$resig->resignation_date}}</td>
                                    <td>
                                        <a class="dropdown-item"
                                           href="{{ url('SeparationFormPreview') }}/{{$resig->resigID}}"
                                           target="_blank"><i class="fa fa-eye text-success" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a class="dropdown-item" href="" target="_blank"><i
                                                    class="fa fa-dot-circle-o text-info"></i>
                                                @if($resig->section_two_name == null)
                                                    TL
                                                @elseif($resig->section_three_name == null)
                                                    MIT
                                                @elseif($resig->section_four_name == null)
                                                    Administration
                                                @elseif($resig->section_five_name == null)
                                                    HR
                                                @elseif($resig->section_seven_name == null)
                                                    Finance
                                                @elseif($resig->section_eight_name == null)
                                                    CEO


                                                @else
                                                    Approved
                                                @endif
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
