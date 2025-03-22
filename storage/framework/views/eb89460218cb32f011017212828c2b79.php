


<?php $__env->startSection('wizard'); ?>
	<?php echo $__env->first([
		config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard',
		'post.createOrEdit.multiSteps.inc.wizard'
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php
	$post ??= [];
	
	$postTypes ??= [];
	$countries ??= [];
	
	$postCatParentId = data_get($post, 'category.parent_id');
	$postCatParentId = (empty($postCatParentId)) ? data_get($post, 'category.id', 0) : $postCatParentId;
?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
    <style>
        textarea {
            white-space: pre-wrap  !important; /* Preserves whitespace and line breaks within the textarea */
        }
    </style>
    	<div class="container">
			<div class="row">
				
				<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.inc.notification', 'post.inc.notification'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

				<div class="col-md-9 page-content">
					<div class="inner-box category-content" style="overflow: visible;">
						<h2 class="title-2">
							<strong><i class="fas fa-edit"></i> <?php echo e(t('update_my_listing')); ?></strong>
							-&nbsp;<a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>"
							   class="" data-bs-placement="top"
								data-bs-toggle="tooltip"
								title="<?php echo data_get($post, 'title'); ?>"
							><?php echo str(data_get($post, 'title'))->limit(45); ?></a>
						</h2>
						
						<div class="row">
							<div class="col-12">
								
								<form class="form-horizontal" id="payableForm" method="POST" action="<?php echo e(url()->current()); ?>" enctype="multipart/form-data">
									<?php echo csrf_field(); ?>

									<input name="_method" type="hidden" value="PUT">
									<input type="hidden" name="post_id" value="<?php echo e(data_get($post, 'id')); ?>">
									<fieldset>
									    
									    
										<?php $cityIdError = (isset($errors) && $errors->has('city_id')) ? ' is-invalid' : ''; ?>
										<div id="cityBox" class="row mb-3 required">
											<label class="col-md-3 col-form-label<?php echo e($cityIdError); ?>" for="city_id">
												<?php echo e(t('city')); ?> <sup>*</sup>
											</label>
											<div class="col-md-8">
												<select id="cityId" name="city_id" class="form-control large-data-selecter<?php echo e($cityIdError); ?>">
													<option value="0" <?php if(empty(old('city_id'))): echo 'selected'; endif; ?>>
														<?php echo e(t('select_a_city')); ?>

													</option>
												</select>
											</div>
										</div>
										
										
										<?php $categoryIdError = (isset($errors) && $errors->has('category_id')) ? ' is-invalid' : ''; ?>
										<div class="row mb-3 required">
											<label class="col-md-3 col-form-label<?php echo e($categoryIdError); ?>"><?php echo e(t('category')); ?> <sup>*</sup></label>
											<div class="col-md-8">
												<div id="catsContainer" class="rounded<?php echo e($categoryIdError); ?>">
													<a href="#browseCategories" data-bs-toggle="modal" class="cat-link" data-id="0">
														<?php echo e(t('select_a_category')); ?>

													</a>
												</div>
											</div>
											<input type="hidden" name="category_id" id="categoryId" value="<?php echo e(old('category_id', data_get($post, 'category.id'))); ?>">
											<input type="hidden" name="category_type" id="categoryType" value="<?php echo e(old('category_type', data_get($post, 'category.type'))); ?>">
										</div>
										
										<?php if(config('settings.single.show_listing_type')): ?>
											
											<?php
												$postTypeIdError = (isset($errors) && $errors->has('post_type_id')) ? ' is-invalid' : '';
												$postTypeId = old('post_type_id', data_get($post, 'post_type_id'));
											?>
											<div id="postTypeBloc" class="row mb-3 required">
												<label class="col-md-3 col-form-label<?php echo e($postTypeIdError); ?>"><?php echo e(t('type')); ?> <sup>*</sup></label>
												<div class="col-md-8">
													<?php $__currentLoopData = $postTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<div class="form-check form-check-inline">
															<input name="post_type_id"
																   id="postTypeId-<?php echo e(data_get($postType, 'id')); ?>"
																   value="<?php echo e(data_get($postType, 'id')); ?>"
																   type="radio"
																   class="form-check-input<?php echo e($postTypeIdError); ?>" <?php if($postTypeId == data_get($postType, 'id')): echo 'checked'; endif; ?>
															>
															<label class="form-check-label mb-0" for="postTypeId-<?php echo e(data_get($postType, 'id')); ?>">
																<?php echo e(data_get($postType, 'name')); ?>

															</label>
														</div>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<div class="form-text text-muted"><?php echo e(t('post_type_hint')); ?></div>
												</div>
											</div>
										<?php endif; ?>
										
										
										<div id="cfContainer"></div>

										
										<?php $titleError = (isset($errors) && $errors->has('title')) ? ' is-invalid' : ''; ?>
										<div class="row mb-3 required">
											<label class="col-md-3 col-form-label<?php echo e($titleError); ?>" for="title"><?php echo e(t('title')); ?> <sup>*</sup></label>
											<div class="col-md-8">
												<input id="title" name="title" placeholder="<?php echo e(t('listing_title')); ?>" class="form-control input-md<?php echo e($titleError); ?>"
													   type="text" value="<?php echo e(old('title', data_get($post, 'title'))); ?>">
												<div class="form-text text-muted"><?php echo e(t('a_great_title_needs_at_least_60_characters')); ?></div>
											</div>
										</div>

										
										<?php
											$descriptionError = (isset($errors) && $errors->has('description')) ? ' is-invalid' : '';
											$postDescription = data_get($post, 'description');
											$descriptionErrorLabel = '';
											$descriptionColClass = 'col-md-8';
											if (config('settings.single.wysiwyg_editor') != 'none') {
												$descriptionColClass = 'col-md-12';
												$descriptionErrorLabel = $descriptionError;
											} else {
												$postDescription = strip_tags($postDescription);
											}
										?>
										<div class="row mb-3 required">
											<label class="col-md-3 col-form-label<?php echo e($descriptionErrorLabel); ?>" for="description">
												<?php echo e(t('Description')); ?> <sup>*</sup>
											</label>
											<div class="<?php echo e($descriptionColClass); ?>">
											     <div id="charCountLabel">0/5000</div>
												<textarea
														class="form-control<?php echo e($descriptionError); ?>"
														id="description"
														name="description"
														  rows="8"
														  maxlength="5000"
														  style="height: 100px"
														  oninput="adjustTextarea(this)"
												><?php echo e(old('description', $postDescription)); ?></textarea>
												<div class="form-text text-muted"><?php echo e(t('describe_what_makes_your_listing_unique')); ?></div>
                                            </div>
										</div>
																				    <style>
                                            #charCountLabel {
                                                text-align: right;
                                                font-size: 12px;
                                                color: #777;
                                                margin-top: 5px;
                                            }
                                            textarea {
                                                resize: none;
                                                overflow-y: auto; /* Show scrollbar when content exceeds the height */
                                                max-height: 500px; /* Set the maximum height */
                                            }
                                          </style>
										<script>
										 function capitalizeTextOnBlur(textboxId) {
                                                var textbox = document.getElementById(textboxId);
                                                
                                                textbox.addEventListener('blur', function() {
                                                    var text = textbox.value;
                                                    textbox.value = text.toUpperCase();
                                                });
                                            }
                                            capitalizeTextOnBlur('title');
                                            function adjustTextarea(textarea) {
                                                // Set the maximum number of rows
                                                const maxRows = 20;
                                            
                                                // Get the character count
                                                const charCount = textarea.value.length;
                                            
                                                // Update character count label
                                                document.getElementById('charCountLabel').innerText = `${charCount}/5000`;
                                            
                                                // Adjust the textarea height based on the content
                                                textarea.style.height = 'auto';
                                                textarea.style.height = (textarea.scrollHeight) + 'px';
                                            
                                                // Limit the number of rows to the maximum
                                                const newRows = Math.min(textarea.rows, maxRows);
                                            
                                                // Check and truncate the content to the maximum character limit
                                                if (charCount > textarea.maxLength) {
                                                    textarea.value = textarea.value.substring(0, textarea.maxLength);
                                                }
                                            }
                                            </script>


										
										<?php
											$priceError = (isset($errors) && $errors->has('price')) ? ' is-invalid' : '';
											$currencySymbol = config('currency.symbol', 'X');
											$price = old('price', data_get($post, 'price'));
											$price = \App\Helpers\Number::format($price, 2, '.', '');
										?>
										<div id="priceBloc" class="row mb-3 required">
											<label class="col-md-3 col-form-label<?php echo e($priceError); ?>" for="price"><?php echo e(t('price')); ?></label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-text"><?php echo $currencySymbol; ?></span>
													<input id="price"
														   name="price"
														   class="form-control<?php echo e($priceError); ?>"
														   placeholder="<?php echo e(t('ei_price')); ?>"
														   type="number"
														   min="0"
														   step="<?php echo e(getInputNumberStep((int)config('currency.decimal_places', 2))); ?>"
														   value="<?php echo $price; ?>"
													>
													<span class="input-group-text">
														<input id="negotiable" name="negotiable" type="checkbox"
															   value="1" <?php echo e((old('negotiable', data_get($post, 'negotiable'))=='1') ? 'checked="checked"' : ''); ?>>
														&nbsp;<small><?php echo e(t('negotiable')); ?></small>
													</span>
												</div>
													  <style>
														#pricehintdiv input[type="radio"] {
														  margin-right: 5px;  padding-right: 10px;
														}
													  </style>	
												    <div id="pricehintdiv" class="form-text text-muted" style="padding: 10px; font-weight: 800;"></div>
					
												<?php if(config('settings.single.price_mandatory') != '1'): ?>
													<div class="form-text text-muted"><?php echo e(t('price_hint')); ?></div>
												<?php endif; ?>
											</div>
										</div>
										
										
										<input id="countryCode" name="country_code"
											   type="hidden"
											   value="<?php echo e(data_get($post, 'country_code') ?? config('country.code')); ?>"
										>
										
										<?php
											$adminType = config('country.admin_type', 0);
										?>
										<?php if(config('settings.single.city_selection') == 'select'): ?>
											<?php if(in_array($adminType, ['1', '2'])): ?>
												
												<?php $adminCodeError = (isset($errors) && $errors->has('admin_code')) ? ' is-invalid' : ''; ?>
												<div id="locationBox" class="row mb-3 required">
													<label class="col-md-3 col-form-label<?php echo e($adminCodeError); ?>" for="admin_code">
														<?php echo e(t('location')); ?> <sup>*</sup>
													</label>
													<div class="col-md-8">
														<select id="adminCode" name="admin_code" class="form-control large-data-selecter<?php echo e($adminCodeError); ?>">
															<option value="0" <?php if(empty(old('admin_code'))): echo 'selected'; endif; ?>>
																<?php echo e(t('select_your_location')); ?>

															</option>
														</select>
													</div>
												</div>
											<?php endif; ?>
										<?php else: ?>
											<?php
												$adminType = (in_array($adminType, ['0', '1', '2'])) ? $adminType : 0;
												$relAdminType = (in_array($adminType, ['1', '2'])) ? $adminType : 1;
												$adminCode = data_get($post, 'city.subadmin' . $relAdminType . '_code', 0);
												$adminCode = data_get($post, 'city.subAdmin' . $relAdminType . '.code', $adminCode);
												$adminName = data_get($post, 'city.subAdmin' . $relAdminType . '.name');
												$cityId = data_get($post, 'city.id', 0);
												$cityName = data_get($post, 'city.name');
												$fullCityName = !empty($adminName) ? $cityName . ', ' . $adminName : $cityName;
											?>
											<input type="hidden" id="selectedAdminType" name="selected_admin_type" value="<?php echo e(old('selected_admin_type', $adminType)); ?>">
											<input type="hidden" id="selectedAdminCode" name="selected_admin_code" value="<?php echo e(old('selected_admin_code', $adminCode)); ?>">
											<input type="hidden" id="selectedCityId" name="selected_city_id" value="<?php echo e(old('selected_city_id', $cityId)); ?>">
											<input type="hidden" id="selectedCityName" name="selected_city_name" value="<?php echo e(old('selected_city_name', $fullCityName)); ?>">
										<?php endif; ?>
									

										
										
										<?php
											$tagsError = (isset($errors) && $errors->has('tags.*')) ? ' is-invalid' : '';
											$tags = old('tags', data_get($post, 'tags'));
										?>
										<div class="row mb-3">
											<label class="col-md-3 col-form-label<?php echo e($tagsError); ?>" for="tags"><?php echo e(t('Tags')); ?></label>
											<div class="col-md-8">
												<select id="tags" name="tags[]" class="form-control tags-selecter" multiple="multiple">
													<?php if(!empty($tags)): ?>
														<?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option selected="selected"><?php echo e($iTag); ?></option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
												</select>
												<div class="form-text text-muted">
													<?php echo t('tags_hint', [
															'limit' => (int)config('settings.single.tags_limit', 15),
															'min'   => (int)config('settings.single.tags_min_length', 2),
															'max'   => (int)config('settings.single.tags_max_length', 30)
														]); ?>

												</div>
											</div>
										</div>
										
										
										<?php if(config('settings.single.permanent_listings_enabled') == '3'): ?>
											<input id="isPermanent" name="is_permanent" type="hidden" value="<?php echo e(old('is_permanent', data_get($post, 'is_permanent'))); ?>">
										<?php else: ?>
											<?php $isPermanentError = (isset($errors) && $errors->has('is_permanent')) ? ' is-invalid' : ''; ?>
											<div id="isPermanentBox" class="row mb-3 required hide">
												<label class="col-md-3 col-form-label"></label>
												<div class="col-md-8">
													<div class="form-check">
														<input id="isPermanent" name="is_permanent"
															   class="form-check-input mt-1<?php echo e($isPermanentError); ?>"
															   value="1"
															   type="checkbox" <?php if(old('is_permanent', data_get($post, 'is_permanent')) == '1'): echo 'checked'; endif; ?>
														>
														<label class="form-check-label mt-0" for="is_permanent">
															<?php echo t('is_permanent_label'); ?>

														</label>
													</div>
													<div class="form-text text-muted"><?php echo e(t('is_permanent_hint')); ?></div>
													<div style="clear:both"></div>
												</div>
											</div>
										<?php endif; ?>


										<div class="content-subheading">
											<i class="fas fa-user"></i>
											<strong><?php echo e(t('seller_information')); ?></strong>
										</div>
										
										
										
										<?php $contactNameError = (isset($errors) && $errors->has('contact_name')) ? ' is-invalid' : ''; ?>
										<div class="row mb-3 required">
											<label class="col-md-3 col-form-label<?php echo e($contactNameError); ?>" for="contact_name">
												<?php echo e(t('your_name')); ?> <sup>*</sup>
											</label>
											<div class="col-md-9 col-lg-8 col-xl-6">
												<div class="input-group">
													<span class="input-group-text"><i class="far fa-user"></i></span>
													<input id="contactName" name="contact_name"
														   type="text"
														   placeholder="<?php echo e(t('your_name')); ?>"
														   class="form-control input-md<?php echo e($contactNameError); ?>"
														   value="<?php echo e(old('contact_name', data_get($post, 'contact_name'))); ?>"
													>
												</div>
											</div>
										</div>
										

										
										<?php
											$forceToDisplay = isBothAuthFieldsCanBeDisplayed() ? ' force-to-display' : '';
										?>
										
										
										<?php
											$emailError = (isset($errors) && $errors->has('email')) ? ' is-invalid' : '';
										?>
										<?php  ?>
										<div class="row mb-3 auth-field-item required<?php echo e($forceToDisplay); ?>">
											<label class="col-md-3 col-form-label<?php echo e($emailError); ?>" for="email"><?php echo e(t('email')); ?>

												<?php if(getAuthField() == 'email'): ?>
													<sup>*</sup>
												<?php endif; ?>
											</label>
											<div class="col-md-9 col-lg-8 col-xl-6">
												<div class="input-group">
													<span class="input-group-text"><i class="far fa-envelope"></i></span>
													<input id="email" name="email"
														   type="text"
                                                                                                                    <?php echo e(auth()->check() ? 'readonly' : ''); ?>

														   class="form-control<?php echo e($emailError); ?>"
														   placeholder="<?php echo e(t('email_address')); ?>"
														   value="<?php echo e(old('email', data_get($post, 'email'))); ?>"
													>
												</div>
											</div>
										</div>
										
										
										<?php
											$phoneError = (isset($errors) && $errors->has('phone')) ? ' is-invalid' : '';
									
                                            $phoneValue = data_get($post, 'phone');
											$phoneValue2 = data_get($post, 'phone2');
											$phoneValue3 = data_get($post, 'phone3');
											$phoneValue4 = data_get($post, 'phone4');
											$phoneValue5 = data_get($post, 'phone5');
                                            $phoneValue2hid = data_get($post, 'phone2');
											$phoneValue3hid = data_get($post, 'phone3');
											$phoneValue4hid = data_get($post, 'phone4');
											$phoneValue5hid = data_get($post, 'phone5');
                                        
                                        
											$phoneCountryValue = data_get($post, 'phone_country') ?? config('country.code');
                                        
                                            $phoneValue = phoneE164($phoneValue, $phoneCountryValue);
											$phoneValueOld = phoneE164(old('phone', $phoneValue), old('phone_country', $phoneCountryValue));
											$phoneValue2Old = phoneE164(old('phone2', $phoneValue2));
											$phoneValue3Old = phoneE164(old('phone3', $phoneValue3));
											$phoneValue4Old = phoneE164(old('phone4', $phoneValue4));
											$phoneValue5Old = phoneE164(old('phone5', $phoneValue5));
                                            $phoneValue2Oldhid = phoneE164(old('phone2hid', $phoneValue2hid));
                                            $phoneValue3Oldhid = phoneE164(old('phone3hid', $phoneValue3hid));
                                            $phoneValue4Oldhid = phoneE164(old('phone4hid', $phoneValue4hid));
                                            $phoneValue5Oldhid = phoneE164(old('phone5hid', $phoneValue5hid));

										?>
										<div class="row mb-3 auth-field-item required<?php echo e($forceToDisplay); ?>">
											<label class="col-md-3 col-form-label<?php echo e($phoneError); ?>" for="phone"><?php echo e(t('phone_number')); ?>

												<?php if(getAuthField() == 'phone'): ?>
													<sup>*</sup>
												<?php endif; ?>
											</label>
											<div class="col-md-9 col-lg-8 col-xl-6">
												<div class="input-group">
													<input id="phone" name="phone"
														   class="form-control input-md<?php echo e($phoneError); ?>"
														   type="text"
														   value="<?php echo e($phoneValueOld); ?>"
													>
													<span class="input-group-text iti-group-text">
														<input id="phoneHidden" name="phone_hidden" type="checkbox"
															   value="1" <?php if(old('phone_hidden', data_get($post, 'phone_hidden'))=='1'): echo 'checked'; endif; ?>>
											             &nbsp;<small><?php echo e(t('Hide')); ?></small>&nbsp;&nbsp;&nbsp;<span>|<i class="fa fa-phone"></i>|</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span onclick="myFunction('phn2')" style="cursor: pointer; width: 30px !important; height: 25px !important; background: #30A851; color: white; border-radius: 5px;">&nbsp;&nbsp;+&nbsp;&nbsp;</span>
													</span>
												</div>
												<input name="phone_country" type="hidden" value="<?php echo e(old('phone_country', $phoneCountryValue)); ?>">
											</div>
										</div>
										
										    <div id="phn2" style="display: none" >
                                        <div class="row mb-3 auth-field-item required<?php echo e($forceToDisplay); ?>">
											<label class="col-md-3 col-form-label<?php echo e($phoneError); ?>" for="phone2"><?php echo e(t('phone_number2')); ?>

												<?php if(getAuthField() == 'phone'): ?>
													<sup>*</sup>
												<?php endif; ?>
											</label>
                                            
											<div class="col-md-9 col-lg-8 col-xl-6">
												<div class="input-group">
                                                    
													<span class="input-group-text iti-group-text" style="padding-top: 0px !important; padding-bottom: 0px !important;"><div class="iti__flag iti__lk"></div><div class="iti__selected-dial-code">+94</div></span>
                                                    <span class="input-group-text iti-group-text" style="width: 200px !important; padding-top: 0px !important; padding-bottom: 0px !important;">
                                                        <input id="phone2" name="phone2"
														   class="form-control input-md<?php echo e($phoneError); ?>"
														   type="tel"
                                                           placeholder="700000000"
                                                           value="<?php echo e($phoneValue2Old); ?>" 
                                                           minlength="9" maxlength="9"
                                                               />
                                                        <input type="hidden" id="phone2hid" name="phone2hid"  value="<?php echo e($phoneValue2Oldhid); ?>" minlength="9" />
                                                    </span>
                                                    <span id="phn2_act" style="display: none;"  class="input-group-text iti-group-text">
														&nbsp;&nbsp;<span onclick="myFunction2('2')" style=" cursor: pointer; width: 30px !Important; height: 25px; background: #C94042; color: white; border-radius: 5px;">-</span>&nbsp;<span onclick="myFunction('phn3')" style="cursor: pointer; width: 30px; height: 25px; background: #30A851; border-radius: 5px;">+</span>
													</span>
                                                    <span  id="phn2_vfy"  class="input-group-text iti-group-text" style="display: none;   width: 100px !important; padding-top: 5px !important; padding-bottom: 0px !important; padding-left: 0.30rem;"><input type="text" size="6" id="phn2_verify" placeholder="6 digit code" name="phn2_verify" />&nbsp;&nbsp;<span id="phone2vf" style="cursor: pointer; width: 40px; height: 25px; background: #30A851; border-radius: 5px; padding: 0.30rem;color:white;">OTP Verify</span>&nbsp;&nbsp;<span onclick="myFunction2('2')" style=" padding: 0.20rem; cursor: pointer; width: 30px !Important; height: 25px; color: #fff; background: #f34538; border-radius: 20px;">&nbsp;x&nbsp;</span></span>
													
												</div>
												<input name="phone2_country" type="hidden" value="<?php echo e(old('phone_country', $phoneCountryValue)); ?>">
											</div>
                                            
                                            
                   
										</div>
                                        </div>
                                        <div id="phn3" style="display: none" > 
                                        <div  class="row mb-3 auth-field-item required<?php echo e($forceToDisplay); ?>">
											<label class="col-md-3 col-form-label<?php echo e($phoneError); ?>" for="phone3"><?php echo e(t('phone_number3')); ?>

												<?php if(getAuthField() == 'phone3'): ?>
													<sup>*</sup>
												<?php endif; ?>
											</label>
                                            
											<div class="col-md-9 col-lg-8 col-xl-6">
												<div class="input-group">
                                                    
													<span class="input-group-text iti-group-text"><div class="iti__flag iti__lk"></div><div class="iti__selected-dial-code">+94</div></span>
                                                    <span class="input-group-text iti-group-text" style="width: 200px !important;">
                                                        <input id="phone3" name="phone3"
														   class="form-control input-md<?php echo e($phoneError); ?>"
														   type="tel"
                                                           placeholder="700000000"
                                                           value="<?php echo e($phoneValue3Old); ?>"
                                                               minlength="9" maxlength="9"
                                                               />
                                                        <input type="hidden" id="phone3hid" name="phone3hid"  value="<?php echo e($phoneValue3Oldhid); ?>" />
                                                    </span>
                                                    <span id="phn3_act" style="display: none"  class="input-group-text iti-group-text">
														&nbsp;&nbsp;<span onclick="myFunction2('3')" style="cursor: pointer; width: 30px !Important; height: 25px; background: #C94042; color: white; border-radius: 5px;">-</span>&nbsp;<span onclick="myFunction('phn4')" style="cursor: pointer; width: 30px; height: 25px; background: #30A851; border-radius: 5px;">+</span>
													</span>
                                                    <span  id="phn3_vfy" class="input-group-text iti-group-text" style="display: none;  width: 100px !important;"><input type="text"  size="6" placeholder="6 digit code" id="phn3_verify" name="phn3_verify" />&nbsp;&nbsp;<span id="phone3vf" style="cursor: pointer; width: 40px; height: 25px; background: #30A851; border-radius: 5px; padding: 0.30rem;color:white;">OTP Verify</span>&nbsp;&nbsp;<span onclick="myFunction2('3')" style=" padding: 0.20rem; cursor: pointer; width: 30px !Important; height: 25px; color: #fff; background: #f34538; border-radius: 20px;">&nbsp;x&nbsp;</span> </span>
													
												</div>
												<input name="phone3_country" type="hidden" value="<?php echo e(old('phone_country', $phoneCountryValue)); ?>">
											</div>
                                            
                                            
                   
										</div>
                                        </div>
                                        <div id="phn4" style="display: none" >
                                        <div  class="row mb-3 auth-field-item required<?php echo e($forceToDisplay); ?>">
											<label class="col-md-3 col-form-label<?php echo e($phoneError); ?>" for="phone4"><?php echo e(t('phone_number4')); ?>

												<?php if(getAuthField() == 'phone4'): ?>
													<sup>*</sup>
												<?php endif; ?>
											</label>
                                            
											<div class="col-md-9 col-lg-8 col-xl-6">
												<div class="input-group">
                                                    
													<span class="input-group-text iti-group-text"><div class="iti__flag iti__lk"></div><div class="iti__selected-dial-code">+94</div></span>
                                                    <span class="input-group-text iti-group-text" style="width: 200px !important;">
                                                        <input id="phone4" name="phone4"
														   class="form-control input-md<?php echo e($phoneError); ?>"
														   type="tel"
                                                           placeholder="700000000"
                                                           value="<?php echo e($phoneValue4Old); ?>"
                                                               minlength="9" maxlength="9"
                                                               />
                                                        <input type="hidden" id="phone4hid" name="phone4hid"  value="<?php echo e($phoneValue4Oldhid); ?>" />
                                                    </span>
                                                    <span id="phn4_act" style="display: none"  class="input-group-text iti-group-text">
														&nbsp;&nbsp;<span onclick="myFunction2('4')" style="cursor: pointer; width: 30px !Important; height: 25px; background: #C94042; color: white; border-radius: 5px;">-</span>&nbsp;<span onclick="myFunction('phn5')" style="cursor: pointer; width: 30px; height: 25px; background: #30A851; border-radius: 5px;">+</span>
													</span>
                                                    <span  id="phn4_vfy"  class="input-group-text iti-group-text" style="display: none; width: 100px !important;"><input type="text" size="6" placeholder="6 digit code" id="phn4_verify" name="phn4_verify" />&nbsp;&nbsp;<span id="phone4vf" style="cursor: pointer; width: 40px; height: 25px; background: #30A851; border-radius: 5px; padding: 0.30rem;color:white;">OTP Verify</span>&nbsp;&nbsp;<span onclick="myFunction2('4')" style=" padding: 0.20rem; cursor: pointer; width: 30px !Important; height: 25px; color: #fff; background: #f34538; border-radius: 20px;">&nbsp;x&nbsp;</span></span>
													
												</div>
												<input name="phone4_country" type="hidden" value="<?php echo e(old('phone_country', $phoneCountryValue)); ?>">
											</div>
                                            
                                            
                   
										</div>
                                        </div>
                                        <div id="phn5" style="display: none"> 
                                        <div class="row mb-3 auth-field-item required<?php echo e($forceToDisplay); ?>">
											<label class="col-md-3 col-form-label<?php echo e($phoneError); ?>" for="phone5"><?php echo e(t('phone_number5')); ?>

												<?php if(getAuthField() == 'phone5'): ?>
													<sup>*</sup>
												<?php endif; ?>
											</label>
                                            
											<div class="col-md-9 col-lg-8 col-xl-6">
                                                <div class="input-group">
                                                    
													<span class="input-group-text iti-group-text"><div class="iti__flag iti__lk"></div><div class="iti__selected-dial-code">+94</div></span>
                                                    <span class="input-group-text iti-group-text" style="width: 200px !important;">
                                                        <input id="phone5" name="phone5"
														   class="form-control input-md<?php echo e($phoneError); ?>"
														   type="tel"
                                                           placeholder="700000000"
                                                           value="<?php echo e($phoneValue5Old); ?>" 
                                                               minlength="9" maxlength="9"
                                                            />
                                                        <input type="hidden" id="phone5hid" name="phone5hid"  value="<?php echo e($phoneValue5Oldhid); ?>" />
                                                    </span>
                                                    <span id="phn5_act" style="display: none"  class="input-group-text iti-group-text">
														&nbsp;&nbsp;<span onclick="myFunction2('5')" style="cursor: pointer; width: 30px !Important; height: 25px; background: #C94042; color: white; border-radius: 5px;">-</span>
													</span>
                                                    <span  id="phn5_vfy"  class="input-group-text iti-group-text" style="display: none; width: 100px !important;"><input type="text" size="6" placeholder="6 digit code" id="phn5_verify" name="phn5_verify" />&nbsp;&nbsp;<span id="phone5vf" style="cursor: pointer; width: 40px; height: 25px; background: #30A851; border-radius: 5px; padding: 0.30rem;color:white;">OTP Verify</span>&nbsp;&nbsp;<span onclick="myFunction2('5')" style=" padding: 0.20rem; cursor: pointer; width: 30px !Important; height: 25px; color: #fff; background: #f34538; border-radius: 20px;">&nbsp;x&nbsp;</span></span>
													
												</div>
												<input name="phone5_country" type="hidden" value="<?php echo e(old('phone_country', $phoneCountryValue)); ?>">
											</div>
                                            
                                            
                   
										</div>
										</div>
                                        
									
										
										<?php
											$authFields = getAuthFields(true);
											$authFieldError = (isset($errors) && $errors->has('auth_field')) ? ' is-invalid' : '';
											$usersCanChooseNotifyChannel = isUsersCanChooseNotifyChannel();
											$authFieldValue = data_get($post, 'auth_field') ?? getAuthField();
											$authFieldValue = ($usersCanChooseNotifyChannel) ? (old('auth_field', $authFieldValue)) : $authFieldValue;
										?>
										<?php if($usersCanChooseNotifyChannel): ?>
											<div class="row mb-3 required">
												<label class="col-md-3 col-form-label" for="auth_field"><?php echo e(t('notifications_channel')); ?> <sup>*</sup></label>
												<div class="col-md-9">
													<?php $__currentLoopData = $authFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iAuthField => $notificationType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<div class="form-check form-check-inline pt-2">
															<input name="auth_field"
																   id="<?php echo e($iAuthField); ?>AuthField"
																   value="<?php echo e($iAuthField); ?>"
																   class="form-check-input auth-field-input<?php echo e($authFieldError); ?>"
																   type="radio" <?php if($authFieldValue == $iAuthField): echo 'checked'; endif; ?>
															>
															<label class="form-check-label mb-0" for="<?php echo e($iAuthField); ?>AuthField">
																<?php echo e($notificationType); ?>

															</label>
														</div>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<div class="form-text text-muted">
														<?php echo e(t('notifications_channel_hint')); ?>

													</div>
												</div>
											</div>
										<?php else: ?>
											<input id="<?php echo e($authFieldValue); ?>AuthField" name="auth_field" type="hidden" value="<?php echo e($authFieldValue); ?>">
										<?php endif; ?>

										
										<div class="row mb-3 pt-3">
											<div class="col-md-12 text-center">
												<a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>" class="btn btn-default btn-lg"><?php echo e(t('Back')); ?></a>
												<button id="nextStepBtn" class="btn btn-primary btn-lg"><?php echo e(t('Update')); ?></button>
											</div>
										</div>

									</fieldset>
								</form>
								
							</div>
						</div>
					</div>
				</div>
				<!-- /.page-content -->

				<div class="col-md-3 reg-sidebar">
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.right-sidebar', 'post.createOrEdit.inc.right-sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
				
			</div>
		</div>
	</div>
