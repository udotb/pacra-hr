
<?php $__env->startSection('content'); ?>


  <!-- Page Wrapper -->

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
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Add Separation</h3>

                            </div>
                            <div class="modal-body">
                                <?php if(!isset($resignation)): ?>

                                <form method="POST" action="<?php echo e(route('addResignation')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="uid" value="<?php echo e($userId); ?>">
                                    


                                    <div class="form-group">
                                        <label>Sepration Submission Date <span class="text-danger">*</span></label>
                                        <div class="">
                                            
                                            <input type="date" class="form-control"   name="resignation_date" value="<?php echo e(Carbon\Carbon::now()->toDateString()); ?>" min="<?php echo e(Carbon\Carbon::now()->toDateString()); ?>"  max= "<?php echo e(Carbon\Carbon::now()->addWeeks(1)->toDateString()); ?>"  required="required">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Last Working Day <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="date" class="form-control" name="lWorking_date" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Current Leave Balance <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="text" class="form-control" name="leaveBalance" value="<?php echo e($getLeaveBalance->first()->current_balance); ?>" readonly="readonly" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>I am joining an entity rated by PACRA in the last one year where I was part of the respective rating team Name of Prospective Employer?<span class="text-danger">*</span></label>
                                        <div class="">
                                            <select class="form-control"  name="inRC" id="inRC">
                                                <option value="00">No</option>
                                                <?php $__currentLoopData = $isRcPart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $isRc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($isRc->first()->opinion_id); ?>"><?php echo e($isRc->first()->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Reason <span class="text-danger">*</span></label>
                                        <textarea name="reason" class="form-control" rows="4" required="required"></textarea>
                                    </div>





                                    <div class="submit-section">
                                        <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered">Submit</button>

                                    </div>
                                </form>

                                    <?php else: ?>
                                    <form method="POST" action="<?php echo e(route('addResignation')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="uid" value="<?php echo e($resignation->first()->user_id); ?>">
                                        <div class="form-group">
                                            <label>Separation Type <span class="text-danger">*</span></label>
                                            
                                            <input type="text" class="form-control"  value="<?php echo e($resignation_types->first()->title); ?>" readonly="readonly" required="required">

                                        </div>


                                        <div class="form-group">
                                            <label>Separation Date <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input type="date" class="form-control " name="resignation_date" value="<?php echo e($resignation->first()->resignation_date); ?>" required="required" readonly="readonly">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Last Working Day <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input type="date" class="form-control" name="lWorking_date" value="<?php echo e($resignation->first()->last_working_day); ?>" required="required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Current Leave Balance <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input type="text" class="form-control" name="leaveBalance" value="<?php echo e($getLeaveBalance->first()->current_balance); ?>" readonly="readonly" required="required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Reason <span class="text-danger">*</span></label>
                                            <textarea name="reason" class="form-control" rows="4" required="required"><?php echo e($resignation->first()->reason); ?></textarea>
                                        </div>

                                        <input type="hidden" name="recordid" value="<?php echo e($resignation->first()->id); ?>">


                                        <?php if($resignation->first()->am_id == $userId and $resignation->first()->am_id): ?>
                                            <div class="submit-section">
                                                <button  class="btn btn-primary submit-btn btn-danger" name="submit" type="submit" value="Approved"> Approve</button>
                                                <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Declined">Decline</button>

                                            </div>
                                        <?php else: ?>
                                        <div class="submit-section">
                                            <button  class="btn btn-primary submit-btn btn-success" name="submit" type="submit" value="Entered">Submit</button>

                                        </div>
                                           <?php endif; ?>
                                    </form>

                                    <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /Page Content -->


        </div>
        <!-- /Page Wrapper -->


        <script>

    $('.date-format').datepicker("yyyy-mm-dd", "option", "maxDate", "+1m +1w" );

            // dp = $('.date-format').datepicker({
            //     format: "yyyy-mm-dd",
            //     multidate: false,
            //     inline: true,
            //     todayHighlight: true,
            //     daysOfWeekDisabled: [0,6],
            //     startDate: 'today',

            // });
            // dp.on('changeDate', function(e) {

            //     if(e.dates.length <6){
            //         selectedDates = e.dates
            //     }else{
            //         dp.data('datepicker').setDates(selectedDates);
            //         alert('Can only select 5 dates')
            //     }

            // });






        </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/resignationForm.blade.php ENDPATH**/ ?>