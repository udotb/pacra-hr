<?php $__env->startSection('content'); ?>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
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
                                <th>Name</th>
                                <th>DOJ</th>
                                <th>Max Prob Salary</th>
                                <th>Max Salary</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $candidateLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$candidateList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td><?php echo e($index+1); ?></td>
                                    <td>
                                        <h2 class="user-name m-t-10 mb-0 text-ellipsis">
                                            <a href="<?php echo e(url('candidateProfile')); ?>/<?php echo e($candidateList->userID); ?>/<?php echo e($candidateList->jobID); ?>"
                                               target="_blank"><?php echo e($candidateList->fname); ?> <?php echo e($candidateList->lname); ?></a>
                                        </h2>
                                    </td>

                                    <td><?php echo e($candidateList->doj); ?></td>

                                    <td><?php echo e($candidateList->probBasicSalary); ?></td>
                                    <td><?php echo e($candidateList->confirmationSalary); ?></td>
                                    <td><?php echo e($candidateList->status); ?></td>

                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                               aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">

                                                <a class="dropdown-item"
                                                   href="<?php echo e(route('finalSalaryForm')); ?>/<?php echo e($candidateList->userID); ?>/<?php echo e($candidateList->candidateID); ?>/<?php echo e($candidateList->jobID); ?>"><i
                                                        class="fa fa-clock-o m-r-5"></i>Enter Final Salary</a>


                                            </div>
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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/ShortListByCEO.blade.php ENDPATH**/ ?>