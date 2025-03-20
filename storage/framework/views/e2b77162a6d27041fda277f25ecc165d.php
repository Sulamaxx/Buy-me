

<?php $__env->startSection('header'); ?>
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h2 class="mb-0">
                <span class="text-capitalize"><?php echo $xPanel->entityNamePlural; ?></span>
                <small><?php echo e(trans('admin.edit')); ?> <?php echo $xPanel->entityName; ?></small>
            </h2>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="<?php echo e(admin_url()); ?>"><?php echo e(trans('admin.dashboard')); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(url($xPanel->route)); ?>" class="text-capitalize"><?php echo $xPanel->entityNamePlural; ?></a></li>
                <li class="breadcrumb-item active d-flex align-items-center"><?php echo e(trans('admin.edit')); ?></li>
            </ol>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex-row d-flex justify-content-center">
        <?php
            $colMd = config('settings.style.admin_boxed_layout') == '1' ? ' col-md-12' : ' col-md-9';
			$settingsClass = (
                (
                    in_array(request()->segment(2), ['settings', 'homepage'])
                    && request()->segment(4) == 'edit'
                )
                || (
                    in_array(request()->segment(4), ['settings', 'homepage'])
                    && request()->segment(6) == 'edit'
                )
			) ? ' settings-edition' : '';
        ?>
        <div class="col-sm-12<?php echo e($colMd); ?>">
            <div class="row">
                <div class="col-lg-6">
                    <?php if($xPanel->hasAccess('list')): ?>
                        <a href="<?php echo e(url($xPanel->route)); ?>" class="btn btn-primary shadow">
                            <i class="fa fa-angle-double-left"></i> <?php echo e(trans('admin.back_to_all')); ?>

                            <span class="text-lowercase"></span>
                        </a>
                        <br><br>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 text-end">
                    <?php if($xPanel->model->translationEnabled()): ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary shadow dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo e(trans('admin.Language')); ?>:
                                <?php echo e($xPanel->model->getAvailableLocales()[request()->input('locale') ? request()->input('locale') : app()->getLocale()]); ?> &nbsp;
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php $__currentLoopData = $xPanel->model->getAvailableLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item ps-3 pe-3 pt-1 pb-1" href="<?php echo e(url($xPanel->route . '/' . $entry->getKey() . '/edit')); ?>?locale=<?php echo e($key); ?>">
                                        <?php echo e($locale); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if($xPanel->hasUploadFields('update', $entry->getKey())): ?>
                <?php echo e(html()->form('PUT', url($xPanel->route . '/' . $entry->getKey()))->acceptsFiles()->open()); ?>

            <?php else: ?>
                <?php echo e(html()->form('PUT', url($xPanel->route . '/' . $entry->getKey()))->open()); ?>

            <?php endif; ?>
            <div class="card border-top border-primary<?php echo e($settingsClass); ?>">
                
                <?php if(!in_array($xPanel->getModel()->getTable(), ['settings', 'home_sections', 'domain_settings', 'domain_home_sections'])): ?>
                <div class="card-header">
                    <h3 class="mb-0"><?php echo e(trans('admin.edit')); ?></h3>
                </div>
				<?php endif; ?>
                <div class="card-body">
                    
                    <?php if(view()->exists('vendor.admin.panel.' . $xPanel->entityName . '.form_content')): ?>
                        <?php echo $__env->make('vendor.admin.panel.' . $xPanel->entityName . '.form_content', ['fields' => $xPanel->getFields('update', $entry->getKey())], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php elseif(view()->exists('vendor.admin.panel.form_content')): ?>
                        <?php echo $__env->make('vendor.admin.panel.form_content', ['fields' => $xPanel->getFields('update', $entry->getKey())], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php else: ?>
                        <?php echo $__env->make('admin.panel.form_content', ['fields' => $xPanel->getFields('update', $entry->getKey())], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
					<?php echo $__env->make('admin.panel.inc.form_save_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
            </div>
            <?php echo e(html()->form()->close()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/edit.blade.php ENDPATH**/ ?>