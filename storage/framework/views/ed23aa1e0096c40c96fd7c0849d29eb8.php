<?php
	$post ??= [];
	$user ??= [];
	$countPackages ??= 0;
	$countPaymentMethods ??= 0
?>
<aside>
	<div class="card card-user-info sidebar-card">
		<?php if(auth()->check() && auth()->id() == data_get($post, 'user_id')): ?>
			<div class="card-header"><?php echo e(t('Manage Listing')); ?></div>
		<?php else: ?>
			<div class="block-cell user">
				<div class="cell-media">
					<img src="<?php echo e(data_get($post, 'user_photo_url')); ?>" alt="<?php echo e(data_get($post, 'contact_name')); ?>">
				</div>
				<div class="cell-content">
					<h5 class="title"><?php echo e(t('Posted by')); ?></h5>
					<span class="name">
						<?php if(!empty($user)): ?>
							<a href="<?php echo e(\App\Helpers\UrlGen::user($user)); ?>">
								<?php echo e(data_get($post, 'contact_name')); ?>

							</a>
						<?php else: ?>
							<?php echo e(data_get($post, 'contact_name')); ?>

						<?php endif; ?>
					</span>
<!--					 shop code statr-->
                        <?php
                        $current_date = date('Y-m-d H:i:s');
                        if (count($userShop)>0 && $userShop[0]->shop_status==1 && $userShop[0]->shop_expire_date>$current_date)
                        {
                        $shoplink ="shop/".str_replace(" ","_",data_get($post, 'contact_name'))."-".$post['user_id']; 
                        ?>
                        <span >
                        <a href="<?php echo e($shoplink); ?>">
								Visit Shop
							</a>
                    </span>
                    <?php
                        }
                    if($UsrType!='')
                    {
                       ?> 
                    <div style="background: #848484; color: aliceblue; padding-left: 3px; width: min-content; border-radius:5px;align-content: center "  > <?php echo e($UsrType); ?>&nbsp;</div>
                    <?php
                    }
                    
                    
                    ?>
