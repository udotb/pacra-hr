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
                            <h5 class="modal-title">Add Job Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if(!isset($jobTitles))
                                <form method="POST" action="{{ route('addJobTitles') }}" class="needs-validation"
                                      novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        <select class="form-control" name="job_title" required="required">
                                            <option value="">Select Designation</option>
                                            @foreach($getDesignations as $getDesignation)
                                                <option
                                                        value="{{$getDesignation->id}}">{{$getDesignation->title}}</option>
                                            @endforeach


                                        </select>


                                        <label>Description <span class="text-danger">*</span></label>
                                        <textarea class="summernote" name="description" required="required"></textarea>

                                        <label>Requirements <span class="text-danger">*</span></label>
                                        <textarea class="summernote" name="requirements" required></textarea>

                                        <label>What we expect from you <span class="text-danger">*</span></label>
                                        <textarea class="summernote" name="jobExpectations" required></textarea>

                                        {{--                                        <label>What you have got </label>--}}
                                        {{--                                        <textarea class="summernote" name="jobBenefits"></textarea>--}}

                                        <label>Salary Bracket<span class="text-danger">*</span></label>
                                        {{--                                        <input class="form-control" name="salary" type="text">--}}
                                        <select class="form-control" name="salary" required="required">
                                            <option value="">Select Salary Range</option>
                                            <option value="35000 - 50000">35000 - 50000</option>
                                            <option value="50000 - 70000">50000 - 70000</option>
                                            <option value="70000 - 90000">70000 - 90000</option>
                                            <option value="90000 - 150000">90000 - 150000</option>
                                            <option value="150000 - 225000">150000 - 225000</option>
                                        </select>


                                    </div>

                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="entered"> Submit
                                        </button>
                                    </div>
                                </form>
                            @else
                                <form method="POST" action="{{ route('addJobTitles') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="{{$jobTitles->first()->id}}">
                                        <label>Job Title <span class="text-danger">*</span></label>
                                        <select class="form-control" name="job_title" required="required">
                                            <option
                                                    value="{{$jobTitles->first()->title}}">{{$jobTitles->first()->jobTitle}}</option>

                                            <option value="">Select Job Title</option>
                                            @foreach($getDesignations as $getDesignation)
                                                <option
                                                        value="{{$getDesignation->id}}">{{$getDesignation->title}}</option>
                                            @endforeach
                                        </select>

                                        <label>Description <span class="text-danger">*</span></label>
                                        <textarea class="summernote"
                                                  name="description">{{$jobTitles->first()->description}}</textarea>

                                        <label>Requirements <span class="text-danger">*</span></label>
                                        <textarea class="summernote"
                                                  name="requirements">{{$jobTitles->first()->requirements}}</textarea>

                                        <label>What we expect from you <span class="text-danger">*</span></label>
                                        <textarea class="summernote"
                                                  name="jobExpectations">{{$jobTitles->first()->jobExpectations}}</textarea>

                                        {{--                                        <label>What you have got </label>--}}
                                        {{--                                        <textarea class="summernote"--}}
                                        {{--                                                  name="jobBenefits">{{$jobTitles->first()->jobBenefits}}</textarea>--}}

                                        <label>Salary Bracket<span class="text-danger">*</span></label>
                                        <select class="form-control" name="salary" required="required">
                                            <option
                                                    value="{{$jobTitles->first()->salary}}">{{$jobTitles->first()->salary}}</option>
                                            <option value="">Select Salary Range</option>
                                            <option
                                                    value="{{$jobTitles->first()->salary ?? ''}}">{{$jobTitles->first()->salary ?? ''}}</option>
                                            <option value="35000 - 50000">35000 - 50000</option>
                                            <option value="50000 - 70000">50000 - 70000</option>
                                            <option value="70000 - 90000">70000 - 90000</option>
                                            <option value="90000 - 150000">90000 - 150000</option>
                                            <option value="150000 - 225000">150000 - 225000</option>
                                        </select>


                                    </div>

                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="update">Update
                                        </button>
                                    </div>
                                </form>
                            @endif
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
