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
                                        <h3 class="modal-title">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('addReScheduleInterview') }}" enctype="multipart/form-data" files="true">
                                            @csrf

                                            <div class="form-group">
                                                <label>Job Title<span class="text-danger">*</span></label>
                                                <div class="">

                                                    <input class="form-control" type="text" name="jobTitle" value="{{$jobDetails->first()->jobTitles}}" readonly="readonly">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Candidate Name <span class="text-danger">*</span></label>
                                                <div class="">

                                                    <input class="form-control" type="text" name="candidateName" value="{{$userProfile->first()->fname}} {{$userProfile->first()->lname}}" required="required">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label>Interview Date <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input class="form-control " type="date" name="date" value="{{$getInterviewDetails->date}}" required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Interview Time <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input class="form-control " type="time" name="time" value="{{$getInterviewDetails->time}}" required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Interview Location<span class="text-danger">*</span></label>
                                                <select name="interviewLocation" required="required" class="select">
                                                    <option value="{{$getInterviewDetails->interviewLocation}}"> {{$getInterviewDetails->interviewLocation}} </option>
                                                        <option value="Online"> Online </option>
                                                        <option value="Head Office"> Head Office</option>

                                                </select>
                                            </div>


                                            <input type="hidden" name="userID" value="{{$userProfile->first()->userID}}" >
                                            <input type="hidden" name="candidateID" value="{{$candidateID}}" >
                                            <input type="hidden" name="jobID" value="{{$jobDetails->first()->id}}" >
                                            <input type="hidden" name="interviewID" value="{{$getInterviewDetails->id}}" >




                                            <div class="submit-section">
                                                <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                        <!-- /Add Leave Modal -->

                    </div>
                </div>
            </div>
            <!-- /Page Content -->



        </div>
        <!-- /Page Wrapper -->

@endsection
