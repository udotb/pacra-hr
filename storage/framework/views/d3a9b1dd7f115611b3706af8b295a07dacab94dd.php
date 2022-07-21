<?php $__env->startSection('content'); ?>
<!-- Page Wrapper -->
<div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Shortlisted Applicants</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                                <li class="breadcrumb-item active">Shortlisted Applicants</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Search Filter -->


                


                <!-- /Search Filter -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable"
                                   id="data_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Job Title</th>
                                        <th>Applicant Name</th>
                                        <th>Apply Date</th>
                                        <th>Requested By</th>
                                        <th class="text-center">Status</th>
                                        <th>Resume</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $jobAppliedLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$jobAppliedList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr>
                                        <td><?php echo e($index+1); ?></td>
                                        <td><?php echo e($jobAppliedList->jobTitlesTable); ?></td>
                                        <td><h2 class="user-name m-t-10 mb-0 text-ellipsis">
                                            <a href="<?php echo e(url('candidateProfile')); ?>/<?php echo e($jobAppliedList->userID); ?>/<?php echo e($jobAppliedList->jobID); ?>" target="_blank"><?php echo e($jobAppliedList->fname); ?> <?php echo e($jobAppliedList->lname); ?></a> </h2></td>
                                        <td><?php echo e($jobAppliedList->applyDate); ?></td>
                                        <td><?php echo e($jobAppliedList->pfname); ?> <?php echo e($jobAppliedList->plname); ?></td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-info"></i> <?php echo e($jobAppliedList->candidateStatus); ?></a>
                                            </div>
                                        </td>
                                        <td><a href="../../storage/app/<?php echo e($jobAppliedList->cv); ?>" class="btn btn-sm btn-primary" download><i class="fa fa-download"></i> Download</a></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?php echo e(route('scheduleTest')); ?>/<?php echo e($jobAppliedList->userID); ?>/<?php echo e($jobAppliedList->candidateID); ?>/<?php echo e($jobAppliedList->jobID); ?>"><i class="fa fa-clock-o m-r-5"></i> Schedule Test</a>
                                                    <a class="dropdown-item" href="<?php echo e(route('scheduleInterview')); ?>/<?php echo e($jobAppliedList->userID); ?>/<?php echo e($jobAppliedList->candidateID); ?>/<?php echo e($jobAppliedList->jobID); ?>"><i class="fa fa-clock-o m-r-5"></i> Schedule Interview</a>

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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/initialShortlist.blade.php ENDPATH**/ ?>