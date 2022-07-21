@extends('layout.mainlayout')
@section('content')
<!-- Page Wrapper -->
@include('layout.partials.modal_function')

<div class="page-wrapper">
			
            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Department</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                                <li class="breadcrumb-item active">Department</li>
                            </ul>
                        </div>
                        @if(in_array('10', $user_rights) )
                            <div class="col-auto float-right ml-auto">
                                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i> Add Department</a>
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
                
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">#</th>
                                        <th>Department Name</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($getDepartments as $index => $dept)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>
                                            <a class="openEditModel dropdown-item " href="#" data-toggle="modal" data-target="#list_employees_{{$dept->id}}" >{{$dept->title}}</a>

                                            </td>
                                        <td>@if($dept->status == 'Entered')

                                                {{$dept->status}}
                                            @else
                                                {{''}}
                                            @endif</td>
                                        <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
{{--
                                                <a class="openEditModel dropdown-item " href="#" data-toggle="modal" data-target="#edit_department" data-id={{$dept->id}}><i class="fa fa-pencil m-r-5"></i> Edit</a>
--}}

                                                <a class="openEditModel dropdown-item " href="#" data-toggle="modal" data-target="#edit_department" data-todo='{"id":{{$dept->id}},"todo":"{{$dept->title}}"}'><i class="fa fa-pencil m-r-5"></i> Edit</a>
{{--
                                                <a class="dropdown-item " href="#" data-toggle="modal" data-target="#delete_department" data-id={{$dept->id}}><i class="fa fa-trash-o m-r-5"></i> Delete</a>
--}}
                                            </div>
                                            </div>

                                        </td>
                                    </tr>

                                    <!-- List Of employees -->
                                    <div class="modal custom-modal fade" id="list_employees_{{$dept->id}}" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="form-header">
                                                        <h3>Employees</h3>
                                                    </div>
                                                    <div class="modal-btn delete-action">
                                                        @foreach($employees->where('department',$dept->id ) as $index => $emp )
                                                        <div class="row">

                                                            <h5 class="table-avatar">
                                                                <a href="{{ url('profile') }}/{{$emp->id}}" class="avatar" target="_blank"><img alt="" src="users/{{$emp->avatar_file}}"></a>
                                                                <a href="{{ url('profile') }}/{{$emp->id}}" target="_blank">{{$emp->display_name}} <span>{{$emp->designation}}</span></a>
                                                            </h5>
{{--
                                                            <a href="{{ url('profile') }}/{{$emp->id}}" target="_blank">{{$emp->display_name}}</a>
--}}

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
            
            <!-- Add Department Modal -->
            <div id="add_department" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Department</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('create_departments') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Department Name <span class="text-danger">*</span></label>
                                    <input class="form-control" name="dpt_name" type="text">
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add Department Modal -->
            
            <!-- Edit Department Modal -->
            <div id="edit_department" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Department</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('update_departments') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Department Name <span class="text-danger">*</span></label>

                                    <input class="form-control" name="dpt_name" id="editDataHolder"  type="text" value="">

                                    <input type="hidden" name="dpt_id" id="editIdHolder" value="" />




                                </div>
                                <div class="submit-section">
                                    @if($userId == 10 )
                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Approved"> Approve</button>
                                    @else
                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Save</button>

                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Edit Department Modal -->

            <!-- Delete Department Modal -->
            <div class="modal custom-modal fade" id="delete_department" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-header">
                                <h3>Delete Department</h3>
                                <p>Are you sure want to delete?</p>
                            </div>
                            <div class="modal-btn delete-action">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Delete Department Modal -->
            
        </div>
        <!-- /Page Wrapper -->





@endsection

