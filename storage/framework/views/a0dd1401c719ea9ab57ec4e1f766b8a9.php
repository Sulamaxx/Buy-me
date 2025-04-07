<?php
    $firstWidget ??= [];
    $firstPosts = (array)data_get($firstWidget, 'posts');
    $firstTotalPosts = (int)data_get($firstWidget, 'totalPosts', 0);

    $sectionOptions ??= [];
    $hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' hidden-sm' : '';
    $carouselEl = '_' . createRandomString(6);

    $isFromHome ??= false;
?>


<div class="container<?php echo e($isFromHome ? '' : ' my-3'); ?><?php echo e($hideOnMobile); ?>">
    <div class="col-xl-12 content-box layout-section" style="background-color: transparent">
        <div class="row row-featured">
            <div class="col-xl-12 box-title" style="background-color: transparent !important">
                <div class="inner" style="background-color: transparent">
                    <h2 style="display: flex; align-items: center;">
                        <span class="title-3" style="font-weight: bold">Recomended For You</span>
                        <div style="width: 30px; height: 2px; background-color: #52AB4A; margin-left: 5px;margin-top:13px"></div>
                    </h2>
                </div>
            </div>

            <div class="col-xl-12" style="background-color: transparent">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 g-2 g-md-3" style="background-color: transparent">
                    <?php $__currentLoopData = $firstPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col">
                            <div class="card" style="border-radius: 0%;min-height: auto;">
                                <div class="four-image-container" style="display: grid; grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(2, 1fr); border-radius: 0%;">
                                    <?php for($i = 0; $i < 4; $i++): ?>
                                        <?php if(data_get($post, 'picture.filename')): ?>
                                            <div class="image-quadrant" style="position: relative; overflow: hidden;">
                                                <a href="<?php echo e(url('/posts/' . $post['id'])); ?>">
                                                    <?php
                                                        echo imgTag('app/default/picture.jpg', 'small', [ 
                                                            'class' => 'w-100 h-100',
                                                            'style' => 'object-fit: cover;',
                                                            'alt' => data_get($post, 'title')
                                                        ]);
                                                    ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="card-body" style="padding: 1rem;">
                                    <h5 class="card-title" style="font-size: 1.5rem; margin-bottom: 0.05rem;font-weight:bold; text-align: left;">
                                        <a href="<?php echo e(url('/posts/' . $post['id'])); ?>" style="color: #000000;">
                                            <?php echo e(str(data_get($post, 'title'))->limit(50)); ?>

                                        </a>
                                    </h5>
                                    <?php if(data_get($post, 'description')): ?>
                                        <p class="card-text" style="font-size: 1.1rem; color: #555; text-align: left; margin-bottom: 1rem;margin-top: 0rem;font-weight:bold">
                                            <?php echo e(str(data_get($post, 'description'))->limit(240)); ?>

                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .image-quadrant a {
        display: block;
        width: 100%;
        height: 100%;
    }
</style><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/search/inc/posts/widget/dummy3.blade.php ENDPATH**/ ?>