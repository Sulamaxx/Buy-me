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
		<?php
			$packageIdError = (isset($errors) && $errors->has('package_id')) ? ' is-invalid' : '';
		?>
		<div class="row mb-3 mb-0">
        <?php
//             print_r($packages);
              $previous_grp = '';
              ?>
			<table id="packagesTable" class="table table-hover checkboxtable mb-0">
				<?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$packageDisabledAttr = '';
						$badge = '';
                $myflag = '';
                $myflag2 = '';
                if($previous_grp=='')
                {
                    $previous_grp = $package->short_name;
                    $myflag = $previous_grp;
                }
                else
                {
                    if($previous_grp == $package->short_name)
                    {
                        $myflag = '';
                    }
                    else
                    {
                        $previous_grp = $package->short_name;
                        $myflag = $previous_grp;
                    }
                }
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
					?>
                
                <?php
                if($myflag!='Free' && $myflag!='')
                {
                    if($myflag!='Free')
                    {
                       if($myflag2=='')
                       {
                           $myflag2=='1';
                       }
                       else
                       {
                           ?></tbody><?php
                       }
                    }
                    
                    ?>
                <tbody class="labels">
                <tr><td colspan="2"  >
                    <?php if($package->ribbon!='') { ?><img for="<?php echo e($myflag); ?>"  style="width: 40px;" src="/public/images/ribbons/<?php echo e($package->ribbon); ?>.png" /><?php } 
                    else
                    {
                        if($myflag=='Paid')
                        {
                        ?>
                         <!-- <i class="fas fa-dollar"></i> -->
						 <img    style="width: 40px;" src="/public/images/ribbons/ads.png" />
                        <?php  
                        } 
                        else 
                        {
                         ?>
                         <!--  <i class="fas fa-tv"></i>  -->
						 <img    style="width: 40px;" src="/public/images/ribbons/spotlight.png" />
                       <?php   
                        }
                    }
                    
                    
                    
                    
                    ?><label for="<?php echo e($myflag); ?>"   style="cursor: pointer; display: initial;" data-toggle="toggle"> <?php if($myflag=='Paid') { echo "Ad listings: Free &"; } else if($myflag=='Wanted Ad') {echo "Ad listings: ";  } else {echo "Promotion package: ";}   ?>  <?php echo e($myflag); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" name="<?php echo e($myflag); ?>" id="<?php echo e($myflag); ?>" data-toggle="toggle">
                    </td></tr>
                </tbody>
                <tbody class="hide">
                <?php
                }
                
                ?>
                
					<tr>
						<td class="text-start align-middle p-3">
							<?php
								$packageCheckedAttr = (old('package_id', $selectedPackageId) == $package->id)
														? ' checked'
														: (($package->price == 0) ? ' checked' : '');
							?>
							<div class="form-check">
								<input class="form-check-input package-selection<?php echo e($packageIdError); ?>"
                                       style="cursor: pointer;" 
									   type="radio"
									   name="package_id"
									   id="packageId-<?php echo e($package->id); ?>"
									   value="<?php echo e($package->id); ?>"
									   data-name="<?php echo e($package->name); ?>"
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
                                        <?php if($package->name=='Regular List (Free)123'){ ?><font size="+2"><?php } ?><?php echo $package->name . $badge; ?><?php if($package->name=='Regular List (Free)123'){ ?></font><?php } ?> </strong>
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
                    
<!--                    <tr><td class="text-start align-middle p-3">&nbsp;</td><td class="text-start align-middle p-3">&nbsp;</td></tr>-->
            </tbody> 
				<tr>
					<td class="text-start align-middle p-3">
						<?php echo $__env->first([
							config('larapen.core.customizedViewPath') . 'payment.payment-methods',
							'payment.payment-methods'
						], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!--                        make payable amount visible-->
                        <p class="mb-0" style="padding-right: 100px;">
							<strong> 
								<?php echo e(t('Payable Amount')); ?>:
								<span class="price-currency amount-currency currency-in-left" style="display: none;"></span>
								<span class="payable-amount">0</span>
								<span class="price-currency amount-currency currency-in-right" style="display: none;"></span>
							</strong>
						</p>
                        <!--                        make payable amount visible-->
					</td>
					<td class="text-end align-middle p-3">
						<!--                        make payable amount visible-->
					</td>
				</tr>
				
				<?php if($doesPaymentExist): ?>
					<tr>
						<td class="text-start align-middle p-3" colspan="2">
							<div class="form-check">
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
						</td>
					</tr>
				<?php endif; ?>
				
			</table>
		</div>
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
</style>

<script>
$(document).ready(function() {
	$('[data-toggle="toggle"]').change(function(){
		$(this).parents().next('.hide').toggle();
	});
    
    
    document.getElementById('Paid').click();
     //document.getElementById('Quick Sell').click();
    
});
</script>
	<?php echo $__env->first([
		config('larapen.core.customizedViewPath') . 'payment.payment-methods.plugins',
		'payment.payment-methods.plugins'
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/payment/packages.blade.php ENDPATH**/ ?>