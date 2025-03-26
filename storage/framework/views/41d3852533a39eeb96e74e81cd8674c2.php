


<?php
    $apiResult ??= [];
	$threads = (array)data_get($apiResult, 'data');
	$totalThreads = (int)data_get($apiResult, 'meta.total', 0);
?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-container">
        <div class="container">
            <div class="row">
                
                <div class="col-md-3 page-sidebar">
                    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <h2 class="title-2">
                            <i class="fas fa-envelope"></i> <?php echo e(t('inbox')); ?>

                        </h2>
                        
                        <?php if(session()->has('flash_notification')): ?>
                            <div class="row">
                                <div class="col-xl-12">
                                    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div id="successMsg" class="alert alert-success hide" role="alert"></div>
                        <div id="errorMsg" class="alert alert-danger hide" role="alert"></div>
                        
                        <div class="inbox-wrapper">
                            <div class="row">
                                <div class="col-md-3 col-lg-2">
                                    <div class="btn-group hidden-sm"></div>
                                </div>
                                
                                <div class="col-md-9 col-lg-10">
                                    
                                    <div class="btn-group mobile-only-inline">
                                        <a href="#" class="btn btn-primary text-uppercase">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group hidden-sm">
                                        <button type="button" class="btn btn-sm-1 btn-default pb-0">
                                            <div class="form-check p-0 m-0">
                                                <input type="checkbox" id="form-check-all">
                                            </div>
                                        </button>
                                        
                                        <button type="button" class="btn btn-sm-5 btn-default dropdown-toggle" data-bs-toggle="dropdown">
                                            <span class="dropdown-menu-sort-selected"><?php echo e(t('action')); ?></span>
                                        </button>
    
                                        <?php echo csrf_field(); ?>

                                        <ul id="groupedAction" class="dropdown-menu dropdown-menu-sort" role="menu">
                                            <li class="dropdown-item">
                                                <a href="<?php echo e(url('account/messages/actions?type=markAsRead')); ?>">
                                                    <?php echo e(t('Mark as read')); ?>

                                                </a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="<?php echo e(url('account/messages/actions?type=markAsUnread')); ?>">
                                                    <?php echo e(t('Mark as unread')); ?>

                                                </a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="<?php echo e(url('account/messages/actions?type=markAsImportant')); ?>">
                                                    <?php echo e(t('Mark as important')); ?>

                                                </a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="<?php echo e(url('account/messages/actions?type=markAsNotImportant')); ?>">
                                                    <?php echo e(t('Mark as not important')); ?>

                                                </a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="<?php echo e(url('account/messages/delete')); ?>">
                                                    <?php echo e(t('Delete')); ?>

                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <button type="button" id="btnRefresh" class="btn btn-sm-1 btn-default hidden-sm" data-bs-toggle="tooltip" title="<?php echo e(t('refresh')); ?>">
                                        <span class="fas fa-sync-alt"></span>
                                    </button>
                                    
                                    <div class="btn-group hidden-sm">
                                        <button type="button" class="btn btn-sm-5 btn-default dropdown-toggle" data-bs-toggle="dropdown">
                                            <?php echo e(t('more')); ?>

                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class="dropdown-item">
                                                <a class="markAllAsRead"><?php echo e(t('Mark all as read')); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="message-tool-bar-right float-end" id="linksThreads">
                                        <?php echo $__env->make('account.messenger.threads.links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="border-0 bg-secondary">
                            
                            <div class="row">
                                <?php echo $__env->make('account.messenger.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                                <div class="col-md-9 col-lg-10">
                                    <div class="message-list">
                                        <div id="listThreads">
                                            <?php echo $__env->make('account.messenger.threads.threads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
    <style>
        
        .loading-img {
            position: absolute;
            width: 32px;
            height: 32px;
            left: 50%;
            top: 50%;
            margin-left: -16px;
            margin-right: -16px;
            z-index: 100000;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
        var loadingImage = '<?php echo e(url('images/loading.gif')); ?>';
        var loadingErrorMessage = '<?php echo e(t('Threads could not be loaded')); ?>';
        var actionText = '<?php echo e(t('action')); ?>';
        var actionErrorMessage = '<?php echo e(t('This action could not be done')); ?>';
        var title = {
            'seen': '<?php echo e(t('Mark as read')); ?>',
            'notSeen': '<?php echo e(t('Mark as unread')); ?>',
            'important': '<?php echo e(t('Mark as important')); ?>',
            'notImportant': '<?php echo e(t('Mark as not important')); ?>',
        };

        setInterval(function() {
            getThreadsAjax(window.location.href);
        }, 3000);

        setInterval(function() {
            var paceActiveElement = document.querySelector('.pace-active');
            if (paceActiveElement) {
                paceActiveElement.className = 'pace pace-inactive';
            }
        }, 50);

        setInterval(function() {
            var paceRunningElement = document.querySelector('.pace-running');
            if (paceRunningElement) {
                paceRunningElement.className = 'skin pace-done';
            }
        }, 50);
	</script>
    <script src="<?php echo e(url('assets/js/app/messenger.js')); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/index.blade.php ENDPATH**/ ?>