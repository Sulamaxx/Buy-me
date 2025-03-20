<div class="col-lg-6 col-md-12">
	<div class="card border-top border-primary shadow-sm">
		<div class="card-body">
			
			<div class="d-md-flex">
				<div>
					<h4 class="card-title fw-bold">
						<span class="lstick d-inline-block align-middle"></span><?php echo e(trans('admin.Reviewed Listings')); ?>

					</h4>
				</div>
				<div class="ms-auto">
					<?php /*?><a href="{{ url('posts/create') }}" target="_blank" class="btn btn-sm btn-light rounded shadow float-start">
						{{ trans('admin.Post New Listing') }}
					</a>
					<a href="{{ admin_url('posts') }}" class="btn btn-sm btn-primary rounded shadow float-end">
						{{ trans('admin.View All Listings') }}
					</a><?php */?>
					<button onclick="exportToExcel('rvad-list')" class="btn btn-sm btn-light rounded shadow float-start">Export to Excel</button>
				</div>
			</div>
			
			<div class="table-responsive mt-md-3 mt-5 no-wrap">
				<table id="rvad-list" class="table v-middle mb-0">
					<thead>
					<tr>
						<th class="border-0"><?php echo e(trans('admin.ID')); ?></th>
						<th class="border-0"><?php echo e(custom_mb_ucfirst(trans('admin.title'))); ?></th>
						<?php /*?><th class="border-0">{{ mb_ucfirst(trans('admin.country')) }}</th><?php */?>
						<th class="border-0"><?php echo e(trans('admin.Status')); ?></th>
						<th class="border-0"><?php echo e(trans('admin.Date')); ?></th>
						<th class="border-0"><?php echo e(trans('admin.revivedusr')); ?></th>
                        <th class="border-0"><?php echo e(trans('admin.revDate')); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php if($revivedPosts->count() > 0): ?>
						<?php $__currentLoopData = $revivedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
							<tr>
								<td class="td-nowrap"><?php echo e($post->id); ?></td>
								<td><?php echo getPostUrl($post); ?>

                                <?php 
//                                    print_r($post);
//                                    exit();
                                    ?>
                                </td>
								<?php /*?><td class="td-nowrap">{!! getCountryFlag($post) !!}</td><?php */?>
								<td class="td-nowrap">
									<?php if(isVerifiedPost($post)): ?>
										<span class="badge bg-success"><?php echo e(trans('admin.Activated')); ?></span>
									<?php else: ?>
										<span class="badge bg-warning text-white"><?php echo e(trans('admin.Unactivated')); ?></span>
									<?php endif; ?>
								</td>
								<td class="td-nowrap">
									<div class="sparkbar" data-color="#00a65a" data-height="20">
										<?php echo e(\App\Helpers\Date::format($post->created_at, 'datetime')); ?>

									</div>
								</td>
                                <td class="td-nowrap"><?php echo e($post->name); ?></td>
                                <td class="td-nowrap"><?php echo e($post->reviewed_at); ?></td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<tr>
							<td colspan="5">
								<?php echo e(trans('admin.No listings found')); ?>

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
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/dashboard/inc/reviewed-posts.blade.php ENDPATH**/ ?>