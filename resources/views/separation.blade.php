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
                    <div class="modal-content">

                        <!-- Employee Separation Form -->

@if($userId == $seprationDetails->first()->uuid)

        <div class="card">
            <div class="card-header">
                <h1 class="card-title mb-0">EMPLOYEE SEPARATION FORM</h1>
                <p class="card-text">Please respond to all statements, ‘✔’ if applicable / affirmative and ‘❌’ if not applicable / negative.</p>
            </div>

            <div class="card-header">
                <h4>Section - 1	| To be completed by Resigning Employee</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">


                        <form method="POST" action="{{ route('addSeparation') }}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault01">Employee Name</label>
                                    <input type="text" class="form-control" name="empName" value="{{$seprationDetails->first()->display_name}}" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault02">Designation</label>
                                    <input type="text" class="form-control" name="empDesignation" value="{{$seprationDetails->first()->designation}}" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefaultUsername">Joining Date:</label>
                                    <input type="text" class="form-control" name="empDoj" value="{{$seprationDetails->first()->doj}}" readonly>

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">

                                    <label for="validationDefault03">Sepration Submission Date:

                                    </label>
                                    <input type="text" class="form-control" value="{{$seprationDetails->first()->resignation_date}}" readonly>
                                    <small id="sponsorHelp" class="form-text text-muted">the date on which resignation was submitted to respective Head</small>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault05">Resignation Effective Date:</label>
                                    <input type="text" class="form-control" id="validationDefault05" placeholder="Zip" value="{{$seprationDetails->first()->last_working_day}}" readonly>
                                    <small id="sponsorHelp" class="form-text text-muted">the date which is the last working day with PACRA</small>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault05">Notice Period (Days):</label>
                                    <input type="text" class="form-control" name="empNoticePeriod" value="{{$seprationDetails->first()->notice_period_days}}" readonly>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault04">Total Period Served:</label>
                                    <input type="text" class="form-control" name="empService" value="{{$seprationDetails->first()->total_period_served}}" readonly>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault03">Correspondence Mail Address:</label>
                                    <input type="text" class="form-control"  value="{{$seprationDetails->first()->address}}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationDefault03">Correspondence Contact Number:</label>
                                    <input type="text" class="form-control"  value="{{$seprationDetails->first()->phone}}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationDefault03">Correspondence E-Mail Address: </label>
                                    <input type="text" class="form-control"  value="{{$seprationDetails->first()->email}}" readonly>
                                </div>

                                @if($seprationDetails->first()->notice_period_days < 30)

                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault03">Reason(s) for Short Notice: </label>
                                    <textarea class="form-control" name="ReasonShortNotice" required ></textarea>

                                </div>

                                @endif

                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault03">Reason(s) for Leaving: </label>
                                    <textarea class="form-control"  readonly >{{$seprationDetails->first()->reason}}</textarea>

                                </div>

                                <input type="hidden" name="regisID" value="{{$seprationDetails->first()->regisID}}">
                                <input type="hidden" name="uuid" value="{{$seprationDetails->first()->uuid}}">


                            </div>
                            <div class="form-group">
                                <div class="form-check">
{{--                                    @if($seprationDetails->first()->inRC != 0)--}}
{{--                                        <input class="form-check-input" type="checkbox" value="{{2}}" name="chklist[]" id="invalidCheck{{2}}" checked="checked" required="required">{{'I am joining an entity rated by PACRA in the last one year where I was part of the respective rating team--}}
{{--Name of Prospective Employer:  '}}{{$seprationDetails->first()->client}}--}}
{{--                                        <label class="form-check-label" for="invalidCheck{{2}}">--}}
{{--                                    @elseif($seprationDetails->first()->inRC == 0)--}}
{{--                                    <input class="form-check-input" type="checkbox" value="{{1}}" name="chklist[]" id="invalidCheck{{1}}" checked="checked" required="required">{{'I am not joining an entity rated by PACRA in the last one year where I was part of the respective rating team'}}--}}
{{--                                        <label class="form-check-label" for="invalidCheck{{1}}">--}}

{{--                                    @endif--}}



                                    @foreach($seprattionCheckList->where('attribute', 'emp') as $key=> $chkList)
                                        <input class="form-check-input" type="checkbox" value="{{$chkList->id}}" name="chklist[]" id="invalidCheck{{$key}}" checked="checked" >
                                        <label class="form-check-label" for="invalidCheck{{$key}}">
                                            {{$chkList->checkList}}</label><br>
                                        @endforeach

                                        </label>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit" name="submit" value="emp_submit">Submit form</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <!-- /Employee Separation Form -->

                       




                            @endif







                    </div>

                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- /Page Wrapper -->




@endsection