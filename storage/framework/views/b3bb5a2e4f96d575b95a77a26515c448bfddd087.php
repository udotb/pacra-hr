<?php $__env->startSection('content'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/js/bootstrap-select.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.1.0/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
        
        
        
        
        
        
        
        
        
        
        
        <!-- /Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Excel Export</h4>
                    </div>
                </div>
            </div>
            <form method="POST" action="<?php echo e(route('attendanceExcelExportSummary')); ?>"
                  enctype="multipart/form-data" files="true">
                <?php echo csrf_field(); ?>
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <input class="form-control floating from_date" type="date" name="from_date"
                                   required="required">
                            <label class="focus-label">From Date</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <input class="form-control floating to_date" type="date" name="to_date" required="required">
                            <label class="focus-label">To date</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-success btn-block report" type="submit">Excel</button>
                    </div>
                </div>
            </form>
            <br>
            <hr>

            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Attendance Report - Last 30 Days</h4>
                    </div>
                </div>
            </div>
            <!-- Search Filter -->
            <form method="POST" action="<?php echo e(route('attendanceReportSingleUser')); ?>"
                  enctype="multipart/form-data" files="true">
                <?php echo csrf_field(); ?>
                <div class="row filter-row">
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <input class="form-control floating from_date" type="date" name="from_date"
                                   required="required">
                            <label class="focus-label">From Date</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <input class="form-control floating to_date" type="date" name="to_date" required="required">
                            <label class="focus-label">To date</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-success btn-block report" type="submit">Get Report</button>
                    </div>
                </div>
            </form>
            <!-- /Search Filter -->
        </div>
        <!-- /Page Content -->
        <div class="accordion" id="accordionExample">
            <div class="card responsive">
                <?php $__currentLoopData = $getAttendanceDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=> $getAttendanceDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card-header responsive" id="heading<?php echo e($getAttendanceDetail->user_id); ?>"
                         style="margin: 0px;padding: 0px; border: none">
                        <h2 class="mb-0">
                            <div class="row" style="white-space: nowrap">
                                <div class="col-sm-3" style="border-right: solid #d2d2d2 1px;">
                                    <button class="btn btn-link ajax-call" key-class="<?php echo e($getAttendanceDetail->user_id); ?>"
                                            type="button" data-toggle="collapse"
                                            data-target="#collapse<?php echo e($getAttendanceDetail->user_id); ?>"
                                            aria-expanded="true"
                                            aria-controls="collapse<?php echo e($getAttendanceDetail->user_id); ?>">
                                        <?php echo e($index+1); ?> - <?php echo e($getAttendanceDetail->fname); ?> <?php echo e($getAttendanceDetail->lname); ?>

                                    </button>
                                </div>

                                <div class="col-sm-1">
                                    <button class="btn">
                                        On Time <p><?php echo e($getAttendanceDetail->OnTime); ?></p>
                                    </button>
                                </div>







                                <div class="col-sm-1" style="padding-left: 0; padding-right: 0">
                                    <button class="btn" style="padding-left: 0; padding-right: 0">
                                        Deductible Late <p><?php echo e($getAttendanceDetail->DeductibleLate); ?></p>
                                    </button>
                                </div>

                                <div class="col-sm-1" style="padding-left: 30px">
                                    <button class="btn">
                                        Absent <p><?php echo e($getAttendanceDetail->Absent); ?></p>
                                    </button>
                                </div>

                                <div class="col-sm-1">
                                    <button class="btn">
                                        Leave <p><?php echo e($getAttendanceDetail->OnLeave); ?></p>
                                    </button>
                                </div>

                                <div class="col-sm-1" style="padding-left: 0; padding-right: 0">
                                    <button class="btn" style="padding-left: 0; padding-right: 0">
                                        Office <p><?php echo e($getAttendanceDetail->InOffice); ?></p>
                                    </button>
                                </div>

                                <div class="col-sm-1" style="padding-left: 0; padding-right: 0">
                                    <button class="btn" style="padding-left: 0; padding-right: 0">
                                        
                                        Anywhere <p>0</p>
                                    </button>
                                </div>

                                <div class="col-sm-1">
                                    <button class="btn">
                                        Leave Balance <p><?php echo e(str_replace($spam, '', round($getAttendanceDetail->current_balance, 2))); ?></p>
                                    </button>
                                </div>
                            </div>
                        </h2>
                    </div>

                    <div id="collapse<?php echo e($getAttendanceDetail->user_id); ?>" class="collapse"
                         aria-labelledby="heading<?php echo e($getAttendanceDetail->user_id); ?>" data-parent="#accordionExample">
                        <div style="text-align: center" id="loading1"></div>
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
            </div>
        </div>
    </div>
    <!-- Page Wrapper -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function () {
            $(".ajax-call").click(function (e) {
                $('#loading1').html('<object data="public/Spinner-1s-200px.svg" width="30" height="30"></object>Loading Please Wait...');
                var id = $(this).attr("key-class");
                console.log(id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var formData = {
                    id: id,
                };
                var type = "POST";
                var ajaxurl = 'ajaxcall';
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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/attendanceReport.blade.php ENDPATH**/ ?>