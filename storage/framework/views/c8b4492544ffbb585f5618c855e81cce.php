<?php
    $widget ??= [];
    $posts = data_get($widget, 'posts');
    // $posts = (array) data_get($widget, 'posts');
    $totalPosts = (int) data_get($widget, 'totalPosts', 0);

    $sectionOptions ??= [];
    $hideOnMobile = data_get($sectionOptions, 'hide_on_mobile') == '1' ? ' hidden-sm' : '';
    $carouselEl = '_' . createRandomString(6);

    $isFromHome ??= false;
?>


<div class="container<?php echo e($isFromHome ? '' : ' my-3'); ?><?php echo e($hideOnMobile); ?>">
    <div class="col-xl-12 content-box layout-section" style="background-color: transparent">
        <div class="row row-featured">
            <div class="col-xl-12 box-title" style="background-color: transparent !important">
                <div class="inner" style="background-color: transparent">
                    <h2 style="display: flex; align-items: center;padding-left:0px;">
                        <span class="title-3"
                            style="font-weight: bold"><?php echo e(data_get($widget, 'title', t('Latest Listings'))); ?></span>
                        <div
                            style="width: 30px; height: 2px; background-color: #52AB4A; margin-left: 5px;margin-top:13px">
                        </div>
                        
                    </h2>
                </div>
            </div>

            <div class="col-xl-12" style="background-color: transparent">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 row-cols-xl-4 g-2 g-md-3"
                    style="background-color: transparent;margin-right: -0.25vw;">
                    <?php if(count($posts) > 0): ?> 
                        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <div class="col lazy-load-item">
                                <div class="card" style="border-radius: 7.5px;min-height: 275px">
                                    <div class="mobile-height" style="position: relative; overflow: hidden; height: 150px;">
                                        <?php if(count($post->pictures) > 0): ?> 
                                            <a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>">
                                                <?php
                                                    echo imgTag($post->pictures[0]->filename, 'medium', [
                                                        'class' => 'card-img-top',
                                                        'alt' => data_get($post, 'title'),
                                                        'loading' => 'lazy',
                                                        'style'=>'border-top-left-radius: 7.5px;border-top-right-radius: 7.5px;object-fit: none;'
                                                    ]);
                                                ?>
                                            </a>
                                        <?php else: ?> 
                                            <?php
                                                echo imgTag('app/default/picture.jpg', 'medium', [
                                                    'class' => 'card-img-top',
                                                    'alt' => data_get($post, 'title'),
                                                    'loading' => 'lazy',
                                                    'style'=>'border-top-left-radius: 7.5px;border-top-right-radius: 7.5px;object-fit: none;'
                                                ]);
                                            ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body"
                                        style="display: flex; flex-direction: column; min-height: 170px;">
                                        <h5 class="card-title"
        style="
            font-size: 1rem;
            margin-bottom: 5px;
            font-weight: bold;
            /* --- Styles added to force 2 lines --- */
            display: -webkit-box; /* Required for line clamping in Webkit browsers */
            -webkit-line-clamp: 2; /* Limit text to 2 lines */
            -webkit-box-orient: vertical; /* Required with -webkit-line-clamp */
            overflow: hidden; /* Hide text that exceeds the 2 lines */
            text-overflow: ellipsis; /* Add ellipsis (...) if text is truncated */
            line-height: 1.4em; /* Set a line height (adjust as needed for your font/design) */
            height: 2.8em; /* Set height equal to 2 * line-height */
            /* ------------------------------------ */
        ">
        <a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>" style="color: #333333;">
            
            <?php echo e(str(data_get($post, 'title'))->limit(50)); ?>

        </a>
    </h5>
                                        <div>
                                            <p class="card-text"
   style="font-size: 0.8rem; color: #999; margin-bottom: 3px;">
    
    <span style="white-space: nowrap;">
        <i class="fas fa-folder"></i> <?php echo e(data_get($post, 'category.name')); ?>

    </span>


    <?php if(data_get($post, 'city.name')): ?>
        
        &nbsp;
        <span style="white-space: nowrap;">
             <i class="fas fa-map-marker-alt"></i>
             <?php echo e(data_get($post, 'city.name')); ?>

        </span>
    <?php endif; ?>
</p>
                                            <p class="card-text"
                                                style="font-size: 0.9rem; color:  #008E00; margin-bottom: 5px;font-weight:bold">
                                                <?php echo data_get($post, 'price_formatted'); ?>

                                            </p>
                                        </div>
                                        <p class="card-text"
                                            style="font-size: 0.7rem; color: #999; text-align: right; margin-top:auto;margin-bottom: 0;">
                                            <i class="far fa-clock"></i>
                                            <?php echo e(\Carbon\Carbon::parse(data_get($post, 'created_at'))->diffForHumans()); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .lazy-load-item {
    opacity: 0;
    transform: translateX(-20px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.lazy-load-item.is-visible {
    opacity: 1;
    transform: translateX(0);
}

@media (min-width: 320px) {
        .mobile-height {
            height: 110px !important;
        }
    }

@media (min-width: 375px) {
        .mobile-height {
            height: 130px !important;
        }
    }

    @media (min-width: 425px) {
        .mobile-height {
            height: 150px !important;
        }
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lazyLoadItems = document.querySelectorAll('.lazy-load-item');

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target); 
                }
            });
        }, {
            threshold: 0.2
        });

        lazyLoadItems.forEach(item => {
            observer.observe(item);
        });
    });
</script>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/search/inc/posts/widget/dummy.blade.php ENDPATH**/ ?>