<!--                    shop code end-->
					<?php if(config('plugins.reviews.installed')): ?>
						<?php if(view()->exists('reviews::ratings-user')): ?>
							<?php echo $__env->make('reviews::ratings-user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<?php endif; ?>
					<?php endif; ?>
				
				</div>
			</div>
		<?php endif; ?>
		
		<div class="card-content">
			<?php
				$evActionStyle = 'style="border-top: 0;"';
			?>
			<?php if(!auth()->check() || (auth()->check() && auth()->user()->getAuthIdentifier() != data_get($post, 'user_id'))): ?>
				<div class="card-body text-start">
					<div class="grid-col">
						<div class="col from">
							<i class="bi bi-geo-alt"></i>
							<span><?php echo e(t('location')); ?></span>
						</div>
						<div class="col to">
							<span>
								<a href="<?php echo \App\Helpers\UrlGen::city(data_get($post, 'city')); ?>">
									<?php echo e(data_get($post, 'city.name')); ?>

								</a>
							</span>
						</div>
					</div>
					<?php if(!config('settings.single.hide_date')): ?>
						<?php if(!empty($user) && !empty(data_get($user, 'created_at_formatted'))): ?>
							<div class="grid-col">
								<div class="col from">
									<i class="bi bi-person-check"></i>
									<span><?php echo e(t('Joined')); ?></span>
								</div>
								<div class="col to">
									<span><?php echo data_get($user, 'created_at_formatted'); ?></span>
								</div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<?php
					$evActionStyle = 'style="border-top: 1px solid #ddd;"';
				?>
			<?php endif; ?>
			
			<div class="ev-action" <?php echo $evActionStyle; ?>>
				<?php if(auth()->check()): ?>
					<?php if(auth()->user()->id == data_get($post, 'user_id')): ?>
						<a href="<?php echo e(\App\Helpers\UrlGen::editPost($post)); ?>" class="btn btn-default btn-block">
							<i class="far fa-edit"></i> <?php echo e(t('Update the details')); ?>

						</a>
						<?php if(config('settings.single.publication_form_type') == '1'): ?>
							<a href="<?php echo e(url('posts/' . data_get($post, 'id') . '/photos')); ?>" class="btn btn-default btn-block">
								<i class="fas fa-camera"></i> <?php echo e(t('Update Photos')); ?>

							</a>
							<?php if($countPackages > 0 && $countPaymentMethods > 0): ?>
								<a href="<?php echo e(url('posts/' . data_get($post, 'id') . '/payment')); ?>" class="btn btn-success btn-block">
									<i class="far fa-check-circle"></i> <?php echo e(t('Make It Premium')); ?>

								</a>
							<?php endif; ?>
						<?php endif; ?>
						<?php if(empty(data_get($post, 'archived_at')) && isVerifiedPost($post)): ?>
							<a href="<?php echo e(url('account/posts/list/' . data_get($post, 'id') . '/offline')); ?>"
							   class="btn btn-warning btn-block confirm-simple-action"
							>
								<i class="fas fa-eye-slash"></i> <?php echo e(t('put_it_offline')); ?>

							</a>
						<?php endif; ?>
                
                
                
                
                <?php
                        $current_date = date('Y-m-d H:i:s');
                        if (count($userShop)>0 && $userShop[0]->shop_status==1 && $userShop[0]->shop_expire_date>$current_date)
                        {
                        $shoplink ="shop/".str_replace(" ","_",data_get($post, 'contact_name'))."-".$post['user_id']; 
                        ?>
                
                
                        <a href="<?php echo e($shoplink); ?>"
							   class="btn btn-primary btn-block"
							>
								<i class="fas fa-shop"></i> My Shop
							</a>
                    <?php
                        }
                ?>
                
                
                
                
                
                
                
                
						<?php if(!empty(data_get($post, 'archived_at'))): ?>
							<a href="<?php echo e(url('account/posts/archived/' . data_get($post, 'id') . '/repost')); ?>"
							   class="btn btn-info btn-block confirm-simple-action"
							>
								<i class="fa fa-recycle"></i> <?php echo e(t('re_post_it')); ?>

							</a>
						<?php endif; ?>
					<?php else: ?>
						<?php echo genPhoneNumberBtn($post, true); ?>

						<?php echo genEmailContactBtn($post, true); ?>

					<?php endif; ?>
						<?php
							try {
								if (auth()->user()->can(\App\Models\Permission::getStaffPermissions())) {
									$btnUrl = admin_url('blacklists/add') . '?';
									$btnQs = (!empty(data_get($post, 'email'))) ? 'email=' . data_get($post, 'email') : '';
									$btnQs = (!empty($btnQs)) ? $btnQs . '&' : $btnQs;
									$btnQs = (!empty(data_get($post, 'phone'))) ? $btnQs . 'phone=' . data_get($post, 'phone') : $btnQs;
									$btnUrl = $btnUrl . $btnQs;
									
									if (!isDemoDomain($btnUrl)) {
										$btnText = trans('admin.ban_the_user');
										$btnHint = $btnText;
										if (!empty(data_get($post, 'email')) && !empty(data_get($post, 'phone'))) {
											$btnHint = trans('admin.ban_the_user_email_and_phone', [
												'email' => data_get($post, 'email'),
												'phone' => data_get($post, 'phone'),
											]);
										} else {
											if (!empty(data_get($post, 'email'))) {
												$btnHint = trans('admin.ban_the_user_email', ['email' => data_get($post, 'email')]);
											}
											if (!empty(data_get($post, 'phone'))) {
												$btnHint = trans('admin.ban_the_user_phone', ['phone' => data_get($post, 'phone')]);
											}
										}
										$tooltip = ' data-bs-toggle="tooltip" data-bs-placement="bottom" title="' . $btnHint . '"';
										
										$btnOut = '<a href="'. $btnUrl .'" class="btn btn-outline-danger btn-block confirm-simple-action"'. $tooltip .'>';
										$btnOut .= $btnText;
										$btnOut .= '</a>';
										
										echo $btnOut;
									}
								}
							} catch (\Throwable $e) {}
						?>
				<?php else: ?>
					<?php echo genPhoneNumberBtn($post, true); ?>

					<?php echo genEmailContactBtn($post, true); ?>

				<?php endif; ?>
			</div>
		</div>
	</div>
	
	<?php if(config('settings.single.show_listing_on_googlemap')): ?>
		<?php
			$mapHeight = 250;
			$mapPlace = (!empty(data_get($post, 'city')))
				? data_get($post, 'city.name') . ',' . config('country.name')
				: config('country.name');
			$mapUrl = getGoogleMapsEmbedUrl(config('services.googlemaps.key'), $mapPlace);
		?>
		<div class="card sidebar-card">
			<div class="card-header"><?php echo e(t('location_map')); ?></div>
			<div class="card-content">
				<div class="card-body text-start p-0">
					<div class="posts-googlemaps">
						<iframe id="googleMaps" width="100%" height="<?php echo e($mapHeight); ?>" src="<?php echo e($mapUrl); ?>"></iframe>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<?php if(isVerifiedPost($post)): ?>
		<?php echo $__env->first([
			config('larapen.core.customizedViewPath') . 'layouts.inc.social.horizontal',
			'layouts.inc.social.horizontal'
		], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
	
	<div class="card sidebar-card">
		<div class="card-header"><?php echo e(t('Safety Tips for Buyers')); ?></div>
		<div class="card-content">
			<div class="card-body text-start">
				<ul class="list-check">
					<li><?php echo e(t('Meet seller at a public place')); ?></li>
					<li><?php echo e(t('Check the item before you buy')); ?></li>
					<li><?php echo e(t('Pay only after collecting the item')); ?></li>
				</ul>
				<?php
					$tipsLinkAttributes = getUrlPageByType('tips');
				?>
				<?php if(!str_contains($tipsLinkAttributes, 'href="#"') && !str_contains($tipsLinkAttributes, 'href=""')): ?>
					<p>
						<a class="float-end" <?php echo $tipsLinkAttributes; ?>>
							<?php echo e(t('Know more')); ?> <i class="fa fa-angle-double-right"></i>
						</a>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</aside>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/post/show/inc/sidebar.blade.php ENDPATH**/ ?>