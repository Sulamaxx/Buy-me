


<?php
    $fiTheme = config('larapen.core.fileinput.theme', 'bs5');
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
                        
                        <?php if(isset($errors) && $errors->any()): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
                                <ul class="list list-check">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="mb-0"><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
    
                        <div id="successMsg" class="alert alert-success hide" role="alert"></div>
                        <div id="errorMsg" class="alert alert-danger hide" role="alert"></div>
                        
                        <div class="inbox-wrapper">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="user-bar-top">
                                        <div class="user-top">
                                            <p>
                                                <a href="<?php echo e(url('account/messages')); ?>">
                                                    <i class="fas fa-inbox"></i>
                                                </a>&nbsp;
                                                <?php if(auth()->id() != data_get($thread, 'p_creator.id')): ?>
                                                    <a href="#user">
                                                        <?php if(isUserOnline(data_get($thread, 'p_creator'))): ?>
                                                            <i class="fa fa-circle color-success"></i>&nbsp;
                                                        <?php endif; ?>
                                                        <strong>
                                                            <a href="<?php echo e(\App\Helpers\UrlGen::user(data_get($thread, 'p_creator'))); ?>">
                                                                <?php echo e(data_get($thread, 'p_creator.name')); ?>

                                                            </a>
                                                        </strong>
                                                    </a>
                                                <?php endif; ?>
                                                <strong><?php echo e(t('Contact request about')); ?></strong>
                                                <a href="<?php echo e(\App\Helpers\UrlGen::post(data_get($thread, 'post'))); ?>">
                                                    <?php echo e(data_get($thread, 'post.title')); ?>

                                                </a>
                                            </p>
                                        </div>
    
                                        <div class="message-tool-bar-right float-end call-xhr-action">
                                            <div class="btn-group btn-group-sm">
                                                <?php if(data_get($thread, 'p_is_important')): ?>
                                                    <a href="<?php echo e(url('account/messages/' . data_get($thread, 'id') . '/actions?type=markAsNotImportant')); ?>"
                                                       class="btn btn-secondary markAsNotImportant"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       title="<?php echo e(t('Mark as not important')); ?>"
                                                    >
                                                        <i class="fas fa-star"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(url('account/messages/' . data_get($thread, 'id') . '/actions?type=markAsImportant')); ?>"
                                                       class="btn btn-secondary markAsImportant"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       title="<?php echo e(t('Mark as important')); ?>"
                                                    >
                                                        <i class="far fa-star"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?php echo e(url('account/messages/' . data_get($thread, 'id') . '/delete')); ?>"
                                                   class="btn btn-secondary"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   title="<?php echo e(t('Delete')); ?>"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <?php if(data_get($thread, 'p_is_unread')): ?>
                                                    <a href="<?php echo e(url('account/messages/' . data_get($thread, 'id') . '/actions?type=markAsRead')); ?>"
                                                       class="btn btn-secondary markAsRead"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       title="<?php echo e(t('Mark as read')); ?>"
                                                    >
                                                        <i class="fas fa-envelope"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(url('account/messages/' . data_get($thread, 'id') . '/actions?type=markAsUnread')); ?>"
                                                       class="btn btn-secondary markAsRead"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       title="<?php echo e(t('Mark as unread')); ?>"
                                                    >
                                                        <i class="fas fa-envelope-open"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="border-0 bg-secondary">
                            
                            <div class="row">
                                <?php echo $__env->make('account.messenger.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                                <div class="col-md-9 col-lg-10 chat-row">
                                    <div class="message-chat p-2 rounded">
                                        <div id="messageChatHistory" class="message-chat-history">
                                            <div id="linksMessages" class="text-center">
                                                <?php echo $linksRender; ?>

                                            </div>
                                            
                                            <?php echo $__env->make('account.messenger.messages.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            
                                        </div>
                                        
                                        <div class="type-message">
                                            <div class="type-form">
                                                <?php
                                                    $updateUrl = url('account/messages/' . data_get($thread, 'id'));
                                                ?>
                                                <form id="chatForm" role="form" method="POST" action="<?php echo e($updateUrl); ?>" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>

                                                    <?php echo view('honeypot::honeypot'); ?>
                                                    <input name="_method" type="hidden" value="PUT">
                                                    <textarea id="body" name="body"
                                                          maxlength="500"
                                                          rows="3"
                                                          class="input-write form-control"
                                                          placeholder="<?php echo e(t('Type a message')); ?>"
                                                          style="<?php echo e((config('lang.direction')=='rtl') ? 'padding-left' : 'padding-right'); ?>: 75px;"
                                                    ></textarea>
                                                    <div class="button-wrap">
                                                        <input id="addFile" name="filename" type="file">
                                                        <button id="sendChat" class="btn btn-primary" type="submit">
                                                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </form>
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
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_styles'); ?>
    <link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css')); ?>" rel="stylesheet">
    <?php if(config('lang.direction') == 'rtl'): ?>
        <link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css')); ?>" rel="stylesheet">
    <?php endif; ?>
    <?php if(str_starts_with($fiTheme, 'explorer')): ?>
        <link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.min.css')); ?>" rel="stylesheet">
    <?php endif; ?>
    <style>
        .file-input {
            display: inline-block;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>

    <script>
        var loadingImage = '<?php echo e(url('images/loading.gif')); ?>';
        var loadingErrorMessage = '<?php echo e(t('Threads could not be loaded')); ?>';
        var actionErrorMessage = '<?php echo e(t('This action could not be done')); ?>';
        var title = {
            'seen': '<?php echo e(t('Mark as read')); ?>',
            'notSeen': '<?php echo e(t('Mark as unread')); ?>',
            'important': '<?php echo e(t('Mark as important')); ?>',
            'notImportant': '<?php echo e(t('Mark as not important')); ?>',
        };
    </script>
    <script src="<?php echo e(url('assets/js/app/messenger.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/app/messenger-chat.js')); ?>" type="text/javascript"></script>
    
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('common/js/fileinput/locales/' . config('app.locale') . '.js')); ?>" type="text/javascript"></script>
    
    <script>
        let options = {};
        options.theme = '<?php echo e($fiTheme); ?>';
        options.language = '<?php echo e(config('app.locale')); ?>';
        options.rtl = <?php echo e((config('lang.direction') == 'rtl') ? 'true' : 'false'); ?>;
        options.allowedFileExtensions = <?php echo getUploadFileTypes('file', true); ?>;
        options.minFileSize = <?php echo e((int)config('settings.upload.min_file_size', 0)); ?>;
        options.maxFileSize = <?php echo e((int)config('settings.upload.max_file_size', 1000)); ?>;
        options.browseClass = 'btn btn-primary';
        options.browseIcon = '<i class="fas fa-paperclip" aria-hidden="true"></i>';
        options.layoutTemplates = {
            main1: '{browse}',
            main2: '{browse}',
            btnBrowse: '<div tabindex="500" class="{css}"{status}>{icon}</div>',
        };
        
        
        $('#addFile').fileinput(options);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/show.blade.php ENDPATH**/ ?>