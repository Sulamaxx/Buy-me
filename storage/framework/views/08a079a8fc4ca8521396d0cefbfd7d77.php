<?php if(config('settings.app.show_countries_charts')): ?>
	<?php
		$usersPerCountry ??= [];
		
		$countUsersCountries = (int)data_get($usersPerCountry, 'countCountries');
		$usersDataArr = json_decode(data_get($usersPerCountry, 'data'), true);
		$usersDataArrLabels = data_get($usersDataArr, 'labels') ?? [];
		$countUsersLabels = (is_array($usersDataArrLabels) && count($usersDataArrLabels) > 1) ? count($usersDataArrLabels) : 0;
	?>
	
	<?php if($countUsersCountries > 1): ?>
		<div class="col-lg-6 col-md-12">
			<div class="card rounded shadow-sm">
				<div class="card-body">
					<div class="d-flex">
						<div>
							<h4 class="card-title mb-1 fw-bold">
								<span class="lstick d-inline-block align-middle"></span><?php echo e(data_get($usersPerCountry, 'title')); ?>

							</h4>
						</div>
						<div class="ms-auto">
						
						</div>
					</div>
					<div class="position-relative chart-responsive">
						<?php if($countUsersLabels > 0): ?>
							<canvas id="pieChartUsers"></canvas>
						<?php else: ?>
							<?php echo trans('admin.No data found'); ?>

						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<?php $__env->startPush('dashboard_styles'); ?>
		<style>
			canvas {
				-moz-user-select: none;
				-webkit-user-select: none;
				-ms-user-select: none;
			}
		</style>
	<?php $__env->stopPush(); ?>
	
	<?php $__env->startPush('dashboard_scripts'); ?>
		<script>
			<?php if($countUsersCountries > 1): ?>
				<?php if($countUsersLabels > 0): ?>
					<?php
						$usersDisplayLegend = ($countUsersLabels <= 15) ? 'true' : 'false';
					?>
					
					var config = {
						type: 'pie', /* pie, doughnut */
						data: <?php echo data_get($usersPerCountry, 'data'); ?>,
						options: {
							responsive: true,
							legend: {
								display: <?php echo e($usersDisplayLegend); ?>,
								position: 'right'
							},
							title: {
								display: false
							},
							animation: {
								animateScale: true,
								animateRotate: true
							}
						}
					};
					
					$(function () {
						var ctx = document.getElementById('pieChartUsers').getContext('2d');
						window.myUsersDoughnut = new Chart(ctx, config);
					});
				<?php endif; ?>
			<?php endif; ?>
		</script>
	<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/dashboard/inc/charts/chartjs/pie/users-per-country.blade.php ENDPATH**/ ?>