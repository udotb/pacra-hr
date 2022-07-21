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

                    <div class="col-auto float-right ml-auto">
                        <a href="<?php echo e(route('siteVisitApplication')); ?>" target="_blank" class="btn add-btn" ><i class="fa fa-plus"></i> <?php echo e('Add Client Visit'); ?></a>
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
                                <th>Dates</th>
                                <th>Reason</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $__currentLoopData = $allWFHs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$allWFH): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php if($allWFH->status == 'Approve' or $allWFH->status == 'Decline' ): ?>
                                    <tr class="holiday-completed">
                                        <td><?php echo e($index +1); ?></td>
                                        <td><?php echo e($allWFH->dates); ?></td>

                                        <td><?php echo e($allWFH->reason); ?></td>
                                        <td></td>

                                        <?php else: ?>
                                            <td><?php echo e($index +1); ?></td>
                                            <td><?php echo e($allWFH->dates); ?></td>
                                            <td><?php echo e($allWFH->comments); ?></td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="<?php echo e(route('siteVisitApplication')); ?>/<?php echo e($allWFH->id); ?>" target="_blank"><i class="fa fa-pencil m-r-5"></i> Edit</a>
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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/client_visit_list.blade.php ENDPATH**/ ?>