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

                <div class="row">
                    <div class="col-md-12">

                        <!-- Add Leave Modal -->

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Add Policy</h3>
                                    </div>
                                    <div class="modal-body">
                                        @if(!isset($leave))
                                        <form method="POST" action="{{ route('add_policy') }}" enctype="multipart/form-data" files="true">
                                            @csrf

                                            <div class="form-group">
                                                <label>Policy Name <span class="text-danger">*</span></label>
                                                <input class="form-control" name="name" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label>Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="description" rows="2"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Upload Policy <span class="text-danger">*</span></label>
                                                <div class="custom-file">
                                                    <input type="file" name="file" class="custom-file-input" id="policy_upload">
                                                    <label class="custom-file-label" for="policy_upload">Choose file</label>
                                                </div>
                                            </div>


                                            <div class="submit-section">
                                                <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Submit</button>
                                            </div>

                                        </form>
                                            @else
                                            <form method="POST" action="{{ route('add_policy') }}" enctype="multipart/form-data" files="true">
                                                @csrf

                                                <div class="form-group">
                                                    <label>Policy Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                                <div class="form-group">
                                                    <label>Description <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" rows="4"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Department</label>
                                                    <select class="select">
                                                        <option>All Departments</option>
                                                        <option>Web Development</option>
                                                        <option>Marketing</option>
                                                        <option>IT Management</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Upload Policy <span class="text-danger">*</span></label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="policy_upload">
                                                        <label class="custom-file-label" for="policy_upload">Choose file</label>
                                                    </div>
                                                </div>


                                                <div class="submit-section">
                                                    <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Submit</button>
                                                    @if(in_array('10', $user_rights) )
                                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Approved"> Approve</button>

                                                    @endif

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