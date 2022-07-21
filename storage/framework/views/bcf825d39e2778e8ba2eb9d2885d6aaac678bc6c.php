<?php $__env->startSection('content'); ?>
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title"><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?></li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table custom-table display"
                               id="data_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Terminated Employee</th>
                                <th>Reason</th>
                                <th>Notice Date</th>
                                <th>Termination Date</th>
                                <th class="text-right">Status</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $__currentLoopData = $terminations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$resignation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(++$key); ?></td>
                                    <td>
                                        <h2 class="table-avatar blue-link">
                                            
                                            <a href="<?php echo e(url('profile')); ?>/<?php echo e($resignation->user_id); ?>"><?php echo e($resignation->display_name); ?> </a>
                                        </h2>
                                    </td>
                                    <td><?php echo e($resignation->reason); ?></td>
                                    <td><?php echo e($resignation->last_working_day); ?></td>
                                    <td><?php echo e($resignation->resignation_date); ?></td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">

                                            <a class="dropdown-item" href=""><i
                                                    class="fa fa-dot-circle-o text-success"></i><?php echo e($resignation->resigStatus); ?>

                                            </a>

                                        </div>
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- /Page Wrapper -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/TerminationReport.blade.php ENDPATH**/ ?>