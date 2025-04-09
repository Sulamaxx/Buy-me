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

                        <div class="row"> {{-- This row will contain your two columns --}}
                            <div class="col-md-6"> {{-- Left side for packages --}}
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
                                    
                                </div>
                            <div class="col-md-6"> {{-- Right side --}}
                                <div class="well pb-0" style="padding-top: 10px">
                                    @includeFirst([
                                        config('larapen.core.customizedViewPath') . 'payment.payment-methods',
                                        'payment.payment-methods'
                                    ])
                                    @includeFirst([
                                        config('larapen.core.customizedViewPath') . 'payment.payment-methods.plugins',
                                        'payment.payment-methods.plugins'
                                    ])
                                    <div id="selected-packages-list" style="margin-top: 10px;border-top: 1px solid #ddd; padding-top: 10px;"></div>
                                    <p class="mb-0" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #ddd; padding-top: 10px;">
                                        <strong>
                                            <span>{{ t('Payable Amount') }}:</span>
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

                @if(isset($post_type_id) && $post_type_id == 2)
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
                @endif
            });

        @endif

        /* Show or Hide the Payment Submit Button */
        /* NOTE: Prevent Package's Downgrading */
        /* Hide the 'Skip' button if Package price > 0 */
        function showPaymentSubmitButton(currentPackagePrice, packagePrice, paymentIsActive, paymentMethod, isCreationFormPage = true) {
            let submitBtn = $('#submitPayableForm');
            let submitBtnLabel = {
                'pay': '{{ t('Pay') }}',
                'submit': '{{ t('submit') }}',
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

        // Clear previous messages
        $('#coupon_message').text('');
        $('#coupon_error').text('');

        // Validate current price
        if (isNaN(currentPrice)) {
            $('#coupon_error').text('Error: Could not read the current price.');
            return;
        }

        // Send AJAX request
        $.ajax({
            url: "{{ route('coupons.getByCode') }}",
            method: 'POST',
            data: {
                code: couponCode,
                _token: '{{ csrf_token() }}' // CSRF token for Laravel
            },
            success: function(response) {
                if (response.success) {

                    var discount = response.discount;
                    var valueType = response.value_type;
                    
                    console.log(discount+' '+valueType);
                    
                    var discountAmount = valueType === 'percentage' ? currentPrice * discount : discount;
                    var discountedPrice = currentPrice - discountAmount;

                    // Update UI
                    payableAmountElement.text(discountedPrice.toFixed(2));
                    $('#discounted_amount').val(discountedPrice.toFixed(2));
                    $('#coupon_message').text('Coupon applied! You saved ' + 
                        (valueType === 'percentage' ? (discount * 100) + '%' : '$' + discountAmount.toFixed(2)));
                } else {
                    $('#coupon_error').text(response.message);
                }
            },
            error: function() {
                $('#coupon_error').text('An error occurred while validating the coupon.');
            }
        });
    });
        });
    </script>
@endsection