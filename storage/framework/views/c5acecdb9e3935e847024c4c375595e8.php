<?php
	$captcha = config('settings.security.captcha');
	$isCaptchaEnabled = !empty($captcha);
	
	$label ??= false;
	$noLabel ??= false;
	$colLeft ??= null;
	$colRight ??= null;
?>
<?php if($isCaptchaEnabled): ?>
	<?php
		$params = [];
		if (isset($label) && $label) {
			$params['label'] = $label;
		}
		if (isset($noLabel) && $noLabel) {
			$params['noLabel'] = $noLabel;
		}
		if (!empty($colLeft)) {
			$params['colLeft'] = $colLeft;
		}
		if (!empty($colRight)) {
			$params['colRight'] = $colRight;
		}
	?>
	<?php if($captcha == 'recaptcha'): ?>
		<?php echo $__env->make('layouts.inc.tools.captcha.recaptcha', $params, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
	<?php if(in_array($captcha, ['default', 'math', 'flat', 'mini', 'inverse', 'custom'])): ?>
		<?php echo $__env->make('layouts.inc.tools.captcha.captcha', $params, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/layouts/inc/tools/captcha.blade.php ENDPATH**/ ?>