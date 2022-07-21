@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
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
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable"
                               id="data_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>DOJ</th>
                                <th>Max Prob Salary</th>
                                <th>Max Salary</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($candidateLists as $index=>$candidateList)

                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>
                                        <h2 class="user-name m-t-10 mb-0 text-ellipsis">
                                            <a href="{{ url('candidateProfile') }}/{{$candidateList->userID}}/{{$candidateList->jobID}}"
                                               target="_blank">{{$candidateList->fname}} {{$candidateList->lname}}</a>
                                        </h2>
                                    </td>

                                    <td>{{$candidateList->doj}}</td>

                                    <td>{{$candidateList->probBasicSalary}}</td>
                                    <td>{{$candidateList->confirmationSalary}}</td>
                                    <td>{{$candidateList->status}}</td>

                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                               aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">

                                                <a class="dropdown-item"
                                                   href="{{route('finalSalaryForm') }}/{{$candidateList->userID}}/{{$candidateList->candidateID}}/{{$candidateList->jobID}}"><i
                                                        class="fa fa-clock-o m-r-5"></i>Enter Final Salary</a>


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
