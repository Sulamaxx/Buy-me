
<td data-order="<?php echo e($entry->{$column['name']}); ?>">
	<?php
	try {
		$dateColumnValue = (new \Illuminate\Support\Carbon($entry->{$column['name']}))->timezone(\App\Helpers\Date::getAppTimeZone());
	} catch (\Throwable $e) {
		$dateColumnValue = new \Illuminate\Support\Carbon($entry->{$column['name']});
	}
	?>
	<?php echo e(\App\Helpers\Date::format($dateColumnValue, 'datetime')); ?>

</td><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/columns/datetime.blade.php ENDPATH**/ ?>