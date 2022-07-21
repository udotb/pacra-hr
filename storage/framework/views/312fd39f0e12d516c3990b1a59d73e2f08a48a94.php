<?php $__env->startSection('content'); ?>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Reimbursement</h3>
                        <a type="button" style="display: flex; float: right"
                           class="btn-success btn" href="<?php echo e(url('reimbursement-form')); ?>">Apply For Reimbursement</a>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Reimbursement</li>
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
                                <th>Name</th>
                                <th>Type</th>
                                <th style="white-space: nowrap">No of Days</th>
                                <th>Client</th>
                                <th>Dated</th>
                                <th>Amount</th>
                                <th class="text-center">Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $reimbursements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$reimbursement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index+1); ?></td>
                                    <td style="white-space: nowrap"><?php echo e($reimbursement->display_name); ?></td>
                                    
                                    <td style="white-space: nowrap"
                                        title="<?php echo e(str_replace($spam, '', $reimbursement->type)); ?>"><?php echo e(str_replace($spam, ' ', $reimbursement->type)); ?></td>
                                    <td><?php echo e($numOfDays); ?></td>
                                    <td><?php echo e(($reimbursement->client == 'N/A')?($reimbursement->client):($reimbursement->other_client)); ?></td>

                                    <td style="white-space: nowrap"><?php echo e(date('d-M-Y', strtotime($reimbursement->dated))); ?></td>
                                    <td>Rs. <?php echo e($reimbursement->amount); ?></td>
                                    <td><?php echo e($reimbursement->status); ?></td>
                                    <td>
                                        <a data-target="#approval_modal<?php echo e($reimbursement->id); ?>" data-toggle="modal"
                                           href="#">
                                            <i title="View Details">
                                                <svg width="20px" height="20px" viewBox="0 0 1792 1792"
                                                     fill="#81b01e">
                                                    <path
                                                        d="M1664 960q-152-236-381-353 61 104 61 225 0 185-131.5 316.5t-316.5 131.5-316.5-131.5-131.5-316.5q0-121 61-225-229 117-381 353 133 205 333.5 326.5t434.5 121.5 434.5-121.5 333.5-326.5zm-720-384q0-20-14-34t-34-14q-125 0-214.5 89.5t-89.5 214.5q0 20 14 34t34 14 34-14 14-34q0-86 61-147t147-61q20 0 34-14t14-34zm848 384q0 34-20 69-140 230-376.5 368.5t-499.5 138.5-499.5-139-376.5-368q-20-35-20-69t20-69q140-229 376.5-368t499.5-139 499.5 139 376.5 368q20 35 20 69z"/>
                                                </svg>
                                            </i>
                                        </a>
                                        <a title="View Attachment" target=_blank
                                           href="<?php echo e($reimbursement->attachment); ?>">
                                            <i title="View Attachment">
                                                <svg width="20px" height="20px" viewBox="0 0 1792 1500"
                                                     fill="#1e81b0">
                                                    <path
                                                        d="M1520 1216q0-40-28-68l-208-208q-28-28-68-28-42 0-72 32 3 3 19 18.5t21.5 21.5 15 19 13 25.5 3.5 27.5q0 40-28 68t-68 28q-15 0-27.5-3.5t-25.5-13-19-15-21.5-21.5-18.5-19q-33 31-33 73 0 40 28 68l206 207q27 27 68 27 40 0 68-26l147-146q28-28 28-67zm-703-705q0-40-28-68l-206-207q-28-28-68-28-39 0-68 27l-147 146q-28 28-28 67 0 40 28 68l208 208q27 27 68 27 42 0 72-31-3-3-19-18.5t-21.5-21.5-15-19-13-25.5-3.5-27.5q0-40 28-68t68-28q15 0 27.5 3.5t25.5 13 19 15 21.5 21.5 18.5 19q33-31 33-73zm895 705q0 120-85 203l-147 146q-83 83-203 83-121 0-204-85l-206-207q-83-83-83-203 0-123 88-209l-88-88q-86 88-208 88-120 0-204-84l-208-208q-84-84-84-204t85-203l147-146q83-83 203-83 121 0 204 85l206 207q83 83 83 203 0 123-88 209l88 88q86-88 208-88 120 0 204 84l208 208q84 84 84 204z"/>
                                                </svg>
                                            </i>
                                        </a>
                                        <a title="Edit" target=_blank
                                           href="<?php echo e(url('edit-reimbursement-form'). '/' .$reimbursement->id); ?>">
                                            <i title="Edit">
                                                <svg width="20px" height="20px" viewBox="0 0 1792 1792"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M888 1184l116-116-152-152-116 116v56h96v96h56zm440-720q-16-16-33 1l-350 350q-17 17-1 33t33-1l350-350q17-17 1-33zm80 594v190q0 119-84.5 203.5t-203.5 84.5h-832q-119 0-203.5-84.5t-84.5-203.5v-832q0-119 84.5-203.5t203.5-84.5h832q63 0 117 25 15 7 18 23 3 17-9 29l-49 49q-14 14-32 8-23-6-45-6h-832q-66 0-113 47t-47 113v832q0 66 47 113t113 47h832q66 0 113-47t47-113v-126q0-13 9-22l64-64q15-15 35-7t20 29zm-96-738l288 288-672 672h-288v-288zm444 132l-92 92-288-288 92-92q28-28 68-28t68 28l152 152q28 28 28 68t-28 68z"/>
                                                </svg>
                                            </i>
                                        </a>
                                    </td>

                                    
                                    
                                    

                                    
                                    
                                    
                                    

                                    
                                    
                                    

                                    

                                    
                                    
                                    

                                    
                                    
                                    
                                    
                                    
                                    
                                    

                                </tr>

                                <div class="modal custom-modal fade" id="approval_modal<?php echo e($reimbursement->id); ?>"
                                     role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="form-header">
                                                    <h3><?php echo e($reimbursement->display_name); ?></h3>
                                                </div>
                                                <div class="modal-btn delete-action">
                                                    <div class="form-group">
                                                        <h4 style="padding-top: 30px">Client</h4>
                                                        <?php echo ($reimbursement->client == 'N/A')?($reimbursement->client):($reimbursement->other_client); ?>

                                                        <h4 style="padding-top: 30px">Type Of Reimbursement</h4>
                                                        <?php echo str_replace($spam, ' ', $reimbursement->type); ?>

                                                        <?php if($reimbursement->TravelType): ?>
                                                            <h4 style="padding-top: 30px">Type Of Travel</h4>
                                                            <?php echo $reimbursement->TravelType ?? ''; ?>

                                                        <?php endif; ?>
                                                        <?php if($reimbursement->MedType): ?>
                                                            <h4 style="padding-top: 30px">Type Of Medical</h4>
                                                            <?php echo $reimbursement->MedType ?? ''; ?>

                                                        <?php endif; ?>
                                                        <h4 style="padding-top: 30px">From Date</h4>
                                                        <?php echo date('d-M-Y', strtotime($reimbursement->from_date)); ?>

                                                        <h4 style="padding-top: 30px">To Date</h4>
                                                        <?php echo date('d-M-Y', strtotime($reimbursement->to_date)); ?>

                                                        <h4 style="padding-top: 30px">Description</h4>
                                                        <?php echo $reimbursement->description; ?>

                                                        <h4 style="padding-top: 30px">Amount</h4>
                                                        <p>Rs: <?php echo e($reimbursement->amount); ?></p>
                                                        <?php if($reimbursement->user_id == $userId && $reimbursement->decline_reason != null): ?>
                                                            <h4 style="padding-top: 30px">Decline Reason</h4>
                                                            <p><?php echo e($reimbursement->status); ?></p>
                                                            <p style="color: indianred; font-size: 26px"><?php echo e($reimbursement->decline_reason); ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
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
            <?php if($totalAmount): ?>
                <div style="display: flex; float: right; padding-top: 20px; padding-right: 10px">
                    <h3 id="udu" style="color: indianred">Pending Rs: <?php echo e($totalAmount); ?></h3>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/reimbursement.blade.php ENDPATH**/ ?>