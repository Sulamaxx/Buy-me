<?php
$var_name = str_replace('[]', '', $field['name']);
$var_name = str_replace('][', '.', $var_name);
$var_name = str_replace('[', '.', $var_name);
$var_name = str_replace(']', '', $var_name);
$required = (isset($field['rules']) && isset($field['rules'][$var_name]) && in_array('required', explode('|', $field['rules'][$var_name]))) ? true : '';
?>
<?php if(isset($field['attributes'])): ?>
    <?php $__currentLoopData = $field['attributes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	<?php if(is_string($attribute)): ?>
			<?php if($attribute == 'class'): ?>
        		<?php echo e($attribute); ?>="<?php echo e($value); ?><?php echo e($errors->has($var_name) ? ' is-invalid' : ''); ?>"
			<?php else: ?>
				<?php echo e($attribute); ?>="<?php echo e($value); ?>"
			<?php endif; ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(!isset($field['attributes']['class'])): ?>
    	<?php if(isset($default_class)): ?>
    		class="<?php echo e($default_class); ?><?php echo e($errors->has($var_name) ? ' is-invalid' : ''); ?>"
    	<?php else: ?>
    		class="form-control<?php echo e($errors->has($var_name) ? ' is-invalid' : ''); ?>"
    	<?php endif; ?>
    <?php endif; ?>
<?php else: ?>
	<?php if(isset($default_class)): ?>
		class="<?php echo e($default_class); ?><?php echo e($errors->has($var_name) ? ' is-invalid' : ''); ?>"
	<?php else: ?>
		class="form-control<?php echo e($errors->has($var_name) ? ' is-invalid' : ''); ?>"
	<?php endif; ?>
<?php endif; ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/inc/field_attributes.blade.php ENDPATH**/ ?>