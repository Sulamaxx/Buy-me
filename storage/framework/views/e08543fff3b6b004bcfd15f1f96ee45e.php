


<?php $__env->startSection('wizard'); ?>
    <?php echo $__env->first([
        config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard',
        'post.createOrEdit.multiSteps.inc.wizard'
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php
    $packages ??= collect();
    $paymentMethods ??= collect();

    $selectedPackage ??= null;
    $currentPackagePrice = $selectedPackage->price ?? 0;
?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-container">
        <?php
        $post_type_id = request()->session()->get('postInput')['post_type_id'];
        ?>
        <div class="container">
            <div class="row">

                <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.inc.notification', 'post.inc.notification'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="col-md-12 page-content">
                    <div class="inner-box">
                        <h2 class="title-2">
                            <strong>
                                <?php if(!empty($selectedPackage)): ?>
                                    <i class="fas fa-wallet"></i> <?php echo e(t('Payment')); ?>

                                <?php else: ?>
                                    <i class="fas fa-tags"></i> <?php echo e(t('Pricing')); ?>

                                <?php endif; ?>
                            </strong>
                        </h2>

                        <div class="row"> 
                            <div class="col-md-6"> 
                                <form class="form" id="payableForm" method="POST" action="<?php echo e(url()->current()); ?>">
                                    <?php echo csrf_field(); ?>

                                    <fieldset>
                                        <?php if(!empty($selectedPackage)): ?>
                                            <?php echo $__env->first([
                                                config('larapen.core.customizedViewPath') . 'payment.packages.selected',
                                                'payment.packages.selected'
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php else: ?>
                                            <?php echo $__env->first([
                                                config('larapen.core.customizedViewPath') . 'payment.packages',
                                                'payment.packages'
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endif; ?>
                                    
                                </div>
                            <div class="col-md-6"> 
                                <div class="well pb-0" style="padding-top: 10px">
                                    <?php echo $__env->first([
                                        config('larapen.core.customizedViewPath') . 'payment.payment-methods',
                                        'payment.payment-methods'
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php echo $__env->first([
                                        config('larapen.core.customizedViewPath') . 'payment.payment-methods.plugins',
                                        'payment.payment-methods.plugins'
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <div id="selected-packages-list" style="margin-top: 10px;border-top: 1px solid #ddd; padding-top: 10px;"></div>
                                    <p class="mb-0" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #ddd; padding-top: 10px;">
                                        <strong>
                                            <span><?php echo e(t('Payable Amount')); ?>:</span>
                                        </strong>
                                        <strong>
                                            <span>
                                                <span class="price-currency amount-currency currency-in-left" style="display: none;"></span>
                                                <span class="payable-amount">0</span>
                                                <span class="price-currency amount-currency currency-in-right" style="display: none;"></span>
                                            </span>
                                        </strong>
                                    </p>
                                </div>
                                <div class="mb-3" style="padding-top: 20px">
                
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter your coupon code">
                                        <button class="btn btn-outline-secondary" type="button" id="apply_coupon">Apply</button>
                                    </div>
                                    <div id="coupon_message" class="form-text text-success"></div>
                                    <div id="coupon_error" class="form-text text-danger"></div>
                                </div>
                            
                                <div class="text-center mt-8" style="margin-top: 40px">
                                    <a href="<?php echo e(url('posts/create/photos')); ?>" class="btn btn-default btn-lg">
                                        <?php echo e(t('Previous')); ?>

                                    </a>
                                    <button id="submitPayableForm" class="btn btn-success btn-lg submitPayableForm"> <?php echo e(t('Pay')); ?> </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
    <?php
        $jqValidateLangFilePath = 'assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js';
    ?>
    <?php if(file_exists(public_path() . '/' . $jqValidateLangFilePath)): ?>
        <script src="<?php echo e(url($jqValidateLangFilePath)); ?>" type="text/javascript"></script>
    <?php endif; ?>

    <script>
        <?php if($packages->count() > 0 && $paymentMethods->count() > 0): ?>

            var currentPackagePrice = <?php echo e($currentPackagePrice ?? 0); ?>;
            var paymentIsActive = <?php echo e($paymentIsActive ?? 0); ?>;
            var isCreationFormPage = true;
            var forceDisplayPaymentMethods = <?php echo e(!empty($selectedPackage) ? 'true' : 'false'); ?>;
            $(document).ready(function () {
                let packageCheckboxes = $('input[name="package_id[]"]');
                let paymentMethodEl = $('#paymentMethodId');
                let payableAmountContainer = $('.payable-amount');
                let amountCurrencyLeft = $('.amount-currency.currency-in-left');
                let amountCurrencyRight = $('.amount-currency.currency-in-right');

                // Function to update the total payable amount and display selected packages
                function updatePayableAmount() {
                    let totalAmount = 0;
                    let selectedPackagesInfo = [];
                    let currencySymbol = '';
                    let currencyInLeft = false;

                    packageCheckboxes.filter(':checked').each(function () {
                        let price = parseFloat($(this).data('price'));
                        let name = $(this).data('name');
                        let symbol = $(this).data('currencysymbol');
                        let inLeft = $(this).data('currencyinleft') === 1;

                        if (!isNaN(price)) {
                            totalAmount += price;
                        }
                        selectedPackagesInfo.push({ name: name, price: price, symbol: symbol, inLeft: inLeft });
                        currencySymbol = symbol;
                        currencyInLeft = inLeft;
                    });

                    payableAmountContainer.text(totalAmount.toFixed(2));

                    if (currencySymbol) {
                        if (currencyInLeft) {
                            amountCurrencyLeft.text(currencySymbol).show();
                            amountCurrencyRight.hide();
                        } else {
                            amountCurrencyRight.text(currencySymbol).show();
                            amountCurrencyLeft.hide();
                        }
                    } else {
                        amountCurrencyLeft.hide();
                        amountCurrencyRight.hide();
                    }

                     let selectedPackagesList = $('#selected-packages-list');
                     selectedPackagesList.empty();
                     selectedPackagesInfo.forEach(pkg => {
                      selectedPackagesList.append(`<p style="display: flex; justify-content: space-between; align-items: center;"><strong><span>${pkg.name}: </span></strong><strong><span>${pkg.symbol} ${pkg.price.toFixed(2)}</span></strong></p>`);
                     });

                    showPaymentMethods(totalAmount, forceDisplayPaymentMethods);
                    let selectedPaymentMethod = paymentMethodEl.find('option:selected').data('name');
                    showPaymentSubmitButton(currentPackagePrice, totalAmount, paymentIsActive, selectedPaymentMethod, isCreationFormPage);
                }

                // Initial call to set the amount if any package is pre-selected
                updatePayableAmount();

                // Listen for changes on the package checkboxes
                packageCheckboxes.on('change', function () {
                    updatePayableAmount();
                });

                // Listen for changes on the payment method (though it might not directly affect the total)
                paymentMethodEl.on('change', function () {
                    let selectedPaymentMethod = $(this).find('option:selected').data('name');
                    let currentTotalAmount = parseFloat(payableAmountContainer.text());
                    showPaymentSubmitButton(currentPackagePrice, currentTotalAmount, paymentIsActive, selectedPaymentMethod, isCreationFormPage);
                });

                /* Form Default Submission */
                $('#submitPayableForm').on('click', function (e) {
                    e.preventDefault();

                    let currentTotalAmount = parseFloat(payableAmountContainer.text());
                    if (currentTotalAmount <= 0) {
                        $('#payableForm').submit();
                    }

                    return false;
                });

                <?php if(isset($post_type_id) && $post_type_id == 2): ?>
                {
                    //disable other packages else wrong selection or abuse may happen to bypass paid ads to free
                    document.getElementById('packageId-15').disabled = true;
                    document.getElementById('packageId-1').disabled = true;
                    document.getElementById('packageId-2').disabled = true;
                    document.getElementById('packageId-8').disabled = true;
                    document.getElementById('packageId-3').disabled = true;
                    document.getElementById('packageId-9').disabled = true;
                    document.getElementById('packageId-10').disabled = true;
                    document.getElementById('packageId-11').disabled = true;

                    document.getElementById('packageId-12').disabled = true;
                    document.getElementById('packageId-13').disabled = true;
                    document.getElementById('packageId-14').disabled = true;

                    var get= document.getElementById('Paid');
                    get.click();
                    var get= document.getElementById('Wanted Ad');
                    get.click();
                    document.getElementById('packageId-19').disabled = false;
                    var get= document.getElementById('packageId-19');
                    get.click();
                }
                <?php endif; ?>
            });

        <?php endif; ?>

        /* Show or Hide the Payment Submit Button */
        /* NOTE: Prevent Package's Downgrading */
        /* Hide the 'Skip' button if Package price > 0 */
        function showPaymentSubmitButton(currentPackagePrice, packagePrice, paymentIsActive, paymentMethod, isCreationFormPage = true) {
            let submitBtn = $('#submitPayableForm');
            let submitBtnLabel = {
                'pay': '<?php echo e(t('Pay')); ?>',
                'submit': '<?php echo e(t('submit')); ?>',
            };
            let skipBtn = $('#skipBtn');

            if (packagePrice > 0) {
                submitBtn.html(submitBtnLabel.pay).show();
                skipBtn.hide();
                //          $("#paymentMethodId").val('5').change(); //make offline payment method autoselect - disabled due to JS error

                if (currentPackagePrice > packagePrice) {
                    submitBtn.hide().html(submitBtnLabel.submit);
                }
                if (currentPackagePrice === packagePrice) {
                    if (paymentMethod === 'offlinepayment') {
                        if (!isCreationFormPage && paymentIsActive !== 1) {
                            submitBtn.hide().html(submitBtnLabel.submit);
                            skipBtn.show();
                        }
                    }
                }
            } else {
                skipBtn.show();
                submitBtn.html(submitBtnLabel.submit);
            }
        }

        $(document).ready(function() {
            var couponCodes = {
                'SUMMER20': 0.20,
                'WELCOME10': 0.10,
                'FREEPACKAGE': 1.00
            };

            $('#apply_coupon').on('click', function() {
                var couponCode = $('#coupon_code').val().toUpperCase();
                var payableAmountElement = $('.payable-amount');
                var currentPrice = parseFloat(payableAmountElement.text());

                $('#coupon_message').text('');
                $('#coupon_error').text('');

                if (isNaN(currentPrice)) {
                    $('#coupon_error').text('Error: Could not read the current price.');
                    return;
                }

                var discountPercentage = couponCodes[couponCode];
                var discountAmount = 0;
                var discountedPrice = currentPrice;

                if (couponCode in couponCodes) {
                    if (discountPercentage > 0) {
                        discountAmount = currentPrice * discountPercentage;
                        discountedPrice = currentPrice - discountAmount;
                        $('#coupon_message').text('Coupon code applied! You saved ' + (discountPercentage * 100) + '%');
                    } else if (discountPercentage === 1.00) {
                        discountedPrice = 0;
                        $('#coupon_message').text('Coupon code applied! This package is now free.');
                    }

                    payableAmountElement.text(discountedPrice.toFixed(2));
                } else if (couponCode) {
                    $('#coupon_error').text('Invalid coupon code.');
                } else {
                    $('#coupon_error').text('Please enter a coupon code.');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/post/createOrEdit/multiSteps/packages/create.blade.php ENDPATH**/ ?>