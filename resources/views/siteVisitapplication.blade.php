@extends('layout.mainlayout')
@section('content')

    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="{{asset('css/multidate.css')}}">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    </head>

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
                            <li class="breadcrumb-item active">{{!empty($meta_title) ? $meta_title: 'PACRA'}}s</li>
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


            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">

                    <!-- Add Leave Modal -->

                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Add Client Visit</h3>
                        </div>
                        <div class="modal-body">
                            @if(!isset($siteVisit))

                                <form method="POST" action="{{ route('addSiteVisit') }}">
                                    @csrf

                                    <input type="hidden" name="uid" value="{{$userId}}">


                                    <div class="form-group">

                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="text" class="form-control date" name="dates"
                                                   placeholder="Pick the multiple dates">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Select Time <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <select name="time" required="required" class="select">
                                                <option value=""> {{'Select Time'}}</option>
                                                <option value="1"> All Day</option>
                                                <option value="2"> First Half</option>
                                                <option value="3"> Second Half</option>

                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label>Select Client <span class="text-danger">*</span></label>
                                        <div class="">
                                            <select name="client" required="required" class="select">
                                                <option value=""> {{'Select Client'}}</option>
                                                <option value="0"> {{'Others'}}</option>
                                                {{--                                                        @if($userDesig == 4 or $userDesig == 16)--}}
                                                @foreach($outstanding->where('manager', $userId) as $clients)

                                                    <option value="{{$clients->Id}}"> {{$clients->Entity}}</option>
                                                @endforeach
                                                {{--                                                                    @elseif($userDesig == 6 or $userDesig == 7 or $userDesig == 8)--}}
                                                @foreach($outstanding->where('analyst', $userId) as $clients)

                                                    <option value="{{$clients->Id}}"> {{$clients->Entity}}</option>
                                                @endforeach

                                                {{--                                                        @elseif($userDesig == 2)--}}
                                                @foreach($outstanding->where('lead_rc_id', $userId) as $clients)

                                                    <option value="{{$clients->Id}}"> {{$clients->Entity}}</option>
                                                @endforeach
                                                {{--                                                            @endif--}}
                                            </select>

                                        </div>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label>Is Anyother going <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <table class="table table-striped custom-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Is Going?</th>
                                                    <th>Time</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($teamMembers as $teamMember)
                                                    <tr>
                                                        <td>{{$teamMember->display_name}}</td>
                                                        <td>
                                                            <select name="team[]" class="select">
                                                                <option value=""> No</option>
                                                                <option value="{{$teamMember->id}}"> Yes</option>

                                                            </select>

                                                        </td>
                                                        <td>
                                                            <select name="teamtime[]" class="select">
                                                                <option value=""> {{'Select Time'}}</option>
                                                                <option value="1"> All Day</option>
                                                                <option value="2"> First Half</option>
                                                                <option value="3"> Second Half</option>
                                                            </select>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Reason <span class="text-danger">*</span></label>
                                        <textarea rows="4" class="form-control" name="reason"
                                                  required="required"></textarea>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="Entered"> Submit
                                        </button>
                                    </div>
                                </form>
                            @else

                                <form method="POST" action="{{ route('addSiteVisit') }}">
                                    @csrf
                                    <input type="hidden" name="recordid" value="{{$siteVisit[0]->recordId}}">
                                    <input type="hidden" name="uid" value="{{$siteVisit[0]->user_id}}">
                                    <input type="hidden" name="amID" value="{{$amId[0]}}">


                                    <div class="form-group">

                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="text" class="form-control date" name="dates"
                                                   value="{{$siteVisit[0]->dates}}"
                                                   placeholder="Pick the multiple dates">


                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Select Time <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <select name="time" required="required" class="select">
                                                <option
                                                    value="{{$siteVisit[0]->time}}">{{$siteVisit[0]->visitTime}}</option>

                                                <option value=""> {{'Select Time'}}</option>
                                                @foreach($clintVisitTimes as $time)
                                                    <option value="{{$time->id}}"> {{$time->title}}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label>Select Client <span class="text-danger">*</span></label>
                                        <div class="">
                                            <select name="client" required="required" class="select">
                                                @if($siteVisit->first()->client_id == 0)
                                                    <option
                                                        value="{{$siteVisit->first()->client_id}}"> {{'Others'}}</option>
                                                @else

                                                    <option
                                                        value="{{$siteVisit->first()->client_id}}"> {{$siteVisit->first()->cName}}</option>
                                                    <option value=""> {{'Select Client'}}</option>

                                                    @if($userDesig == 4 or $userDesig == 16)
                                                        @foreach($outstanding->where('manager', $userId) as $clients)

                                                            <option
                                                                value="{{$clients->Id}}"> {{$clients->Entity}}</option>
                                                        @endforeach
                                                    @elseif($userDesig == 6 or $userDesig == 7 or $userDesig == 8)
                                                        @foreach($outstanding->where('analyst', $userId) as $clients)

                                                            <option
                                                                value="{{$clients->Id}}"> {{$clients->Entity}}</option>
                                                        @endforeach

                                                    @elseif($userDesig == 2)
                                                        @foreach($outstanding->where('lead_rc_id', $userId) as $clients)

                                                            <option
                                                                value="{{$clients->Id}}"> {{$clients->Entity}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>

                                        </div>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label>Is Anyother going <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <table class="table table-striped custom-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Is Going?</th>
                                                    <th>Time</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($teams as $key=>$team)


                                                    <tr>
                                                        <td>{{$team->display_name}}</td>
                                                        <td>
                                                            <select name="team[]" class="select">

                                                                <option value="{{$team->id}}"> Yes</option>
                                                                <option value=""> No</option>

                                                            </select>
                                                        </td>
                                                        <td>


                                                            <select name="teamtime[]" class="select">


                                                                <option value=""> {{'Select Time'}}</option>
                                                                <option
                                                                    {{$temp[$team->id] == 1 ? 'selected' : '' }} value="1">
                                                                    All Day
                                                                </option>
                                                                <option
                                                                    {{$temp[$team->id] == 2 ? 'selected' : '' }} value="2">
                                                                    First Half
                                                                </option>
                                                                <option
                                                                    {{$temp[$team->id] == 3 ? 'selected' : ''}} value="3">
                                                                    Second Half
                                                                </option>

                                                            </select>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Reason <span class="text-danger">*</span></label>
                                        <textarea rows="4" class="form-control" name="reason"
                                                  required="required">{{$siteVisit->first()->comments}}</textarea>
                                    </div>
                                    <div class="submit-section">
                                        @if($siteVisit->first()->user_id == $userId and $siteVisit->first()->status == 'Entered' )
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Update"> Update
                                            </button>
                                        @endif
                                        @if($siteVisit->first()->user_id <> $userId and (in_array('16', $user_rights )) and $siteVisit->first()->status == 'Entered' )
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="approve"> Approve
                                            </button>
                                            <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                    type="submit" value="decline"> Decline
                                            </button>

                                        @endif


                                    </div>
                                </form>

                                {{--


                                                                                    </div>
                                                                                </div>


                                                                                <div class="form-group">
                                                                                    <label>Reason <span class="text-danger">*</span></label>
                                                                                    <textarea rows="4" class="form-control" name="reason"  required="required"> {{$siteVisit[0]->comments}}</textarea>
                                                                                </div>
                                {{--
                                                                                @if($attribute == 'siteVisit')

                                                                                    <div class="submit-section">
                                                                                        @if($WFH[0]->status == 'Entered' and (in_array('16', $user_rights)) )
                                                                                            <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Approve"> Approve</button>
                                                                                            <button  class="btn btn-primary submit-btn btn-danger" name="submit" type="submit" value="Decline"> Decline</button>


                                                                                        @elseif($WFH[0]->status == 'Approve' or $WFH[0]->status == 'Recommend' or $WFH[0]->status == 'Decline' )
                                                                                            {{'You already'}} {{$WFH[0]->status}} {{'this application'}}

                                                                                        @else
                                                                                            <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Submit</button>

                                                                                        @endif
                                                                                    </div>

                                                                                @else



                                                                                <div class="submit-section">
                                                                                    @if($WFH[0]->status == 'Recommend' and (in_array('6', $user_rights)) )
                                                                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Approve"> Approve</button>
                                                                                        <button  class="btn btn-primary submit-btn btn-danger" name="submit" type="submit" value="Decline"> Decline</button>

                                                                                    @elseif($WFH[0]->status == 'Entered' and (in_array('16', $user_rights)) )
                                                                                    <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Recommend"> Recommend</button>
                                                                                        <button  class="btn btn-primary submit-btn btn-danger" name="submit" type="submit" value="Decline"> Decline</button>

                                                                                    @elseif($WFH[0]->status == 'Approve' or $WFH[0]->status == 'Recommend' or $WFH[0]->status == 'Decline' )
                                                                                        {{'You already'}} {{$WFH[0]->status}} {{'this application'}}

                                                                                    @else
                                                                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Submit</button>

                                                                                    @endif
                                                                                </div>
                                                                            </form>
                                                                          @endif--}}
                            @endif

                        </div>
                    </div>

                    <!-- /Add Leave Modal -->

                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- /Page Wrapper -->


    <script>


        dp = $('.date').datepicker({
            format: "yyyy-mm-dd",
            multidate: true,
            inline: true,
            todayHighlight: true,
            daysOfWeekDisabled: [0, 6],
            startDate: 'today'
        });
        dp.on('changeDate', function (e) {

            if (e.dates.length < 6) {
                selectedDates = e.dates
            } else {
                dp.data('datepicker').setDates(selectedDates);
                alert('Can only select 5 dates')
            }

        });


    </script>

@endsection
