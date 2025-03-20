


<?php $__env->startSection('wizard'); ?>
    <?php echo $__env->first([
		config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard',
		'post.createOrEdit.multiSteps.inc.wizard'
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php
	$picturesLimit ??= 0;
	$picturesLimit = is_numeric($picturesLimit) ? $picturesLimit : 0;
	$picturesLimit = ($picturesLimit > 0) ? $picturesLimit : 1;
	
	// Get the listing pictures (by applying the picture limit)
	$pictures = $picturesInput ?? [];
	$pictures = collect($pictures)->slice(0, $picturesLimit)->all();
	
	$fiTheme = config('larapen.core.fileinput.theme', 'bs5');
?>
<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-container">
        <div class="container">
            <div class="row">
    
                <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.inc.notification', 'post.inc.notification'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
                <div class="col-md-12 page-content">
                    <div class="inner-box">
						
                        <h2 class="title-2">
							<strong><i class="fas fa-camera"></i> <?php echo e(t('Photos')); ?></strong>
						</h2>
						
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-horizontal"
                                      id="payableForm"
                                      method="POST"
                                      action="<?php echo e(request()->fullUrl()); ?>"
                                      enctype="multipart/form-data"
                                      onsubmit="actionButton.disabled = true; return true;"
                                >
                                    <?php echo csrf_field(); ?>

                                    <fieldset>
                                        <?php if($picturesLimit > 0): ?>
											
											<?php $picturesError = (isset($errors) && $errors->has('pictures')) ? ' is-invalid' : ''; ?>
                                            <div id="picturesBloc" class="input-group row">
												<div class="col-md-3 form-label<?php echo e($picturesError); ?>"> <?php echo e(t('pictures')); ?> </div>
												<div class="col-md-8"></div>
												<div class="col-md-12 text-center pt-2" style="position: relative; float: <?php echo (config('lang.direction')=='rtl') ? 'left' : 'right'; ?>;">
													<div <?php echo (config('lang.direction')=='rtl') ? 'dir="rtl"' : ''; ?> class="file-loading">
														<input id="pictureField" name="pictures[]" type="file" multiple class="file picimg<?php echo e($picturesError); ?>">
													</div>
													<div class="form-text text-muted">
														<?php echo e(t('add_up_to_x_pictures_text', ['pictures_number' => $picturesLimit])); ?>

													</div>
												</div>
                                            </div>
                                        <?php endif; ?>
                                        <div id="uploadError" class="mt-2" style="display: none;"></div>
                                        <div id="uploadSuccess" class="alert alert-success fade show mt-2" style="display: none;"></div>
										
										
                                        <div class="input-group row mt-4">
                                            <div class="col-md-12 text-center">
												<a href="<?php echo e(url('posts/create')); ?>" class="btn btn-default btn-lg"><?php echo e(t('Previous')); ?></a>
												<button id="nextStepBtn" name="actionButton" class="btn btn-primary btn-lg">
													<?php echo e($nextStepLabel ?? t('Next')); ?>

												</button>
                                            </div>
                                        </div>
                                    	
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
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

<?php
	/* Get Upload URL */
	$uploadUrl = url('posts/create/photos');
	$uploadUrl = qsUrl($uploadUrl, request()->only(['package']), null, false);
?>

<?php $__env->startSection('after_scripts'); ?>
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('common/js/fileinput/locales/' . config('app.locale') . '.js')); ?>" type="text/javascript"></script>
    <script>
		let options = {};
		options.theme = '<?php echo e($fiTheme); ?>';
		options.language = '<?php echo e(config('app.locale')); ?>';
		options.rtl = <?php echo e((config('lang.direction') == 'rtl') ? 'true' : 'false'); ?>;
		options.overwriteInitial = false;
		options.showCaption = false;
		options.showPreview = true;
		options.allowedFileExtensions = <?php echo getUploadFileTypes('image', true); ?>;
		options.uploadUrl = '<?php echo e($uploadUrl); ?>';
		options.uploadAsync = false;
		options.showCancel = false;
		options.showUpload = false;
		options.showRemove = false;
		options.showBrowse = true;
		options.browseClass = 'btn btn-primary';
		options.minFileSize = <?php echo e((int)config('settings.upload.min_image_size', 0)); ?>;
		options.maxFileSize = <?php echo e((int)config('settings.upload.max_image_size', 1000)); ?>;
		options.browseOnZoneClick = true;
		options.minFileCount = 0;
		options.maxFileCount = <?php echo e($picturesLimit); ?>;
		options.validateInitialCount = true;
		options.initialPreview = [];
		options.initialPreviewAsData = true;
		options.initialPreviewFileType = 'image';
		options.initialPreviewConfig = [];
		options.fileActionSettings = {
			showRotate: false,
			showUpload: false,
			showDrag: true,
			showRemove: true,
			removeClass: 'btn btn-outline-danger btn-sm',
			showZoom: true,
			zoomClass: 'btn btn-outline-secondary btn-sm',
		};
		options.elErrorContainer = '#uploadError';
		options.msgErrorClass = 'alert alert-block alert-danger';
		
		<?php if(!empty($pictures)): ?>
			<?php $__currentLoopData = $pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(empty($filePath)) continue; ?>
				<?php
					$pictureUrl = imgUrl($filePath, 'medium');
					$deleteUrl = url('posts/create/photos/' . $idx . '/delete');
					try {
						$fileExists = (isset($disk) && !empty($filePath) && $disk->exists($filePath));
						$fileSize = $fileExists ? (int)$disk->size($filePath) : 0;
					} catch (\Throwable $e) {
						$fileSize = 0;
					}
				?>
				options.initialPreview[<?php echo e($idx); ?>] = '<?php echo e($pictureUrl); ?>';
				options.initialPreviewConfig[<?php echo e($idx); ?>] = {};
				options.initialPreviewConfig[<?php echo e($idx); ?>].key = <?php echo e((int)$idx); ?>;
				options.initialPreviewConfig[<?php echo e($idx); ?>].caption = '<?php echo e(basename($filePath)); ?>';
				options.initialPreviewConfig[<?php echo e($idx); ?>].size = <?php echo e($fileSize); ?>;
				options.initialPreviewConfig[<?php echo e($idx); ?>].url = '<?php echo e($deleteUrl); ?>';
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
		
		
		let pictureFieldEl = $('#pictureField');
        pictureFieldEl.fileinput(options);
		
		/* Show the upload status message */
		pictureFieldEl.on('filebatchpreupload', function(event, data) {
			$('#uploadSuccess').html('<ul></ul>').hide();
		});
		
		/* Auto-upload files */
		pictureFieldEl.on('filebatchselected', function(event, files) {
			$(this).fileinput('upload');
		});
		
		/* Show the upload success message */
		pictureFieldEl.on('filebatchuploadsuccess', function(event, data) {
			/* Show uploads success messages */
			let out = '';
			$.each(data.files, function(key, file) {
				if (typeof file !== 'undefined') {
					let fname = file.name;
					out = out + <?php echo t('fileinput_file_uploaded_successfully'); ?>;
				}
			});
			let uploadSuccessEl = $('#uploadSuccess');
			uploadSuccessEl.find('ul').append(out);
			uploadSuccessEl.fadeIn('slow');
			
			/* Change button label */
			$('#nextStepAction').html('<?php echo e($nextStepLabel); ?>').removeClass('btn-default').addClass('btn-primary');
		});
		
		/* Show upload error message */
		pictureFieldEl.on('filebatchuploaderror', function(event, data, msg) {
			showErrorMessage(msg);
		});
		
		/* Before deletion */
        pictureFieldEl.on('filepredelete', function(jqXHR) {
            let abort = true;
            if (confirm("<?php echo e(t('Are you sure you want to delete this picture')); ?>")) {
                abort = false;
            }
            return abort;
        });
		
		/* Show the deletion success message */
		pictureFieldEl.on('filedeleted', function(event, key, jqXHR, data) {
			/* Check local vars */
			if (typeof jqXHR.responseJSON === 'undefined') {
				return false;
			}
			
			let obj = jqXHR.responseJSON;
			if (typeof obj.status === 'undefined' || typeof obj.message === 'undefined') {
				return false;
			}
			
			/* Deletion Notification */
			if (parseInt(obj.status) === 1) {
				showSuccessMessage(obj.message);
			} else {
				showErrorMessage(obj.message);
			}
		});
		
		/* Show deletion error message */
		pictureFieldEl.on('filedeleteerror', function(event, data, msg) {
			showErrorMessage(msg);
		});
		
		/* Reorder (Sort) files */
		pictureFieldEl.on('filesorted', function(event, params) {
			reorderPictures(params);
		});
		
		/**
		 * Reorder (Sort) pictures
		 * @param params
		 * @returns {boolean}
		 */
		function reorderPictures(params)
		{
			if (typeof params.stack === 'undefined') {
				return false;
			}
			
			waitingDialog.show('<?php echo e(t('Processing')); ?>...');
			
			let ajax = $.ajax({
				method: 'POST',
				url: siteUrl + '/posts/create/photos/reorder',
				data: {
					'params': params,
					'_token': $('input[name=_token]').val()
				}
			});
			ajax.done(function(data) {
		
				setTimeout(function() {
					waitingDialog.hide();
				}, 250);
		
				if (typeof data.status === 'undefined') {
					return false;
				}
				
				/* Reorder Notification */
				if (parseInt(data.status) === 1) {
					showSuccessMessage(data.message);
				} else {
					showErrorMessage(data.message);
				}
				
				return false;
			});
			ajax.fail(function (xhr, textStatus, errorThrown) {
				let message = getJqueryAjaxError(xhr);
				if (message !== null) {
					showErrorMessage(message);
				}
			});
			
			return false;
		}
		
		/**
		 * Show Success Message
		 * @param message
		 */
		function showSuccessMessage(message)
		{
			let errorEl = $('#uploadError');
			let successEl = $('#uploadSuccess');
			
			errorEl.hide().empty();
			errorEl.removeClass('alert alert-block alert-danger');
			
			successEl.html('<ul></ul>').hide();
			successEl.find('ul').append(message);
			successEl.fadeIn('slow');
		}
		
		/**
		 * Show Errors Message
		 * @param message
		 */
		function showErrorMessage(message)
		{
			jsAlert(message, 'error', false);
			
			let errorEl = $('#uploadError');
			let successEl = $('#uploadSuccess');
			
			/* Error Notification */
			successEl.empty().hide();
			
			errorEl.html('<ul></ul>').hide();
			errorEl.addClass('alert alert-block alert-danger');
			errorEl.find('ul').append(message);
			errorEl.fadeIn('slow');
		}
        
        $(document).ready(function(){
  const box = document.getElementsByClassName('fileinput-remove')[0];
        box.style.visibility = 'hidden';
});
        
    </script>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/post/createOrEdit/multiSteps/photos/create.blade.php ENDPATH**/ ?>