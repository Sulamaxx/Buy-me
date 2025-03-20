<?php if(auth()->check()): ?>
	<?php
		// Get plugins admin menu
		$pluginsMenu = '';
		$plugins = plugin_installed_list();
		if (!empty($plugins)) {
			foreach($plugins as $plugin) {
				if (method_exists($plugin->class, 'getAdminMenu')) {
					$pluginsMenu .= call_user_func($plugin->class . '::getAdminMenu');
				}
			}
		}
	?>
	<style>
		#adminSidebar ul li span {
			text-transform: capitalize;
		}
	</style>
	<aside class="left-sidebar" id="adminSidebar">
		
		<div class="scroll-sidebar">
			
			<nav class="sidebar-nav">
				<ul id="sidebarnav">
					<li class="sidebar-item user-profile">
						<a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
							<img src="<?php echo e(auth()->user()->photo_url); ?>" alt="user">
							<span class="hide-menu"><?php echo e(auth()->user()->name); ?></span>
						</a>
						<ul aria-expanded="false" class="collapse first-level">
							<li class="sidebar-item">
								<a href="<?php echo e(admin_url('account')); ?>" class="sidebar-link p-0">
									<i class="mdi mdi-adjust"></i>
									<span class="hide-menu"><?php echo e(trans('admin.my_account')); ?></span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="<?php echo e(admin_url('logout')); ?>" class="sidebar-link p-0">
									<i class="mdi mdi-adjust"></i>
									<span class="hide-menu"><?php echo e(trans('admin.logout')); ?></span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="sidebar-item">
						<a href="<?php echo e(admin_url('dashboard')); ?>" class="sidebar-link waves-effect waves-dark">
							<i data-feather="home" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.dashboard')); ?></span>
						</a>
					</li>
					<?php if(
						auth()->user()->can('post-list')
						|| auth()->user()->can('category-list')
						|| auth()->user()->can('picture-list')
						|| auth()->user()->can('post-type-list')
						|| auth()->user()->can('field-list')
						|| userHasSuperAdminPermissions()
					): ?>
						<li class="sidebar-item">
							<a href="#" class="sidebar-link has-arrow waves-effect waves-dark">
								<i data-feather="list"></i> <span class="hide-menu"><?php echo e(trans('admin.listings')); ?></span>
							</a>
							<ul aria-expanded="false" class="collapse first-level">
								<?php if(auth()->user()->can('post-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('posts')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.list')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('category-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('categories')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.categories')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('picture-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('pictures')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.pictures')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('post-type-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('post_types')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.listing types')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('field-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('custom_fields')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.custom fields')); ?></span>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(
						auth()->user()->can('user-list')
						|| auth()->user()->can('role-list')
						|| auth()->user()->can('permission-list')
						|| auth()->user()->can('gender-list')
						|| userHasSuperAdminPermissions()
					): ?>
						<li  class="sidebar-item">
							<a href="#" class="sidebar-link has-arrow waves-effect waves-dark">
								<i data-feather="users" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.users')); ?></span>
							</a>
							<ul aria-expanded="false" class="collapse first-level">
								<?php if(auth()->user()->can('user-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('users')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.list')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('role-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('roles')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.roles')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('permission-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('permissions')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.permissions')); ?></span>
										</a>
									</li>
								<?php endif; ?>
								<?php if(auth()->user()->can('gender-list') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('genders')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu"><?php echo e(trans('admin.titles')); ?></span>
										</a>
									</li>
								<?php endif; ?>
                                <!--   shop code stert -->
                                <?php if(userHasSuperAdminPermissions()): ?> 
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('member_shops')); ?>" class="sidebar-link">
											<i class="mdi mdi-adjust"></i>
											<span class="hide-menu">Member Shops</span>
										</a>
									</li>
								<?php endif; ?>
                                <!--  shop code end -->
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(
						auth()->user()->can('payment-list')
						|| userHasSuperAdminPermissions()
					): ?>
						<li class="sidebar-item">
							<a href="#" class="sidebar-link has-arrow waves-effect waves-dark">
								<i data-feather="dollar-sign" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.payments')); ?></span>
							</a>
							<ul aria-expanded="false" class="collapse first-level">
								<li class="sidebar-item">
									<a href="<?php echo e(admin_url('payments/promotion')); ?>" class="sidebar-link">
										<i class="mdi mdi-adjust"></i>
										<span class="hide-menu"><?php echo e(trans('admin.promotions')); ?></span>
									</a>
								</li>
								<li class="sidebar-item">
									<a href="<?php echo e(admin_url('payments/subscription')); ?>" class="sidebar-link">
										<i class="mdi mdi-adjust"></i>
										<span class="hide-menu"><?php echo e(trans('admin.subscriptions')); ?></span>
									</a>
<!--                                    category assignments-->
                                    <li class="sidebar-item">
									<a href="<?php echo e(admin_url('packagescs')); ?>" class="sidebar-link">
										<i class="mdi mdi-adjust"></i>
										<span class="hide-menu"><?php echo e(trans('admin.catassign')); ?></span>
									</a>
								    </li>
