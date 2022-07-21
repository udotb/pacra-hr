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
                                        <h3 class="modal-title">Schedule Test</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('addScheduleTest') }}" enctype="multipart/form-data" files="true">
                                            @csrf

                                            <div class="form-group">
                                                <label>Job Title<span class="text-danger">*</span></label>
                                                <div class="">

                                                    <input class="form-control" type="text" name="jobTitle" value="{{$jobDetails->first()->jobTitles}}" readonly="readonly" >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Candidate Name <span class="text-danger">*</span></label>
                                                <div class="">

                                                    <input class="form-control" type="text" name="candidateName" value="{{$userProfile->first()->fname}} {{$userProfile->first()->lname}}" required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Test Date <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input class="form-control " type="date" name="date" required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Test Time <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input class="form-control " type="time" name="time" required="required">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label>Test Conductors<span class="text-danger">*</span></label>
                                                <select name="testConductors[]" required="required" class="select" multiple="multiple">
                                                    <option value=""> {{'Select Test Conductors'}}</option>
                                                    @foreach($allActiveUsers as $allActiveUser)
                                                        <option value="{{$allActiveUser->id}}"> {{$allActiveUser->display_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label>Email Text for Candidate<span class="text-danger">*</span></label>
                                                <textarea class="summernote" name="candidateEmailText">Dear {{$userProfile->first()->fname}} {{$userProfile->first()->lname}} <br>Your Test Time:<br>Thank You</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Email Text for Test Conductors</label>
                                                <textarea class="summernote" name="conductorEmailText"></textarea>
                                            </div>

                                            <input type="hidden" name="userID" value="{{$userProfile->first()->userID}}" >
                                            <input type="hidden" name="candidateID" value="{{$candidateID}}" >
                                            <input type="hidden" name="jobID" value="{{$jobDetails->first()->id}}" >



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
