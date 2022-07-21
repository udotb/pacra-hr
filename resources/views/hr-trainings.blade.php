@extends('layout.mainlayout')
@section('content')
    <title>
        HR Trainings
    </title>
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">{{!empty($meta_title) ? $meta_title: 'HR Trainings'}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{!empty($meta_title) ? $meta_title: 'HR Trainings'}}
                            </li>
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
                            <h3 class="modal-title">HR Trainings</h3>
                            <a type="button" target="_blank" style="display: flex; float: right"
                               class="btn-outline-success btn"
                               href="https://209.97.168.200/pacrawizpackv3/public/admin/trainingsconductedform">View Data</a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('storeHrTrainings') }}" enctype="multipart/form-data"
                                  files="true">
                                @csrf
                                <div class="form-group">
                                    {{--                                    <input type="hidden" , name="uid" value="{{$userId}}">--}}
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" id="date" name="date"
                                           max="{{\Carbon\Carbon::now()->format('Y-m-d')}}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Title Of Training Course <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input class="form-control"
                                               placeholder="Enter Title" name="title" required=""/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Duration (hours) <span class="text-danger">*</span></label>
                                    <input type="number" placeholder="Enter Duration" name="duration"
                                           class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>No. Of Officials Attended (Cadre-Wise) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" placeholder="Enter No. Of Attendees" name="attendees"
                                           class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Broad Areas Covered <span
                                            class="text-danger">*</span></label>
                                    <input type="text" placeholder="Enter Area Covered" name="areas"
                                           class="form-control">
                                </div>


                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn btn-success" name="submit" type="submit"
                                            value="Entered"> Submit
                                    </button>
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
