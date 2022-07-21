<?php $__env->startSection('content'); ?>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Rejected Applicants</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Job Applicants</li>
                        </ul>
                    </div>
                </div>
            </div>
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
                                <th class="text-center">Status</th>
                                <th>Resume</th>
                                <th class="text-right">Rejection Reason</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $jobAppliedLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$jobAppliedList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index+1); ?></td>
                                    <td><?php echo e($jobAppliedList->jobTitlesTable); ?></td>
                                    <td><h2 class="user-name m-t-10 mb-0 text-ellipsis">
                                            <a href="<?php echo e(url('candidateProfile')); ?>/<?php echo e($jobAppliedList->userID); ?>/<?php echo e($jobAppliedList->jobID); ?>"
                                               target="_blank"><?php echo e($jobAppliedList->fname); ?> <?php echo e($jobAppliedList->lname); ?></a>
                                        </h2></td>
                                    <td><?php echo e($jobAppliedList->applyDate); ?></td>
                                    <td class="text-center">
                                        <div class="dropdown action-label">
                                            <a class="dropdown-item" href="#"><i
                                                    class="fa fa-dot-circle-o text-info"></i> <?php echo e($jobAppliedList->candidateStatus); ?>

                                            </a>
                                        </div>
                                    </td>
                                    <td><a href="https://209.97.168.200/pacra-job-portal/public/<?php echo e($jobAppliedList->cv); ?>"
                                           class="btn btn-sm btn-primary" download><i class="fa fa-download"></i>
                                            Download</a></td>
                                    <td class="truncate"
                                        title="<?php echo e(str_replace($spam, ' ', $jobAppliedList->title)); ?>"><?php echo e(str_replace($spam, ' ', $jobAppliedList->title)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/rejectedApplicants.blade.php ENDPATH**/ ?>