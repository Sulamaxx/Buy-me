
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> >
    <label class="form-label fw-bolder"><?php echo $field['label']; ?></label>
	<?php echo $__env->make('admin.panel.fields.inc.translatable_icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <select
        name="<?php echo e($field['name']); ?>"
        <?php echo $__env->make('admin.panel.inc.field_attributes', ['default_class' =>  'form-select'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    	>
		
        <?php if(isset($field['allows_null']) && $field['allows_null']==true): ?>
            <option value="">-</option>
        <?php endif; ?>
		
		<?php
			$field['value'] = (isset($field['value']) && !empty($field['value']))
				? $field['value']
				: ($field['default'] ?? null);
		?>
		<?php if(isset($field['options']) && !empty($field['options'])): ?>
			<?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($key); ?>"
					<?php if((isset($field['value']) && $key==$field['value']) || ( ! is_null( old($field['name']) ) && old($field['name']) == $key) ): ?>
						 selected
					<?php endif; ?>
				><?php echo e($value); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</select>
	
    
    <?php if(isset($field['hint'])): ?>
        <div class="form-text"><?php echo $field['hint']; ?></div>
    <?php endif; ?>
</div><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/fields/select_from_array.blade.php ENDPATH**/ ?>