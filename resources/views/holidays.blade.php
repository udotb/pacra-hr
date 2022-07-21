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
                        <h3 class="page-title">Holidays 2019</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Holidays</li>
                        </ul>
                    </div>
                    @if(in_array('10', $user_rights) )
                        <div class="col-auto float-right ml-auto">
                            <a href="{{ route('holiday_form') }}" target="_blank" class="btn add-btn"><i
                                    class="fa fa-plus"></i> Add Holiday</a>
                        </div>
                    @endif


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
                                <th>Title</th>
                                <th>From</th>
                                <th>To</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($allHolidays as $index=>$allHoliday)

                                @if(date("Y-m-d")>$allHoliday->to_date)
                                    <tr class="holiday-completed">
                                        <td>{{$index +1}}</td>
                                        <td>{{$allHoliday->holiday_name}}</td>
                                        <td>{{$allHoliday->from_date}}</td>
                                        <td>{{$allHoliday->to_date}}</td>
                                        <td></td>

                                        @else
                                            <td>{{$index +1}}</td>
                                            <td>{{$allHoliday->holiday_name}}</td>
                                            <td>{{$allHoliday->from_date}}</td>
                                            <td>{{$allHoliday->to_date}}</td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle"
                                                       data-toggle="dropdown" aria-expanded="false"><i
                                                            class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                           href="{{ route('holiday_form') }}/{{$allHoliday->id}}"
                                                           target="_blank"><i class="fa fa-pencil m-r-5"></i> Edit</a>
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
