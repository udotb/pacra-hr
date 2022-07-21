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
                
               
                
                <div class="row staff-grid-row">

                    @foreach ($activeQuizes as $activeQuize)
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{$activeQuize->title}}</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{$activeQuize->description}}</p>
                                <p>Per Question Mark: {{$activeQuize->marks}} <br>
                                    Total Time: {{$activeQuize->time}}
                                    </p>
                                <a class="btn btn-primary" href="{{ route('questionsList') }}/{{$activeQuize->id}}" target="_blank">Questions List</a>
                                <a class="btn btn-primary" href="{{ route('questionsForm') }}/{{$activeQuize->id}}" target="_blank">Add Question</a>

                            </div>
                        </div>
                    </div>
                        
                    @endforeach

                    


                </div>
            </div>
            <!-- /Page Content -->
            
            
            
            

            
        </div>
        <!-- /Page Wrapper -->
@endsection