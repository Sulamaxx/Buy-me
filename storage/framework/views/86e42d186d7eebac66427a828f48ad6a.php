<?php
	$enabled ??= false;
	$nameFieldName ??= '';
	$validFromFieldName ??= '';
	$encryptedValidFrom ??= '';
?>
<?php if($enabled): ?>
	<div class="form-group mb-3 required" style="display: none" aria-hidden="true">
		<input id="<?php echo e($nameFieldName); ?>"
		       name="<?php echo e($nameFieldName); ?>"
		       type="text"
		       value=""
		       autocomplete="nope"
		       tabindex="-1"
		>
		<input name="<?php echo e($validFromFieldName); ?>"
		       type="text"
		       value="<?php echo e($encryptedValidFrom); ?>"
		       autocomplete="off"
		       tabindex="-1"
		>
	</div>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\packages\larapen\honeypot\src/resources/views/honeypot.blade.php ENDPATH**/ ?>