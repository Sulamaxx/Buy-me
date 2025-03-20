
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> >
	<?php echo $__env->make('admin.panel.fields.inc.translatable_icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="form-check form-switch mt-2">
		<input type="hidden" name="<?php echo e($field['name']); ?>" value="0">
		<input type="checkbox" value="1" name="<?php echo e($field['name']); ?>"
			<?php if(isset($field['value'])): ?>
				<?php
					$isFieldChecked = (str_ends_with($field['name'], '_at'))
						? (!empty($field['value']) || !empty(old($field['name'])))
						: (((int) $field['value'] == 1 || old($field['name']) == 1) && old($field['name']) !== '0');
				?>
				
				<?php if($isFieldChecked): ?>
					checked="checked"
				<?php endif; ?>
			<?php elseif(isset($field['default']) && $field['default']): ?>
				checked="checked"
			<?php endif; ?>
			
			<?php if(isset($field['attributes']) && !empty($field['attributes'])): ?>
				<?php $__currentLoopData = $field['attributes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if($attribute == 'class'): ?>
						<?php echo e($attribute); ?>="form-check-input <?php echo e($value); ?>"
					<?php elseif($attribute == 'style'): ?>
						<?php echo e($attribute); ?>="cursor: pointer; <?php echo e($value); ?>"
					<?php else: ?>
						<?php echo e($attribute); ?>="<?php echo e($value); ?>"
					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php if(!array_key_exists('class', $field['attributes'])): ?>
					class="form-check-input"
				<?php endif; ?>
				<?php if(!array_key_exists('style', $field['attributes'])): ?>
					style="cursor: pointer;"
				<?php endif; ?>
			<?php else: ?>
				class="form-check-input" style="cursor: pointer;"
			<?php endif; ?>
		>
		<label class="form-check-label fw-bolder">
			<?php echo $field['label']; ?>

		</label>
		
		
		<?php if(isset($field['hint'])): ?>
			<div class="form-text"><?php echo $field['hint']; ?></div>
		<?php endif; ?>
    </div>
</div>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/fields/checkbox_switch.blade.php ENDPATH**/ ?>