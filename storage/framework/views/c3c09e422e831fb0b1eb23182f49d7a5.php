<?php
	$postInput ??= [];
	$post ??= [];
	$admin ??= [];
	
	$isMultiStepsForm = (config('settings.single.publication_form_type') == '1');
	$isSingleStepForm = (config('settings.single.publication_form_type') == '2');
	
	$isSingleStepCreateForm = ($isSingleStepForm && request()->segment(1) == 'create');
	$isSingleStepEditForm = ($isSingleStepForm && request()->segment(1) == 'edit');
	
	$picturesLimit ??= 0;
	$picturesLimit = is_numeric($picturesLimit) ? $picturesLimit : 0;
	$picturesLimit = ($picturesLimit > 0) ? $picturesLimit : 1;
	
	$pictures = [];
	if ($isSingleStepEditForm) {
		$pictures = data_get($post, 'pictures', []);
		$pictures = collect($pictures)->slice(0, (int)$picturesLimit)->all();
	}
	
	$postId = data_get($post, 'id') ?? '';
	$postTypeId = data_get($post, 'post_type_id') ?? data_get($postInput, 'post_type_id', 0);
	$countryCode = data_get($post, 'country_code') ?? data_get($postInput, 'country_code', config('country.code', 0));
	
	$adminType = config('country.admin_type', 0);
	$selectedAdminCode = data_get($admin, 'code') ?? data_get($postInput, 'admin_code', 0);
	$cityId = (int)(data_get($post, 'city_id') ?? data_get($postInput, 'city_id', 0));
	
	$fiTheme = config('larapen.core.fileinput.theme', 'bs5');
