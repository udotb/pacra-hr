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
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">

                    <!-- Add Leave Modal -->

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Job Title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if(!isset($hiringRequests))
                                <form method="POST" action="{{ route('addHiringRequest') }}" class="needs-validation"
                                      novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label>Job Description <span class="text-danger">*</span></label>
                                        <select class="form-control" name="job_title" onchange="fetchData(this)"
                                                required="required">
                                            <option value="">Select Job Description</option>
                                            @foreach($jobTitles as $jobTitle)
                                                <option value="{{$jobTitle->id}}">{{$jobTitle->jobTitle}}</option>
                                            @endforeach
                                        </select>


                                        <label>
                                            Description
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="description" class="summernote" name="description">
                                        </textarea>
                                        <label>
                                            Requirements
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="requirement" class="summernote" name="requirements">
                                        </textarea>
                                        <label>
                                            What we expect from you
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="expectation" class="summernote" name="jobExpectations">
                                        </textarea>
                                        {{--                                        <label>--}}
                                        {{--                                            What you have got--}}
                                        {{--                                            <span class="text-danger">*</span>--}}
                                        {{--                                        </label>--}}
                                        {{--                                        <textarea id="benefits" class="summernote" name="jobBenefits">--}}
                                        </textarea>
                                        <label>
                                            Number of Vacancy
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" name="vacancy" type="number" min="1"
                                               required="required">
                                    </div>

                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="entered">
                                            Submit
                                        </button>
                                    </div>
                                </form>

                            @else

                                <form method="POST" action="{{ route('addHiringRequest') }}">
                                    @csrf
                                    <input type="hidden" name="recordID" value="{{$hiringRequests->first()->id}}">
                                    <div class="form-group">

                                        <label>
                                            Job Description
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" name="job_title" onchange="fetchData(this)"
                                                required="required">
                                            <option
                                                value="{{$hiringRequests->first()->title}}">{{$hiringRequests->first()->jobTitles}}</option>
                                        </select>
                                        <label>Description
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="description" class="summernote" name="description">{{$hiringRequests->first()->description}}
                                            </textarea>
                                        <label>Requirements
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="requirement" class="summernote" name="requirements">{{$hiringRequests->first()->requirements}}
                                            </textarea>
                                        <label>
                                            What we expect from you
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="expectation" class="summernote" name="jobExpectations">
                                                {{$hiringRequests->first()->jobExpectations}}
                                            </textarea>
                                        {{--                                            <label>What you have got--}}
                                        {{--                                                <span class="text-danger">*</span></label>--}}
                                        {{--                                            <textarea id="benefits" class="summernote" name="jobBenefits">{{$hiringRequests->first()->jobBenefits}}--}}
                                        </textarea>
                                        <label>Number of Vacancy
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" name="vacancy"
                                               value="{{$hiringRequests->first()->vacancies}}" type="int"
                                               required="required">
                                    </div>
                                    @if($hiringRequests->first()->status != 'authenticate')
                                        <div class="submit-section">
                                            @if($hiringRequests->first()->amID == $userId && $hiringRequests->first()->status != 'recommended')
                                                <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                        type="submit" value="recommended">Recommended
                                                </button>
                                                <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                        type="submit" value="decline"> Decline
                                                </button>
                                            @elseif($hiringRequests->first()->status == 'recommended')
                                                <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                        type="submit" value="recommended">Update
                                                </button>
                                            @else
                                                <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                        type="submit" value="entered"> Submit
                                                </button>
                                            @endif
                                        </div>
                                    @endif
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

    <script>

        function fetchData(el) {
            var id = el.value;
            console.log(id);
            var html = '';
            $.ajax({
                url: '{{url('hiringRequestFormDetails')}}/' + id,
                type: "GET",
                success: function (data) {
                    console.log(data);
                    $('#description').summernote('code', data.data.description);
                    $('#requirement').summernote('code', data.data.requirements);
                    $('#expectation').summernote('code', data.data.jobExpectations);
                    $('#benefits').summernote('code', data.data.jobBenefits);
                    $('#salary').summernote('code', data.data.salary);
                }
            });


        }
    </script>
@endsection

