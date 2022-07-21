@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Attendance</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-4">
                    <div class="card punch-status">
                        <div class="card-body">
                            <h5 class="card-title">Timesheet <small class="text-muted">{{date("d-M-Y")}} {{date("g:i:s A") }}</small></h5>
                            <div class="stats-list">
                            <form method="POST" action="{{ route('mark_attendance') }}">
                                @csrf

                            {{--{!! Form::open(['route' => 'mark_attendance']) !!}--}}

                            @if($today_attendance->isEmpty())
                                <?php $ipAddresses = array('125.209.73.138', '110.37.226.186');?>
                                @if (!in_array($ip_address, $ipAddresses))
                                <div class="punch-det">
                                <h6 class="alert alert-danger" role="alert">You are not in Pacra...!!!</h6>

                            </div>
                                    @endif
                            @else

                                <div class="punch-det">
                                    <h6>Punch In at</h6>
                                    <p>{{date("D, ")}} {{date("d-M-Y")}}  {{$today_attendance[0]->log_in_time}}</p>
                                </div>
                            @endif






                            @if($today_attendance->isEmpty())

                            <div class="punch-info">
                                <div class="punch-hours">
                                    <span>0.00 hrs</span>
                                </div>
                            </div>
                            <div class="punch-btn-section">
                               {{-- {!! Form::submit('Punch In', ['class'=>'btn btn-primary punch-btn', 'name'=>'punch_in'])!!}--}}
                                <input type="hidden" name="punch_in_value" value="punch_in" />
                                <button type="submit" name ="punch_in" class="btn btn-primary punch-btn">Punch In</button>
                            </div>

                            @else

                                <div class="punch-info">
                                    <div class="punch-hours">
                                        @foreach ($today_attendance as $attendance)
                                            <?php
                                            $log_in_time = $attendance->log_in_time;
                                            $current_time = date("H:i:s ");

                                            $Interval =(strtotime($current_time) - strtotime($log_in_time)) ; ?>

                                                <span>{{gmdate("H:i", $Interval)}} hrs</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="punch-btn-section">
                                    <input type="hidden" name="punch_in_value" value="punch_out" />
                                    <button type="submit" name ="punch_out" class="btn btn-primary punch-btn">Punch Out</button>
                                    {{--{!! Form::submit('Punch Out', ['class'=>'btn btn-primary punch-btn', 'name'=>'punch_out'])!!}--}}
                                </div>
                            @endif
                            </form>
                        </div>
                    </div>
                    </div>
                </div>





                <div class="col-md-4">
                    <div class="card att-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Presence</h5>
                            <div class="stats-list">

                                <div class="punch-det">
                                    <h6>Today</h6>
                                    <p>{{date("d-M-Y")}} {{date("g:i:s A") }}</p>
                                </div>

                                <form method="POST" action="{{ route('mark_presence') }}">
                                    @csrf
                                {{--{!! Form::open(['route' => 'mark_presence']) !!}--}}

                                <div class="form-group">
                                    <label>Enter Your Reason <span class="text-danger">*</span></label>
                                    <textarea rows="4" class="form-control" name="reason"></textarea>
                                </div>



                                <div class="punch-btn-section">
                                    <button type="submit" name ="submit" class="btn btn-primary punch-btn">Submit</button>

{{--
                                    {!! Form::submit('Submit', ['class'=>'btn btn-primary punch-btn', 'name'=>'submit'])!!}
--}}
                                </div>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="card recent-activity">
                        <div class="card-body">
                            <h5 class="card-title">Your Leave</h5>
                            <div class="time-list">
                                <div class="dash-stats-list">
                                    <h4>4.5</h4>
                                    <p>Leave Taken</p>
                                </div>
                                <div class="dash-stats-list">
                                    <h4>12</h4>
                                    <p>Remaining</p>
                                </div>
                            </div>
                            <div class="request-btn">
                                <a href="#" class="btn btn-primary punch-btn"data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i>Apply Leave</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>




        </div>
        <!-- /Page Content -->

        <!-- Add Leave Modal -->
        <div id="add_leave" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('add_leaves') }}">
                            @csrf
                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <select name="leave_type" required="required" class="select">
                                    <option value=""> {{'Select Leave Type'}}</option>
                                    @foreach($leaves_types as $leaves_type)

                                        <option value="{{$leaves_type->id}}"> {{$leaves_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="">

                                    <input class="form-control " type="date" name="from_date" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="">
                                    <input class="form-control " type="date" name="to_date" required="required">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Leave Reason <span class="text-danger">*</span></label>
                                <textarea rows="4" class="form-control" name="reason" required="required"></textarea>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Leave Modal -->
    </div>
    <!-- Page Wrapper -->
@endsection