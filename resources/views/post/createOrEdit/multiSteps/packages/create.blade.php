{{--
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 * Website: https://laraclassifier.com
 * Author: BeDigit | https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - https://codecanyon.net/licenses/standard
--}}
@extends('layouts.master')

@section('wizard')
    @includeFirst([
        config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard',
        'post.createOrEdit.multiSteps.inc.wizard'
    ])
@endsection

@php
    $packages ??= collect();
    $paymentMethods ??= collect();

    $selectedPackage ??= null;
    $currentPackagePrice = $selectedPackage->price ?? 0;
@endphp
@section('content')
    @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
    <div class="main-container">
        <?php
        $post_type_id = request()->session()->get('postInput')['post_type_id'];
        ?>
        <div class="container">
            <div class="row">

                @includeFirst([config('larapen.core.customizedViewPath') . 'post.inc.notification', 'post.inc.notification'])

                <div class="col-md-12 page-content">
                    <div class="inner-box">

                        <h2 class="title-2">
                            <strong>
                                @if (!empty($selectedPackage))
                                    <i class="fas fa-wallet"></i> {{ t('Payment') }}
                                @else
                                    <i class="fas fa-tags"></i> {{ t('Pricing') }}
                                @endif
                            </strong>
                        </h2>

                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form" id="payableForm" method="POST" action="{{ url()->current() }}">
                                    {!! csrf_field() !!}
                                    <fieldset>

                                        @if (!empty($selectedPackage))
                                            @includeFirst([
                                                config('larapen.core.customizedViewPath') . 'payment.packages.selected',
                                                'payment.packages.selected'
                                            ])
                                        @else
                                            @includeFirst([
                                                config('larapen.core.customizedViewPath') . 'payment.packages',
                                                'payment.packages'
                                            ])
                                        @endif

                                        <div class="mb-3">
                                            <label for="coupon_code" class="form-label">Coupon Code</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter your coupon code">
                                                <button class="btn btn-outline-secondary" type="button" id="apply_coupon">Apply</button>
                                            </div>
                                            <div id="coupon_message" class="form-text text-success"></div>
                                            <div id="coupon_error" class="form-text text-danger"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-center mt-4">
                                                <a href="{{ url('posts/create/photos') }}" class="btn btn-default btn-lg">
                                                    {{ t('Previous') }}
                                                </a>
                                                <button id="submitPayableForm" class="btn btn-success btn-lg submitPayableForm"> {{ t('Pay') }} </button>
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
    </div>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
    @php
        $jqValidateLangFilePath = 'assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js';
    @endphp
    @if (file_exists(public_path() . '/' . $jqValidateLangFilePath))
        <script src="{{ url($jqValidateLangFilePath) }}" type="text/javascript"></script>
    @endif

    <script>
        @if ($packages->count() > 0 && $paymentMethods->count() > 0)

            var currentPackagePrice = {{ $currentPackagePrice ?? 0 }};
            var paymentIsActive = {{ $paymentIsActive ?? 0 }};
            var isCreationFormPage = true;
            var forceDisplayPaymentMethods = {{ !empty($selectedPackage) ? 'true' : 'false' }};
            $(document).ready(function ()
            {
                let selectedPackageEl = $('input[name=package_id]:checked');
                let paymentMethodEl = $('#paymentMethodId');

            //  document.getElementById('Paid').click();

                /* Get the selected package ID & info */
                var selectedPackage;

                if (selectedPackageEl.length > 0) {
                    selectedPackage = selectedPackageEl.val();
                } else {
                    if (hasQueryParameter('package')) {
                        let urlWithoutPackage = removeURLParameter('package');
                        redirect(urlWithoutPackage);
                    }
                }

                /* Show price & Payment Methods */
                var packagePrice = getPackagePrice(selectedPackage);
                var packageCurrencySymbol = selectedPackageEl.data('currencysymbol');
                var packageCurrencyInLeft = selectedPackageEl.data('currencyinleft');
                var paymentMethod = paymentMethodEl.find('option:selected').data('name');
                showPaymentMethods(packagePrice, forceDisplayPaymentMethods);
                showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
                showPaymentSubmitButton(currentPackagePrice, packagePrice, paymentIsActive, paymentMethod, isCreationFormPage);

                /* Select a Package */
                $('.package-selection').click(function () {
                    selectedPackage = $(this).val();
                    packagePrice = getPackagePrice(selectedPackage);
                    packageCurrencySymbol = $(this).data('currencysymbol');
                    packageCurrencyInLeft = $(this).data('currencyinleft');
                    showPaymentMethods(packagePrice);
                    showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
                    showPaymentSubmitButton(currentPackagePrice, packagePrice, paymentIsActive, paymentMethod, isCreationFormPage);
                    $("#paymentMethodId").val('5').change(); //make offline payment method autoselect
                });

                /* Select a Payment Method */
                paymentMethodEl.on('change', function () {
                    paymentMethod = $(this).find('option:selected').data('name');
                    showPaymentSubmitButton(currentPackagePrice, packagePrice, paymentIsActive, paymentMethod, isCreationFormPage);
                });

                /* Form Default Submission */
                $('#submitPayableForm').on('click', function (e) {
                    e.preventDefault();

                    if (packagePrice <= 0) {
                        $('#payableForm').submit();
                    }

                    return false;
                });

                if(<?php echo($post_type_id);?>=='2')
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
            });

        @endif

        /* Show or Hide the Payment Submit Button */
        /* NOTE: Prevent Package's Downgrading */
        /* Hide the 'Skip' button if Package price > 0 */
        function showPaymentSubmitButton(currentPackagePrice, packagePrice, paymentIsActive, paymentMethod, isCreationFormPage = true)
        {
            let submitBtn = $('#submitPayableForm');
            let submitBtnLabel = {
                'pay': '{{ t('Pay') }}',
                'submit': '{{ t('submit') }}',
            };
            let skipBtn = $('#skipBtn');

            if (packagePrice > 0) {
                submitBtn.html(submitBtnLabel.pay).show();
                skipBtn.hide();
    //          $("#paymentMethodId").val('5').change(); //make offline payment method autoselect - disabled due to JS error

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
        var currentPrice;

        $('#coupon_message').text('');
        $('#coupon_error').text('');

        if (payableAmountElement.length > 0) {
            currentPrice = parseFloat(payableAmountElement.text().replace(/[^0-9.]/g, '')); 
            if (isNaN(currentPrice)) {
                $('#coupon_error').text('Error: Could not read the current price.');
                return;
            }
        } else {
            $('#coupon_error').text('Error: Could not find the payable amount element.');
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
@endsection