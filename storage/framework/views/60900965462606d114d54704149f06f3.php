<?php
    $packageType ??= null;
    $packages ??= collect();
    $paymentMethods ??= collect();

    $payment ??= [];
    $upcomingPayment ??= [];
    $package ??= []; // Selected package
    $selectedPackageId = data_get($package, 'id', data_get($payment, 'package.id', 0));

    $isPayabilityActivated = (
        !empty($packageType)
        && isset($packages, $paymentMethods)
        && $packages->count() > 0
        && $paymentMethods->count() > 0
    );

    $doesPaymentExist = (
        !empty($payment)
        && !empty(data_get($payment, 'package'))
        && !empty(data_get($payment, 'paymentMethod'))
    );
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?php if($isPayabilityActivated): ?>
    <div class="well pb-0">
        <table id="packagesTable" class="table table-hover checkboxtable mb-0">
            <tbody>
            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $packageDisabledAttr = '';
                $badge = '';
                $myflag = '';

                if ($doesPaymentExist) {
                    if ($package->price > 0) {
                        if ($package->currency_code == data_get($payment, 'package.currency_code')) {
                            if ($package->price < data_get($payment, 'package.price')) {
                                $badge = ' <span class="badge bg-warning">' . t('downgrade') . '</span>';
                            }
                            if ($package->price > data_get($payment, 'package.price')) {
                                $badge = ' <span class="badge bg-success" >' . t('upgrade') . '</span>';
                            }
                            if ($package->price === data_get($payment, 'package.price')) {
                                $badge = '';
                            }
                        } else {
                            $badge = '';
                        }
                    } else {
                        $packageDisabledAttr = ' disabled';
                        $badge = ' <span class="badge bg-danger">' . t('not_available') . '</span>';
                    }

                    if ($package->id == data_get($payment, 'package.id')) {
                        $badge = ' <span class="badge bg-secondary">' . t('current') . '</span>';
                        if (data_get($payment, 'active') == 0) {
                            $badge .= ' <span class="badge bg-info">' . t('payment_pending') . '</span>';
                        } else {
                            $badge .= ' <span class="badge bg-info">' . data_get($payment, 'expiry_info') . '</span>';
                        }
                    }
                } else {
                    if ($package->price > 0) {
                        $badge = ' <span class="badge bg-success" >' . t('upgrade') . '</span>';
                    }
                }

                if ($package->short_name) {
                    $myflag = $package->short_name;
                }
                ?>

                <tr>
                    <td class="text-start align-middle p-3">
                        <?php
                            $packageIdError = (isset($errors) && $errors->has('package_id')) ? ' is-invalid' : '';
                            $packageCheckedAttr = (is_array(old('package_id')) && in_array($package->id, old('package_id')))
                                                ? ' checked'
                                                : (($package->price == 0 && !old('package_id')) ? ' checked' : '');
                        ?>
                        <div class="form-check">
                            <input class="form-check-input package-selection<?php echo e($packageIdError); ?>"
                                   style="cursor: pointer;"
                                   type="checkbox"
                                   name="package_id[]"
                                   id="packageId-<?php echo e($package->id); ?>"
                                   value="<?php echo e($package->id); ?>"
                                   data-name="<?php echo e($package->name); ?>"
                                   data-price="<?php echo e($package->price); ?>"
                                   data-currencysymbol="<?php echo e($package->currency->symbol); ?>"
                                   data-currencyinleft="<?php echo e($package->currency->in_left); ?>"
                                   <?php echo e($packageCheckedAttr); ?> <?php echo e($packageDisabledAttr); ?>

                            >
                            <label class="form-check-label mb-0<?php echo e($packageIdError); ?>">
                                <strong class=""
                                        data-bs-placement="right"
                                        data-bs-toggle="tooltip"
                                        title="<?php echo $package->description_string; ?>"
                                >
                                    <?php if($package->ribbon!='') { ?><img for="<?php echo e($myflag); ?>"  style="width: 40px;" src="/public/images/ribbons/<?php echo e($package->ribbon); ?>.png" /><?php }
                                    else
                                    {
                                        if($myflag=='Paid')
                                        {
                                            ?>
                                                <img     style="width: 40px;" src="/public/images/ribbons/ads.png" />
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                                <img     style="width: 40px;" src="/public/images/ribbons/spotlight.png" />
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php if($package->name=='Regular List (Free)123'){ ?><font size="+2"><?php } ?><?php echo $package->name . $badge; ?><?php if($package->name=='Regular List (Free)123'){ ?></font><?php } ?>
                                </strong>
                            </label>
                        </div>
                    </td>
                    <td class="text-end align-middle p-3">
                        <p id="price-<?php echo e($package->id); ?>" class="mb-0">
                            <?php if($package->currency->in_left == 1): ?>
                                <span class="price-currency"><?php echo $package->currency->symbol; ?></span>
                            <?php endif; ?>
                            <span class="price-int"><?php echo e($package->price); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <?php if($package->currency->in_left == 0): ?>
                                <span class="price-currency"><?php echo $package->currency->symbol; ?></span>
                            <?php endif; ?>
                        </p>
                    </td>
                </tr>

                <?php
                if($myflag=='Free')
                {
                    ?>
                    <tr><td colspan="2">
                            <h3>
                                <?php if($packageType == 'promotion'): ?>
                                    <i class="fa fa-product-hunt icon-color-4"></i> <?php echo e(t('promote_your_listing')); ?>

                                <?php else: ?>
                                    <i class="fa fa-product-hunt icon-color-4"></i> <?php echo e(t('upgrade_your_subscription')); ?>

                                <?php endif; ?>
                            </h3>
                            <p>
                                <?php echo e(($packageType == 'promotion') ? t('promo_packages_hint') : t('subs_packages_hint')); ?>

                            </p>
                                </td></tr>
                    <?php
                }
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php if($doesPaymentExist): ?>
            <div class="form-check mt-3">
                <input name="accept_package_renewal" id="acceptPackageRenewal"
                       class="form-check-input"
                       value="1"
                       type="checkbox" <?php if(old('accept_package_renewal') == '1'): echo 'checked'; endif; ?>
                >
                <label class="form-check-label" for="acceptPackageRenewal">
                    <?php echo t('accept_package_renewal_label'); ?>

                </label>
                <div class="form-text text-muted">
                    <?php echo t('accept_package_renewal_hint', ['date' => data_get($upcomingPayment, 'period_start_formatted')]); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
    <style>
        .labels tr td {
            background-color: #F5F5F5;
            font-weight: bold;
        }

        .label tr td label {
            display: block;
        }

        [data-toggle="toggle"] {
            display: none;
        }

        /* Desktop Styles */
        @media (min-width: 992px) {
            .well.pb-0 > .row {
                display: flex;
                flex-wrap: wrap;
            }
            .well.pb-0 > .row > * {
                width: auto;
                max-width: none;
            }
            .well.pb-0 .package-section {
                width: 50%;
                padding-right: 15px;
            }
            .well.pb-0 .payment-section {
                width: 50%;
                padding-left: 15px;
            }
            .well.pb-0 .row > .col-md-12 {
                width: auto;
                max-width: none;
            }

            #packagesTable {
                width: 100%;
                table-layout: fixed;
            }

            #packagesTable td {
                word-break: break-word;
                overflow-wrap: break-word;
                white-space: normal !important;
            }
        }

        /* Mobile Styles (Optional - Adjust as needed) */
        @media (max-width: 991px) {

            #packagesTable td.text-end.align-middle.p-3,
            #packagesTable td.text-start.align-middle.p-3 {
                padding-inline: 0 !important;
            }
            .well.pb-0 .package-section,
            .well.pb-0 .payment-section {
                width: 100%;
            }
        }
    </style>
<?php endif; ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/payment/packages.blade.php ENDPATH**/ ?>