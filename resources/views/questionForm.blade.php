@extends('layout.mainlayout')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
			
            <div class="content container-fluid">
            
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Add {{!empty($meta_title) ? $meta_title: 'PACRA'}}</h4>
                            </div>
                            <div class="card-body">
                                
                                <form method="post" action="{{ route('addQuestion') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Question</label>
                                        <div class="col-md-10">
                                            <textarea rows="5" cols="5" class="form-control" placeholder="Enter question here" name="question"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        @php
                                        $indexes = ['A','B','C','D']    
                                        @endphp
                                        @foreach ($indexes as $item)
                                        <div class="col-md-4 mb-3">
                                            <label>{{$item}} - Option</label>
                                            <input type="text" name="options[{{$item}}]" class="form-control" placeholder="Please Enter A Option" required>
                                        
                                        </div>
                                        @endforeach
                                        
                
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Correct Answer</label>
                                        <div class="col-md-10">
                                            <select name="correctAnswer"  class="form-control">
                                                @foreach ($indexes as $item)
                                                <option value="{{$item}}">{{$item}}</option>
                                                @endforeach
                                              </select>

                                           
                                        </div>
                                    </div>
                                   <input type="hidden" name="quizID" value="{{$quizID}}">
                                    
                                    

                                    <div class="submit-section">
                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered">Submit</button>

                                    </div>
                                    
                                </form>
                                    
                                
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            
            </div>			
        </div>
@endsection