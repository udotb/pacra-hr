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
                            <form method="POST" action="{{ route('addScheduleInterview') }}"
                                  enctype="multipart/form-data" files="true">
                                @csrf

                                <div class="form-group">
                                    <label>Job Title<span class="text-danger">*</span></label>
                                    <div class="">

                                        <input class="form-control" type="text" name="jobTitle"
                                               value="{{$jobDetails->first()->jobTitles}}" readonly="readonly">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Candidate Name <span class="text-danger">*</span></label>
                                    <div class="">

                                        <input class="form-control" type="text" name="candidateName"
                                               value="{{$userProfile->first()->fname}} {{$userProfile->first()->lname}}"
                                               required="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Interview Round<span class="text-danger">*</span></label>
                                    <select name="interviewRound" id="interviewRound" required="required"
                                            class="select">
                                        <option value=""> {{'Select Interview Round'}}</option>
                                        <option value="HR/TL"> HR / Team Lead</option>
                                        <option value="Vertical Chief"> Vertical Chief</option>
                                        <option value="CEO/Final"> CEO / Final</option>
                                    </select>
                                </div>

                                <div class="form-group" id="HRTL" style="display: none">
                                    <label>Upload Test</label>
                                    <input type="file" name="candidatesTest" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid file of
                                        scanned test.</small>

                                    <label>Marks Obtained </label>
                                    <input type="number" class="form-control" name="marks">

                                    <label>Upload Miscellaneous Document </label>
                                    <input type="file" name="miscellaneousDoc" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid
                                        file.</small>
                                </div>

                                <div class="form-group" id="UH" style="display: none">
                                    <label>Upload Interview Sheet HR <span class="text-danger">*</span></label>
                                    <input type="file" name="interviewSheetHR" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid file of
                                        scanned HR Interview Sheet for UH.</small>

                                    <label>Upload Interview Sheet TL <span class="text-danger">*</span></label>
                                    <input type="file" name="interviewSheetTL" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid file of
                                        scanned TL Interview Sheet for UH.</small>
                                </div>

                                <div class="form-group" id="CEO" style="display: none">
                                    <label>Upload Interview Sheet UH <span class="text-danger">*</span></label>
                                    <input type="file" name="interviewSheetUH" id="file">
                                    <small id="fileHelp" class="form-text text-muted">Please Upload valid file of
                                        scanned UH Interview Sheet for CEO.</small>
                                </div>

                                <div class="form-group">
                                    <label>Interview Date <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input class="form-control " type="date" name="date" required="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Interview Time <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input class="form-control " type="time" name="time" required="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Interview Location<span class="text-danger">*</span></label>
                                    <select name="interviewLocation" required="required" class="select">
                                        <option value=""> {{'Select Interview Location'}}</option>
                                        <option value="Online"> Online</option>
                                        <option value="Head Office"> Head Office</option>

                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Interviewers<span class="text-danger">*</span></label>
                                    <select name="interviewers[]" required="required" class="select"
                                            multiple="multiple">
                                        <option value=""> {{'Select Interviewers'}}</option>
                                        @foreach($allActiveUsers as $allActiveUser)
                                            <option
                                                value="{{$allActiveUser->id}}"> {{$allActiveUser->display_name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Email Text for Candidate</label>
                                    <textarea class="summernote"
                                              name="candidateEmailText">Dear {{$userProfile->first()->fname}} {{$userProfile->first()->lname}} <br>Your Test Time:<br>Thank You</textarea>

                                </div>

                                <div class="form-group">
                                    <label>Email Text for Interviewers</label>
                                    <textarea class="summernote" name="conductorEmailText"></textarea>

                                </div>

                                <input type="hidden" name="userID" value="{{$userProfile->first()->userID}}">
                                <input type="hidden" name="candidateID" value="{{$candidateID}}">
                                <input type="hidden" name="jobID" value="{{$jobDetails->first()->id}}">


                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn btn-success" name="submit" type="submit"
                                            value="Entered"> Submit
                                    </button>
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
