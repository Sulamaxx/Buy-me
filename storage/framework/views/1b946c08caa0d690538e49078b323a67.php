

<script type="text/javascript">
	jQuery(document).ready(function ($) {
		
		PNotify.defaultModules.set(PNotifyBootstrap4, {});
		PNotify.defaultModules.set(PNotifyFontAwesome5Fix, {});
		PNotify.defaultModules.set(PNotifyFontAwesome5, {});
		
		<?php $__currentLoopData = Alert::getMessages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $messages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				
				<?php
					$message = addcslashesLite($message);
				?>
				
				$(function () {
					let alertMessage = "<?php echo $message; ?>";
					let alertType = "<?php echo e($type); ?>";
					
					<?php if($message == t('demo_mode_message')): ?>
						pnAlertForPrologue(alertType, alertMessage, 'Information');
					<?php else: ?>
						pnAlertForPrologue(alertType, alertMessage);
					<?php endif; ?>
				});
				
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		
		/**
		 * Show a PNotify alert (Using the Stack feature)
		 * @param type
		 * @param message
		 * @param title
		 */
		function pnAlertForPrologue(type, message, title = '') {
			if (typeof window.stackTopRight === 'undefined') {
				window.stackTopRight = new PNotify.Stack({
					dir1: 'down',
					dir2: 'left',
					firstpos1: 25,
					firstpos2: 25,
					spacing1: 10,
					spacing2: 25,
					modal: false,
					maxOpen: Infinity
				});
			}
			let alertParams = {
				text: message,
				textTrusted: true,
				type: 'info',
				icon: false,
				stack: window.stackTopRight
			};
			switch (type) {
				case 'error':
					alertParams.type = 'error';
					break;
				case 'warning':
					alertParams.type = 'notice';
					break;
				case 'notice':
					alertParams.type = 'notice';
					break;
				case 'info':
					alertParams.type = 'info';
					break;
				case 'success':
					alertParams.type = 'success';
					break;
			}
			if (typeof title !== 'undefined' && title != '' && title.length !== 0) {
				alertParams.title = title;
				alertParams.icon = true;
			}
			
			PNotify.alert(alertParams);
		}
	});
</script><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/layouts/inc/alerts.blade.php ENDPATH**/ ?>