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
                        <h3 class="page-title">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->


{{--            <form method="POST" action="{{ route('jobApplicantsSearch') }}">--}}
{{--                @csrf--}}
{{--                <div class="row filter-row">--}}
{{--                    <div class="col-sm-8">--}}
{{--                        <div class="form-group form-focus">--}}
{{--                            <div class="form-group">--}}
{{--                                <select class="form-control" name="jobID" required="required">--}}
{{--                                    <option></option>--}}
{{--                                    @foreach($JobLists as $JobList)--}}
{{--                                        <option value="{{$JobList->jobID}}">{{$JobList->jobTitle}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}

{{--                            </div>--}}
{{--                            <label class="focus-label">Select Job</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-sm-4">--}}
{{--                        <button class="btn btn-success btn-block ">Get Applicant</button>--}}


{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}


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
                                <th>Candidate Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Round</th>
                                <th>Interviewer</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($approvalCheck == 0)
                            @foreach($candidateLists as $index=>$candidateList)

                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$candidateList->desTitle}}</td>
                                    <td>
                                        <h2 class="user-name m-t-10 mb-0 text-ellipsis">
                                            <a href="{{ url('candidateProfile') }}/{{$candidateList->userID}}/{{$candidateList->jobID}}"
                                               target="_blank">{{$candidateList->fname}} {{$candidateList->lname}}</a>
                                        </h2>
                                    </td>
                                    <td>{{$candidateList->date}}</td>
                                    <td>{{$candidateList->time}}</td>
                                    <td>{{$candidateList->interviewRound}}</td>
                                    <td>{{$candidateList->Fname}} {{$candidateList->Lname}}</td>

                                    <td class="text-right">
                                        <div class="dropdown action-label">
                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#"
                                               data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-dot-circle-o text-success"></i> Select Action
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">

                                                <a class="dropdown-item"
                                                   href="{{route('hiringDecision') }}/{{$candidateList->userID}}/{{$candidateList->candidateID}}/{{$candidateList->jobID}}/{{'Shortlist By CEO'}}"><i
                                                        class="fa fa-dot-circle-o text-success"></i> Appointed</a>
                                                <a class="dropdown-item"
                                                   href="{{route('hiringDecision') }}/{{$candidateList->userID}}/{{$candidateList->candidateID}}/{{$candidateList->jobID}}/{{'reject'}}"><i
                                                        class="fa fa-dot-circle-o text-danger"></i> Rejected</a>
                                                <a class="dropdown-item"
                                                   href="{{route('hiringDecision') }}/{{$candidateList->userID}}/{{$candidateList->candidateID}}/{{$candidateList->jobID}}/{{'reject'}}"><i
                                                        class="fa fa-dot-circle-o text-info"></i> Hold</a>

                                            </div>
                                        </div>
                                        {{--
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">

                                                <a class="dropdown-item" href="{{route('scheduleInterview') }}/{{$candidateList->userID}}/{{$candidateList->candidateID}}/{{$candidateList->jobID}}"><i class="fa fa-clock-o m-r-5"></i> Schedule Interview</a>


                                            </div>
                                        </div>--}}
                                    </td>
                                </tr>
                            @endforeach
                            @endif

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
