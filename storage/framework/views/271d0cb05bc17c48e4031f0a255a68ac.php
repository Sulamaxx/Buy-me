<?php
	$autoAdvertising ??= [];
?>
<?php if(!empty($autoAdvertising)): ?>
	<div class="row d-flex justify-content-center m-0 p-0">
		<div class="col-12 text-center m-0 p-0">
			<?php echo data_get($autoAdvertising, 'tracking_code_large'); ?>

		</div>
	</div>
<?php endif; ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/layouts/inc/advertising/auto.blade.php ENDPATH**/ ?>