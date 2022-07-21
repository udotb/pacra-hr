
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
                        <table class="table table-striped custom-table mb-0 datatable"
                               id="data_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Terminated Employee</th>
                                <th>Reason</th>
                                <th>Notice Date</th>
                                <th>Termination Date</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $__currentLoopData = $termination; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $resig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index+1); ?></td>
                                    <td>
                                        <h2 class="table-avatar blue-link">

                                            <a href="<?php echo e(url('profile')); ?>/<?php echo e($resig->user_id); ?>"><?php echo e($resig->display_name); ?> </a>
                                        </h2>
                                    </td>
                                    <td><?php echo e($resig->reason); ?></td>
                                    <td><?php echo e($resig->last_working_day); ?></td>
                                    <td><?php echo e($resig->termination_date); ?></td>
                                    <td><?php echo e($resig->status); ?></td>
                                    <?php if($resig->status != 'Declined'): ?>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                               aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                   href="<?php echo e(route('resignationForm')); ?>/<?php echo e($resig->resigID); ?>"><i
                                                        class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item"
                                                   href="<?php echo e(route('resignationForm')); ?>/<?php echo e($resig->resigID); ?>"><i
                                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                    <?php endif; ?>
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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/termination.blade.php ENDPATH**/ ?>