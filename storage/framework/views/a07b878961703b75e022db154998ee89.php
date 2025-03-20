<?php if(auth()->user()->can('setting-list') || userHasSuperAdminPermissions()): ?>
	<?php if(config('settings.app.general_settings_as_submenu_in_sidebar')): ?>
		<li class="sidebar-item">
			<a href="#general-settings" class="has-arrow sidebar-link">
				<span class="hide-menu"><?php echo e(trans('admin.general_settings')); ?></span>
			</a>
			<ul aria-expanded="false" class="collapse second-level">
				<?php if(isset($settings) && $settings->count() > 0): ?>
					<?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('settings/' . $setting->id . '/edit')); ?>" class="sidebar-link">
								<span class="hide-menu"><?php echo e($setting->name); ?></span>
							</a>
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<li class="sidebar-item">&nbsp;</li>
				<?php endif; ?>
			</ul>
		</li>
	<?php else: ?>
		<li class="sidebar-item">
			<a href="<?php echo e(admin_url('settings')); ?>" class="sidebar-link">
				<span class="hide-menu"><?php echo e(trans('admin.general_settings')); ?></span>
			</a>
		</li>
	<?php endif; ?>
<?php endif; ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/layouts/inc/sidebar/general-settings.blade.php ENDPATH**/ ?>