@extends('layout.mainlayout')
@section('content')
    <style>
        .headline h4, .headline p {
            display: inline;
            vertical-align: top;
            /*font-family: 'Open Sans', sans-serif;*/
            /*font-size: 16px;*/
            line-height: 15px;
        }
    </style>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="card punch-status">
                        <div class="card-body">
                            <h5 class="card-title">Timesheet <small
                                    class="text-muted">{{date("d-M-Y")}} {{date("g:i:s A") }}</small></h5>
                            <div class="stats-list">
                                <form method="POST" action="{{ route('mark_attendance') }}">
                                    @csrf


                                    @if($attendanceActivity->isEmpty())
                                        <?php $ipAddresses = array('202.141.241.58', '125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58', '110.39.42.115', '37.120.148.134', '202.47.36.144', '110.93.217.146');?>
                                        @if (!in_array($ip_address, $ipAddresses))
                                            <div class="punch-det">
                                                <h6 class="alert alert-danger" role="alert">You are not in
                                                    Pacra...!!!</h6>

                                            </div>
                                        @endif
                                    @else

                                        <div class="punch-det">
                                            <h6>Punch In at</h6>
                                            <p>{{date("D, ")}} {{date("d-M-Y")}}

                                                {{!empty($today_attendance[0]->log_in_time) ? $today_attendance[0]->log_in_time: ''}}

                                            </p>
                                        </div>
                                    @endif






                                    @if($attendanceActivity->isEmpty())

                                        <div class="punch-info">
                                            <div class="punch-hours">
                                                <span>0.00 hrs</span>
                                            </div>
                                        </div>
                                        <div class="punch-btn-section">

                                            <input type="hidden" name="punch_in_value" value="punch_in"/>

                                            <?php $ipAddresses = array('202.141.241.58', '125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58', '110.39.42.115', '37.120.148.134', '202.47.36.144', '110.93.217.146', '127.0.0.1');?>

                                            @if (in_array($ip_address, $ipAddresses) )
                                                <button type="submit" name="punch_in"
                                                        class="btn btn-primary punch-btn">
                                                    Punch In
                                                </button>
                                            @elseif(!in_array($ip_address, $ipAddresses)and $chkWFH == null and $chkClientVsit == null and $chkClientVsitTeam == null)
                                                <h6 class="alert alert-danger" role="alert">You are not allowed to
                                                    mark
                                                    attendance from home...!!!</h6>
                                            @elseif(!in_array($ip_address, $ipAddresses)and ($chkWFH <> null or $chkClientVsit <> null or $chkClientVsitTeam <> null))
                                                <button type="submit" name="punch_in"
                                                        class="btn btn-primary punch-btn">
                                                    Punch In
                                                </button>
                                            @else
                                                <h6 class="alert alert-danger" role="alert">You are not allowed to
                                                    mark
                                                    attendance from home...!!!</h6>
                                            @endif
                                        </div>

                                    @elseif($attendanceActivity[0]->activity=='punch_out')

                                        <div class="punch-info">
                                            <div class="punch-hours">
                                                <span>0.00 hrs</span>
                                            </div>
                                        </div>
                                        <div class="punch-btn-section">
                                            {{-- {!! Form::submit('Punch In', ['class'=>'btn btn-primary punch-btn', 'name'=>'punch_in'])!!}--}}
                                            <input type="hidden" name="punch_in_value" value="punch_in"/>
                                            <button type="submit" name="punch_in" class="btn btn-primary punch-btn">
                                                Punch In
                                            </button>
                                        </div>

                                    @else

                                        <div class="punch-info">
                                            <div class="punch-hours">
                                                @foreach ($maxPunchIn as $attendance)
                                                    <?php
                                                    $log_in_time = $attendance->time;
                                                    $current_time = date("H:i:s ");

                                                    $Interval = (strtotime($current_time) - strtotime($log_in_time)); ?>

                                                    <span>{{gmdate("H:i", $Interval)}} hrs</span>
                                                    <input type="hidden" name="office_hours"
                                                           value={{gmdate("H:i:s", $Interval)}} />
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="punch-btn-section">
                                            <?php $ipAddresses = array('202.141.241.58', '125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58', '110.39.42.115', '37.120.148.134', '202.47.36.144', '110.93.217.146');?>

                                            @if (in_array($ip_address, $ipAddresses) || count($chkWFH) > 0 || count($chkClientVsit) > 0 || count($chkClientVsitTeam) > 0 )
                                                <input type="hidden" name="punch_in_value" value="punch_out"/>
                                                <button type="submit" name="punch_out"
                                                        class="btn btn-primary punch-btn">
                                                    Punch Out
                                                </button>
                                            @else
                                                <h6 class="alert alert-danger" role="alert">You are only allowed to
                                                    Punch Out within PACRA</h6>
                                            @endif
                                            {{--{!! Form::submit('Punch Out', ['class'=>'btn btn-primary punch-btn', 'name'=>'punch_out'])!!}--}}
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card recent-activity">
                        <div class="card-body">
                            <h5 class="card-title">Today Activity</h5>
                            <ul class="res-activity-list">

                                @foreach($todayAttendanceActivity as $activity)
                                    <li>
                                        <p class="mb-0">
                                            @if($activity->activity == 'punch_in')
                                                {{'Punch In at'}}
                                            @else
                                                {{'Punch Out at'}}
                                            @endif
                                        </p>
                                        <p class="res-activity-time">
                                            <i class="fa fa-clock-o"></i>
                                            {{date("g:i A", strtotime($activity->time))}}

                                        </p>
                                    </li>

                                @endforeach


                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card att-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Statistics (Month to Date)</h5>
                            <div class="stats-list">
                                <div class="stats-info">
                                    <p>On Time <strong>{{$ontime_statistics}} <small>/ {{$diffInMonthdays}}
                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                             style="width: {{$ontime_statistics/$diffInMonthdays*100}}%"
                                             aria-valuenow="{{$ontime_statistics/365*100}}" aria-valuemin="0"
                                             aria-valuemax="365"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Late Coming <strong>{{$late_statistics}} <small>/ {{$diffInMonthdays}}
                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                             style="width: {{$late_statistics/$diffInMonthdays*100}}%"
                                             aria-valuenow="{{$late_statistics/365*100}}" aria-valuemin="0"
                                             aria-valuemax="50"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Leaves <strong>{{$leave_statistics}} <small>/ {{$diffInMonthdays}}
                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             style="width: {{$leave_statistics/$diffInMonthdays*100}}%"
                                             aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Absent <strong>{{$absent_statistics}} <small>/ {{$diffInMonthdays}}
                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                             style="width: {{$absent_statistics/$diffInMonthdays*100}}%"
                                             aria-valuenow="{{$absent_statistics/365*100}}" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Public Holiday | Weekend <strong>{{$holiday_statistics}}
                                            | {{$weekend_statistics}}</strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: {{$holiday_statistics+$weekend_statistics/$diffInMonthdays*100}}%"
                                             aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card att-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Statistics (Year to Date)</h5>
                            <div class="stats-list">
                                <div class="stats-info">
                                    <p>On Time <strong>{{$ontime_statisticsYear}} <small>/ {{$yearToDateDays}}
                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                             style="width: {{$ontime_statisticsYear/$yearToDateDays*100}}%"
                                             aria-valuenow="{{$ontime_statistics/365*100}}" aria-valuemin="0"
                                             aria-valuemax="365"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Late Coming <strong>{{$late_statisticsYear}} <small>/ {{$yearToDateDays}}
                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                             style="width: {{$late_statisticsYear/$yearToDateDays*100}}%"
                                             aria-valuenow="{{$late_statistics/365*100}}" aria-valuemin="0"
                                             aria-valuemax="50"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Leaves <strong>{{$leave_statisticsYear}} <small>/ {{$yearToDateDays}}
                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             style="width: {{$leave_statisticsYear/$yearToDateDays*100}}%"
                                             aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Absent <strong>{{$absent_statisticsYear}} <small>/ {{$yearToDateDays}}
                                                Days</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                             style="width: {{$absent_statisticsYear/$yearToDateDays*100}}%"
                                             aria-valuenow="{{$absent_statistics/365*100}}" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Public Holiday | Weekend <strong>{{$holiday_statisticsYear}}
                                            | {{$weekend_statisticsYear}}</strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: {{$holiday_statisticsYear+$weekend_statisticsYear/$yearToDateDays*100}}%"
                                             aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card recent-activity">
                        <div class="card-body">
                            <div class="card-title headline" style="white-space: nowrap">
                                <h4>Your Leave</h4>
                                <p style="color: #777777; display: inline;vertical-align: top;">
                                    from: {{date('d-M', strtotime($currentMonthStart ?? ''))}} - Up Till Now
                                </p>
                            </div>
                            <div class="time-list">
                                <div class="dash-stats-list">
                                    <h4>{{number_format((float)$leavesPerMonth, 2, '.', '')}}</h4>
                                    <p>Entitled</p>
                                </div>
                                <div class="dash-stats-list">
                                    <h4>{{$getLeaveTaken}}</h4>
                                    <p>Taken</p>
                                </div>
                                <div class="dash-stats-list">
                                    <h4>{{number_format((float)$getLeaveBalance, 2, '.', '')}}</h4>
                                    {{--                                    <h4>NA</h4>--}}
                                    <p>Remaining</p>
                                </div>
                            </div>
                            <div class="request-btn">
                                <a href="{{route('leave_application')}}" class="btn btn-primary punch-btn">
                                    <i class="fa fa-plus"></i>Apply Leave</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Filter -->


            <form method="POST" action="{{ route('get_employee_attendance_report') }}">
                @csrf
                <div class="row filter-row">
                    <div class="col-sm-4">
                        <div class="form-group form-focus">
                            <div class="form-group">

                                <input class="form-control " type="date" name="from_date" required="required">
                            </div>
                            <label class="focus-label">Select Start Date</label>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group form-focus">
                            <div class="form-group">

                                <input class="form-control " type="date" name="to_date" required="required">
                            </div>
                            <label class="focus-label">Select End Date</label>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="{{$userId}}">


                    <div class="col-sm-4">
                        <button class="btn btn-success btn-block ">Get Report</button>


                    </div>
                </div>
            </form>


            <!-- /Search Filter -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Punch In</th>
                                <th>Punch Out</th>
                                <th>Office Hours</th>
                                <th>Status</th>
                                {{--                                <th>Punch Out Status</th>--}}
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($last_two_days_attendance as $index => $attendance)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$attendance->date}}</td>
                                    <td>{{$attendance->log_in_time}}</td>
                                    @if($attendance->punch_out_status == 'Auto Punch Out')
                                        <td style="color: red">{{$attendance->log_out_time}}</td>
                                    @else
                                        <td>{{$attendance->log_out_time}}</td>
                                    @endif
                                    <?php    $log_in_time = $attendance->log_in_time;
                                    $Interval = (strtotime($attendance->log_out_time) - strtotime($log_in_time)); ?>

                                    <td>
                                        {{!empty($attendance->log_out_time) ? gmdate("H:i", $Interval): ''}}
                                    </td>
                                    <td>{{$attendance->title}}</td>
                                    {{--                                    <td>{{$attendance->punch_out_status}}</td>--}}
                                    <td>

                                        {{--                                        @if($attendance->date == carbon\carbon::now()->toDateString() and (empty($checkEditAttendanceApp->first()->id)) )--}}
                                        @if($attendance->date == carbon\carbon::now()->toDateString() and (empty($checkEditAttendanceApp->first()->id)) )
                                            <a href="{{ route('editAttendanceRequest') }}/{{$attendance->attendanceRecordID}}"
                                               target="_blank">{{'Edit'}}</a>

                                        @endif
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
    <!-- Page Wrapper -->
@endsection
