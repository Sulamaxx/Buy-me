<header class="topbar">
	<?php
		$navbarTheme = (config('settings.style.admin_navbar_bg') == 'skin6') ? 'navbar-light' : 'navbar-dark';
	?>
	<nav class="navbar top-navbar navbar-expand-md <?php echo e($navbarTheme); ?>">
		
		<div class="navbar-header">
			
			
			<a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
				<i class="fas fa-bars"></i>
			</a>
			
			
			<a class="navbar-brand" href="<?php echo e(url('/')); ?>" target="_blank">
				
				<span class="logo-text m-auto">
					<img src="<?php echo e(config('settings.app.logo_dark_url')); ?>" alt="<?php echo e(strtolower(config('settings.app.name'))); ?>" class="dark-logo img-fluid"/>
					<img src="<?php echo e(config('settings.app.logo_light_url')); ?>" alt="<?php echo e(strtolower(config('settings.app.name'))); ?>" class="light-logo img-fluid"/>
				</span>
			</a>
			
			
			<a class="topbartoggler d-block d-md-none waves-effect waves-light"
			   href="javascript:void(0)"
			   data-bs-toggle="collapse"
			   data-bs-target="#navbarSupportedContent"
			   aria-controls="navbarSupportedContent"
			   aria-expanded="false"
			   aria-label="Toggle navigation"
			>
				<i class="bi bi-three-dots"></i>
			</a>
			
		</div>
		
		<div class="navbar-collapse collapse" id="navbarSupportedContent">
			
			<ul class="navbar-nav me-auto">
				<li class="nav-item">
					<a class="nav-link sidebartoggler d-none d-md-block waves-effect waves-dark" href="javascript:void(0)">
						<i class="fas fa-bars"></i>
					</a>
				</li>
			</ul>
			
			
			<ul class="navbar-nav justify-content-end">
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle waves-effect waves-dark"
					   href=""
					   data-bs-toggle="dropdown"
					   aria-haspopup="true"
					   aria-expanded="false"
					>
						<img src="<?php echo e(auth()->user()->photo_url); ?>"
							 alt="user"
							 width="30"
							 class="profile-pic rounded-circle"
						/>
					</a>
					<div class="dropdown-menu dropdown-menu-end user-dd">
						<div class="d-flex no-block align-items-center p-3 bg-primary text-white mb-2">
							<div class="">
								<img src="<?php echo e(auth()->user()->photo_url); ?>" alt="user" class="rounded-circle" width="60">
							</div>
							<div class="ms-2">
								<h4 class="mb-0 text-white"><?php echo e(auth()->user()->name); ?></h4>
								<p class="mb-0"><?php echo e(auth()->user()->email); ?></p>
							</div>
						</div>
						<a class="dropdown-item" href="<?php echo e(admin_url('account')); ?>">
							<i data-feather="user" class="feather-sm text-info me-1 ms-1"></i> <?php echo e(trans('admin.my_account')); ?>

						</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo e(admin_url('logout')); ?>">
							<i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i> <?php echo e(trans('admin.logout')); ?>

						</a>
					</div>
				</li>
			</ul>
		</div>
		
	</nav>
</header>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/layouts/inc/header.blade.php ENDPATH**/ ?>