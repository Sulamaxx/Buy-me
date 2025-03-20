<!DOCTYPE html>
<html lang="<?php echo e(getLangTag(config('app.locale'))); ?>" dir="ltr">
<head>
    <meta charset="<?php echo e(config('larapen.core.charset', 'utf-8')); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="<?php echo e(config('app.name')); ?>">
    
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(config('settings.app.favicon_url')); ?>">
    
    <title><?php echo e(isset($title) ? $title.' :: ' . config('app.name') . ' Admin' : config('app.name') . ' Admin'); ?></title>
    
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    
    
    <base target="_top"/>
    
    <link rel="canonical" href="<?php echo e(url()->current()); ?>" />
    
    <?php echo $__env->yieldContent('before_styles'); ?>
    
    <link href="<?php echo e(url(mix('css/admin.css'))); ?>" rel="stylesheet">

    <?php echo $__env->yieldContent('after_styles'); ?>
    
    
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?php echo $__env->yieldContent('captcha_head'); ?>
    <?php echo $__env->yieldContent('recaptcha_head'); ?>
</head>

<body>
<div class="main-wrapper">
    
    <?php
    $wrapperStyle = '';
    $logoUrl = '';
    try {
        if (is_link(public_path('storage'))) {
            $bgImgUrl = config('settings.style.login_bg_image_url');
            $wrapperStyle = 'background:url(' . $bgImgUrl . ') no-repeat center center; background-size: cover;';
            $logoUrl = config('settings.app.logo_dark_url');
        }
    } catch (\Throwable $e) {}
    ?>
    
    
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="<?php echo $wrapperStyle; ?>">
        <div class="auth-box p-4 bg-white rounded">
    
            <div class="logo text-center mb-5">
                <a href="<?php echo e(url('/')); ?>">
                    <img src="<?php echo e($logoUrl); ?>" alt="logo" class="img-fluid" style="width:250px; height:auto;">
                </a>
                <hr class="border-0 bg-secondary">
            </div>
            
            <?php echo $__env->yieldContent('content'); ?>
            
        </div>
    </div>
    
</div>

<?php echo $__env->make('common.js.init', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('before_scripts'); ?>

<script>
    
    var defaultAuthField = '<?php echo e(old('auth_field', getAuthField())); ?>';
    var phoneCountry = '';
</script>

<script src="<?php echo e(admin_url('common/js/intl-tel-input/countries.js') . getPictureVersion()); ?>"></script>
<script src="<?php echo e(url(mix('js/admin.js'))); ?>"></script>


<script>
    preventPageLoadingInIframe();
    
    $(document).ready(function()
    {
        $('[data-bs-toggle="tooltip"]').tooltip();
        $('.preloader').fadeOut();
        
        
        $('#to-recover').on('click', function() {
            $('#loginform').slideUp();
            $('#recoverform').fadeIn();
        });
        $('#to-login').on('click', function() {
            $('#recoverform').slideUp();
            $('#loginform').fadeIn();
        });
    });
    
    /**
     * Prevent the page to load in IFRAME by redirecting it to the top-level window
     */
    function preventPageLoadingInIframe() {
        try {
            if (window.top.location !== window.location) {
                window.top.location.replace(siteUrl);
            }
        } catch (e) {
            console.error(e);
        }
    }
</script>

<?php echo $__env->make('admin.layouts.inc.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('after_scripts'); ?>
<?php echo $__env->yieldContent('captcha_footer'); ?>

</body>
</html>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/layouts/auth.blade.php ENDPATH**/ ?>