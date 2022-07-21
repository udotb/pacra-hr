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
                        <h3 class="page-title">Job Applicants</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Job Applicants</li>
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
                                            <a href="{{ url('candidateProfile') }}/{{$jobAppliedList->userID}}/{{$jobAppliedList->jobID}}"
                                               target="_blank">{{$jobAppliedList->fname}} {{$jobAppliedList->lname}}</a>
                                        </h2></td>
                                    <td>{{$jobAppliedList->applyDate}}</td>
                                    <td>{{$jobAppliedList->pfname}} {{$jobAppliedList->plname}}</td>
                                    <td class="text-center">
                                        <div class="dropdown action-label">
                                            <a class="dropdown-item" href="#"><i
                                                        class="fa fa-dot-circle-o text-info"></i> {{$jobAppliedList->candidateStatus}}
                                            </a>
                                        </div>
                                    </td>
                                    <td><a href="https://209.97.168.200/pacra-job-portal/public/{{$jobAppliedList->cv}}"
                                           class="btn btn-sm btn-primary" download><i class="fa fa-download"></i>
                                            Download</a></td>
                                    <td class="text-center">
                                        <div class="dropdown action-label">
                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#"
                                               data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-dot-circle-o text-success"></i> Select Action
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                   href="{{route('addInitialShortlist') }}/{{$jobAppliedList->userID}}/{{$jobAppliedList->candidateID}}/{{$jobAppliedList->jobID}}/{{'Shortlist'}}"><i
                                                            class="fa fa-dot-circle-o text-success"></i> Shortlist</a>
                                                <a class="dropdown-item"
                                                   href="{{route('addInitialShortlist') }}/{{$jobAppliedList->userID}}/{{$jobAppliedList->candidateID}}/{{$jobAppliedList->jobID}}/{{'Hold'}}"><i
                                                            class="fa fa-dot-circle-o text-purple"></i> Hold</a>
                                                <a class="dropdown-item"
                                                   href="{{ '#modalLong' . $jobAppliedList->candidateID }}"
                                                   data-toggle="modal"><i class="fa fa-dot-circle-o text-danger"></i>Rejected</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                {{--                                <div id="{{ 'modalLong' . $jobAppliedList->candidateID }}" class="modal custom-modal fade"--}}
                                <div class="modal custom-modal fade" id={{ 'modalLong' . $jobAppliedList->candidateID }}
                                        role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Please Enter Rejection Comments</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="user" method="POST"
                                                      action="{{ url('rejectApplicants/'.$jobAppliedList->candidateID) }}"
                                                      enctype="multipart/form-data" files="true">
                                                    @csrf
                                                    <input value="{{$jobAppliedList->candidateID}}" name="recID"
                                                           type="hidden">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <select class="form-control"
                                                                        name="rejection_comment"
                                                                        placeholder="Select Rejection Comment">
                                                                    @foreach ($rejectionReasons as $rejectionReason)
                                                                        <option
                                                                                value="{{ $rejectionReason->id }}">{{ $rejectionReason->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="submit-section">
                                                        <button class="btn btn-primary submit-btn btn-sm"
                                                                name="Rejected"
                                                                type="submit" value="Rejected">
                                                            Submit
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
