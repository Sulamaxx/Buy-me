<?php
    $midAdvertising ??= [];
    $posts ??= [];
    $totalPosts ??= 0;

    $city ??= null;
    $cat ??= null;
?>

<?php
    function divideAndRoundUp($number)
    {
        // If the number is 0 or out of range, increment it to 1
        if ($number < 1 || $number > 13) {
            $number = 1; // Default to 1 if out of range
        }

        // Divide the number by 2
        $result = $number / 2;

        // Round up to the nearest integer
        $roundedResult = ceil($result);

        return $roundedResult;
    }
?>

<?php if(!empty($posts) && $totalPosts > 0): ?>
    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($key == 7): ?>
            <div class="item-list">
                
                <?php echo $__env->first([
                    config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.middle',
                    'layouts.inc.advertising.middle',
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endif; ?>

        <?php if(data_get($post, 'featured') == 1): ?>
            <div class="item-list featured-item" style="border-left: 5px solid #FDAB02; background-color: #fdab0217;">
            <?php else: ?>
                <div class="item-list">
        <?php endif; ?>
        <?php if(data_get($post, 'featured') == 1): ?>
            <?php if(!empty(data_get($post, 'payment.package'))): ?>
                <!--
     <?php if(data_get($post, 'payment.package.ribbon') != ''): ?>
<div class="ribbon-horizontal <?php echo e(data_get($post, 'payment.package.ribbon')); ?>">
       <span><?php echo e(data_get($post, 'payment.package.short_name')); ?></span>
      </div>
<?php endif; ?>
-->
            <?php endif; ?>
        <?php endif; ?>

        <?php
            $picturePath = data_get($post, 'picture.filename');
            $pictureAttr = ['class' => 'lazyload thumbnail no-margin', 'alt' => data_get($post, 'title')];

            $postUrl = \App\Helpers\UrlGen::post($post);
            $parentCatUrl = null;
            if (!empty(data_get($post, 'category.parent'))) {
                $parentCatUrl = \App\Helpers\UrlGen::category(data_get($post, 'category.parent'), null, $city);
            }
            $catUrl = \App\Helpers\UrlGen::category(data_get($post, 'category'), null, $city);
            $locationUrl = \App\Helpers\UrlGen::city(data_get($post, 'city'), null, $cat);
        ?>
        <?php
        //            print_r($post);
        //            exit();
        ?>
        <div class="row">
            <div class="col-sm-3 col-12 no-padding photobox">
                <div class="add-image">
                    <span class="photo-count">
                        <i class="fa fa-camera"></i> <?php echo e(data_get($post, 'count_pictures')); ?>

                    </span>
                    <a href="<?php echo e($postUrl); ?>">
                        <?php echo imgTag($picturePath, 'medium', $pictureAttr); ?>

                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-12 add-desc-box">
                <div class="items-details">
                    <h5 class="add-title">
                        <a href="<?php echo e($postUrl); ?>">
                            <?php echo e(str(data_get($post, 'title'))->limit(60)); ?>

                        </a>
                    </h5>
                    <!--                    display usertype start -->
                    <?php
                        if(!empty(data_get($post, 'user.usr_type'))){
                    $usertypeid = data_get($post, 'user.usr_type');
                    
                    if($usertypeid>1)
                    {
                        $usertypedata = DB::table('usr_types')->select('usr_type')->where('id',$usertypeid)->get();
                        $UsrType = $usertypedata[0]->usr_type;
                        ?>
                    <div
                        style="background: #848484; color: aliceblue; padding-left: 3px; width: min-content; border-radius:5px;align-content: center ">
                        <?php echo e($UsrType); ?>&nbsp;</div>
                    <?php
                    }}
                    ?>
                    <!--                    display usertype end -->
                    <?php
                        $showPostInfo =
                            (!config('settings.list.hide_post_type') && config('settings.single.show_listing_type')) ||
                            !config('settings.list.hide_date') ||
                            !config('settings.list.hide_category') ||
                            !config('settings.list.hide_location');
                    ?>
                    <?php if($showPostInfo): ?>
                        <span class="info-row">
                            <?php if(!config('settings.list.hide_post_type') && config('settings.single.show_listing_type')): ?>
                                <?php if(!empty(data_get($post, 'postType'))): ?>
                                    <span class="add-type business-posts" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="<?php echo e(data_get($post, 'postType.name')); ?>">
                                        <?php echo e(strtoupper(mb_substr(data_get($post, 'postType.name'), 0, 1))); ?>

                                    </span>&nbsp;
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if(!config('settings.list.hide_date')): ?>
                                <span class="date"<?php echo config('lang.direction') == 'rtl' ? ' dir="rtl"' : ''; ?>>
                                    <i class="far fa-clock"></i> <?php echo data_get($post, 'created_at_formatted'); ?>

                                </span>
                            <?php endif; ?>
                            <?php if(!config('settings.list.hide_category')): ?>
                                <span class="category"<?php echo config('lang.direction') == 'rtl' ? ' dir="rtl"' : ''; ?>>
                                    <i class="bi bi-folder"></i>&nbsp;
                                    <?php if(!empty(data_get($post, 'category.parent'))): ?>
                                        <a href="<?php echo $parentCatUrl; ?>" class="info-link">
                                            <?php echo e(data_get($post, 'category.parent.name')); ?>

                                        </a>&nbsp;&raquo;&nbsp;
                                    <?php endif; ?>
                                    <a href="<?php echo $catUrl; ?>" class="info-link">
                                        <?php echo e(data_get($post, 'category.name')); ?>

                                    </a>
                                </span>
                            <?php endif; ?>
                            <?php if(!config('settings.list.hide_location')): ?>
                                <span class="item-location"<?php echo config('lang.direction') == 'rtl' ? ' dir="rtl"' : ''; ?>>
                                    <i class="bi bi-geo-alt"></i>&nbsp;
                                    <a href="<?php echo $locationUrl; ?>" class="info-link">
                                        <?php echo e(data_get($post, 'city.name')); ?>

                                    </a> <?php echo e(data_get($post, 'distance_info')); ?>

                                </span>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>

                    <?php if(config('plugins.reviews.installed')): ?>
                        <?php if(view()->exists('reviews::ratings-list')): ?>
                            <?php echo $__env->make('reviews::ratings-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-sm-3 col-12 text-end price-box" style="white-space: nowrap;">
                <div id="pricehintdiv" class="form-text text-muted">
                    <?php
                    $chkval = data_get($post, 'category.id');
                    $prntval = data_get($post, 'property_price_type');
                    
                    //                        echo('<script>alert('.$prntval.');</script>');
                    //                        exit();


                    if ($prntval == '') {
                        if ($chkval == '42') {
                            $prntval = 'per month';
                        } elseif ($chkval == '140') {
                            $prntval = 'per day';
                        } elseif ($chkval == '38') {
                            // $prntval = "per acre"; //was perch
                            $prntval = 'per perch'; //was perch
                        } elseif ($chkval == '44') {
                            $prntval = 'per perch';
                        } elseif ($chkval == '45') {
                            $prntval = 'per month';
                        } elseif ($chkval == '141') {
                            $prntval = 'per month';
                        } elseif ($chkval == '40') {
                            $prntval = 'per month';
                        } elseif ($chkval == '43') {
                            $prntval = 'per month';
                        }
                    }
                    ?><?php echo e($prntval); ?></div>
                <h3 class="item-price">
                    <?php echo data_get($post, 'price_formatted'); ?>

                </h3>

                <?php if(!empty(data_get($post, 'payment.package'))): ?>
                    <?php if(data_get($post, 'payment.package.has_badge') == 1): ?>
                        <a class="btn btn-danger btn-sm make-favorite">
                            <i class="fa fa-certificate"></i>
                            <span><?php echo e(data_get($post, 'payment.package.short_name')); ?></span>
                        </a>&nbsp;
                    <?php endif; ?>
                <?php endif; ?>
                <?php if(!empty(data_get($post, 'savedByLoggedUser'))): ?>
                    <a class="btn btn-success btn-sm make-favorite" id="<?php echo e(data_get($post, 'id')); ?>">
                        <i class="fas fa-bookmark"></i> <span><?php echo e(t('Saved')); ?></span>
                    </a>
                <?php else: ?>
                    <a class="btn btn-default btn-sm make-favorite" id="<?php echo e(data_get($post, 'id')); ?>">
                        <i class="fas fa-bookmark"></i> <span><?php echo e(t('Save')); ?></span>
                    </a>
                <?php endif; ?>
                <?php
                    if(data_get($post, 'payment.package.ribbon')!='')
                    {
                    ?>

                <div><img style="width: 40px;"
                        src="/public/images/ribbons/<?php echo e(data_get($post, 'payment.package.ribbon')); ?>.png" /></div>
                <?php } ?>
            </div>
        </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <div class="p-4" style="width: 100%;">
        <?php echo e(t('no_result_refine_your_search')); ?>

    </div>
<?php endif; ?>

<?php $__env->startSection('after_scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
    <script>
        
        var lang = {
            labelSavePostSave: "<?php echo t('Save listing'); ?>",
            labelSavePostRemove: "<?php echo t('Remove favorite'); ?>",
            loginToSavePost: "<?php echo t('Please log in to save the Listings'); ?>",
            loginToSaveSearch: "<?php echo t('Please log in to save your search'); ?>"
        };
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/search/inc/posts/template/list.blade.php ENDPATH**/ ?>