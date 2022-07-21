@extends('layout.settingslayout')
@section('content')

          
		
<!-- Page Wrapper -->
<div class="page-wrapper">
			
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                    
                        <!-- Page Header -->
                        <div class="page-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3 class="page-title">Add New Institute</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /Page Header -->
                        
                        <form method="POST" action="{{ route('addInstitute') }}" enctype="multipart/form-data" files="true">
                            @csrf
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Institute Name</label>
                                        <input class="form-control " name="title"  type="text">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>City</label>
                                        <select class="form-control selectpicker" name="city" data-show-subtext="true" data-live-search="true">                                                
                                            @foreach ($Cities as $city)
                                            <option value="{{$city->id}}">{{$city->city}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>
                                
                                
                            </div>

                           
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
            
        </div>
        <!-- /Page Wrapper -->
        </div>
		@endsection