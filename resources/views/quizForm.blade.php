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
                                @if(!isset($quizData))
                                <form method="post" action="{{ route('addQuiz') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Quiz Title</label>
                                        <div class="col-md-10">
                                            <input type="text" name="title" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Per Question Mark</label>
                                        <div class="col-md-10">
                                            <input type="number" name="marks" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Quiz Time (in minutes)</label>
                                        <div class="col-md-10">
                                            <input type="number" name="time" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Description</label>
                                        <div class="col-md-10">
                                            <textarea rows="5" cols="5" class="form-control" placeholder="Enter text here" name="description"></textarea>
                                        </div>
                                    </div>

                                    <div class="submit-section">
                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered">Submit</button>

                                    </div>
                                    
                                </form>
                                    
                                @else
                                <form method="post" action="{{ route('addQuiz') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Quiz Title</label>
                                        <div class="col-md-10">
                                            <input type="text" name="title" value="{{$quizData->first()->title}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Per Question Mark</label>
                                        <div class="col-md-10">
                                            <input type="number" name="marks" value="{{$quizData->first()->marks}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Quiz Time (in minutes)</label>
                                        <div class="col-md-10">
                                            <input type="number" name="time" value="{{$quizData->first()->time}}" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-2">Description</label>
                                        <div class="col-md-10">
                                            <textarea rows="5" cols="5" class="form-control" placeholder="Enter text here" name="description">{{$quizData->first()->description}}</textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="quizID" value="{{$quizData->first()->id}}">

                                    <div class="submit-section">
                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered">Submit</button>

                                    </div>
                                    
                                </form>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            
            </div>			
        </div>
@endsection