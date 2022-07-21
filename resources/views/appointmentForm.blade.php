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
                    <div class="col-md-12">
                        <div class="card mb-0">
                            <div class="card-header">
                                <h4 class="card-title mb-0">{{!empty($meta_title) ? $meta_title: 'PACRA'}}</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('addAppointmentForm') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            {{-- <h4 class="card-title">Personal Details</h4> --}}



                                            
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Refrence:<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="refrence" value="P/HR/L/" class="form-control">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Date:<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="date" name="date"  class="form-control">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Employee No:<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="candidateEmpNo" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Grade<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <select name="candidategrade" class="form-control">
                                                        <option value="">Select HR Policy Grade</option>
                                                        @foreach ($allGrades as $allGrades)
                                                        <option value="{{$allGrades->id}}">{{$allGrades->name}}</option>
                                                        @endforeach
                                                      </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Name<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="candidateName" value="{{$getCandidateName->first()->fname}} {{ $getCandidateName->first()->lname}}" class="form-control" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Email<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="candidateEmail" value="{{$getCandidateName->first()->email}}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Phone<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="candidatePhone" value="{{$getCandidateName->first()->contactNumber}}" class="form-control" readonly>
                                                </div>
                                            </div>


                                        </div>


                                        <div class="col-xl-6">
                                            <h4 class="card-title">During Probation</h4>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Basic Salary<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="probBasicSalary" class="form-control">
                                                </div>
                                            </div>
                                            

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">EOBI Employer’s Contribution<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="probEOBIEmployer" value="630" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">EOBI Employee Contribution<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="probEOBIEmployee" value="130" class="form-control">
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="col-xl-6">
                                            <h4 class="card-title">On Confirmation</h4>
                                            
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Basic Salary<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="confirmationSalary" class="form-control">
                                                </div>
                                            </div>
                                            

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">EOBI Employer’s Contribution<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="confirmationEOBIEmployer" value="630" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">EOBI Employee Contribution<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="confirmationEOBIEmployee" value="130" class="form-control">
                                                </div>
                                            </div>
                                           
                                           
                                        </div>
                                    </div>
                                    <input type="hidden" name="userID" value="{{$userID}}">
                                    <input type="hidden" name="candidateID" value="{{$candidateID}}">
                                    <input type="hidden" name="jobID" value="{{$jobID}}">

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>			
        </div>
@endsection