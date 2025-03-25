
<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> >
    <label class="form-label fw-bolder"><?php echo $field['label']; ?></label>
    <?php echo $__env->make('admin.panel.fields.inc.translatable_icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="input-group colorpicker-component">

        <input
        	type="text"
        	name="<?php echo e($field['name']); ?>"
            value="<?php echo e(old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' ))); ?>"
            <?php echo $__env->make('admin.panel.inc.field_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        	>
        <span class="input-group-text colorpicker-input-addon">
            <i class="color-preview-<?php echo e($field['name']); ?>"></i>
        </span>
        
    </div>

    
    <?php if(isset($field['hint'])): ?>
        <div class="form-text"><?php echo $field['hint']; ?></div>
    <?php endif; ?>
</div>




<?php if($xPanel->checkIfFieldIsFirstOfItsType($field, $fields)): ?>

    
    <?php $__env->startPush('crud_fields_styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.css')); ?>" />
    <?php $__env->stopPush(); ?>

    
    <?php $__env->startPush('crud_fields_scripts'); ?>
        <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.js')); ?>"></script>
    <?php $__env->stopPush(); ?>

<?php endif; ?>

<?php $__env->startPush('crud_fields_scripts'); ?>
<script type="text/javascript">
    jQuery('document').ready(function($){
        /* https://itsjavi.com/bootstrap-colorpicker/tutorial-Basics.html */
        var config = jQuery.extend({}, <?php echo isset($field['colorpicker_options']) ? json_encode($field['colorpicker_options']) : '{}'; ?>);
        var picker = $('[name="<?php echo e($field['name']); ?>"]').parents('.colorpicker-component').colorpicker(config);
        $('[name="<?php echo e($field['name']); ?>"]').on('focus', function() {
            picker.colorpicker('show');
        });
    })
</script>
<?php $__env->stopPush(); ?>



<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/fields/color_picker.blade.php ENDPATH**/ ?>