

<?php $__env->startSection('content'); ?>
	
	<?php if(isset($errors) && $errors->any()): ?>
        <div class="alert alert-danger ms-0 me-0 mb-5">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($error); ?><br>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
	<?php endif; ?>
    
    <?php if(session('status')): ?>
        <div class="alert alert-success ms-0 me-0 mb-5">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>
    
    <div id="loginform">
        
        <div class="logo">
            <h3 class="box-title mb-3"><?php echo e(trans('admin.login')); ?></h3>
        </div>
        
        <div class="row">
            <div class="col-12">
                
                <form class="form-horizontal mt-3" id="loginform" action="<?php echo e(admin_url('login')); ?>" method="post">
                    <?php echo csrf_field(); ?>

                    <?php echo view('honeypot::honeypot'); ?>
                    
                    
                    <?php
                        if (isset($errors)) {
                            $emailHasError = $errors->has('email');
                            $emailRowError = $emailHasError ? ' has-danger' : '';
                            $emailFieldError = $emailHasError ? ' form-control-danger' : '';
							$emailError = $errors->first('email');
                        }
                    ?>
                    <div class="row mb-3 auth-field-item<?php echo e($emailRowError ?? ''); ?>">
                        <?php if(config('settings.sms.enable_phone_as_auth_field') == '1'): ?>
                            <div class="col-12 pb-1">
                                <a href="" class="auth-field text-muted" data-auth-field="phone"><?php echo e(t('login_with_phone')); ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input id="email" name="email"
                                   type="text"
                                   placeholder="<?php echo e(trans('admin.email_address')); ?>"
                                   class="form-control<?php echo e($emailFieldError ?? ''); ?>"
                                   value="<?php echo e(old('email')); ?>"
                            >
                        </div>
                        <?php if(isset($emailHasError) && $emailHasError): ?>
                            <div class="invalid-feedback"><?php echo e($emailError ?? ''); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    
                    <?php if(config('settings.sms.enable_phone_as_auth_field') == '1'): ?>
                        <?php
                            if (isset($errors)) {
                                $phoneHasError = $errors->has('phone');
                                $phoneRowError = $emailHasError ? ' has-danger' : '';
                                $phoneFieldError = $emailHasError ? ' form-control-danger' : '';
                                $phoneError = $errors->first('email');
                            }
                        ?>
                        <div class="row mb-3 auth-field-item<?php echo e($phoneHasError ?? ''); ?>">
                            <div class="col-12 pb-1">
                                <a href="" class="auth-field text-muted" data-auth-field="email"><?php echo e(t('login_with_email')); ?></a>
                            </div>
                            <div class="">
                                <input id="phone" name="phone"
                                       type="tel"
                                       class="form-control<?php echo e($phoneRowError ?? ''); ?>"
                                       value="<?php echo e(phoneE164(old('phone'), old('phone_country', 'us'))); ?>"
                                >
                                <input name="phone_country" type="hidden" value="<?php echo e(old('phone_country', 'us')); ?>">
                            </div>
                            <?php if(isset($phoneHasError) && $phoneHasError): ?>
                                <div class="invalid-feedback"><?php echo e($phoneError ?? ''); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    
                    <input name="auth_field" type="hidden" value="<?php echo e(old('auth_field', getAuthField())); ?>">
                    
                    
                    <?php
                        if (isset($errors)) {
							$pwdHasError = $errors->has('phone');
							$pwdRowError = $pwdHasError ? ' has-danger' : '';
							$pwdFieldError = $pwdHasError ? ' form-control-danger' : '';
							$pwdError = $errors->first('email');
						}
                    ?>
                    <div class="row mb-3<?php echo e($pwdRowError ?? ''); ?>">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input id="password" name="password"
                                   type="password"
                                   class="form-control<?php echo e($pwdFieldError ?? ''); ?>"
                                   placeholder="<?php echo e(trans('admin.password')); ?>"
                                   autocomplete="new-password"
                            >
                        </div>
                        <?php if(isset($pwdHasError) && $pwdHasError): ?>
                            <div class="invalid-feedback"><?php echo e($pwdError ?? ''); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    
                    <?php echo $__env->make('layouts.inc.tools.captcha', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    
                    
                    <div class="row mb-3">
                        <div class="d-flex">
                            <div class="checkbox checkbox-info pt-0">
                                <input type="checkbox" name="remember_me" id="rememberMe" class="material-inputs chk-col-indigo">
                                <label for="rememberMe"> <?php echo e(trans('admin.remember_me')); ?> </label>
                            </div>
                            <div class="ms-auto">
                                <a href="javascript:void(0)" id="to-recover" class="text-muted float-end">
                                    <i class="fa fa-lock me-1"></i> <?php echo e(trans('admin.forgot_your_password')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row mb-3 text-center mt-4">
                        <div class="col-12 d-grid">
                            <button class="btn btn-primary btn-lg waves-effect waves-light" type="submit"><?php echo e(trans('admin.login')); ?></button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        
    </div>
    
    <?php echo $__env->make('admin.auth.passwords.inc.recover-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>