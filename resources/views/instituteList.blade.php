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
                            <table id="candidateSearch" class="table table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>City</th>
                                        
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($Institute as $index=>$list)

                                    <tr>
                                        <td>{{$index+1}}</td>
                                        
                                        <td>{{$list->title}}</td>
                                        
                                        <td>{{$list->city}}</td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-success"></i> Select Action
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Shortlist</a>
                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-purple"></i> Hold</a>
                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Rejected</a>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        {{-- <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{route('scheduleTest') }}/{{$jobAppliedList->userID}}/{{$jobAppliedList->candidateID}}/{{$jobAppliedList->jobID}}"><i class="fa fa-clock-o m-r-5"></i> Schedule Test</a>

                                                </div>
                                            </div>
                                        </td> --}}
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