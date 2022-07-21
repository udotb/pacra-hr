@extends('layout.mainlayout')
@section('content')
    <title>Monthly Attendance Report</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/js/bootstrap-select.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.1.0/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Monthly Attendance Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance Report</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <form class="form_report" method="POST" action="{{ route('monthlyAttandance') }}">

                @csrf
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <input class="form-control floating from_date" type="date" name="from_date">
                            <label class="focus-label">From Date</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <input class="form-control floating to_date" type="date" name="to_date">
                            <label class="focus-label">To date</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-success btn-block report ">Get Attendance</button>
                    </div>

                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table display"
                               id="monthlyAtt">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Punch In Time</th>
                                <th>Punch Out Time</th>
                                <th>Office Hours</th>
                                <th class="text-center">Status</th>
                                <th>Punch Out Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($getAttendanceDetails->count())
                                @foreach ($getAttendanceDetails as $key => $getAttendanceDetail)
                                    <tr id="tr_{{ $getAttendanceDetail->id }}">
                                        <td>{{ $getAttendanceDetail->fname}} {{$getAttendanceDetail->lname }}</td>
                                        <td>{{$getAttendanceDetail->date}}</td>
                                        <td>{{$getAttendanceDetail->log_in_time}}</td>
                                        @if($getAttendanceDetail->punch_out_status == 'Auto Punch Out')
                                            <td style="color: red">{{$getAttendanceDetail->log_out_time}}</td>
                                        @else
                                            <td>{{$getAttendanceDetail->log_out_time}}</td>
                                        @endif
                                        <td>{{$getAttendanceDetail->office_hours}}</td>
                                        <td>{{$getAttendanceDetail->title}}</td>
                                        <td>{{$getAttendanceDetail->punch_out_status}}</td>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->

    <script>
        $(document).ready(function () {
            $('#monthlyAtt').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5', 'pdf'
                ],
                initComplete: function () {
                    var btns = $('.dt-button');
                    btns.addClass('btn btn-secondary dt');
                    btns.removeClass('dt-button');
                },
            });
        });
    </script>
@endsection