?>
<?php $__env->startSection('modal_location'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.modal.location', 'layouts.inc.modal.location'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after_styles_stack'); ?>
	<?php echo $__env->make('layouts.inc.tools.wysiwyg.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
	
	<?php if($isSingleStepForm): ?>
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
			/* Preview Frame Size */
			.krajee-default.file-preview-frame .kv-file-content {
				height: auto;
			}
			.krajee-default.file-preview-frame .file-thumbnail-footer {
				height: 30px;
			}
		</style>
	<?php endif; ?>
	
	<link href="<?php echo e(url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('after_scripts_stack'); ?>
	<?php echo $__env->make('layouts.inc.tools.wysiwyg.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
	<?php
		$jqValidateLangFilePath = 'assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js';
	?>
	<?php if(file_exists(public_path() . '/' . $jqValidateLangFilePath)): ?>
		<script src="<?php echo e(url($jqValidateLangFilePath)); ?>" type="text/javascript"></script>
	<?php endif; ?>
	
	
	<?php if($isSingleStepForm): ?>
		<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('common/js/fileinput/locales/' . config('app.locale') . '.js')); ?>" type="text/javascript"></script>
	<?php endif; ?>
	
	<script src="<?php echo e(url('assets/plugins/momentjs/moment.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')); ?>" type="text/javascript"></script>
	
	<script>
		/* Translation */
		var lang = {
			'select': {
				'country': "<?php echo e(t('select_a_country')); ?>",
				'admin': "<?php echo e(t('select_a_location')); ?>",
				'city': "<?php echo e(t('select_a_city')); ?>"
			},
			'price': "<?php echo e(t('price')); ?>",
			'salary': "<?php echo e(t('Salary')); ?>",
			'nextStepBtnLabel': {
				'next': "<?php echo e(t('Next')); ?>",
				'submit': "<?php echo e(t('Update')); ?>"
			}
		};
		
		var stepParam = 0;
		
		/* Category */
		/* Custom Fields */
		var errors = '<?php echo addslashes($errors->toJson()); ?>';
		var oldInput = '<?php echo addslashes(collect(session()->getOldInput('cf', data_get($postInput, 'cf')))->toJson()); ?>';
		var postId = '<?php echo e($postId); ?>';
		
		/* Permanent Posts */
		var permanentPostsEnabled = '<?php echo e(config('settings.single.permanent_listings_enabled', 0)); ?>';
		var postTypeId = '<?php echo e(old('post_type_id', $postTypeId)); ?>';
		
		/* Locations */
		var countryCode = '<?php echo e(old('country_code', $countryCode)); ?>';
		var adminType = '<?php echo e($adminType); ?>';
		var selectedAdminCode = '<?php echo e(old('admin_code', $selectedAdminCode)); ?>';
		var cityId = '<?php echo e(old('city_id', data_get($postInput, 'city_id', $cityId))); ?>';
		
		/* Packages */
		var packageIsEnabled = false;
		<?php if(isset($packages, $paymentMethods) && $packages->count() > 0 && $paymentMethods->count() > 0): ?>
			packageIsEnabled = true;
		<?php endif; ?>
	</script>
	<script>
		
		let options = {};
		options.theme = '<?php echo e($fiTheme); ?>';
		options.language = '<?php echo e(config('app.locale')); ?>';
		options.rtl = <?php echo e((config('lang.direction') == 'rtl') ? 'true' : 'false'); ?>;
		options.dropZoneEnabled = false;
		options.overwriteInitial = true;
		options.showCaption = true;
		options.showPreview = true;
		options.showClose = true;
		options.showUpload = false;
		options.showRemove = false;
		options.previewFileType = 'image';
		options.allowedFileExtensions = <?php echo getUploadFileTypes('image', true); ?>;
		options.minFileSize = <?php echo e((int)config('settings.upload.min_image_size', 0)); ?>;
		options.maxFileSize = <?php echo e((int)config('settings.upload.max_image_size', 1000)); ?>;
		options.initialPreview = [];
		options.initialPreviewConfig = [];
		options.fileActionSettings = {
			showRotate: false,
			showUpload: false,
			showDrag: false,
			showRemove: true,
			removeClass: 'btn btn-outline-danger btn-sm',
			showZoom: true,
			zoomClass: 'btn btn-outline-secondary btn-sm',
		};
		
		
		<?php if($isSingleStepForm): ?>
			<?php if($isSingleStepCreateForm): ?>
				
				
				$('.post-picture').fileinput(options);
			<?php else: ?>
				
				<?php for($i = 0; $i <= $picturesLimit-1; $i++): ?>
					options.initialPreview = [];
					options.initialPreviewConfig = [];
					<?php
						$picture = data_get($pictures, $i);
					?>
					<?php if(!empty($picture)): ?>
						<?php
							$postId = data_get($post, 'id');
							$pictureId = data_get($picture, 'id');
							$pictureUrl = data_get($picture, 'url.medium');
							$filePath = data_get($picture, 'filename');
							$deleteUrl = url('posts/' . $postId . '/photos/' . $pictureId . '/delete');
							try {
								$fileExists = (isset($disk) && !empty($filePath) && $disk->exists($filePath));
								$fileSize = $fileExists ? (int)$disk->size($filePath) : 0;
							} catch (\Throwable $e) {
								$fileSize = 0;
							}
						?>
						options.initialPreview[<?php echo e($i); ?>] = '<img src="<?php echo e($pictureUrl); ?>" class="file-preview-image">';
						options.initialPreviewConfig[<?php echo e($i); ?>] = {};
						options.initialPreviewConfig[<?php echo e($i); ?>].key = <?php echo e((int)($pictureId ?? $i)); ?>;
						options.initialPreviewConfig[<?php echo e($i); ?>].caption = '<?php echo e(basename($filePath)); ?>';
						options.initialPreviewConfig[<?php echo e($i); ?>].size = <?php echo e($fileSize); ?>;
						options.initialPreviewConfig[<?php echo e($i); ?>].url = '<?php echo e($deleteUrl); ?>';
					<?php endif; ?>
					
					
					$('#picture<?php echo e($i); ?>').fileinput(options);
					
					/* Delete picture */
					$('#picture<?php echo e($i); ?>').on('filepredelete', function(event, key, jqXHR, data) {
						let abort = true;
						if (confirm("<?php echo e(t('Are you sure you want to delete this picture')); ?>")) {
							abort = false;
						}
						return abort;
					});
				<?php endfor; ?>
			<?php endif; ?>
		<?php endif; ?>
		
		$(document).ready(function() {
			
			<?php if(config('settings.single.city_selection') == 'select'): ?>
				<?php if($errors->has('admin_code')): ?>
					$('select[name="admin_code"]').closest('div').addClass('is-invalid');
				<?php endif; ?>
			<?php endif; ?>
			<?php if($errors->has('city_id')): ?>
				$('select[name="city_id"]').closest('div').addClass('is-invalid');
			<?php endif; ?>
			
			
			<?php
				$tagsLimit = (int)config('settings.single.tags_limit', 15);
				$tagsMinLength = (int)config('settings.single.tags_min_length', 2);
				$tagsMaxLength = (int)config('settings.single.tags_max_length', 30);
			?>
			let selectTagging = $('.tags-selecter').select2({
				language: langLayout.select2,
				width: '100%',
				tags: true,
				maximumSelectionLength: <?php echo e($tagsLimit); ?>,
				tokenSeparators: [',', ';', ':', '/', '\\', '#'],
				createTag: function (params) {
					var term = $.trim(params.term);
					
					
					let invalidCharsArray = [',', ';', '_', '/', '\\', '#'];
					let arrayLength = invalidCharsArray.length;
					for (let i = 0; i < arrayLength; i++) {
						let invalidChar = invalidCharsArray[i];
						if (term.indexOf(invalidChar) !== -1) {
							return null;
						}
					}
					
					
					
					if (term === '') {
						return null;
					}
					
					
					if (term.length < <?php echo e($tagsMinLength); ?> || term.length > <?php echo e($tagsMaxLength); ?>) {
						return null;
					}
					
					return {
						id: term,
						text: term
					}
				}
			});
			
			
			selectTagging.on('change', function(e) {
				if ($(this).val().length > <?php echo e($tagsLimit); ?>) {
					$(this).val($(this).val().slice(0, <?php echo e($tagsLimit); ?>));
				}
			});
			
			
			<?php if($errors->has('tags.*')): ?>
				$('select[name^="tags"]').next('.select2.select2-container').addClass('is-invalid');
			<?php endif; ?>
		});
	</script>
	
	<script src="<?php echo e(url('assets/js/app/d.modal.category.js') . vTime()); ?>"></script>
	<?php if(config('settings.single.city_selection') == 'select'): ?>
		<script src="<?php echo e(url('assets/js/app/d.select.location.js') . vTime()); ?>"></script>
	<?php else: ?>
		<script src="<?php echo e(url('assets/js/app/browse.locations.js') . vTime()); ?>"></script>
		<script src="<?php echo e(url('assets/js/app/d.modal.location.js') . vTime()); ?>"></script>
	<?php endif; ?>
	
<?php $__env->stopPush(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/post/createOrEdit/inc/form-assets.blade.php ENDPATH**/ ?>