<script>
const box = document.querySelector("[for='emailAuthField']");
box.innerHTML = 'Email';
</script>
		   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>  
       function xmlhttpcond(xht)
{
	if (xht.readyState==4 && xht.status==200) {
		return true;
	}
	else{
		return false;
	}
} //xmlhttpcond	
function xmlhttpfunc()
{
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    return new XMLHttpRequest();
  } else { // code for IE6, IE5
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
} //xmlhttpfunc
    
    function myFunction(nme) {
  var x = document.getElementById(nme);
        x.style.display = "block";
}
    function myFunction2(nme) {
  var w = document.getElementById('phn'+nme+'_verify');
  var x = document.getElementById('phn'+nme);
  var y = document.getElementById('phone'+nme);
  var z = document.getElementById('phone'+nme+'hid');
        document.getElementById("phn"+nme+"_act").style.display = "none";
        document.getElementById("phn"+nme+"_vfy").style.display = "block";
        y.value = '';
        z.value = '';
        w.value = '';
        x.style.display = "none";
}
    
   $(document).ready(function() {
       
       $(document).on('click', '#phone2vf', function(e) {
           
           var phn2_verify= $('#phn2_verify').val();
           var val_ph2= $('#phone2').val();
//           val_ph2 = phn2_verify;
           if(phn2_verify.length == 6)
               {
                   
        xmlhttp1 = xmlhttpfunc();
		xmlhttp1.onreadystatechange=function() 
		{
			if (xmlhttpcond(xmlhttp1))
			{
                var tvall = xmlhttp1.responseText;
                if(tvall == "verified")
                    {
                        alert("Your Phone Verified!");
                        $('#phn2_act').removeAttr('style');
                document.getElementById("phn2_vfy").style.display = "none";
                        $('#phone2hid').val(val_ph2);
                    }
                else
                    {
                        alert("Please Try Again!");
                    }
			}
		}
        var ajaxlink = "<?php echo e(url('/')); ?>";
           ajaxlink+="/posts/veryfyphone/";
		xmlhttp1.open("GET",ajaxlink+val_ph2+"/"+phn2_verify,true);
		xmlhttp1.send();
        
               }
           
       });
       
       
       $(document).on('keyup', '#phone2', function(e) {
           
          var val_ph2= $('#phone2').val();
           if(val_ph2.length == 1 && val_ph2=='0')
               {
                   $('#phone2').val('');
               }
           if(val_ph2.length == 9)
               {
                   
                var testval = $('#phone2hid').val();
              if(val_ph2!=testval)    
           { 
               document.getElementById("phn2_act").style.display = "none";
             document.getElementById("phn2_vfy").style.display = "block";    
               
        xmlhttp1 = xmlhttpfunc();
		xmlhttp1.onreadystatechange=function() 
		{
			if (xmlhttpcond(xmlhttp1))
			{
                var tvall = xmlhttp1.responseText;
                alert("Please check your mobile for the OTP");
        $('#phn2_verify').focus();
			}
		}
        var ajaxlink = "<?php echo e(url('/')); ?>";
           ajaxlink+="/posts/notifyphone/";
		xmlhttp1.open("GET",ajaxlink+val_ph2,true);
		xmlhttp1.send();
                   
            
                   
         }
       else
           {
               $('#phn2_act').removeAttr('style');
              document.getElementById("phn2_vfy").style.display = "none";   
           }
               }
			});
       
       
       
       
       
       
       $(document).on('click', '#phone3vf', function(e) {
           
           var phn2_verify= $('#phn3_verify').val();
           var val_ph2= $('#phone3').val();
//           val_ph2 = phn2_verify;
           if(phn2_verify.length == 6)
               {
                   
        xmlhttp1 = xmlhttpfunc();
		xmlhttp1.onreadystatechange=function() 
		{
			if (xmlhttpcond(xmlhttp1))
			{
                var tvall = xmlhttp1.responseText;
                if(tvall == "verified")
                    {
                        alert("Your Phone Verified!");
                        $('#phn3_act').removeAttr('style');
                document.getElementById("phn3_vfy").style.display = "none";
                        $('#phone3hid').val(val_ph2);
                    }
                else
                    {
                        alert("Please Try Again!");
                    }
			}
		}
        var ajaxlink = "<?php echo e(url('/')); ?>";
           ajaxlink+="/posts/veryfyphone/";
		xmlhttp1.open("GET",ajaxlink+val_ph2+"/"+phn2_verify,true);
		xmlhttp1.send();
        
               }
           
       });
       
       
       $(document).on('keyup', '#phone3', function(e) {
           
          var val_ph2= $('#phone3').val();
           if(val_ph2.length == 1 && val_ph2=='0')
               {
                   $('#phone3').val('');
               }
           if(val_ph2.length == 9)
               {
                   var testval3 = $('#phone3hid').val();
              if(val_ph2!=testval3)    
           { 
             document.getElementById("phn3_act").style.display = "none";
             document.getElementById("phn3_vfy").style.display = "block";
                   
        xmlhttp1 = xmlhttpfunc();
		xmlhttp1.onreadystatechange=function() 
		{
			if (xmlhttpcond(xmlhttp1))
			{
                var tvall = xmlhttp1.responseText;
                alert("Please check your mobile for the OTP");
        $('#phn3_verify').focus();
			}
		}
        var ajaxlink = "<?php echo e(url('/')); ?>";
           ajaxlink+="/posts/notifyphone/";
		xmlhttp1.open("GET",ajaxlink+val_ph2,true);
		xmlhttp1.send();
           }
                   else
                       {
                          $('#phn3_act').removeAttr('style');
                          document.getElementById("phn3_vfy").style.display = "none";   
                       }
               }
			});
       
       
       
       
       
       
       $(document).on('click', '#phone4vf', function(e) {
           
           var phn2_verify= $('#phn4_verify').val();
           var val_ph2= $('#phone4').val();
//           val_ph2 = phn2_verify;
           if(phn2_verify.length == 6)
               {
                   
        xmlhttp1 = xmlhttpfunc();
		xmlhttp1.onreadystatechange=function() 
		{
			if (xmlhttpcond(xmlhttp1))
			{
                var tvall = xmlhttp1.responseText;
                if(tvall == "verified")
                    {
                        alert("Your Phone Verified!");
                        $('#phn4_act').removeAttr('style');
                document.getElementById("phn4_vfy").style.display = "none";
                        $('#phone4hid').val(val_ph2);
                    }
                else
                    {
                        alert("Please Try Again!");
                    }
			}
		}
        var ajaxlink = "<?php echo e(url('/')); ?>";
           ajaxlink+="/posts/veryfyphone/";
		xmlhttp1.open("GET",ajaxlink+val_ph2+"/"+phn2_verify,true);
		xmlhttp1.send();
        
               }
           
       });
       
       
       $(document).on('keyup', '#phone4', function(e) {
           
          var val_ph2= $('#phone4').val();
           if(val_ph2.length == 1 && val_ph2=='0')
               {
                   $('#phone4').val('');
               }
           if(val_ph2.length == 9)
               {
                var testval = $('#phone4hid').val();
              if(val_ph2!=testval)    
           { 
             document.getElementById("phn4_act").style.display = "none";
             document.getElementById("phn4_vfy").style.display = "block";   
        xmlhttp1 = xmlhttpfunc();
		xmlhttp1.onreadystatechange=function() 
		{
			if (xmlhttpcond(xmlhttp1))
			{
                var tvall = xmlhttp1.responseText;
                alert("Please check your mobile for the OTP");
                $('#phn2_verify').focus();
			}
		}
        var ajaxlink = "<?php echo e(url('/')); ?>";
           ajaxlink+="/posts/notifyphone/";
		xmlhttp1.open("GET",ajaxlink+val_ph2,true);
		xmlhttp1.send();
               }
                   else
                       {
                          $('#phn4_act').removeAttr('style');
                          document.getElementById("phn4_vfy").style.display = "none";   
                       }
               }
			});
       
       
       
       
       
       
       $(document).on('click', '#phone5vf', function(e) {
           
           var phn2_verify= $('#phn5_verify').val();
           var val_ph2= $('#phone5').val();
//           val_ph2 = phn2_verify;
           if(phn2_verify.length == 6)
               {

                   
        xmlhttp1 = xmlhttpfunc();
		xmlhttp1.onreadystatechange=function() 
		{
			if (xmlhttpcond(xmlhttp1))
			{
                var tvall = xmlhttp1.responseText;
                if(tvall == "verified")
                    {
                        alert("Your Phone Verified!");
                        $('#phn5_act').removeAttr('style');
                document.getElementById("phn5_vfy").style.display = "none";
                        $('#phone5hid').val(val_ph2);
                    }
                else
                    {
                        alert("Please Try Again!");
                    }
			}
		}
        var ajaxlink = "<?php echo e(url('/')); ?>";
           ajaxlink+="/posts/veryfyphone/";
		xmlhttp1.open("GET",ajaxlink+val_ph2+"/"+phn2_verify,true);
		xmlhttp1.send();
        
               }
           
       });
       
       $(document).on('keyup', '#phone5', function(e) {
           
          var val_ph2= $('#phone5').val();
           if(val_ph2.length == 1 && val_ph2=='0')
               {
                   $('#phone5').val('');
               }
           if(val_ph2.length == 9)
               {
                var testval = $('#phone5hid').val();
              if(val_ph2!=testval)    
           { 
               document.getElementById("phn5_act").style.display = "none";
             document.getElementById("phn5_vfy").style.display = "block";
                   
        xmlhttp1 = xmlhttpfunc();
		xmlhttp1.onreadystatechange=function() 
		{
			if (xmlhttpcond(xmlhttp1))
			{
                var tvall = xmlhttp1.responseText;
                alert("Please check your mobile for the OTP");
                $('#phn5_verify').focus();
			}
		}
        var ajaxlink = "<?php echo e(url('/')); ?>";
           ajaxlink+="/posts/notifyphone/";
		xmlhttp1.open("GET",ajaxlink+val_ph2,true);
		xmlhttp1.send();
               }
           else
                       {
                         $('#phn5_act').removeAttr('style');
                          document.getElementById("phn5_vfy").style.display = "none";   
                       }
               }
			});
       
       
       
       var phone2verified = $('#phone2hid').val();
       if(phone2verified!='')
           {
             document.getElementById("phn2").style.display = "block";
             $('#phn2_act').removeAttr('style');
//             document.getElementById("phn2_act").style.display = "block";
             document.getElementById("phn2_vfy").style.display = "none";
           }
       else{
             document.getElementById("phn2").style.display = "none";
             document.getElementById("phn2_act").style.display = "none";
             document.getElementById("phn2_vfy").style.display = "block";
       }
       
     
       var phone3verified = $('#phone3hid').val();
       if(phone3verified!='')
           {
             document.getElementById("phn3").style.display = "block";
               $('#phn3_act').removeAttr('style');
//             document.getElementById("phn2_act").style.display = "block";
             document.getElementById("phn3_vfy").style.display = "none";
           }
       else{
             document.getElementById("phn3").style.display = "none";
             document.getElementById("phn3_act").style.display = "none";
             document.getElementById("phn3_vfy").style.display = "block";
       }
       
       
       var phone4verified = $('#phone4hid').val();
       if(phone4verified!='')
           {
             document.getElementById("phn4").style.display = "block";
               $('#phn4_act').removeAttr('style');
//             document.getElementById("phn2_act").style.display = "block";
             document.getElementById("phn4_vfy").style.display = "none";
           }
       else{
            document.getElementById("phn4").style.display = "none";
             document.getElementById("phn4_act").style.display = "none";
             document.getElementById("phn4_vfy").style.display = "block";
       }
       
       var phone5verified = $('#phone5hid').val();
       if(phone5verified!='')
           {
             document.getElementById("phn5").style.display = "block";
               $('#phn5_act').removeAttr('style');
//             document.getElementById("phn2_act").style.display = "block";
             document.getElementById("phn5_vfy").style.display = "none";
           }
       else{
            document.getElementById("phn5").style.display = "none";
             document.getElementById("phn5_act").style.display = "none";
             document.getElementById("phn5_vfy").style.display = "block";
       }
       
                
                     setTimeout(function ()  {
//        var chkval = $('.cat-link').attr("data-id");
        var chkval = <?php echo e(old('category_id', data_get($post, 'category.id'))); ?>;
//                          alert(chkval);
        var prntval = '';
        var old_ptype = '<?php echo e(data_get($post, 'property_price_type')); ?>';
//                                alert(old_ptype);
        if(chkval=='42')
            {
                if (old_ptype=='per day')
                    {
                        prntval = '<input type="radio" checked name="property_price_type" id="property_price_type1" value="per day">per day <input type="radio" name="property_price_type" id="property_price_type2" value="per month">per month';
                    }
                else
                    {
                        prntval = '<input type="radio" name="property_price_type" id="property_price_type1" value="per day">per day <input type="radio" checked name="property_price_type" id="property_price_type2" value="per month">per month';
                    }
                
            }
        else if(chkval=='140')
            {
                prntval = '<input type="radio" checked name="property_price_type" id="property_price_type1" value="per day">per day';
            }
        else if(chkval=='38')
            {
                if (old_ptype=='per perch')
                    {
                                        prntval = '<input type="radio" checked name="property_price_type" id="property_price_type1" value="per perch">per perch <input type="radio" name="property_price_type" id="property_price_type2" value="per acre">per acre <input type="radio" name="property_price_type" id="property_price_type3" value="total price">Total Price';
                    }
                else if(old_ptype=='per acre')
                    {
                                       prntval = '<input type="radio" name="property_price_type" id="property_price_type1" value="per perch">per perch <input type="radio" checked name="property_price_type" id="property_price_type2" value="per acre">per acre <input type="radio" name="property_price_type" id="property_price_type3" value="total price">Total Price';
                    }
				else{
					                   prntval = '<input type="radio" name="property_price_type" id="property_price_type1" value="per perch">per perch <input type="radio" name="property_price_type" id="property_price_type2" value="per acre">per acre <input type="radio" checked name="property_price_type" id="property_price_type3" value="total price">Total Price';
    
				}
            }
        else if(chkval=='44')
            {
                if (old_ptype=='per perch')
                    {
                                        prntval = '<input type="radio" checked name="property_price_type" id="property_price_type1" value="per perch">per perch <input type="radio" name="property_price_type" id="property_price_type2" value="per acre">per acre <input type="radio" name="property_price_type" id="property_price_type3" value="total price">Total Price';
                    }
                else if(old_ptype=='per acre')
                    {
                                       prntval = '<input type="radio" name="property_price_type" id="property_price_type1" value="per perch">per perch <input type="radio" checked name="property_price_type" id="property_price_type2" value="per acre">per acre <input type="radio" name="property_price_type" id="property_price_type3" value="total price">Total Price';
                    }
				else{
					                   prntval = '<input type="radio" name="property_price_type" id="property_price_type1" value="per perch">per perch <input type="radio" name="property_price_type" id="property_price_type2" value="per acre">per acre <input type="radio" checked name="property_price_type" id="property_price_type3" value="total price">Total Price';
    
				}
            }
        else if(chkval=='45')
            {
                prntval = '<input type="radio" checked name="property_price_type" id="property_price_type2" value="per month">per month';
            }
        else if(chkval=='141')
            {
                prntval = '<input type="radio" checked name="property_price_type" id="property_price_type2" value="per month">per month';
            }
        else if(chkval=='40')
            {
                prntval = '<input type="radio" checked name="property_price_type" id="property_price_type2" value="per month">per month';
            }
        else if(chkval=='43')
            {
                prntval = '<input type="radio" checked name="property_price_type" id="property_price_type2" value="per month">per month';
            }
        $("#pricehintdiv").html(prntval);
	}, 1000);
       
    
}); 
</script>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.category-modal', 'post.createOrEdit.inc.category-modal'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
		defaultAuthField = '<?php echo e(old('auth_field', $authFieldValue ?? getAuthField())); ?>';
		phoneCountry = '<?php echo e(old('phone_country', ($phoneCountryValue ?? ''))); ?>';
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.form-assets', 'post.createOrEdit.inc.form-assets'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/post/createOrEdit/multiSteps/edit.blade.php ENDPATH**/ ?>