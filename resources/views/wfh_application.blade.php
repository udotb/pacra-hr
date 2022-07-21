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


            <div class="row">
                <div class="col-md-12">

                    <!-- Add Leave Modal -->

                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Add WFH </h3>
                        </div>
                        <div class="modal-body">
                            @if(!isset($WFH))
                                <form method="POST" action="{{ route('add_wfh') }}">
                                    @csrf

                                    <input type="hidden" name="uid" value="{{$userId}}">

                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="text" class="form-control date" name="dates"
                                                   placeholder="Pick the multiple dates">
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
                                <form method="POST" action="{{ route('add_wfh') }}">
                                    @csrf

                                    <div class="form-group">

                                        <input type="hidden" name="recordid" value="{{$WFH[0]->id}}">
                                        <input type="hidden" name="uid" value="{{$WFH[0]->user_id}}">
                                        <input type="hidden" name="amID" value="{{$amId[0]}}">

                                        <label>Dates <span class="text-danger">*</span></label>
                                        <div class="">
                                            {{--
                                            --}} <input type="text" class="form-control date" name="dates"
                                                        value="{{$WFH[0]->dates}}"
                                                        placeholder="Pick the multiple dates">


                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Reason <span class="text-danger">*</span></label>
                                        <textarea rows="4" class="form-control" name="reason"
                                                  required="required"> {{$WFH[0]->reason}}</textarea>
                                    </div>


                                    <div class="submit-section">
                                        @if($WFH[0]->status == 'Recommend' and (in_array('6', $user_rights)) )
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Approve"> Approve
                                            </button>
                                            <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                    type="submit" value="Decline-HR"> Decline
                                            </button>

                                        @elseif($WFH[0]->status == 'Entered' and (in_array('16', $user_rights)) )
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Recommend"> Recommend
                                            </button>
                                            <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                    type="submit" value="Decline-TL"> Decline
                                            </button>

                                        @elseif($WFH[0]->status == 'Approve' or $WFH[0]->status == 'Recommend' or $WFH[0]->status == 'Decline-HR' or $WFH[0]->status == 'Decline-TL' )
                                            {{'You already'}} {{$WFH[0]->status}} {{'this application'}}

                                        @else
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Entered"> Submit
                                            </button>

                                        @endif
                                    </div>
                                </form>
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
