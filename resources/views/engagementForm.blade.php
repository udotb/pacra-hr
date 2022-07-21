@extends('layout.mainlayout')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
			
            <div class="content container-fluid">
            
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('addEngagementForm') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Reference <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" name="reference" value="Ref: P/HR/" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Department <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <select name="department" id="cars" class="form-control">
                                                <option value="">Select Department</option>
                                                @foreach ($getDepartments as $getDepartment)
                                                <option value="{{$getDepartment->id}}">{{$getDepartment->title}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Position (Nature) <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <select name="department" id="cars" class="form-control">
                                                <option value="">Select Position (Nature)</option>
                                                @foreach ($positionNatures as $positionNature)
                                                <option value="{{$positionNature->id}}">{{$positionNature->title}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Period of Engagement <span class="text-danger">*</span></label>
                                        <div class="col-md-10">

                                            <input type="radio" id="Perpetual" name="engagementPeriodType" value="Perpetual">
                                            <label for="Perpetual">Perpetual</label>

                                            <input type="radio" id="Probation to Perpetual" name="engagementPeriodType" value="Probation to Perpetual">
                                            <label for="Probation to Perpetual">Probation to Perpetual</label>

                                            <input type="radio" id="Period Specific" name="engagementPeriodType" value="Period Specific">
                                            <label for="Period Specific">Period Specific</label>

                                            <input type="radio" id="Probation Duration" name="engagementPeriodType" value="Probation Duration">
                                            <label for="Probation Duration">Probation Duration</label> <br>

                                            <label for="engagementPeriod">Engagement Period</label>
                                            <input type="text" id="engagementPeriod" name="engagementPeriod" class="form-control" placeholder="Please type Engagement Period in case of Period Specific or Probation Duration ">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Name of Candidate <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" name="candidateName" value="{{$getCandidateName->first()->fname}} {{ $getCandidateName->first()->lname}}" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Designation  <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <select name="designation" id="cars" class="form-control">
                                                <option value="">Select Designation</option>
                                                @foreach ($getDesignations as $getDesignation)
                                                <option value="{{$getDesignation->id}}">{{$getDesignation->title}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">HR Policy Grade <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <select name="grade" id="cars" class="form-control">
                                                <option value="">Select HR Policy Grade</option>
                                                @foreach ($allGrades as $allGrades)
                                                <option value="{{$allGrades->id}}">{{$allGrades->name}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Date of Joining <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <input type="date" name="doj"  class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Salary Package (PKR) During Probation <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" name="probSalary"  class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Salary Package (PKR) On Confirmation <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" name="afterProbSalary"  class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Other Benefits <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <textarea id="description" class="summernote" name="benifits">{{$getJobDetails->first()->jobBenefits}}</textarea>
                                        </div>
                                    </div>

                                    <input type="hidden" name="userID" value="{{$userID}}">
                                    <input type="hidden" name="candidateID" value="{{$candidateID}}">
                                    <input type="hidden" name="jobID" value="{{$jobID}}">



                                    <div class="submit-section">
                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            
            </div>			
        </div>
@endsection