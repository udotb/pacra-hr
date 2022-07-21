<?php $__env->startSection('content'); ?>

    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo e(asset('css/multidate.css')); ?>">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    </head>

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
                            <li class="breadcrumb-item active"><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?>s</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->

            <?php if(session()->has('message')): ?>
                <div class="alert alert-success">
                    <?php echo e(session()->get('message')); ?>

                </div>
            <?php endif; ?>


            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session()->get('error')); ?>

                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12">

                    <!-- Add Leave Modal -->

                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Add Client Visit</h3>
                        </div>
                        <div class="modal-body">
                            <?php if(!isset($siteVisit)): ?>

                                <form method="POST" action="<?php echo e(route('addSiteVisit')); ?>">
                                    <?php echo csrf_field(); ?>

                                    <input type="hidden" name="uid" value="<?php echo e($userId); ?>">


                                    <div class="form-group">

                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="text" class="form-control date" name="dates"
                                                   placeholder="Pick the multiple dates">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Select Time <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <select name="time" required="required" class="select">
                                                <option value=""> <?php echo e('Select Time'); ?></option>
                                                <option value="1"> All Day</option>
                                                <option value="2"> First Half</option>
                                                <option value="3"> Second Half</option>

                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label>Select Client <span class="text-danger">*</span></label>
                                        <div class="">
                                            <select name="client" required="required" class="select">
                                                <option value=""> <?php echo e('Select Client'); ?></option>
                                                <option value="0"> <?php echo e('Others'); ?></option>
                                                
                                                <?php $__currentLoopData = $outstanding->where('manager', $userId); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clients): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option value="<?php echo e($clients->Id); ?>"> <?php echo e($clients->Entity); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                
                                                <?php $__currentLoopData = $outstanding->where('analyst', $userId); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clients): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option value="<?php echo e($clients->Id); ?>"> <?php echo e($clients->Entity); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                
                                                <?php $__currentLoopData = $outstanding->where('lead_rc_id', $userId); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clients): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option value="<?php echo e($clients->Id); ?>"> <?php echo e($clients->Entity); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                
                                            </select>

                                        </div>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label>Is Anyother going <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <table class="table table-striped custom-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Is Going?</th>
                                                    <th>Time</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?php $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teamMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($teamMember->display_name); ?></td>
                                                        <td>
                                                            <select name="team[]" class="select">
                                                                <option value=""> No</option>
                                                                <option value="<?php echo e($teamMember->id); ?>"> Yes</option>

                                                            </select>

                                                        </td>
                                                        <td>
                                                            <select name="teamtime[]" class="select">
                                                                <option value=""> <?php echo e('Select Time'); ?></option>
                                                                <option value="1"> All Day</option>
                                                                <option value="2"> First Half</option>
                                                                <option value="3"> Second Half</option>
                                                            </select>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Reason <span class="text-danger">*</span></label>
                                        <textarea rows="4" class="form-control" name="reason"
                                                  required="required"></textarea>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                type="submit" value="Entered"> Submit
                                        </button>
                                    </div>
                                </form>
                            <?php else: ?>

                                <form method="POST" action="<?php echo e(route('addSiteVisit')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="recordid" value="<?php echo e($siteVisit[0]->recordId); ?>">
                                    <input type="hidden" name="uid" value="<?php echo e($siteVisit[0]->user_id); ?>">
                                    <input type="hidden" name="amID" value="<?php echo e($amId[0]); ?>">


                                    <div class="form-group">

                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="text" class="form-control date" name="dates"
                                                   value="<?php echo e($siteVisit[0]->dates); ?>"
                                                   placeholder="Pick the multiple dates">


                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Select Time <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <select name="time" required="required" class="select">
                                                <option
                                                    value="<?php echo e($siteVisit[0]->time); ?>"><?php echo e($siteVisit[0]->visitTime); ?></option>

                                                <option value=""> <?php echo e('Select Time'); ?></option>
                                                <?php $__currentLoopData = $clintVisitTimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($time->id); ?>"> <?php echo e($time->title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label>Select Client <span class="text-danger">*</span></label>
                                        <div class="">
                                            <select name="client" required="required" class="select">
                                                <?php if($siteVisit->first()->client_id == 0): ?>
                                                    <option
                                                        value="<?php echo e($siteVisit->first()->client_id); ?>"> <?php echo e('Others'); ?></option>
                                                <?php else: ?>

                                                    <option
                                                        value="<?php echo e($siteVisit->first()->client_id); ?>"> <?php echo e($siteVisit->first()->cName); ?></option>
                                                    <option value=""> <?php echo e('Select Client'); ?></option>

                                                    <?php if($userDesig == 4 or $userDesig == 16): ?>
                                                        <?php $__currentLoopData = $outstanding->where('manager', $userId); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clients): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <option
                                                                value="<?php echo e($clients->Id); ?>"> <?php echo e($clients->Entity); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php elseif($userDesig == 6 or $userDesig == 7 or $userDesig == 8): ?>
                                                        <?php $__currentLoopData = $outstanding->where('analyst', $userId); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clients): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <option
                                                                value="<?php echo e($clients->Id); ?>"> <?php echo e($clients->Entity); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <?php elseif($userDesig == 2): ?>
                                                        <?php $__currentLoopData = $outstanding->where('lead_rc_id', $userId); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clients): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <option
                                                                value="<?php echo e($clients->Id); ?>"> <?php echo e($clients->Entity); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </select>

                                        </div>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label>Is Anyother going <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <table class="table table-striped custom-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Is Going?</th>
                                                    <th>Time</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                    <tr>
                                                        <td><?php echo e($team->display_name); ?></td>
                                                        <td>
                                                            <select name="team[]" class="select">

                                                                <option value="<?php echo e($team->id); ?>"> Yes</option>
                                                                <option value=""> No</option>

                                                            </select>
                                                        </td>
                                                        <td>


                                                            <select name="teamtime[]" class="select">


                                                                <option value=""> <?php echo e('Select Time'); ?></option>
                                                                <option
                                                                    <?php echo e($temp[$team->id] == 1 ? 'selected' : ''); ?> value="1">
                                                                    All Day
                                                                </option>
                                                                <option
                                                                    <?php echo e($temp[$team->id] == 2 ? 'selected' : ''); ?> value="2">
                                                                    First Half
                                                                </option>
                                                                <option
                                                                    <?php echo e($temp[$team->id] == 3 ? 'selected' : ''); ?> value="3">
                                                                    Second Half
                                                                </option>

                                                            </select>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Reason <span class="text-danger">*</span></label>
                                        <textarea rows="4" class="form-control" name="reason"
                                                  required="required"><?php echo e($siteVisit->first()->comments); ?></textarea>
                                    </div>
                                    <div class="submit-section">
                                        <?php if($siteVisit->first()->user_id == $userId and $siteVisit->first()->status == 'Entered' ): ?>
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="Update"> Update
                                            </button>
                                        <?php endif; ?>
                                        <?php if($siteVisit->first()->user_id <> $userId and (in_array('16', $user_rights )) and $siteVisit->first()->status == 'Entered' ): ?>
                                            <button class="btn btn-primary submit-btn btn-success" name="submit"
                                                    type="submit" value="approve"> Approve
                                            </button>
                                            <button class="btn btn-primary submit-btn btn-danger" name="submit"
                                                    type="submit" value="decline"> Decline
                                            </button>

                                        <?php endif; ?>


                                    </div>
                                </form>

                                
                            <?php endif; ?>

                        </div>
                    </div>

                    <!-- /Add Leave Modal -->

                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>
    <!-- /Page Wrapper -->


    <script>


        dp = $('.date').datepicker({
            format: "yyyy-mm-dd",
            multidate: true,
            inline: true,
            todayHighlight: true,
            daysOfWeekDisabled: [0, 6],
            startDate: 'today'
        });
        dp.on('changeDate', function (e) {

            if (e.dates.length < 6) {
                selectedDates = e.dates
            } else {
                dp.data('datepicker').setDates(selectedDates);
                alert('Can only select 5 dates')
            }

        });


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/siteVisitapplication.blade.php ENDPATH**/ ?>