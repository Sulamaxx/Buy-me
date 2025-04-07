

<?php
    // Supported Icons Fonts
    $iconSetArray = [
            'bootstrapicons',
            'elusiveicons',
            'flagicon',
            'fontawesome4',
            'fontawesome5',
            'glyphicon', // Bootstrap 3
            'ionicons',
            'mapicons',
            'materialdesign',
            'octicons',
            'typicons',
            'weathericons',
    ];
    
    // If no iconset was provided, set the default iconset to Font-Awesome
    if (!isset($field['iconset'])) {
        $field['iconset'] = 'fontawesome';
    } else {
        if (!in_array($field['iconset'], $iconSetArray)) {
            $field['iconset'] = 'fontawesome';
        }
    }
    if (!isset($field['version'])) {
        $field['version'] = 'lastest';
    } else {
        if (empty($field['version'])) {
            $field['version'] = 'lastest';
        }
    }
    if (!isset($field['search'])) {
        $field['search'] = 'Search icon';
    }
?>

<div <?php echo $__env->make('admin.panel.inc.field_wrapper_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> >
    <label class="form-label fw-bolder"><?php echo $field['label']; ?></label>
    <?php echo $__env->make('admin.panel.fields.inc.translatable_icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div>
        <button class="btn btn-secondary" role="iconpicker" data-icon="<?php echo e(old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default'])
         ? $field['default'] : '' ))); ?>" data-iconset="<?php echo e($field['iconset']); ?>" data-iconset-version="<?php echo e($field['version']); ?>" data-search-text="<?php echo e($field['search']); ?>"></button>
        <input
            type="hidden"
            name="<?php echo e($field['name']); ?>"
            value="<?php echo e(old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' ))); ?>"
            <?php echo $__env->make('admin.panel.inc.field_attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        >
    </div>

    
    <?php if(isset($field['hint'])): ?>
        <div class="form-text"><?php echo $field['hint']; ?></div>
    <?php endif; ?>
</div>


<?php if($xPanel->checkIfFieldIsFirstOfItsType($field, $fields)): ?>
    
    <?php if($field['iconset'] == 'bootstrapicons'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/bootstrapicons/1.9.1/css/bootstrap-icons.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Bootstrap Icons -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-bootstrapicons-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'elusiveicons'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/elusiveicons/2.0.0/css/elusive-icons.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Elusive Icons -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-elusiveicons-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'flagicon'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            <!-- Flag Icons CDN -->
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/flagicon/3.5.0/css/flag-icon.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Elusive Icons -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-flagicon-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'fontawesome4'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome4/4.7.0/css/font-awesome.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Font Awesome -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-fontawesome4-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'fontawesome5'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome5/5.15.4/css/all.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
    
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Font Awesome -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-fontawesome5-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'glyphicon'): ?>
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Bundle -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-glyphicon-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'ionicons'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/ionicons/2.0.1/css/ionicons.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Ionicons -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-ionicons-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'mapicons'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/mapicons/2.1.0/css/map-icons.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Map Icons -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-mapicons-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'materialdesign'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/materialdesign/2.2.0/css/material-design-iconic-font.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Material Design -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-materialdesign-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'octicons'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/octicons/4.4.0/css/octicons.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Octicons -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-octicons-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'typicons'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/typicons/2.0.9/css/typicons.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Typicons -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-typicons-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php elseif($field['iconset'] == 'weathericons'): ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/weathericons/2.0.10/css/weather-icons.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Weather Icons -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-weathericons-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php else: ?>
        <?php $__env->startPush('crud_fields_styles'); ?>
            
            <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome5/5.15.4/css/all.min.css')); ?>"/>
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startPush('crud_fields_scripts'); ?>
            <!-- Iconpicker Iconset for Font Awesome -->
            <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/iconset/iconset-fontawesome5-all.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
    
    
    <?php $__env->startPush('crud_fields_styles'); ?>
        <!-- Iconpicker -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.css')); ?>"/>
    <?php $__env->stopPush(); ?>
    
    
    <?php $__env->startPush('crud_fields_scripts'); ?>
        <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/bootstrap/4.1.3/js/bootstrap.bundle.min.js')); ?>"></script>
        <!-- Iconpicker Bundle -->
        <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.js')); ?>"></script>
        
        
        <script>
            jQuery(document).ready(function($) {
                $('button[role=iconpicker]').on('change', function(e) {
                    $(this).siblings('input[type=hidden]').val(e.icon);
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
    
<?php endif; ?>



<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/fields/icon_picker.blade.php ENDPATH**/ ?>