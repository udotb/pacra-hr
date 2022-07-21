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

                            <div class="col-auto float-right ml-auto">
                                <a href="{{ route('quizForm') }}" target="_blank" class="btn add-btn" ><i class="fa fa-plus"></i>Add Quiz</a>
                            </div>


                    </div>
                </div>
                <!-- /Page Header -->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Marks</th>
                                        <th>Time</th>
                                        <th>Description</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($activeQuizes as $index=>$activeQuize)
                                            <td>{{$index +1}}</td>
                                            <td>{{$activeQuize->title}}</td>
                                            <td>{{$activeQuize->marks}}</td>
                                            <td>{{$activeQuize->time}}</td>
                                            <td>{{$activeQuize->description}}</td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{ route('quizForm') }}/{{$activeQuize->id}}" target="_blank"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                    </tr>
                                  @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <!-- /Page Wrapper -->
@endsection