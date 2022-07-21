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
                    <div class="modal-content">

                        @if(in_array('26', $userRights))
                        <!-- Employee Separation Form | Accounts  Section 7-->
                            <div class="card">
                                <div class="card-header">
                                    <h1 class="card-title mb-0">EMPLOYEE SEPARATION FORM</h1>
                                    <p class="card-text">Please respond to all statements, ‘✔’ if applicable / affirmative and ‘❌’ if not applicable / negative.</p>
                                </div>

                                <div class="card-header">
                                    <h4>Section - 6	| Final Approval | To be approved by the Chief Executive Officer </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm">


                                            <form method="POST" action="{{ route('addSeparation') }}">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="validationDefault01">Name</label>
                                                        <input type="text" class="form-control" name="empName" value="{{$seprationDetails->first()->display_name}}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="validationDefault02">Designation</label>
                                                        <input type="text" class="form-control" name="empDesignation" value="{{$seprationDetails->first()->designation}}" readonly>
                                                    </div>

                                                </div>
                                                <div class="form-row">

                                                    <div class="col-md-12 mb-3">
                                                        <label for="validationDefault02">Comments (if any):</label>
                                                        <textarea  class="form-control" name="comments"></textarea>
                                                    </div>

                                                </div>
                                                <div class="form-row">

                                                    <input type="hidden" name="regisID" value="{{$resignation->first()->id}}">

                                                    <input type="hidden" name="userID" value="{{$userId}}">
                                                    <input type="hidden" name="DesigID" value="{{$seprationDetails->first()->designation_id}}">

                                                </div>

                                                <button class="btn btn-primary" type="submit" name="submit" value="ceo_submit">Submit form</button>
                                            </form>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endif







                    </div>

                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- /Page Wrapper -->




@endsection