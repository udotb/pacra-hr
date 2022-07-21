@extends('layout.mainlayout')
@section('content')
    <style>
        .logo li {
            display: inline-block;
        }
    </style>
    <title>
        Reimbursement Form
    </title>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">{{!empty($meta_title) ? $meta_title: 'Reimbursement Form'}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="index">Reimbursement</a></li>
                            <li class="breadcrumb-item active">{{!empty($meta_title) ? $meta_title: 'Reimbursement Form'}}
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
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

            @if (\Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            @if (\Session::has('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        <li>{!! \Session::get('danger') !!}</li>
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Reimbursement Form</h3>
                            <a data-target="#profile_info" data-toggle="modal"
                               type="button" style="display: flex; float: right"
                               class="btn-outline-success btn" href="#">View Allowances
                            </a>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('store-reimbursement-form') }}"
                                  enctype="multipart/form-data"
                                  files="true">
                                @csrf
                                <div class="form-group">
                                    <label>Reimbursement Type <span class="text-danger">*</span></label>
                                    <select id="multiple" class="form-control reimbursementType"
                                            placeholder="Select Reimbursement Type" required="required" name="type[]"
                                            style="height: max-content"
                                            multiple="">
                                        @foreach($allowanceType as $allowanceTypes)
                                            <option value="{{$allowanceTypes->id}}">{{$allowanceTypes->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="travelType" style="display: none">
                                    <label>Travel Type <span class="text-danger">*</span></label>
                                    <select class="select" name="travelType" required="required" id="tt2">
                                        <option value="">Select Travel Type</option>
                                        @foreach($travelType as $travelTypes)
                                            <option value="{{$travelTypes->id}}">{{$travelTypes->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="medicalTypeDiv" style="display: none">
                                    <label>Medical Type <span class="text-danger">*</span></label>
                                    <select class="select" name="medicalType" required="required" id="medicalTypeInput">
                                        <option value="">Select Medical Type</option>
                                        @foreach($medicalType as $medicalTypes)
                                            <option value="{{$medicalTypes->id}}">{{$medicalTypes->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="amountDiv" style="display: none">
                                    <label>Amount <span class="text-danger">*</span></label>
                                    <input class="form-control" name="travelAmount" required="required"
                                           id="amountInput">
                                </div>
                                <div class="form-group" id="kmsDiv" style="display: none">
                                    <label>KMs Travelled <span class="text-danger">*</span></label>
                                    <input class="form-control" name="kms" required="required" id="kmsInput">
                                </div>
                                <div class="form-group">
                                    <label>From Date <span class="text-danger">*</span></label>
                                    <input type="date" id="from_date" name="from_date"
                                           min="{{\Carbon\Carbon::now()->subDays(10)->format('Y-m-d')}}"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>To Date <span class="text-danger">*</span></label>
                                    <input type="date" id="to_date" name="to_date"
                                           max="{{\Carbon\Carbon::now()->addDays(10)->format('Y-m-d')}}"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <div class="">
                                        <textarea class="form-control" cols="9" rows="3" required="required"
                                                  name="description" placeholder="Enter Description">{{$reimbursementData[0]->description ?? ''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group" id="clientDiv">
                                    <label>Name Of Client <span class="text-danger">*</span></label>
                                    <select class="form-control selectpicker" name="client"
                                            data-show-subtext="true"
                                            data-live-search="true" id="clientSelect">
                                        <option value="">Select Client</option>
                                        <option value="other">Other</option>
                                    @foreach($clientName as $clientNames)
                                            <option
                                                value="{{$clientNames->company_id}}">{{$clientNames->clientName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="otherClientDiv" style="display: none">
                                    <input class="form-control" name="otherClient" required="required" id="otherClientInput">
                                </div>
                                <div class="form-group" id="otherAmountDiv" style="display: none">
                                    <label>Amount <span class="text-danger">*</span></label>
                                    <input class="form-control" name="otherAmount" required="required" id="otherAmountInput">
                                </div>
                                @if($userId == 10)
                                    <div class="form-group">
                                        <label>Actual <span class="text-danger">*</span></label>
                                        <input class="form-control" name="actual" required="required">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Attachment <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input type="file" name="attachment"
                                               accept="image/x-png,image/gif,image/jpeg,application/pdf" multiple>
                                        <small id="fileHelp" class="form-text text-muted">Can upload multiple files
                                            (image or pdf only).</small>
                                        <div class="submit-section">
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit"
                                                    value="Entered"> Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="profile_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Allowances Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if($getGrade == 1)
                                    <u><h4>Travel</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Air Travel: </li>
                                        <li style="padding-left: 1%">Economy Class</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Rail / Bus Travel: </li>
                                        <li style="padding-left: 1%">AC</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Own Transport: </li>
                                        <li style="padding-left: 1%">0.15 l/km</li>
                                    </ul>
                                    <u><h4>Accommodation</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">If PACRA has not arranged: </li>
                                        <li style="padding-left: 1%">Rs: 15,000 or Actual</li>
                                    </ul>
                                    <u><h4>Meal</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">If PACRA has not arranged: </li>
                                        <li style="padding-left: 1%">Rs: 5,000 or Actual</li>
                                    </ul>
                                    <u><h4>Hospitalization</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Hospital Care: </li>
                                        <li style="padding-left: 1%">Rs: 250,000</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Maternity: </li>
                                        <li style="padding-left: 1%">Rs: 100,000</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Major Medical Care: </li>
                                        <li style="padding-left: 1%">Rs: 500,000</li>
                                    </ul>
                                @elseif($getGrade == 2)
                                    <u><h4>Travel</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Air Travel: </li>
                                        <li style="padding-left: 1%">Economy Class</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Rail / Bus Travel: </li>
                                        <li style="padding-left: 1%">AC</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Own Transport: </li>
                                        <li style="padding-left: 1%">0.12 l/km</li>
                                    </ul>
                                    <u><h4>Accommodation</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">If PACRA has not arranged: </li>
                                        <li style="padding-left: 1%">Rs: 7,500</li>
                                    </ul>
                                    <u><h4>Meal</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">If PACRA has not arranged: </li>
                                        <li style="padding-left: 1%">Rs: 2,500</li>
                                    </ul>
                                    <u><h4>Hospitalization</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Hospital Care: </li>
                                        <li style="padding-left: 1%">Rs: 250,000</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Maternity: </li>
                                        <li style="padding-left: 1%">Rs: 100,000</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Major Medical Care: </li>
                                        <li style="padding-left: 1%">Rs: 500,000</li>
                                    </ul>
                                @elseif($getGrade == 3 || $getGrade == 4)
                                    <u><h4>Travel</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Air Travel: </li>
                                        <li style="padding-left: 1%">Economy Class</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Rail / Bus Travel: </li>
                                        <li style="padding-left: 1%">AC</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Own Transport: </li>
                                        <li style="padding-left: 1%">0.10 l/km</li>
                                    </ul>
                                    <u><h4>Accommodation</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">If PACRA has not arranged: </li>
                                        <li style="padding-left: 1%">Rs: 5,000</li>
                                    </ul>
                                    <u><h4>Meal</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">If PACRA has not arranged: </li>
                                        <li style="padding-left: 1%">Rs: 2,000</li>
                                    </ul>
                                    <u><h4>Hospitalization</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Hospital Care: </li>
                                        <li style="padding-left: 1%">Rs: 150,000</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Maternity: </li>
                                        <li style="padding-left: 1%">Rs: 75,000</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Major Medical Care: </li>
                                        <li style="padding-left: 1%">Rs: 300,000</li>
                                    </ul>
                                @elseif($getGrade == 5)
                                    <u><h4>Travel</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Air Travel: </li>
                                        <li style="padding-left: 1%">Economy Class</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Rail / Bus Travel: </li>
                                        <li style="padding-left: 1%">AC</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Own Transport: </li>
                                        <li style="padding-left: 1%">0.8 l/km</li>
                                    </ul>
                                    <u><h4>Accommodation</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">If PACRA has not arranged: </li>
                                        <li style="padding-left: 1%">Rs: 3,000</li>
                                    </ul>
                                    <u><h4>Meal</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">If PACRA has not arranged: </li>
                                        <li style="padding-left: 1%">Rs: 1,500</li>
                                    </ul>
                                    <u><h4>Hospitalization</h4></u>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Hospital Care: </li>
                                        <li style="padding-left: 1%">Rs: 100,000</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Maternity: </li>
                                        <li style="padding-left: 1%">Rs: 50,000</li>
                                    </ul>
                                    <ul class="logo">
                                        <li style="font-size: 16px">Major Medical Care: </li>
                                        <li style="padding-left: 1%">Rs: 200,000</li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
