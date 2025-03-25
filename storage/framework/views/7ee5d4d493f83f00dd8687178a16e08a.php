<div data-preview="#<?php echo e($field['name']); ?>"
	data-aspectRatio="<?php echo e($field['aspect_ratio'] ?? 0); ?>"
	data-crop="<?php echo e($field['crop'] ?? false); ?>"
	<?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
>
	<div class="col-12 text-center p-2 border border-1 border-light rounded-2" style="height: 100%;">
		
		<div class="text-start">
			<label class="form-label fw-bolder"><?php echo $field['label']; ?></label>
			<?php echo $__env->make('admin.panel.fields.inc.translatable_icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		
		<div class="row d-flex justify-content-center mt-3 mb-3">
			<div class="col-sm-6 text-center">
				<?php
				$prefix = $field['prefix'] ?? '';
				$fileUrl = (isset($field['value']) && is_string($field['value']))
					? \Storage::disk($field['disk'])->url($field['value'])
					: ($field['default'] ?? \Storage::disk($field['disk'])->url(config('larapen.core.picture.default')));
				$fileUrl = $prefix . old($field['name'], $fileUrl);
				?>
				<img id="mainImage" class="rounded" src="<?php echo e(url($fileUrl)); ?>">
			</div>
			<?php if(isset($field['crop']) && $field['crop']): ?>
				<div class="col-sm-3 text-center">
					<div class="docs-preview clearfix">
						<div id="<?php echo e($field['name']); ?>" class="img-preview preview-lg">
							<img src=""
								 style="display: block; min-width: 0 !important; min-height: 0 !important; max-width: none !important; max-height: none !important; margin-left: -32.875px; margin-top: -18.4922px; transform: none;"
							>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
		
		<div class="btn-group">
			<label class="btn btn-primary btn-file mb-0">
				<?php echo e(trans('admin.choose_file')); ?> <input type="file" accept="image/*" id="uploadImage"  <?php echo $__env->make('admin.panel.inc.field_attributes', ['default_class' => 'hide'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>>
				<input type="hidden" id="hiddenImage" name="<?php echo e($field['name']); ?>">
			</label>
			<?php if(isset($field['crop']) && $field['crop']): ?>
				<button class="btn btn-secondary" id="rotateLeft" type="button" style="display: none;"><i class="fa fa-rotate-left"></i></button>
				<button class="btn btn-secondary" id="rotateRight" type="button" style="display: none;"><i class="fa fa-rotate-right"></i></button>
				<button class="btn btn-secondary" id="zoomIn" type="button" style="display: none;"><i class="fa fa-search-plus"></i></button>
				<button class="btn btn-secondary" id="zoomOut" type="button" style="display: none;"><i class="fa fa-search-minus"></i></button>
				<button class="btn btn-warning" id="reset" type="button" style="display: none;"><i class="fa fa-times"></i></button>
			<?php endif; ?>
			<button class="btn btn-danger" id="remove" type="button"><i class="fa fa-trash"></i></button>
		</div>
		
		
		<?php if(isset($field['hint'])): ?>
			<br>
			<div class="form-text"><?php echo $field['hint']; ?></div>
		<?php endif; ?>
		
	</div>
</div>





<?php if($xPanel->checkIfFieldIsFirstOfItsType($field, $fields)): ?>
    
    
    <?php $__env->startPush('crud_fields_styles'); ?>
    
    <link href="<?php echo e(asset('assets/plugins/cropper/dist/cropper.min.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        .hide {
            display: none;
        }
        .image .btn-group {
            margin-top: 10px;
        }
        img {
            max-width: 100%; /* This rule is very important, please do not ignore this! */
        }
        .img-container, .img-preview {
            width: 100%;
            text-align: center;
        }
        .img-preview {
            float: left;
            margin-right: 10px;
            margin-bottom: 10px;
            overflow: hidden;
        }
        .preview-lg {
            width: 263px;
            height: 148px;
        }
        
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
    </style>
    <?php $__env->stopPush(); ?>
    
    
    <?php $__env->startPush('crud_fields_scripts'); ?>
    
    <script src="<?php echo e(asset('assets/plugins/cropper/dist/cropper.min.js')); ?>"></script>
    <script>
		jQuery(document).ready(function($) {
			// Loop through all instances of the image field
			$('form div.image').each(function(index){
				// Find DOM elements under this form-group element
				var $mainImage = $(this).find('#mainImage');
				var $uploadImage = $(this).find("#uploadImage");
				var $hiddenImage = $(this).find("#hiddenImage");
				var $rotateLeft = $(this).find("#rotateLeft")
				var $rotateRight = $(this).find("#rotateRight")
				var $zoomIn = $(this).find("#zoomIn")
				var $zoomOut = $(this).find("#zoomOut")
				var $reset = $(this).find("#reset")
				var $remove = $(this).find("#remove")
				// Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
				var options = {
					viewMode: 2,
					checkOrientation: false,
					autoCropArea: 1,
					responsive: true,
					preview : $(this).attr('data-preview'),
					aspectRatio : $(this).attr('data-aspectRatio')
				};
				var crop = $(this).attr('data-crop');
				
				// Hide 'Remove' button if there is no image saved
				if (!$mainImage.attr('src')){
					$remove.hide();
				}
				// Initialise hidden form input in case we submit with no change
				$hiddenImage.val($mainImage.attr('src'));
				
				
				// Only initialize cropper plugin if crop is set to true
				if(crop){
					
					$remove.click(function() {
						$mainImage.cropper("destroy");
						$mainImage.attr('src','');
						$hiddenImage.val('');
						$rotateLeft.hide();
						$rotateRight.hide();
						$zoomIn.hide();
						$zoomOut.hide();
						$reset.hide();
						$remove.hide();
					});
				} else {
					
					$(this).find("#remove").click(function() {
						$mainImage.attr('src','');
						$hiddenImage.val('');
						$remove.hide();
					});
				}
				
				$uploadImage.change(function() {
					var fileReader = new FileReader(),
						files = this.files,
						file;
					
					if (!files.length) {
						return;
					}
					file = files[0];
					
					if (/^image\/\w+$/.test(file.type)) {
						fileReader.readAsDataURL(file);
						fileReader.onload = function () {
							$uploadImage.val("");
							if(crop){
								$mainImage.cropper(options).cropper("reset", true).cropper("replace", this.result);
								// Override form submit to copy canvas to hidden input before submitting
								$('form').submit(function() {
									var imageURL = $mainImage.cropper('getCroppedCanvas').toDataURL(file.type);
									$hiddenImage.val(imageURL);
									return true; // return false to cancel form action
								});
								$rotateLeft.click(function() {
									$mainImage.cropper("rotate", 90);
								});
								$rotateRight.click(function() {
									$mainImage.cropper("rotate", -90);
								});
								$zoomIn.click(function() {
									$mainImage.cropper("zoom", 0.1);
								});
								$zoomOut.click(function() {
									$mainImage.cropper("zoom", -0.1);
								});
								$reset.click(function() {
									$mainImage.cropper("reset");
								});
								$rotateLeft.show();
								$rotateRight.show();
								$zoomIn.show();
								$zoomOut.show();
								$reset.show();
								$remove.show();
								
							} else {
								$mainImage.attr('src',this.result);
								$hiddenImage.val(this.result);
								$remove.show();
							}
						};
					} else {
						alert("Please choose an image file.");
					}
				});
				
			});
		});
    </script>
    
    
    <?php $__env->stopPush(); ?>
<?php endif; ?>


<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/fields/image.blade.php ENDPATH**/ ?>