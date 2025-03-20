

<?php $__env->startSection('header'); ?>
	<div class="row page-titles">
		<div class="col-md-5 col-12 align-self-center">
			<h3 class="mb-0">
				<?php echo e(trans('admin.dashboard')); ?>

				
				<!-- <small>
					<?php echo e(trans('admin.first_page_you_see', [
						'appName' => config('app.name'),
						'appVersion' => env('APP_VERSION', config('version.app'))
					])); ?>

				</small> -->
			</h3>
		</div>
		<div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
			<ol class="breadcrumb mb-0 p-0 bg-transparent">
				<li class="breadcrumb-item"><a href="<?php echo e(admin_url()); ?>"><?php echo e(config('app.name')); ?></a></li>
				<li class="breadcrumb-item active d-flex align-items-center"><?php echo e(trans('admin.dashboard')); ?></li>
			</ol>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
        
			
			<?php echo $__env->make('admin.dashboard.inc.stats-boxes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
			<div class="row">
				
				
				<?php if ($__env->exists('admin.dashboard.inc.charts.' . $chartsType['provider'] . '.' . $chartsType['type'] . '.latest-posts')) echo $__env->make('admin.dashboard.inc.charts.' . $chartsType['provider'] . '.' . $chartsType['type'] . '.latest-posts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				
				
				<?php if ($__env->exists('admin.dashboard.inc.charts.' . $chartsType['provider'] . '.' . $chartsType['type'] . '.latest-users')) echo $__env->make('admin.dashboard.inc.charts.' . $chartsType['provider'] . '.' . $chartsType['type'] . '.latest-users', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				
				
				<?php echo $__env->make('admin.dashboard.inc.latest-posts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				
				
				<?php echo $__env->make('admin.dashboard.inc.latest-users', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
                
                <?php echo $__env->make('admin.dashboard.inc.reviewed-posts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
				<?php echo $__env->make('admin.dashboard.inc.updated-posts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				
				
				<?php echo $__env->make('admin.dashboard.inc.charts.chartjs.pie.posts-per-country', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				
				
				<?php echo $__env->make('admin.dashboard.inc.charts.chartjs.pie.users-per-country', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				
			</div>
			
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('after_styles'); ?>
	<link rel="stylesheet" href="<?php echo e(asset('assets/plugins/morris/0.5.1/morris.css')); ?>">
	
	<!-- DASHBOARD LIST CONTENT - dashboard_styles stack -->
	<?php echo $__env->yieldPushContent('dashboard_styles'); ?>
	
	<style>
		/* Bootstrap tooltip need to be in single line */
		
		@media (min-width: 992px) {
			.tooltip-inner {
				white-space: nowrap;
				max-width: none;
			}
		}
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script src="<?php echo e(asset('assets/plugins/raphael/raphael.min.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/plugins/morris/morris.min.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/plugins/chartjs/2.7.2/Chart.js')); ?>"></script>
	
	<!-- DASHBOARD LIST CONTENT - dashboard_scripts stack -->
	<?php echo $__env->yieldPushContent('dashboard_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>