@extends('layout.mainlayout')
@section('content')
{{-- <link rel="stylesheet" href="{{asset('css/multidate.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> --}}

  <!-- Page Wrapper -->

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
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Add Separation</h3>

                            </div>
                            <div class="modal-body">
                                @if(!isset($resignation))

                                <form method="POST" action="{{ route('addResignation') }}">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{$userId}}">
                                    {{--<div class="form-group">
                                        <label>Resignation Type <span class="text-danger">*</span></label>
                                        <select class="form-control"  name="resignation_type" id="resignation_type" required="required">
                                            <option value="">Select Resignation Type</option>
                                        @foreach($resignation_types as $resignation_type)
                                            <option value="{{$resignation_type->id}}">{{$resignation_type->title}}</option>
                                           @endforeach
                                        </select>
                                    </div>--}}


                                    <div class="form-group">
                                        <label>Sepration Submission Date <span class="text-danger">*</span></label>
                                        <div class="">
                                            {{-- <input type="date" class="form-control" name="resignation_date" value="{{Carbon\Carbon::now()->toDateString()}}" readonly="readonly" required="required"> --}}
                                            <input type="date" class="form-control"   name="resignation_date" value="{{Carbon\Carbon::now()->toDateString()}}" min="{{Carbon\Carbon::now()->toDateString()}}"  max= "{{Carbon\Carbon::now()->addWeeks(1)->toDateString()}}"  required="required">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Last Working Day <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="date" class="form-control" name="lWorking_date" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Current Leave Balance <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="text" class="form-control" name="leaveBalance" value="{{$getLeaveBalance->first()->current_balance}}" readonly="readonly" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>I am joining an entity rated by PACRA in the last one year where I was part of the respective rating team Name of Prospective Employer?<span class="text-danger">*</span></label>
                                        <div class="">
                                            <select class="form-control"  name="inRC" id="inRC">
                                                <option value="00">No</option>
                                                @foreach($isRcPart as $isRc)
                                                    <option value="{{$isRc->first()->opinion_id}}">{{$isRc->first()->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Reason <span class="text-danger">*</span></label>
                                        <textarea name="reason" class="form-control" rows="4" required="required"></textarea>
                                    </div>





                                    <div class="submit-section">
                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered">Submit</button>

                                    </div>
                                </form>

                                    @else
                                    <form method="POST" action="{{ route('addResignation') }}">
                                        @csrf
                                        <input type="hidden" name="uid" value="{{$resignation->first()->user_id}}">
                                        <div class="form-group">
                                            <label>Separation Type <span class="text-danger">*</span></label>
                                            {{--<select class="form-control"  name="resignation_type" id="resignation_type" required="required">
                                                <option value="{{$resignation->first()->resignation_type}}">{{$resignation->first()->resignation_type}}</option>
                                                <option value="">Select Resignation Type</option>
                                                @foreach($resignation_types as $resignation_type)
                                                    <option value="{{$resignation_type->id}}">{{$resignation_type->title}}</option>
                                                @endforeach
                                            </select>--}}
                                            <input type="text" class="form-control"  value="{{$resignation_types->first()->title}}" readonly="readonly" required="required">

                                        </div>


                                        <div class="form-group">
                                            <label>Separation Date <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input type="date" class="form-control " name="resignation_date" value="{{$resignation->first()->resignation_date}}" required="required" readonly="readonly">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Last Working Day <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input type="date" class="form-control" name="lWorking_date" value="{{$resignation->first()->last_working_day}}" required="required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Current Leave Balance <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input type="text" class="form-control" name="leaveBalance" value="{{$getLeaveBalance->first()->current_balance}}" readonly="readonly" required="required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Reason <span class="text-danger">*</span></label>
                                            <textarea name="reason" class="form-control" rows="4" required="required">{{$resignation->first()->reason}}</textarea>
                                        </div>

                                        <input type="hidden" name="recordid" value="{{$resignation->first()->id}}">


                                        @if($resignation->first()->am_id == $userId and $resignation->first()->am_id)
                                            <div class="submit-section">
                                                <button  class="btn btn-primary submit-btn btn-danger" name="submit" type="submit" value="Approved"> Approve</button>
                                                <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Declined">Decline</button>

                                            </div>
                                        @else
                                        <div class="submit-section">
                                            <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered">Submit</button>

                                        </div>
                                           @endif
                                    </form>

                                    @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /Page Content -->


        </div>
        <!-- /Page Wrapper -->


        <script>

    $('.date-format').datepicker("yyyy-mm-dd", "option", "maxDate", "+1m +1w" );

            // dp = $('.date-format').datepicker({
            //     format: "yyyy-mm-dd",
            //     multidate: false,
            //     inline: true,
            //     todayHighlight: true,
            //     daysOfWeekDisabled: [0,6],
            //     startDate: 'today',

            // });
            // dp.on('changeDate', function(e) {

            //     if(e.dates.length <6){
            //         selectedDates = e.dates
            //     }else{
            //         dp.data('datepicker').setDates(selectedDates);
            //         alert('Can only select 5 dates')
            //     }

            // });






        </script>

@endsection
