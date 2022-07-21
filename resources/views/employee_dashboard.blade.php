@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="welcome-box">
                        <div class="welcome-img">
                            <img src="{{asset('users/')}}/{{$userDP}}" alt="">
                        </div>
                        <div class="welcome-det">
                            <h3>Welcome, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
                            <p>{{date("l, ")}} {{date("d M Y")}} </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <section class="dash-section">
                        <h1 class="dash-sec-title">Today</h1>
                        <div class="dash-sec-content">


                            <div class="dash-info-list">
                                <a href="#" class="dash-card">
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class="fa fa-building-o"></i>
                                        </div>
                                        <div class="dash-card-content">
                                            @if($check_ip == NULL)
                                                <p>You are working from home today</p>
                                            @else
                                                <p>You are working from office today</p>
                                            @endif
                                        </div>
                                        <div class="dash-card-avatars">
                                            <div class="e-avatar"><img src="{{asset('users/')}}/{{$userDP}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            {{-- <div class="dash-info-list">
                                 <a href="#" class="dash-card text-danger">
                                     <div class="dash-card-container">
                                         <div class="dash-card-icon">
                                             <i class="fa fa-hourglass-o"></i>
                                         </div>
                                         <div class="dash-card-content">
                                             <p>Richard Miles is off sick today</p>
                                         </div>
                                         <div class="dash-card-avatars">
                                             <div class="e-avatar"><img src="img/profiles/avatar-09.jpg" alt=""></div>
                                         </div>
                                     </div>
                                 </a>
                             </div>


                             <div class="dash-info-list">
                                 <a href="#" class="dash-card">
                                     <div class="dash-card-container">
                                         <div class="dash-card-icon">
                                             <i class="fa fa-suitcase"></i>
                                         </div>
                                         <div class="dash-card-content">
                                             <p>You are away today</p>
                                         </div>
                                         <div class="dash-card-avatars">
                                             <div class="e-avatar"><img src="img/profiles/avatar-02.jpg" alt=""></div>
                                         </div>
                                     </div>
                                 </a>
                             </div>
