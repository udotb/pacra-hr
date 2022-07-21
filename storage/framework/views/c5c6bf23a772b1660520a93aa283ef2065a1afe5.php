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
                                <th>Resigning Employee</th>
                                <th>Reason</th>
                                <th>Notice Date</th>
                                <th>Resignation Date</th>
                                <th>Preview</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                                ?>
                            <?php if(in_array('27', $userRights)): ?>

                                <?php $__currentLoopData = $resignation->where('section_two_name', null); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$resig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key+1); ?></td>
                                        <td>
                                            <h2 class="table-avatar blue-link">
                                                <a href="profile" class="avatar"><img alt=""
                                                                                      src="img/profiles/avatar-02.jpg"></a>
                                                <a href="profile"><?php echo e($resig->display_name); ?> </a>
                                                
                                            </h2>
                                        </td>
                                        <td><?php echo e($resig->reason); ?></td>
                                        <td><?php echo e($resig->last_working_day); ?></td>
                                        <td><?php echo e($resig->resignation_date); ?></td>
                                        <td>
                                            <a class="dropdown-item"
                                               href="<?php echo e(url('SeparationFormPreview')); ?>/<?php echo e($resig->resigID); ?>"
                                               target="_blank"><i class="fa fa-eye text-success" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a class="dropdown-item"
                                                   href="<?php echo e(url('TLempSeparationForm')); ?>/<?php echo e($resig->resigID); ?>"
                                                   target="_blank"><i class="fa fa-dot-circle-o text-info"></i> Pending</a>
                                            </div>
                                        </td>
                                    </tr>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/TLseparationList.blade.php ENDPATH**/ ?>