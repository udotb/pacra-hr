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
                        <?php if(in_array('10', $user_rights) ): ?>
                        <div class="col-auto float-right ml-auto">

                            <a href="<?php echo e(url('add_employee')); ?>" class="btn add-btn" ><i class="fa fa-plus"></i> Add Employee</a>

                            <div class="view-icons">
                                <a href="employees" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                                <a href="employees-list" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Search Filter -->
                <form method="POST" action="<?php echo e(route('employeeSearch')); ?>">
                    <?php echo csrf_field(); ?>
                <div class="row filter-row">

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="floating selectpicker" name="empId" data-show-subtext="true" data-live-search="true">

                            
                                
                                <option value="">Select Employee</option>
                                <?php $__currentLoopData = $all_users2->groupBy('display_name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e($all_user->first()->id); ?>"><?php echo e($all_user->first()->display_name); ?></option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label class="focus-label">Employee Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="floating selectpicker" name="desig_id" data-show-subtext="true" data-live-search="true">

                            
                                
                                <option value="">Select Designation</option>
                                <?php $__currentLoopData = $allDesignations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allDesignation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e($allDesignation->id); ?>"><?php echo e($allDesignation->title); ?></option>
                                    <option></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label class="focus-label">Designation</label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="floating selectpicker" name="dept_id" data-show-subtext="true" data-live-search="true">

                            
                                
                                <option value="">Select Department</option>
                                <?php $__currentLoopData = $allDepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allDepartment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e($allDepartment->id); ?>"><?php echo e($allDepartment->title); ?></option>
                                    <option></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label class="focus-label">Department</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="floating selectpicker" name="grade_id" data-show-subtext="true" data-live-search="true">

                            
                                
                                <option value="">Select Grade</option>
                                <?php $__currentLoopData = $allGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allGrade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($allGrade->id); ?>"><?php echo e($allGrade->name); ?></option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label class="focus-label">Grade</label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div class="">
                                <input class="form-control floating " name="from_date" type="date">
                            </div>
                            <label class="focus-label">From</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div class="">
                                <input class="form-control floating " name="to_date" type="date">
                            </div>
                            <label class="focus-label">To</label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div class="">
                                <input type="text" list="foods" autocomplete="on" class="form-control floating ">
                                <datalist id="food">
                                    <option value="Burger"> Burger</option>
                                    <option value="Pizza"> Pizza</option>
                                </datalist>
                            </div>
                            <label class="focus-label">Test</label>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-success btn-block ">Search</button>

                    </div>
                </div>
                </form>
                <!-- Search Filter -->

                <div class="row staff-grid-row">
                    <?php $__currentLoopData = $all_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                        <div class="profile-widget">
                            <div class="profile-img">
                                <a href="<?php echo e(url('profile')); ?>/<?php echo e($users->id); ?>" target="_blank" class="avatar"><img src="<?php echo e(asset('users/')); ?>/<?php echo e($users->avatar_file); ?>" alt=""></a>
                            </div>
                            

                            <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="<?php echo e(url('profile')); ?>/<?php echo e($users->id); ?>" target="_blank"><?php echo e($users->display_name); ?></a></h4>
                            <div class="small text-muted"><?php echo e($users->desig); ?></div>

                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <!-- /Page Content -->
          

        </div>
        <!-- /Page Wrapper -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\pacra-hrms\resources\views/employees.blade.php ENDPATH**/ ?>