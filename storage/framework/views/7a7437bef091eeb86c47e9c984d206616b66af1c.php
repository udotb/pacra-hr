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
                                <th>Candidate Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Round</th>
                                <th>Interviewer</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($approvalCheck == 0): ?>
                            <?php $__currentLoopData = $candidateLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$candidateList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td><?php echo e($index+1); ?></td>
                                    <td><?php echo e($candidateList->desTitle); ?></td>
                                    <td>
                                        <h2 class="user-name m-t-10 mb-0 text-ellipsis">
                                            <a href="<?php echo e(url('candidateProfile')); ?>/<?php echo e($candidateList->userID); ?>/<?php echo e($candidateList->jobID); ?>"
                                               target="_blank"><?php echo e($candidateList->fname); ?> <?php echo e($candidateList->lname); ?></a>
                                        </h2>
                                    </td>
                                    <td><?php echo e($candidateList->date); ?></td>
                                    <td><?php echo e($candidateList->time); ?></td>
                                    <td><?php echo e($candidateList->interviewRound); ?></td>
                                    <td><?php echo e($candidateList->Fname); ?> <?php echo e($candidateList->Lname); ?></td>

                                    <td class="text-right">
                                        <div class="dropdown action-label">
                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#"
                                               data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-dot-circle-o text-success"></i> Select Action
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">

                                                <a class="dropdown-item"
                                                   href="<?php echo e(route('hiringDecision')); ?>/<?php echo e($candidateList->userID); ?>/<?php echo e($candidateList->candidateID); ?>/<?php echo e($candidateList->jobID); ?>/<?php echo e('Shortlist By CEO'); ?>"><i
                                                        class="fa fa-dot-circle-o text-success"></i> Appointed</a>
                                                <a class="dropdown-item"
                                                   href="<?php echo e(route('hiringDecision')); ?>/<?php echo e($candidateList->userID); ?>/<?php echo e($candidateList->candidateID); ?>/<?php echo e($candidateList->jobID); ?>/<?php echo e('reject'); ?>"><i
                                                        class="fa fa-dot-circle-o text-danger"></i> Rejected</a>
                                                <a class="dropdown-item"
                                                   href="<?php echo e(route('hiringDecision')); ?>/<?php echo e($candidateList->userID); ?>/<?php echo e($candidateList->candidateID); ?>/<?php echo e($candidateList->jobID); ?>/<?php echo e('reject'); ?>"><i
                                                        class="fa fa-dot-circle-o text-info"></i> Hold</a>

                                            </div>
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

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/shortListedForFinalInterview.blade.php ENDPATH**/ ?>