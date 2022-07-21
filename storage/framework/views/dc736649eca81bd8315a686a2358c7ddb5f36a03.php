<?php $__env->startSection('content'); ?>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Attendance</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
            <form method="POST" action="<?php echo e(route('attendanceReportSingleUser')); ?>"
                  enctype="multipart/form-data" files="true">
                <?php echo csrf_field(); ?>
                <div class="row filter-row">

                    <div class="col-sm-6 col-md-3">

                        <div class="form-group form-focus select-focus">
                            <select class="select floating" name="user_id" required="required">
                                <option value="">Select Employee</option>
                                <?php $__currentLoopData = $getUsers->groupBy('fname'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($user->first()->id); ?>"><?php echo e($user->first()->fname); ?> <?php echo e($user->first()->lname); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label class="focus-label">Employee Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <input class="form-control floating from_date" type="date" name="from_date">
                            <label class="focus-label">From Date</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <input class="form-control floating to_date" type="date" name="to_date">
                            <label class="focus-label">To date</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-success btn-block report ">Get Report</button>
                    </div>
                </div>
            </form>
            <!-- /Search Filter -->
        </div>
        <!-- /Page Content -->
        <div class="accordion" id="accordionExample">
            <div class="card">
                <?php $__currentLoopData = $getAttendanceDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=> $getAttendanceDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card-header" id="heading<?php echo e($getAttendanceDetail->user_id); ?>">
                        <h2 class="mb-0">
                            <div class="row">
                                <div class="col-sm-4">
                                    <button class="btn btn-link ajax-call" key-class="<?php echo e($getAttendanceDetail->user_id); ?>"
                                            type="button" data-toggle="collapse"
                                            data-target="#collapse<?php echo e($getAttendanceDetail->user_id); ?>"
                                            aria-expanded="true"
                                            aria-controls="collapse<?php echo e($getAttendanceDetail->user_id); ?>">
                                        <?php echo e($index+1); ?> - <?php echo e($getAttendanceDetail->fname); ?> <?php echo e($getAttendanceDetail->lname); ?>

                                    </button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn" style="width: 150%">
                                        On Time <?php echo e($getAttendanceDetail->OnTime); ?>

                                    </button>
                                </div>

                                <div class="col-sm-1">
                                    <button class="btn" style="margin-left: 12px">
                                        Late <?php echo e($getAttendanceDetail->Late); ?>

                                    </button>
                                </div>

                                <div class="col-sm-1">
                                    <button class="btn">
                                        Absent <?php echo e($getAttendanceDetail->Absent); ?>

                                    </button>
                                </div>

                                <div class="col-sm-1">
                                    <button class="btn">
                                        Leave <?php echo e($getAttendanceDetail->OnLeave); ?>

                                    </button>
                                </div>

                                <div class="col-sm-1">
                                    <button class="btn">
                                        Office <?php echo e($getAttendanceDetail->InOffice); ?>

                                    </button>
                                </div>

                                <div class="col-sm-1">
                                    <button class="btn">
                                        Anywhere 0
                                    </button>
                                </div>
                            </div>
                        </h2>
                    </div>

                    <div id="collapse<?php echo e($getAttendanceDetail->user_id); ?>" class="collapse"
                         aria-labelledby="heading<?php echo e($getAttendanceDetail->user_id); ?>" data-parent="#accordionExample">
                        <div style="text-align: center" id="loading"></div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped tt<?php echo e($getAttendanceDetail->user_id); ?>" data-isload="0">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Punch In Time</th>
                                    <th>Punch Out Time</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody class="body<?php echo e($getAttendanceDetail->user_id); ?>">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <span style="display: none" class="from_date"><?php echo e($customStartDate); ?></span>
                <span style="display: none" class="to_date"><?php echo e($customEndDate); ?></span>
            </div>
        </div>
    </div>



    <!-- Page Wrapper -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function () {
            $(".ajax-call").click(function (e) {
                $('#loading').html('<object data="public/Spinner-1s-200px.svg" width="30" height="30"></object>Loading Please Wait...');
                var id = $(this).attr("key-class");
                var fromDate = $(".from_date").text();
                var toDate = $(".to_date").text();
                console.log(id);
                console.log(fromDate);
                console.log(toDate);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var formData = {
                    id: id,
                    fromDate: fromDate,
                    toDate: toDate,
                };
                var type = "POST";
                var ajaxurl = 'ajaxcall2';
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: 'json',
                    success: function (success) {
                        $("div#loading").hide();
                        var html = '';
                        $.each(success.data, function (index, item) {
                            html = html + '<tr>';
                            html = html + '<td>';
                            let d = new Date(item['date']);
                            let ye = new Intl.DateTimeFormat('en', {year: '2-digit'}).format(d);
                            let mo = new Intl.DateTimeFormat('en', {month: 'short'}).format(d);
                            let da = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(d);
                            html = html + `${da}-${mo}-${ye}`;
                            html = html + '</td>';
                            html = html + '<td>';
                            html = html + (item['log_in_time'] ? item['log_in_time'] : ' ');
                            html = html + '</td>';
                            html = html + '<td>';
                            html = html + (item['log_out_time'] ? item['log_out_time'] : ' ');
                            html = html + '</td>';

                            html = html + '<td>';
                            if (jQuery.inArray(item['ip_address_login'], ['125.209.73.138', '110.37.226.186', '175.107.239.42', '202.141.241.58', '110.39.42.115']) !== -1)
                                html = html + 'In Office';
                            else if (jQuery.inArray(item['ip_address_login'], ['']) !== -1)
                                html = html + '';
                            else
                                html = html + 'Any Where';
                            html = html + '</td>';

                            html = html + '<td>';
                            html = html + item['title'];
                            html = html + '</td>';

                            html = html + '</tr>';
                        });
                        $('.body' + id).html(html);
                        if ($('.tt' + id).attr('data-isload') == '0') {
                            $('.tt' + id).DataTable({
                                "pageLength": 100,
                                dom: 'Bfrtip',
                                buttons: [
                                    'excelHtml5', 'pdf'
                                ],
                                initComplete: function () {
                                    var btns = $('.dt-button');
                                    btns.addClass('btn btn-secondary dt');
                                    btns.removeClass('dt-button');
                                },
                            });
                            $('.tt' + id).attr('data-isload', '1')
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/attendanceReportSingleUser.blade.php ENDPATH**/ ?>