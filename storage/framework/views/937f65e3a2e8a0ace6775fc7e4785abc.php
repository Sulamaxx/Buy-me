<?php
	$commentsAreDisabledByUser ??= false;
	$areCommentsActivated = (
		config('settings.single.activation_facebook_comments')
		&& config('services.facebook.client_id')
		&& !$commentsAreDisabledByUser
	);
	$fbClientId = config('services.facebook.client_id');
	$locale = config('lang.iso_locale', 'en_US');
?>
<?php if($areCommentsActivated): ?>
	<div class="container">
		<div id="fb-root"></div>
		<script>
			(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/<?php echo e($locale); ?>/sdk.js#xfbml=1&version=v2.5&appId=<?php echo e($fbClientId); ?>";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<div class="fb-comments" data-href="<?php echo e(request()->url()); ?>" data-width="100%" data-numposts="5"></div>
	</div>
<?php endif; ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/layouts/inc/tools/facebook-comments.blade.php ENDPATH**/ ?>