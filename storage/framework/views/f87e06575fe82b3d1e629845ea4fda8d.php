<script>
	
	var siteUrl = '<?php echo e(url('/')); ?>';
	var languageCode = '<?php echo e(config('app.locale')); ?>';
	var isLogged = <?php echo e((auth()->check()) ? 'true' : 'false'); ?>;
	var isLoggedAdmin = <?php echo e((auth()->check() && auth()->user()->can(\App\Models\Permission::getStaffPermissions())) ? 'true' : 'false'); ?>;
	var isAdminPanel = <?php echo e(isAdminPanel() ? 'true' : 'false'); ?>;
	var demoMode = <?php echo e(isDemoDomain() ? 'true' : 'false'); ?>;
	var demoMessage = '<?php echo e(addcslashes(t('demo_mode_message'), "'")); ?>';
	
	
	var cookieParams = {
		expires: <?php echo e((int)config('settings.other.cookie_expiration')); ?>,
		path: "<?php echo e(config('session.path')); ?>",
		domain: "<?php echo e(!empty(config('session.domain')) ? config('session.domain') : getCookieDomain()); ?>",
		secure: <?php echo e(config('session.secure') ? 'true' : 'false'); ?>,
		sameSite: "<?php echo e(config('session.same_site')); ?>"
	};
	
	
	var langLayout = {
		'confirm': {
			'button': {
				'yes': "<?php echo e(t('confirm_button_yes')); ?>",
				'no': "<?php echo e(t('confirm_button_no')); ?>",
				'ok': "<?php echo e(t('confirm_button_ok')); ?>",
				'cancel': "<?php echo e(t('confirm_button_cancel')); ?>"
			},
			'message': {
				'question': "<?php echo e(t('confirm_message_question')); ?>",
				'success': "<?php echo e(t('confirm_message_success')); ?>",
				'error': "<?php echo e(t('confirm_message_error')); ?>",
				'errorAbort': "<?php echo e(t('confirm_message_error_abort')); ?>",
				'cancel': "<?php echo e(t('confirm_message_cancel')); ?>"
			}
		}
	};
</script><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/common/js/init.blade.php ENDPATH**/ ?>