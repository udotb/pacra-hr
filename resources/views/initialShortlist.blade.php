@extends('layout.mainlayout')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Shortlisted Applicants</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                                <li class="breadcrumb-item active">Shortlisted Applicants</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Search Filter -->


                {{-- <form method="POST" action="{{ route('jobApplicantsSearch') }}">
                    @csrf
                    <div class="row filter-row">
                        <div class="col-sm-8">
                            <div class="form-group form-focus">
                                <div class="form-group">
                                    <select class="form-control" name="jobID" required="required">
                                        <option ></option>
                                        @foreach($JobLists as $JobList)
                                        <option value="{{$JobList->jobID}}">{{$JobList->jobTitle}}</option>
                                            @endforeach
                                    </select>

                                </div>
                                <label class="focus-label">Select Job</label>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <button class="btn btn-success btn-block ">Get Applicant</button>


                        </div>
                    </div>
                </form> --}}


                <!-- /Search Filter -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable"
                                   id="data_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Job Title</th>
                                        <th>Applicant Name</th>
                                        <th>Apply Date</th>
                                        <th>Requested By</th>
                                        <th class="text-center">Status</th>
                                        <th>Resume</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($jobAppliedLists as $index=>$jobAppliedList)

                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$jobAppliedList->jobTitlesTable}}</td>
                                        <td><h2 class="user-name m-t-10 mb-0 text-ellipsis">
                                            <a href="{{ url('candidateProfile') }}/{{$jobAppliedList->userID}}/{{$jobAppliedList->jobID}}" target="_blank">{{$jobAppliedList->fname}} {{$jobAppliedList->lname}}</a> </h2></td>
                                        <td>{{$jobAppliedList->applyDate}}</td>
                                        <td>{{$jobAppliedList->pfname}} {{$jobAppliedList->plname}}</td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-info"></i> {{$jobAppliedList->candidateStatus}}</a>
                                            </div>
                                        </td>
                                        <td><a href="../../storage/app/{{$jobAppliedList->cv}}" class="btn btn-sm btn-primary" download><i class="fa fa-download"></i> Download</a></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{route('scheduleTest') }}/{{$jobAppliedList->userID}}/{{$jobAppliedList->candidateID}}/{{$jobAppliedList->jobID}}"><i class="fa fa-clock-o m-r-5"></i> Schedule Test</a>
                                                    <a class="dropdown-item" href="{{route('scheduleInterview') }}/{{$jobAppliedList->userID}}/{{$jobAppliedList->candidateID}}/{{$jobAppliedList->jobID}}"><i class="fa fa-clock-o m-r-5"></i> Schedule Interview</a>

                                                </div>
                                            </div>
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
        <!-- /Page Wrapper -->
@endsection
