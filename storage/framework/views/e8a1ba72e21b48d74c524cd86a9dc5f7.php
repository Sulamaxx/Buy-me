<div class="col-lg-6 col-md-12">
	<div class="card border-top border-primary shadow-sm">
		<div class="card-body">
			
			<div class="d-md-flex">
				<div>
					<h4 class="card-title fw-bold">
						<span class="lstick d-inline-block align-middle"></span><?php echo e(trans('admin.Latest Users')); ?>

					</h4>
				</div>
				<div class="ms-auto">
					<a href="<?php echo e(admin_url('users')); ?>" class="btn btn-sm btn-primary rounded shadow float-end">
						<?php echo e(trans('admin.View All Users')); ?>

					</a>
					<button onclick="exportToExcel('ad-list')" class="btn btn-sm btn-light rounded shadow float-start">Export to Excel</button>
				</div>
			</div>
			
			<div class="table-responsive mt-md-3 mt-5 no-wrap">
				<table id="user-list" class="table v-middle mb-0">
					<thead>
					<tr>
						<th class="border-0"><?php echo e(trans('admin.ID')); ?></th>
						<th class="border-0"><?php echo e(trans('admin.Name')); ?></th>
						<th class="border-0"><?php echo e(custom_mb_ucfirst(trans('admin.country'))); ?></th>
						<th class="border-0"><?php echo e(trans('admin.Status')); ?></th>
						<th class="border-0"><?php echo e(trans('admin.Date')); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php if($latestUsers->count() > 0): ?>
						<?php $__currentLoopData = $latestUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td class="td-nowrap"><a href="<?php echo e(admin_url('users/' . $user->id . '/edit')); ?>"><?php echo e($user->id); ?></a></td>
								<td>
									<?php
										$url = admin_url('users/' . $user->id . '/edit');
										echo linkStrLimit($url, $user->name, 35);
									?>
								</td>
								<td class="td-nowrap"><?php echo getCountryFlag($user); ?></td>
								<td class="td-nowrap">
									<?php if(isVerifiedUser($user)): ?>
										<span class="badge bg-success"><?php echo e(trans('admin.Activated')); ?></span>
									<?php else: ?>
										<span class="badge bg-warning text-white"><?php echo e(trans('admin.Unactivated')); ?></span>
									<?php endif; ?>
								</td>
								<td class="td-nowrap">
									<div class="sparkbar" data-color="#00a65a" data-height="20">
										<?php echo e(\App\Helpers\Date::format($user->created_at, 'datetime')); ?>

									</div>
								</td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<tr>
							<td colspan="5">
								<?php echo e(trans('admin.No users found')); ?>

							</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>

<?php $__env->startPush('dashboard_styles'); ?>
	<style>
		.td-nowrap {
			width: 10px;
			white-space: nowrap;
		}
	</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('dashboard_scripts'); ?>
<script>
    function exportToExcel(tableId) {
        var table = document.getElementById(tableId);
        var html = table.outerHTML;

        // Generate a download link
        var blob = new Blob([html], { type: 'application/vnd.ms-excel' });
        var a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'table_data.xls';
        a.click();
    }
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/dashboard/inc/latest-users.blade.php ENDPATH**/ ?>