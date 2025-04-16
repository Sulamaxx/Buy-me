<?php
    $socialLinksAreEnabled = (
        config('settings.social_link.facebook_page_url')
        || config('settings.social_link.twitter_url')
        || config('settings.social_link.youtube_url')
        || config('settings.social_link.instagram_url')
    );
?>
<footer class="main-footer">
    <div class="footer-content" style="background-color: #dcdcdc;border-top:none">
        <!-- Desktop View -->
        <div class="container d-none d-sm-block d-md-block d-lg-block">
            <div class="row">
                <div class="col-md-3">
                    <a href="<?php echo e(url('/')); ?>" class="navbar-brand logo logo-title">
                        <img src="<?php echo e(config('settings.app.logo_url')); ?>"
                             alt="<?php echo e(strtolower(config('settings.app.name'))); ?>"
                             class="main-logo footer-main-logo"
                             data-bs-placement="bottom"
                             data-bs-toggle="tooltip"
                        />
                    </a>
                </div>
                <div class="col-md-9">
                    <ul class="list-inline text-right">
                        <?php if(isset($pages) && $pages->count() > 0): ?>
									<?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<li class="list-inline-item">
											<?php
												$linkTarget = '';
												if ($page->target_blank == 1) {
													$linkTarget = 'target="_blank"';
												}
											?>
											<?php if(!empty($page->external_link)): ?>
												<a href="<?php echo $page->external_link; ?>" rel="nofollow" <?php echo $linkTarget; ?> class="footer-link"> <?php echo e($page->name); ?> </a>
											<?php else: ?>
												<a href="<?php echo e(\App\Helpers\UrlGen::page($page)); ?>" <?php echo $linkTarget; ?> class="footer-link"> <?php echo e($page->name); ?> </a>
											<?php endif; ?>
										</li>
                                        <?php if(!$loop->last): ?>
                                        <li class="list-inline-item">|</li>
                                        <?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="margin-left: -20px; margin-top:10px">
                    <p class="copy-info">© <?php echo e(date('Y')); ?> <?php echo e(config('settings.app.name')); ?>. <?php echo e(t('all_rights_reserved')); ?>.</p>
                </div>
                <div class="col-md-6 text-right">
                    <?php if($socialLinksAreEnabled): ?>
                        <ul class="list-inline d-inline-block">
                            <?php if(config('settings.social_link.facebook_page_url')): ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo e(config('settings.social_link.facebook_page_url')); ?>">
                                        <img src="/images/social/facebook.png" alt="Facebook" class="social-icon">
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(config('settings.social_link.twitter_url')): ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo e(config('settings.social_link.twitter_url')); ?>">
                                        <img src="/images/social/x.png" alt="X" class="social-icon">
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(config('settings.social_link.youtube_url')): ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo e(config('settings.social_link.youtube_url')); ?>">
                                        <img src="/images/social/youtube.png" alt="YouTube" class="social-icon">
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(config('settings.social_link.instagram_url')): ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo e(config('settings.social_link.instagram_url')); ?>">
                                        <img src="/images/social/instagram.png" alt="Instagram" class="social-icon">
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>

        <!-- Mobile View -->
        <div class="container d-block d-sm-none">
            <div class="text-center">
                <a href="<?php echo e(url('/')); ?>" class="navbar-brand logo logo-title">
                    <img src="<?php echo e(config('settings.app.logo_url')); ?>"
                         alt="<?php echo e(strtolower(config('settings.app.name'))); ?>"
                         class="main-logo footer-main-logo"
                         data-bs-placement="bottom"
                         data-bs-toggle="tooltip"
                    />
                </a>
            </div>
            <div class="text-center">
                <ul class="list-unstyled">
                    <?php if(isset($pages) && $pages->count() > 0): ?>
									<?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<li>
											<?php
												$linkTarget = '';
												if ($page->target_blank == 1) {
													$linkTarget = 'target="_blank"';
												}
											?>
											<?php if(!empty($page->external_link)): ?>
												<a href="<?php echo $page->external_link; ?>" rel="nofollow" <?php echo $linkTarget; ?> class="footer-link"> <?php echo e($page->name); ?> </a>
											<?php else: ?>
												<a href="<?php echo e(\App\Helpers\UrlGen::page($page)); ?>" <?php echo $linkTarget; ?> class="footer-link"> <?php echo e($page->name); ?> </a>
											<?php endif; ?>
										</li>
                                
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
                </ul>
            </div>
            
            <div class="text-center">
                <?php if($socialLinksAreEnabled): ?>
                    <ul class="list-inline">
                        <?php if(config('settings.social_link.facebook_page_url')): ?>
                            <li class="list-inline-item">
                                <a href="<?php echo e(config('settings.social_link.facebook_page_url')); ?>">
                                    <img src="/images/social/facebook.png" alt="Facebook" class="social-icon">
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(config('settings.social_link.twitter_url')): ?>
                            <li class="list-inline-item">
                                <a href="<?php echo e(config('settings.social_link.twitter_url')); ?>">
                                    <img src="/images/social/x.png" alt="X" class="social-icon">
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(config('settings.social_link.youtube_url')): ?>
                            <li class="list-inline-item">
                                <a href="<?php echo e(config('settings.social_link.youtube_url')); ?>">
                                    <img src="/images/social/youtube.png" alt="YouTube" class="social-icon">
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(config('settings.social_link.instagram_url')): ?>
                            <li class="list-inline-item">
                                <a href="<?php echo e(config('settings.social_link.instagram_url')); ?>">
                                    <img src="/images/social/instagram.png" alt="Instagram" class="social-icon">
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="text-center">
                <p class="copy-info">© <?php echo e(date('Y')); ?> <?php echo e(config('settings.app.name')); ?>. <?php echo e(t('all_rights_reserved')); ?>.</p>
            </div>
        </div>
    </div>
</footer>

<style>
    /* .btn-orange {
        background-color: orange;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
    }
    .btn-orange:hover {
        background-color: darkorange;
        color: white;
    } */
    .footer-link {
        color: black !important;
        text-decoration: none;
    }
    .footer-link:hover {
        text-decoration: underline;
    }
    .social-icon {
        width: 24px; /* Adjust size as needed */
        height: 24px;
        margin: 0 5px;
    }
    .phone-icon {
        width: 20px; /* Adjust size as needed */
        height: 20px;
        margin-right: 5px;
    }
</style><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/layouts/inc/footer.blade.php ENDPATH**/ ?>