--}}


                        </div>
                    </section>

                    <section class="dash-section">
                        <h1 class="dash-sec-title">Tomorrow</h1>
                        <div class="dash-sec-content">
                            <div class="dash-info-list">
                                <div class="dash-card">
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class="fa fa-suitcase"></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <p>{{$getEmpOnLeaveTomorrow->count()}} people will be away tomorrow</p>
                                        </div>
                                        <div class="dash-card-avatars">
                                            @foreach ($getEmpOnLeaveTomorrow as $getEmpOnLeave)
                                                <a href="{{ url('profile') }}/{{$getEmpOnLeave->user_id}}"
                                                   target="_blank" class="e-avatar"><img
                                                        src="{{asset('users/')}}/{{$getEmpOnLeave->avatar_file}}"
                                                        alt=""></a>

                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="dash-section">
                        {{-- <h1 class="dash-sec-title">Next seven days</h1> --}}
                        <div class="dash-sec-content">


                            <div class="dash-info-list">
                                <div class="dash-card">
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <h3>Reporting To</h3>
                                        </div>
                                    </div>


                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class=""></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <h4><a href="{{ url('profile') }}/{{$reportingTo->first()->amID}}"
                                                   target="_blank"
                                                   style="color: #1f1f1f">{{$reportingTo->first()->AmName}}</a></h4>

                                            {{-- <p>{{$reportingTo->first()->AmName}}</p> --}}
                                        </div>

                                        <div class="dash-card-avatars">
                                            <div class="e-avatar"><img
                                                    src="{{asset('users/')}}/{{$reportingTo->first()->avatar_file}}"
                                                    alt=""></div>
                                        </div>

                                    </div>


                                    <br>
                                    <div class="dash-card-container">
                                        <div class="dash-card-icon">
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                        <div class="dash-card-content">
                                            <h3>Reportees </h3>
                                        </div>
                                    </div>


                                    @foreach($reportees as $reportee)

                                        <div class="dash-card-container">
                                            <div class="dash-card-icon">
                                                <i class=""></i>
                                            </div>
                                            <div class="dash-card-content">
                                                <h4><a href="{{ url('profile') }}/{{$reportee->id}}" target="_blank"
                                                       style="color: #1f1f1f">{{$reportee->display_name}}</a></h4>

                                                {{-- <p>{{$reportee->display_name}}</p> --}}
                                            </div>

                                            <div class="dash-card-avatars">
                                                <div class="e-avatar"><img
                                                        src="{{asset('users/')}}/{{$reportee->avatar_file}}" alt="">
                                                </div>
                                            </div>

                                        </div>

                                    @endforeach


                                </div>
                            </div>

                        </div>
                    </section>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="dash-sidebar">
                        <?php $user_rights = \App\Helpers\helpers::get_user_rights(Auth::id()); ?>
                        @if(in_array('9', $user_rights) )
                            <section>
                                <h5 class="dash-title">Employees</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4><a href="{{ url('employees') }}" target="_blank"
                                                       style="color: #1f1f1f">{{$getActiveEmployee}}</a></h4>
                                                <p>Total</p>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4><a href="{{ url('present-employees') }}" target="_blank"
                                                       style="color: #1f1f1f">{{$presentEmployees}}</a></h4>
                                                <p>Present</p>
                                            </div>
                                        </div>
                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4><a href="{{ url('on-time') }}" target="_blank"
                                                       style="color: #1f1f1f">{{$onTimeEmployees}}</a></h4>
                                                <p>On Time</p>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4><a href="{{ url('late-comers') }}" target="_blank"
                                                       style="color: #1f1f1f">{{$lateComersEmployees}}</a></h4>
                                                <p>Late Comers</p>
                                            </div>
                                        </div>

                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                @if($absentEmployeesIf == 0)
                                                    <h4><a href="{{ url('absentees') }}" target="_blank"
                                                           style="color: #1f1f1f">{{$absentEmployees}}</a></h4>
                                                @else
                                                    <h4><a href="{{ url('absentees') }}" target="_blank"
                                                           style="color: #1f1f1f">{{$absentEmployeesIf}}</a></h4>
                                                @endif
                                                <p>Absent</p>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4><a href="{{ url('on-leave') }}" target="_blank"
                                                       style="color: #1f1f1f">{{$onLeaveEmployees}}</a></h4>
                                                <p>On Leave</p>
                                            </div>
                                        </div>

                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4><a href="{{ url('in-office') }}" target="_blank"
                                                       style="color: #1f1f1f">{{$getEmployeesInOffice}}</a></h4>
                                                <p>In Office</p>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4><a href="{{ url('anywhere-emp') }}" target="_blank"
                                                       style="color: #1f1f1f">{{$getAnywhereEmployees}}</a></h4>
                                                <p>Anywhere</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>                            @endif


                                <h5 class="dash-title">Your Annual Leave Balanve</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="time-list">
                                            <div class="dash-stats-list">
                                                <h4>
                                                    {{!empty($getLeaveTaken) ? $getLeaveTaken: '0'}}
                                                </h4>
                                                <p>Leaves Taken</p>
                                            </div>
                                            <div class="dash-stats-list">
                                                <h4>
                                                    {{!empty($getLeaveBalance->first()->current_balance) ? $getLeaveBalance->first()->current_balance: '0'}}
                                                </h4>
                                                <p>Remaining</p>
                                            </div>
                                        </div>
                                        <div class="request-btn">
                                            <a class="btn btn-primary" href="{{ route('leave_application') }}">Apply
                                                Leave</a>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section>
                                <h5 class="dash-title">Upcoming Holiday</h5>
                                <div class="card">
                                    <div class="card-body text-left">
                                        @foreach ($upcomingHoliday as $index=>$holiday)
                                            <h4><a href="{{ url('holidays') }}" target="_blank"
                                                   style="color: #1f1f1f">{{1+$index}} - {{$holiday->holiday_name}}
                                                    - {{date('d M Y', strtotime($holiday->from_date))}}</a></h4>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->
@endsection


