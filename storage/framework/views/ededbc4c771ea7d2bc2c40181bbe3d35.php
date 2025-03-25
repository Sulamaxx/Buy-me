
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> >
	<label class="form-label fw-bolder"><?php echo $field['label']; ?></label>
	<?php echo $__env->make('admin.panel.fields.inc.translatable_icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<select
			name="<?php echo e($field['name']); ?><?php if(isset($field['allows_multiple']) && $field['allows_multiple']==true): ?>[]<?php endif; ?>"
			style="width: 100%"
			<?php echo $__env->make('admin.panel.inc.field_attributes', ['default_class' =>  'form-select select2_from_skins'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php if(isset($field['allows_multiple']) && $field['allows_multiple']==true): ?>multiple <?php endif; ?>
	>
		
		<?php if(isset($field['allows_null']) && $field['allows_null']==true): ?>
			<option value="">-</option>
		<?php endif; ?>
		
		<?php if(isset($field['options']) && !empty($field['options'])): ?>
			<?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($key); ?>"
						<?php if(isset($field['value']) && ($key==$field['value'] || (is_array($field['value']) && in_array($key, $field['value'])))
							|| ( ! is_null( old($field['name']) ) && old($field['name']) == $key)): ?>
						selected
						<?php endif; ?>
				><?php echo $value; ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</select>
	
	
	<?php if(isset($field['hint'])): ?>
		<div class="form-text"><?php echo $field['hint']; ?></div>
	<?php endif; ?>
</div>




<?php if($xPanel->checkIfFieldIsFirstOfItsType($field, $fields)): ?>
	
	
	<?php $__env->startPush('crud_fields_styles'); ?>
	
	<link href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
	<?php $__env->stopPush(); ?>
	
	
	<?php $__env->startPush('crud_fields_scripts'); ?>
	
	<script src="<?php echo e(asset('assets/plugins/select2/js/select2.js')); ?>"></script>
	<script>
		var skins = jQuery.parseJSON('<?php echo $field['skins']; ?>');
		
		jQuery(document).ready(function($) {
			// trigger select2 for each untriggered select2 box
			$('.select2_from_skins').each(function (i, obj) {
				if (!$(obj).hasClass("select2-hidden-accessible"))
				{
					$(obj).select2({
						theme: "bootstrap",
						templateResult: formatColor,
						templateSelection: formatColor
					});
				}
			});
		});
		
		function formatColor (color) {
			if (!color.id) {
				return color.text;
			}
			
			let hex = '#000000';
			if (typeof skins[color.id] !== 'undefined' && typeof skins[color.id].color !== 'undefined' && skins[color.id].color != null) {
				hex = skins[color.id].color;
			}
			if (color.id == 'default') {
				hex = '#CCCCCC';
			}
			
			let colorIcon = '<div style="display: inline-block; width: 30px; height: 20px; background-color: ' + hex + ';"></div>';
			let colorText = '&nbsp;' + color.text + '';
			
			var formattedColor = $(
				'<div style="display: flex; align-items: center;">' + colorIcon + ' ' + colorText + '</div>'
			);
			
			return formattedColor;
		}
	</script>
	<?php $__env->stopPush(); ?>

<?php endif; ?>

<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/fields/select2_from_skins.blade.php ENDPATH**/ ?>