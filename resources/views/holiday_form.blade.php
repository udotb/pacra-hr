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
                                        <h3 class="modal-title">Add Holiday</h3>
                                    </div>
                                    <div class="modal-body">
                                        @if(!isset($leave))
                                        <form method="POST" action="{{ route('add_holiday') }}">
                                            @csrf

                                            <div class="form-group">
                                                <label>Holiday Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="holiday_name" required="required">

                                                <input type="hidden" name="recordid" value="">

                                            </div>
                                            <div class="form-group">
                                                <label>Holiday Type <span class="text-danger">*</span></label>
                                                <select class="form-control" name="holiday_type" required="required">
                                                    @foreach($holidays_type as $htype)
                                                        <option value="{{$htype->id}}">{{$htype->title}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="form-group">
                                                <label>Holiday Start Date <span class="text-danger">*</span></label>
                                                <input class="form-control" name="from_date" type="date" required="required">
                                            </div>

                                            <div class="form-group">
                                                <label>Holiday End Date <span class="text-danger">*</span></label>
                                                <input class="form-control" name="to_date" type="date" required="required">
                                            </div>


                                            <div class="submit-section">
                                                <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Submit</button>
                                            </div>

                                        </form>
                                            @else
                                            <form method="POST" action="{{ route('add_holiday') }}">
                                                @csrf
{{--{{dd($leave)}}--}}
                                                <div class="form-group">
                                                    <label>Holiday Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="holiday_name" required="required" value="{{$leave[0]->holiday_name}}">

                                                    <input type="hidden" name="recordid" value="{{$leave[0]->id}}">

                                                </div>
                                                <div class="form-group">
                                                    <label>Holiday Type <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="holiday_type" required="required">
                                                        <option value="{{$leave[0]->holiday_type}}">{{$leave[0]->title}}</option>
                                                        @foreach($holidays_type as $htype)
                                                            <option value="{{$htype->id}}">{{$htype->title}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="form-group">
                                                    <label>Holiday Start Date <span class="text-danger">*</span></label>
                                                    <input class="form-control" name="from_date" type="date" value="{{$leave[0]->from_date}}" required="required">
                                                </div>

                                                <div class="form-group">
                                                    <label>Holiday End Date <span class="text-danger">*</span></label>
                                                    <input class="form-control" name="to_date" type="date" value="{{$leave[0]->to_date}}" required="required">
                                                </div>



                                                <div class="submit-section">
                                                    <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered"> Submit</button>
                                                    @if(\Illuminate\Support\Facades\Auth::id() == 9 )
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
