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

                        <!-- Add Leave Modal -->

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Add Final Joining Date of {{$candidateLists->fname.' '.$candidateLists->lname  }}</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('addfinalSalaryForm') }}" enctype="multipart/form-data" files="true">
                                            @csrf
                                            <div class="row">
                                                <div class="col-xl-12">


                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Date of Joining<span class="text-danger">*</span></label>
                                                        <div class="col-lg-9">
                                                            <input type="date" name="doj" value="{{$candidateLists->doj}}" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-xl-6">
                                                    <h4 class="card-title">During Probation</h4>

                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Basic Salary(Minimum)<span class="text-danger">*</span></label>
                                                        <div class="col-lg-9">
                                                            <input type="number" name="probBasicSalaryMin" value="{{$candidateLists->probBasicSalaryMin}}" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Basic Salary(Maximum)<span class="text-danger">*</span></label>
                                                        <div class="col-lg-9">
                                                            <input type="number" name="probBasicSalary" value="{{$candidateLists->probBasicSalary}}" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-xl-6">
                                                    <h4 class="card-title">On Confirmation</h4>

                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Basic Salary(Minimum)<span class="text-danger">*</span></label>
                                                        <div class="col-lg-9">
                                                            <input type="number" name="confirmationSalaryMin" value="{{$candidateLists->confirmationSalaryMin}}" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Basic Salary(Maximum)<span class="text-danger">*</span></label>
                                                        <div class="col-lg-9">
                                                            <input type="number" name="confirmationSalary" value="{{$candidateLists->confirmationSalary}}" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <input type="hidden" name="userID" value="{{$candidateLists->userID}}">
                                            <input type="hidden" name="candidateID" value="{{$candidateLists->candidateID}}">
                                            <input type="hidden" name="jobID" value="{{$candidateLists->jobID}}">

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
