@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Rejected Applicants</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Job Applicants</li>
                        </ul>
                    </div>
                </div>
            </div>
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
                                <th class="text-center">Status</th>
                                <th>Resume</th>
                                <th class="text-right">Rejection Reason</th>
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
                                    <td class="truncate"
                                        title="{{ str_replace($spam, ' ', $jobAppliedList->title)}}">{{ str_replace($spam, ' ', $jobAppliedList->title) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
