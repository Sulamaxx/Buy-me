<div class="row payment-plugin" id="webxpayPayment" style="display: none;">
    <div class="col-md-10 col-sm-12 box-center center mt-4 mb-0">
        <div class="row">
            
            <div class="col-xl-12 text-center">
                <img class="img-fluid"
                     src="<?php echo e(url('plugins/webxpay/images/payment.png')); ?>"
                     title="<?php echo e(trans('webxpay::messages.payment_with')); ?>"
                     alt="<?php echo e(trans('webxpay::messages.payment_with')); ?>"
                >
            </div>
            
            <!-- ... -->
            
        </div>
    </div>
</div>

<?php $__env->startSection('after_scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
    <script>
        $(document).ready(function ()
        {
            var selectedPackage = $('input[name=package_id]:checked').val();
            var packagePrice = getPackagePrice(selectedPackage);
            var paymentMethod = $('#paymentMethodId').find('option:selected').data('name');
            
            /* Check Payment Method */
            checkPaymentMethodForWebxPay(paymentMethod, packagePrice);
            
            $('#paymentMethodId').on('change', function () {
                paymentMethod = $(this).find('option:selected').data('name');
                checkPaymentMethodForWebxPay(paymentMethod, packagePrice);
            });
            $('.package-selection').on('click', function () {
                selectedPackage = $(this).val();
                packagePrice = getPackagePrice(selectedPackage);
                paymentMethod = $('#paymentMethodId').find('option:selected').data('name');
                checkPaymentMethodForWebxPay(paymentMethod, packagePrice);
            });
            
            /* Send Payment Request */
            $('#submitPayableForm').on('click', function (e)
            {
                e.preventDefault();
                
                paymentMethod = $('#paymentMethodId').find('option:selected').data('name');
                
                if (paymentMethod !== 'webxpay' || packagePrice <= 0) {
                    return false;
                }
                
                $('#payableForm').submit();
                
                /* Prevent form from submitting */
                return false;
            });
        });
        
        function checkPaymentMethodForWebxPay(paymentMethod, packagePrice)
        {
            if (paymentMethod === 'webxpay' && packagePrice > 0) {
                $('#webxpayPayment').show();
            } else {
                $('#webxpayPayment').hide();
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\extras\plugins\webxpay\resources\views/webxpay.blade.php ENDPATH**/ ?>