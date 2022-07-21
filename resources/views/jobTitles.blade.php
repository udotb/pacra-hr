@extends('layout.mainlayout')
@section('content')
    @include('layout.partials.modal_function'))
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
                    @if(in_array('10', $user_rights) )
                        <div class="col-auto float-right ml-auto">
                            <a href="{{ route('jobTitlesForm') }}" class="btn add-btn" target="_blank"><i
                                    class="fa fa-plus"></i> Add Job Description</a>
                        </div>
                    @endif

                </div>
            </div>
            <!-- /Page Header -->
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif


            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable"
                               id="data_table">
                            <thead>
                            <tr>
                                <th style="width: 30px;">#</th>
                                <th>Title</th>

                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            {{--{{nl2br($jobTitles->first()->description)}}
                            {{ nl2br(strip_tags(htmlspecialchars($jobTitles->first()->description))) }}
                            {{ strip_tags($jobTitles->first()->description, '&nbsp;') }}--}}

                            {{--{!! $jobTitles->first()->jobBenefits !!}--}}

                            @foreach($jobTitles as $index => $jobTitle)
                                <tr>

                                    <td>{{$index+1}}</td>
                                    <td>
                                        <a class="openEditModel dropdown-item " href="#" data-toggle="modal"
                                           data-target="#jobDetails{{$jobTitle->id}}">{{$jobTitle->jobTitle}}</a>

                                    </td>

                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                               aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="openEditModel dropdown-item"
                                                   href="{{ route('jobTitlesForm') }}/{{!empty($jobTitle->id) ? $jobTitle->id: ''}}"
                                                   target="_blank"><i class="fa fa-pencil m-r-5"></i> Edit / Approve</a>

{{--                                                <a class="dropdown-item"--}}
{{--                                                   href="{{url('jobTitles/delete', $jobTitle->id ?? '')}}"--}}
{{--                                                    --}}{{--                                                    data-toggle="modal" data-target="#delete_designation"--}}
{{--                                                ><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}

                                            </div>
                                        </div>
                                    </td>
                                </tr>


                                <!-- List Of employees -->
                                <div class="modal custom-modal fade" id="jobDetails{{$jobTitle->id}}" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="form-header">
                                                    <h3>{{$jobTitle->jobTitle}}</h3>
                                                </div>
                                                <div class="modal-btn delete-action">
                                                    @foreach($jobTitles->where('id',$jobTitle->id ) as $index => $desc )


                                                        <div class="form-group">
{{--                                                            <h3>Job Title</h3>--}}
{{--                                                            <p>{{$desc->jobTitle}}</p>--}}

                                                            <h3>Description</h3>
                                                            {!! $desc->description !!}

                                                            <h3>Requirements</h3>
                                                            {!! $desc->requirements !!}

                                                            <h3>What we expect from you</h3>
                                                            {!! $desc->jobExpectations !!}

{{--                                                            <h3>What you have got</h3>--}}
{{--                                                            {!! $desc->jobBenefits !!}--}}

                                                            <h3>Salary Bracket</h3>
                                                            <p>{{$desc->salary}}</p>


                                                        </div>





                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / List Of employees -->


                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Designation Modal -->
        <div id="add_designation" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Job Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('addJobTitles') }}">
                            @csrf
                            <div class="form-group">
                                <label>Job Title <span class="text-danger">*</span></label>
                                <input class="form-control" name="job_title" type="text">

                                <label>Description <span class="text-danger">*</span></label>
                                <textarea class="summernote" name="description"></textarea>

                                <label>Requirements <span class="text-danger">*</span></label>
                                <textarea class="summernote" name="requirements"></textarea>

                                <label>What we expect from you <span class="text-danger">*</span></label>
                                <textarea class="summernote" name="jobExpectations"></textarea>

{{--                                <label>What you have got <span class="text-danger">*</span></label>--}}
{{--                                <textarea class="summernote" name="jobBenefits"></textarea>--}}

                                <label>Salary Bracket<span class="text-danger">*</span></label>
                                <input class="form-control" name="salary" type="text">


                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Designation Modal -->

        <!-- Edit Designation Modal -->
        <div id="edit_designation" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Designation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('update_designations') }}">
                            @csrf
                            <div class="form-group">
                                <label>Designation Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="desg_name" id="editDataHolder" type="text" value="">

                                <input type="hidden" name="desg_id" id="editIdHolder" value=""/>
                            </div>

                            <div class="submit-section">
                                @if($userId == 10 )
                                    <button class="btn btn-primary submit-btn btn-success" name="submit" type="submit"
                                            value="Approved"> Approve
                                    </button>
                                @else
                                    <button class="btn btn-primary submit-btn btn-success" name="submit" type="submit"
                                            value="Entered"> Save
                                    </button>

                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Designation Modal -->

        <!-- Delete Designation Modal -->
        <div class="modal custom-modal fade" id="delete_designation" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Designation</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{url('jobTitles/delete', $jobTitle->id ?? '')}}"
                                       class="btn btn-primary continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal"
                                       class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Designation Modal -->

    </div>
    <!-- /Page Wrapper -->
@endsection
