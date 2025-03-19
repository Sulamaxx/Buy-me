<?php
	$post ??= [];
	$fiTheme = config('larapen.core.fileinput.theme', 'bs5');
?>
<div class="modal fade" id="contactUser" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h4 class="modal-title">
					<i class="fas fa-envelope"></i> <?php echo e(t('contact_advertiser')); ?>

				</h4>
				
				<button type="button" class="close" data-bs-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<form role="form"
			      method="POST"
			      action="<?php echo e(url('account/messages/posts/' . data_get($post, 'id'))); ?>"
			      enctype="multipart/form-data"
			>
				<?php echo csrf_field(); ?>

				<?php echo view('honeypot::honeypot'); ?>
				<div class="modal-body">

					<?php if(isset($errors) && $errors->any() && old('messageForm')=='1'): ?>
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
							<ul class="list list-check">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo e($error); ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					<?php endif; ?>
					
					<?php
						$authUser = auth()->check() ? auth()->user() : null;
						$isNameCanBeHidden = (!empty($authUser));
						$isEmailCanBeHidden = (!empty($authUser) && !empty($authUser->email));
						$isPhoneCanBeHidden = (!empty($authUser) && !empty($authUser->phone));
						$authFieldValue = data_get($post, 'auth_field', getAuthField());
					?>
					
					
					<?php if($isNameCanBeHidden): ?>
						<input type="hidden" name="name" value="<?php echo e($authUser->name ?? null); ?>">
					<?php else: ?>
						<?php
							$fromNameError = (isset($errors) && $errors->has('name')) ? ' is-invalid' : '';
						?>
						<div class="mb-3 required">
							<label class="control-label" for="name"><?php echo e(t('Name')); ?> <sup>*</sup></label>
							<div class="input-group">
								<input id="fromName" name="name"
									   type="text"
									   class="form-control<?php echo e($fromNameError); ?>"
									   placeholder="<?php echo e(t('your_name')); ?>"
									   value="<?php echo e(old('name', $authUser->name ?? null)); ?>"
								>
							</div>
						</div>
					<?php endif; ?>
					
					
					<?php if($isEmailCanBeHidden): ?>
						<input type="hidden" name="email" value="<?php echo e($authUser->email ?? null); ?>">
					<?php else: ?>
						<?php
							$fromEmailError = (isset($errors) && $errors->has('email')) ? ' is-invalid' : '';
						?>
						<div class="mb-3 required">
							<label class="control-label" for="email"><?php echo e(t('E-mail')); ?>

								<?php if($authFieldValue == 'email'): ?>
									<sup>*</sup>
								<?php endif; ?>
							</label>
							<div class="input-group">
								<span class="input-group-text"><i class="far fa-envelope"></i></span>
								<input id="fromEmail" name="email"
									   type="text"
									   class="form-control<?php echo e($fromEmailError); ?>"
									   placeholder="<?php echo e(t('eg_email')); ?>"
									   value="<?php echo e(old('email', $authUser->email ?? null)); ?>"
								>
							</div>
						</div>
					<?php endif; ?>
					
					
					<?php if($isPhoneCanBeHidden): ?>
						<input type="hidden" name="phone" value="<?php echo e($authUser->phone ?? null); ?>">
						<input name="phone_country" type="hidden" value="<?php echo e($authUser->phone_country ?? config('country.code')); ?>">
					<?php else: ?>
						<?php
							$fromPhoneError = (isset($errors) && $errors->has('phone')) ? ' is-invalid' : '';
							$phoneValue = $authUser->phone ?? null;
							$phoneCountryValue = $authUser->phone_country ?? config('country.code');
							$phoneValue = phoneE164($phoneValue, $phoneCountryValue);
							$phoneValueOld = phoneE164(old('phone', $phoneValue), old('phone_country', $phoneCountryValue));
						?>
						<div class="mb-3 required">
							<label class="control-label" for="phone"><?php echo e(t('phone_number')); ?>

								<?php if($authFieldValue == 'phone'): ?>
									<sup>*</sup>
								<?php endif; ?>
							</label>
							<input id="fromPhone" name="phone"
								   type="tel"
								   maxlength="60"
								   class="form-control m-phone<?php echo e($fromPhoneError); ?>"
								   placeholder="<?php echo e(t('phone_number')); ?>"
								   value="<?php echo e($phoneValueOld); ?>"
							>
							<input name="phone_country" type="hidden" value="<?php echo e(old('phone_country', $phoneCountryValue)); ?>">
						</div>
					<?php endif; ?>
					
					
					<input name="auth_field" type="hidden" value="<?php echo e($authFieldValue); ?>">
					
					
					<?php $bodyError = (isset($errors) && $errors->has('body')) ? ' is-invalid' : ''; ?>
					<div class="mb-3 required">
						<label class="control-label" for="body">
							<?php echo e(t('Message')); ?> <span class="text-count">(500 max)</span> <sup>*</sup>
						</label>
						<textarea id="body" name="body"
							rows="5"
							class="form-control required<?php echo e($bodyError); ?>"
							style="height: 150px;"
							placeholder="<?php echo e(t('your_message_here')); ?>"
						><?php echo e(old('body', t('is_still_available', ['name' => data_get($post, 'contact_name', t('sir_miss'))]))); ?></textarea>
					</div>
					<?php
						$catType = data_get($post, 'category.parent.type', data_get($post, 'category.type'));
					?>
					<?php if($catType == 'job-offer'): ?>
						
						<?php $filenameError = (isset($errors) && $errors->has('filename')) ? ' is-invalid' : ''; ?>
						<div class="mb-3 required" <?php echo (config('lang.direction')=='rtl') ? 'dir="rtl"' : ''; ?>>
							<label class="control-label<?php echo e($filenameError); ?>" for="filename"><?php echo e(t('Resume')); ?> </label>
							<input id="filename" name="filename" type="file" class="file<?php echo e($filenameError); ?>">
							<div class="form-text text-muted">
								<?php echo e(t('file_types', ['file_types' => showValidFileTypes('file')])); ?>

							</div>
						</div>
						<input type="hidden" name="catType" value="<?php echo e($catType); ?>">
					<?php endif; ?>
					
					<?php echo $__env->make('layouts.inc.tools.captcha', ['label' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					
					<input type="hidden" name="country_code" value="<?php echo e(config('country.code')); ?>">
					<input type="hidden" name="post_id" value="<?php echo e(data_get($post, 'id')); ?>">
					<input type="hidden" name="messageForm" value="1">
				</div>
				
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary float-end"><?php echo e(t('send_message')); ?></button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo e(t('Cancel')); ?></button>
				</div>
			</form>
			
		</div>
	</div>
</div>
<?php $__env->startSection('after_styles'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_styles'); ?>
	<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css')); ?>" rel="stylesheet">
	<?php if(config('lang.direction') == 'rtl'): ?>
		<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css')); ?>" rel="stylesheet">
	<?php endif; ?>
	<?php if(str_starts_with($fiTheme, 'explorer')): ?>
		<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.min.css')); ?>" rel="stylesheet">
	<?php endif; ?>
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
		.file-loading:before {
			content: " <?php echo e(t('loading_wd')); ?>";
		}
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('common/js/fileinput/locales/' . config('app.locale') . '.js')); ?>" type="text/javascript"></script>

	<script>
		<?php if(auth()->check()): ?>
			phoneCountry = '<?php echo e(old('phone_country', ($phoneCountryValue ?? ''))); ?>';
		<?php endif; ?>
		
		let options = {};
		options.theme = '<?php echo e($fiTheme); ?>';
		options.language = '<?php echo e(config('app.locale')); ?>';
		options.rtl = <?php echo e((config('lang.direction') == 'rtl') ? 'true' : 'false'); ?>;
		options.allowedFileExtensions = <?php echo getUploadFileTypes('file', true); ?>;
		options.minFileSize = <?php echo e((int)config('settings.upload.min_file_size', 0)); ?>;
		options.maxFileSize = <?php echo e((int)config('settings.upload.max_file_size', 1000)); ?>;
		options.showPreview = false;
		options.showUpload = false;
		options.showRemove = false;
		
		
		$('#filename').fileinput(options);
		
		$(document).ready(function () {
			<?php if($errors->any()): ?>
				<?php if($errors->any() && old('messageForm')=='1'): ?>
					
					let quickLogin = new bootstrap.Modal(document.getElementById('contactUser'), {});
					quickLogin.show();
				<?php endif; ?>
			<?php endif; ?>
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/account/messenger/modal/create.blade.php ENDPATH**/ ?>