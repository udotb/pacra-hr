
<?php $__env->startSection('content'); ?>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Job Applicants</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Job Applicants</li>
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
                            <?php $__currentLoopData = $jobAppliedLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$jobAppliedList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tbody>
                                <tr>
                                    <td><?php echo e($index+1); ?></td>
                                    <td><?php echo e($jobAppliedList->jobTitlesTable); ?></td>
                                    <td><h2 class="user-name m-t-10 mb-0 text-ellipsis">
                                            <a href="<?php echo e(url('candidateProfile')); ?>/<?php echo e($jobAppliedList->userID); ?>/<?php echo e($jobAppliedList->jobID); ?>"
                                               target="_blank"><?php echo e($jobAppliedList->fname); ?> <?php echo e($jobAppliedList->lname); ?></a>
                                        </h2></td>
                                    <td><?php echo e($jobAppliedList->applyDate); ?></td>
                                    <td><?php echo e($jobAppliedList->pfname); ?> <?php echo e($jobAppliedList->plname); ?></td>
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
                                    <td class="text-center">
                                        <div class="dropdown action-label">
                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#"
                                               data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-dot-circle-o text-success"></i> Select Action
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                   href="<?php echo e(route('addInitialShortlist')); ?>/<?php echo e($jobAppliedList->userID); ?>/<?php echo e($jobAppliedList->candidateID); ?>/<?php echo e($jobAppliedList->jobID); ?>/<?php echo e('Shortlist'); ?>"><i
                                                        class="fa fa-dot-circle-o text-success"></i> Shortlist</a>
                                                <a class="dropdown-item"
                                                   href="<?php echo e(route('addInitialShortlist')); ?>/<?php echo e($jobAppliedList->userID); ?>/<?php echo e($jobAppliedList->candidateID); ?>/<?php echo e($jobAppliedList->jobID); ?>/<?php echo e('Hold'); ?>"><i
                                                        class="fa fa-dot-circle-o text-purple"></i> Hold</a>
                                                <a class="dropdown-item"
                                                   href="<?php echo e('#modalLong' . $jobAppliedList->candidateID); ?>"
                                                data-toggle="modal"><i class="fa fa-dot-circle-o text-danger"></i>Rejected</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal custom-modal fade" id=<?php echo e('modalLong' . $jobAppliedList->candidateID); ?>

                                        role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Please Enter Rejection Comments</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="user" method="POST"
                                                      action="<?php echo e(url('rejectApplicants/'.$jobAppliedList->candidateID)); ?>"
                                                      enctype="multipart/form-data" files="true">
                                                    <?php echo csrf_field(); ?>
                                                    <input value="<?php echo e($jobAppliedList->candidateID); ?>" name="recID" type="hidden">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <select class="form-control"
                                                                        name="rejection_comment"
                                                                        placeholder="Select Rejection Comment">
                                                                    <?php $__currentLoopData = $rejectionReasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rejectionReason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option
                                                                            value="<?php echo e($rejectionReason->id); ?>"><?php echo e($rejectionReason->title); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="submit-section">
                                                        <button class="btn btn-primary submit-btn btn-sm"
                                                                name="Rejected"
                                                                type="submit" value="Rejected">
                                                            Submit
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/jobsApplicants.blade.php ENDPATH**/ ?>