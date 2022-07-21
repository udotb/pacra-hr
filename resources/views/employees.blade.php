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
                        @if(in_array('10', $user_rights) )
                        <div class="col-auto float-right ml-auto">
{{--
                            <a href="{{ url('add_employees') }}" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Add Employee</a>
--}}
                            <a href="{{ url('add_employee') }}" class="btn add-btn" ><i class="fa fa-plus"></i> Add Employee</a>

                            <div class="view-icons">
                                <a href="employees" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                                <a href="employees-list" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Search Filter -->
                <form method="POST" action="{{ route('employeeSearch') }}">
                    @csrf
                <div class="row filter-row">

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="floating selectpicker" name="empId" data-show-subtext="true" data-live-search="true">

                            {{-- <select class="select floating" name="empId"> --}}
                                {{--<input type="text" class="form-control floating">--}}
                                <option value="">Select Employee</option>
                                @foreach($all_users2->groupBy('display_name') as $all_user)

                                    <option value="{{$all_user->first()->id}}">{{$all_user->first()->display_name}}</option>
{{--                                    <option></option>--}}
                                @endforeach
                            </select>
                            <label class="focus-label">Employee Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="floating selectpicker" name="desig_id" data-show-subtext="true" data-live-search="true">

                            {{-- <select class="select floating" name="desig_id"> --}}
                                {{--<input type="text" class="form-control floating">--}}
                                <option value="">Select Designation</option>
                                @foreach($allDesignations as $allDesignation)

                                    <option value="{{$allDesignation->id}}">{{$allDesignation->title}}</option>
                                    <option></option>
                                @endforeach
                            </select>
                            <label class="focus-label">Designation</label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="floating selectpicker" name="dept_id" data-show-subtext="true" data-live-search="true">

                            {{-- <select class="select floating" name="dept_id"> --}}
                                {{--<input type="text" class="form-control floating">--}}
                                <option value="">Select Department</option>
                                @foreach($allDepartments as $allDepartment)

                                    <option value="{{$allDepartment->id}}">{{$allDepartment->title}}</option>
                                    <option></option>
                                @endforeach
                            </select>
                            <label class="focus-label">Department</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="floating selectpicker" name="grade_id" data-show-subtext="true" data-live-search="true">

                            {{-- <select class="select floating" name="grade_id"> --}}
                                {{--<input type="text" class="form-control floating">--}}
                                <option value="">Select Grade</option>
                                @foreach($allGrades as $allGrade)
                                    <option value="{{$allGrade->id}}">{{$allGrade->name}}</option>
{{--                                    <option></option>--}}
                                @endforeach
                            </select>
                            <label class="focus-label">Grade</label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div class="">
                                <input class="form-control floating " name="from_date" type="date">
                            </div>
                            <label class="focus-label">From</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div class="">
                                <input class="form-control floating " name="to_date" type="date">
                            </div>
                            <label class="focus-label">To</label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div class="">
                                <input type="text" list="foods" autocomplete="on" class="form-control floating ">
                                <datalist id="food">
                                    <option value="Burger"> Burger</option>
                                    <option value="Pizza"> Pizza</option>
                                </datalist>
                            </div>
                            <label class="focus-label">Test</label>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-success btn-block ">Search</button>
{{--
                        <a href="#" class="btn btn-success btn-block"> Search </a>
--}}
                    </div>
                </div>
                </form>
                <!-- Search Filter -->

                <div class="row staff-grid-row">
                    @foreach($all_users as $users)
                    <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                        <div class="profile-widget">
                            <div class="profile-img">
                                <a href="{{ url('profile') }}/{{$users->id}}" target="_blank" class="avatar"><img src="{{asset('users/')}}/{{$users->avatar_file}}" alt=""></a>
                            </div>
                            {{--<div class="dropdown profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">

--}}{{--
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
--}}{{--
                                </div>
                            </div>--}}

                            <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{ url('profile') }}/{{$users->id}}" target="_blank">{{$users->display_name}}</a></h4>
                            <div class="small text-muted">{{$users->desig}}</div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- /Page Content -->
          {{--
            <!-- Add Employee Modal -->
            <div id="add_employee" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Last Name</label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Username <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                            <input class="form-control" type="email">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Password</label>
                                            <input class="form-control" type="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Confirm Password</label>
                                            <input class="form-control" type="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                            <div class="cal-icon"><input class="form-control datetimepicker" type="text"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Phone </label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Company</label>
                                            <select class="select">
                                                <option value="">Global Technologies</option>
                                                <option value="1">Delta Infotech</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select Department</option>
                                                <option>Web Development</option>
                                                <option>IT Management</option>
                                                <option>Marketing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Designation <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select Designation</option>
                                                <option>Web Designer</option>
                                                <option>Web Developer</option>
                                                <option>Android Developer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive m-t-15">
                                    <table class="table table-striped custom-table">
                                        <thead>
                                            <tr>
                                                <th>Module Permission</th>
                                                <th class="text-center">Read</th>
                                                <th class="text-center">Write</th>
                                                <th class="text-center">Create</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center">Import</th>
                                                <th class="text-center">Export</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Holidays</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Leaves</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Clients</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Projects</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tasks</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Chats</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Assets</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Timing Sheets</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add Employee Modal -->

            <!-- Edit Employee Modal -->
            <div id="edit_employee" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                            <input class="form-control" value="John" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Last Name</label>
                                            <input class="form-control" value="Doe" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Username <span class="text-danger">*</span></label>
                                            <input class="form-control" value="johndoe" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                            <input class="form-control" value="johndoe@example.com" type="email">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Password</label>
                                            <input class="form-control" value="johndoe" type="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Confirm Password</label>
                                            <input class="form-control" value="johndoe" type="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                            <input type="text" value="FT-0001" readonly class="form-control floating">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                            <div class="cal-icon"><input class="form-control datetimepicker" type="text"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Phone </label>
                                            <input class="form-control" value="9876543210" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Company</label>
                                            <select class="select">
                                                <option>Global Technologies</option>
                                                <option>Delta Infotech</option>
                                                <option selected>International Software Inc</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select Department</option>
                                                <option>Web Development</option>
                                                <option>IT Management</option>
                                                <option>Marketing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Designation <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select Designation</option>
                                                <option>Web Designer</option>
                                                <option>Web Developer</option>
                                                <option>Android Developer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive m-t-15">
                                    <table class="table table-striped custom-table">
                                        <thead>
                                            <tr>
                                                <th>Module Permission</th>
                                                <th class="text-center">Read</th>
                                                <th class="text-center">Write</th>
                                                <th class="text-center">Create</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center">Import</th>
                                                <th class="text-center">Export</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Holidays</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Leaves</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Clients</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Projects</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tasks</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Chats</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Assets</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Timing Sheets</td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input checked="" type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Edit Employee Modal -->

            <!-- Delete Employee Modal -->
            <div class="modal custom-modal fade" id="delete_employee" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-header">
                                <h3>Delete Employee</h3>
                                <p>Are you sure want to delete?</p>
                            </div>
                            <div class="modal-btn delete-action">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Delete Employee Modal -->--}}

        </div>
        <!-- /Page Wrapper -->
@endsection
