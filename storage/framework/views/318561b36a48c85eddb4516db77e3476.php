<?php if(auth()->user()->can('language-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(admin_url('languages')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.languages')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(auth()->user()->can('home-section-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(admin_url('homepage')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.homepage')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(auth()->user()->can('meta-tag-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(admin_url('meta_tags')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.meta tags')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(auth()->user()->can('package-list')|| userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="#packages" class="sidebar-link has-arrow">
			<i class="mdi mdi-adjust"></i> <span class="hide-menu"><?php echo e(trans('admin.packages')); ?></span>
		</a>
		<ul aria-expanded="false" class="collapse second-level">
			<li class="sidebar-item">
				<a href="<?php echo e(admin_url('packages/promotion')); ?>" class="sidebar-link">
					<i class="mdi mdi-adjust"></i>
					<span class="hide-menu"><?php echo e(trans('admin.promotion')); ?></span>
				</a>
			</li>
			<li class="sidebar-item">
				<a href="<?php echo e(admin_url('packages/subscription')); ?>" class="sidebar-link">
					<i class="mdi mdi-adjust"></i>
					<span class="hide-menu"><?php echo e(trans('admin.subscription')); ?></span>
				</a>
			</li>
			<li class="sidebar-item">&nbsp;</li>
		</ul>
	</li>
<?php endif; ?>
<?php if(auth()->user()->can('payment-method-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(admin_url('payment_methods')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.payment methods')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(auth()->user()->can('advertising-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(admin_url('advertisings')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.advertising')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(
	auth()->user()->can('country-list')
	|| auth()->user()->can('currency-list')
	|| userHasSuperAdminPermissions()
): ?>
	<li class="sidebar-item">
		<a href="#international" class="sidebar-link has-arrow">
			<i class="fa fa-globe"></i> <span class="hide-menu"><?php echo e(trans('admin.international')); ?></span>
		</a>
		<ul aria-expanded="false" class="collapse second-level">
			<?php if(auth()->user()->can('country-list') || userHasSuperAdminPermissions()): ?>
				<li class="sidebar-item">
					<a href="<?php echo e(admin_url('countries')); ?>" class="sidebar-link">
						<i class="mdi mdi-adjust"></i>
						<span class="hide-menu"><?php echo e(trans('admin.countries')); ?></span>
					</a>
				</li>
			<?php endif; ?>
			<?php if(auth()->user()->can('currency-list') || userHasSuperAdminPermissions()): ?>
				<li class="sidebar-item">
					<a href="<?php echo e(admin_url('currencies')); ?>" class="sidebar-link">
						<i class="mdi mdi-adjust"></i>
						<span class="hide-menu"><?php echo e(trans('admin.currencies')); ?></span>
					</a>
				</li>
			<?php endif; ?>
			<li class="sidebar-item">&nbsp;</li>
		</ul>
	</li>
<?php endif; ?>
<?php if(auth()->user()->can('blacklist-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(admin_url('blacklists')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.blacklist')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if(auth()->user()->can('report-type-list') || userHasSuperAdminPermissions()): ?>
	<li class="sidebar-item">
		<a href="<?php echo e(admin_url('report_types')); ?>" class="sidebar-link">
			<i class="mdi mdi-adjust"></i>
			<span class="hide-menu"><?php echo e(trans('admin.report types')); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/layouts/inc/sidebar/tableData-settings.blade.php ENDPATH**/ ?>