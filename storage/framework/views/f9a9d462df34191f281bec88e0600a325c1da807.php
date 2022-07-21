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

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Attendance Summary Report
                            ( <?php echo e(date('d-M-y', strtotime($customStartDate))); ?>

                            - <?php echo e(date('d-M-y', strtotime($customEndDate))); ?> )</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance Summary Report</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table display"
                               id="monthlyAtt">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>On Time</th>

                                <th>Late</th>
                                <th>0.25</th>
                                <th>0.50</th>
                                <th>0.75</th>
                                <th>Absents</th>
                                <th>Leaves</th>
                                <th>Balance</th>
                                <th>Total Days</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($getAttendanceDetails->count()): ?>
                                <?php $__currentLoopData = $getAttendanceDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $getAttendanceDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="tr_<?php echo e($getAttendanceDetail->id); ?>">
                                        <td><?php echo e($getAttendanceDetail->display_name); ?></td>
                                        <td><?php echo e($getAttendanceDetail->OnTime); ?></td>

                                        <td><?php echo e($getAttendanceDetail->DeductibleLate); ?></td>
                                        <td><?php echo e($getAttendanceDetail->firstDeduction); ?></td>
                                        <td><?php echo e($getAttendanceDetail->secondDeduction); ?></td>
                                        <td><?php echo e($getAttendanceDetail->thirdDeduction); ?></td>
                                        <td><?php echo e($getAttendanceDetail->Absent); ?></td>
                                        <td><?php echo e($getAttendanceDetail->OnLeave); ?></td>
                                        <td><?php echo e(str_replace($spam, '', $getAttendanceDetail->current_balance)); ?></td>
                                        <td>
                                            <?php echo e($getAttendanceDetail->OnTime +
                                            $getAttendanceDetail->Late +
                                            $getAttendanceDetail->DeductibleLate +
                                            $getAttendanceDetail->Absent +
                                            $getAttendanceDetail->OnLeave); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->

    <script>
        $(document).ready(function () {
            $('#monthlyAtt').DataTable({
                "pageLength": 100,
                dom: 'Bfrtip',
                "ordering": false,
                buttons: [
                    'excelHtml5', 'pdf'
                ],
                initComplete: function () {
                    var btns = $('.dt-button');
                    btns.addClass('btn btn-secondary dt');
                    btns.removeClass('dt-button');
                },
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/attendanceExcelView.blade.php ENDPATH**/ ?>