<!--                                category assignments-->
								</li>
							</ul>
						</li>
					<?php endif; ?>
					<?php if(auth()->user()->can('page-list') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('pages')); ?>" class="sidebar-link">
								<i data-feather="book-open" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.pages')); ?></span>
							</a>
						</li>
					<?php endif; ?>

					<?php if(auth()->user()->can('page-list') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('sliders')); ?>" class="sidebar-link">
								<i data-feather="image" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('Slider')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php echo $pluginsMenu; ?>

					
					
					<?php if(
						auth()->user()->can('setting-list')
						|| auth()->user()->can('language-list')
						|| auth()->user()->can('home-section-list')
						|| auth()->user()->can('meta-tag-list')
						|| auth()->user()->can('package-list')
						|| auth()->user()->can('payment-method-list')
						|| auth()->user()->can('advertising-list')
						|| auth()->user()->can('country-list')
						|| auth()->user()->can('currency-list')
						|| auth()->user()->can('blacklist-list')
						|| auth()->user()->can('report-type-list')
						|| userHasSuperAdminPermissions()
					): ?>
						<li class="nav-small-cap">
							<i class="mdi mdi-dots-horizontal"></i>
							<span class="hide-menu"><?php echo e(trans('admin.configuration')); ?></span>
						</li>
						
						<?php if(
							auth()->user()->can('setting-list')
							|| auth()->user()->can('language-list')
							|| auth()->user()->can('home-section-list')
							|| auth()->user()->can('meta-tag-list')
							|| auth()->user()->can('package-list')
							|| auth()->user()->can('payment-method-list')
							|| auth()->user()->can('advertising-list')
							|| auth()->user()->can('country-list')
							|| auth()->user()->can('currency-list')
							|| auth()->user()->can('blacklist-list')
							|| auth()->user()->can('report-type-list')
							|| userHasSuperAdminPermissions()
						): ?>
							<li class="sidebar-item">
								<a href="#" class="has-arrow sidebar-link">
									<i data-feather="settings" class="feather-icon"></i>
									<span class="hide-menu"><?php echo e(trans('admin.settings')); ?></span>
								</a>
								<ul aria-expanded="false" class="collapse first-level">
									<?php echo $__env->make('admin.layouts.inc.sidebar.general-settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									<?php echo $__env->make('admin.layouts.inc.sidebar.tableData-settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								</ul>
							</li>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php if(auth()->user()->can('plugin-list') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('plugins')); ?>" class="sidebar-link">
								<i data-feather="package" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.plugins')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php if(auth()->user()->can('clear-cache') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('actions/clear_cache')); ?>" class="sidebar-link">
								<i data-feather="refresh-cw" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.clear cache')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					<?php if(auth()->user()->can('backup-list') || userHasSuperAdminPermissions()): ?>
						<li class="sidebar-item">
							<a href="<?php echo e(admin_url('backups')); ?>" class="sidebar-link">
								<i data-feather="hard-drive" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.backups')); ?></span>
							</a>
						</li>
					<?php endif; ?>
					
					<?php if(
						auth()->user()->can('system-info')
						|| auth()->user()->can('maintenance')
						|| userHasSuperAdminPermissions()
					): ?>
						<li  class="sidebar-item">
							<a href="#" class="sidebar-link has-arrow waves-effect waves-dark">
								<i data-feather="alert-circle"></i> <span class="hide-menu"><?php echo e(trans('admin.system')); ?></span>
							</a>
							<ul aria-expanded="false" class="collapse first-level">
								<?php if(
									auth()->user()->can('maintenance') ||
									userHasSuperAdminPermissions()
								): ?>
									<?php if(app()->isDownForMaintenance()): ?>
										<?php if(auth()->user()->can('maintenance') || userHasSuperAdminPermissions()): ?>
											<li class="sidebar-item">
												<a href="<?php echo e(admin_url('actions/maintenance/up')); ?>"
												   data-bs-toggle="tooltip"
												   title="<?php echo e(trans('admin.Leave Maintenance Mode')); ?>"
												   class="sidebar-link confirm-simple-action"
												>
													<span class="hide-menu"><?php echo e(trans('admin.Live Mode')); ?></span>
												</a>
											</li>
										<?php endif; ?>
									<?php else: ?>
										<?php if(auth()->user()->can('maintenance') || userHasSuperAdminPermissions()): ?>
											<li class="sidebar-item">
												<a href="<?php echo e(admin_url('actions/maintenance/down')); ?>"
												   data-bs-toggle="tooltip"
												   title="<?php echo e(trans('admin.Put in Maintenance Mode')); ?>"
												   class="sidebar-link confirm-simple-action"
												>
													<span class="hide-menu"><?php echo e(trans('admin.Maintenance')); ?></span>
												</a>
											</li>
										<?php endif; ?>
									<?php endif; ?>
								<?php endif; ?>
								<?php if(auth()->user()->can('system-info') || userHasSuperAdminPermissions()): ?>
									<li class="sidebar-item">
										<a href="<?php echo e(admin_url('system')); ?>" class="sidebar-link">
											<span class="hide-menu"><?php echo e(trans('admin.system_info')); ?></span>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(userHasSuperAdminPermissions()): ?>
					 	<li class="sidebar-item">
							<a href="<?php echo e(url('docs/api')); ?>" target="_blank" class="sidebar-link">
								<i data-feather="book" class="feather-icon"></i> <span class="hide-menu"><?php echo e(trans('admin.api_docs')); ?></span>
							</a>
						</li> 
					<?php endif; ?>
					
				</ul>
			</nav>
			
		</div>
		
	</aside>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/layouts/inc/sidebar.blade.php ENDPATH**/ ?>