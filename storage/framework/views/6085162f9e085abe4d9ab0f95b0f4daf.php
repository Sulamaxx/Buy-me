<?php if(isset($customFields) && !empty($customFields)): ?>
	<form id="cfForm" role="form" class="form" action="<?php echo e(request()->url()); ?>" method="GET">
		<?php
			$disabledFieldsTypes = ['file', 'video'];
			$clearFilterBtn = '';
			$firstFieldFound = false;
		?>
		<?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if(in_array(data_get($field, 'type'), $disabledFieldsTypes) || data_get($field, 'use_as_filter') != 1) continue; ?>
			<?php
				// Fields parameters
				$fieldId = 'cf.' . data_get($field, 'id');
				$fieldName = 'cf[' . data_get($field, 'id') . ']';
				$fieldOld = 'cf.' . data_get($field, 'id');
				
				// Get the default value
				$defaultValue = (request()->filled($fieldOld)) ? request()->input($fieldOld) : data_get($field, 'default_value');
				
				// Field Query String
				$fieldQueryStringId = 'cf' . data_get($field, 'id') . 'QueryString';
				$fieldQueryStringValue = \App\Helpers\Arr::query(request()->except(['page', $fieldId]));
				$fieldQueryString = '<input type="hidden" id="' . $fieldQueryStringId . '" value="' . $fieldQueryStringValue . '">';
				
				// Clear Filter Button
				$clearFilterBtn = \App\Helpers\UrlGen::getCustomFieldFilterClearLink($fieldOld, $cat ?? null, $city ?? null);
			?>
			
			<?php if(in_array(data_get($field, 'type'), ['text', 'textarea', 'url', 'number'])): ?>
				
				
				<div class="block-title has-arrow sidebar-header">
					<h5>
						<span class="fw-bold">
							<?php echo e(data_get($field, 'name')); ?>

						</span> <?php echo $clearFilterBtn; ?>

					</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content row px-1 gx-1 gy-1">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<input id="<?php echo e($fieldId); ?>"
								   name="<?php echo e($fieldName); ?>"
								   type="<?php echo e((data_get($field, 'type') == 'number') ? 'number' : 'text'); ?>"
								   placeholder="<?php echo e(data_get($field, 'name')); ?>"
								   class="form-control input-md"
								   value="<?php echo e(strip_tags($defaultValue)); ?>"<?php echo (data_get($field, 'type') == 'number') ? ' autocomplete="off"' : ''; ?>

							>
						</div>
						<?php /*?><div class="col-lg-3 col-md-12 col-sm-12">
							<button class="btn btn-default btn-block btn-sm-1" type="submit">{{ t('go') }}</button>
						</div><?php */?>
					</div>
				</div>
				<?php echo $fieldQueryString; ?>

				<div style="clear:both"></div>
			
			<?php endif; ?>
			<?php if(data_get($field, 'type') == 'checkbox'): ?>
				
				
				<div class="block-title has-arrow sidebar-header">
					<h5>
						<span class="fw-bold"><a href="#"><?php echo e(data_get($field, 'name')); ?></a></span> <?php echo $clearFilterBtn; ?>

					</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content">
						<div class="form-check form-switch">
							<input id="<?php echo e($fieldId); ?>"
								   name="<?php echo e($fieldName); ?>"
								   value="1"
								   type="checkbox"
								   class="form-check-input"
									<?php echo e(($defaultValue == '1') ? 'checked="checked"' : ''); ?>

							>
							<label class="form-check-label" for="<?php echo e($fieldId); ?>">
								<?php echo e(data_get($field, 'name')); ?>

							</label>
						</div>
					</div>
				</div>
				<?php echo $fieldQueryString; ?>

				<div style="clear:both"></div>
			
			<?php endif; ?>
			<?php if(data_get($field, 'type') == 'checkbox_multiple'): ?>
				
				<?php if(!empty(data_get($field, 'options'))): ?>
					
					<div class="block-title has-arrow sidebar-header">
						<h5>
							<span class="fw-bold">
								<?php echo e(data_get($field, 'name')); ?>

							</span> <?php echo $clearFilterBtn; ?>

						</h5>
					</div>
					<div class="block-content list-filter">
						<?php
							$cmFieldStyle = (is_array(data_get($field, 'options')) && count(data_get($field, 'options')) > 12)
								? ' style="height: 250px; overflow-y: scroll;"'
								: '';
						?>
						<div class="filter-content"<?php echo $cmFieldStyle; ?>>
							<?php $__currentLoopData = data_get($field, 'options'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
									$optionId = data_get($option, 'id');
									
									// Get the default value
									$defaultValue = (request()->filled($fieldOld . '.' . $optionId))
										? request()->input($fieldOld . '.' . $optionId)
										: (
											(
												is_array(data_get($field, 'default_value'))
												&& !empty($optionId)
												&& !empty(data_get($field, 'default_value.' . $optionId . '.value'))
											)
												? data_get($field, 'default_value.' . $optionId . '.value')
												: data_get($field, 'default_value')
										);
									
									// Field Query String
									$fieldQueryStringId = 'cf' . data_get($field, 'id') . $optionId . 'QueryString';
									$fieldQueryStringValue = \App\Helpers\Arr::query(request()->except(['page', $fieldId . '.' . $optionId]));
									$fieldQueryString = '<input type="hidden" id="' . $fieldQueryStringId . '" value="' . $fieldQueryStringValue . '">';
								?>
								<div class="form-check form-switch">
									<input id="<?php echo e($fieldId . '.' . $optionId); ?>"
										   name="<?php echo e($fieldName . '[' . $optionId . ']'); ?>"
										   value="<?php echo e($optionId); ?>"
										   type="checkbox"
										   class="form-check-input"
											<?php echo e(($defaultValue == $optionId) ? 'checked="checked"' : ''); ?>

									>
									<label class="form-check-label" for="<?php echo e($fieldId . '.' . $optionId); ?>">
										<?php echo e(data_get($option, 'value')); ?>

									</label>
								</div>
								<?php echo $fieldQueryString; ?>

							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
					<div style="clear:both"></div>
				<?php endif; ?>
			
			<?php endif; ?>
			<?php if(data_get($field, 'type') == 'radio'): ?>
				
				<?php if(!empty(data_get($field, 'options'))): ?>
					
					<div class="block-title has-arrow sidebar-header">
						<h5>
							<span class="fw-bold">
								<?php echo e(data_get($field, 'name')); ?>

							</span> <?php echo $clearFilterBtn; ?>

						</h5>
					</div>
					<div class="block-content list-filter">
						<?php
							$rFieldStyle = (is_array(data_get($field, 'options')) && count(data_get($field, 'options')) > 12)
								? ' style="height: 250px; overflow-y: scroll;"'
								: '';
						?>
						<div class="filter-content"<?php echo $rFieldStyle; ?>>
							<?php $__currentLoopData = data_get($field, 'options'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
									$optionId = data_get($option, 'id');
								?>
								<div class="form-check">
									<input id="<?php echo e($fieldId); ?>"
										   name="<?php echo e($fieldName); ?>"
										   value="<?php echo e($optionId); ?>"
										   type="radio"
										   class="form-check-input"
											<?php echo e(($defaultValue == $optionId) ? 'checked="checked"' : ''); ?>

									>
									<label class="form-check-label" for="<?php echo e($fieldId); ?>">
										<?php echo e(data_get($option, 'value')); ?>

									</label>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
					<?php echo $fieldQueryString; ?>

					<div style="clear:both"></div>
				<?php endif; ?>
				
			<?php endif; ?>
			<?php if(data_get($field, 'type') == 'select'): ?>
			
				
				<div class="block-title has-arrow sidebar-header">
					<h5>
						<span class="fw-bold">
							<?php echo e(data_get($field, 'name')); ?>

						</span> <?php echo $clearFilterBtn; ?>

					</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content">
						<?php
							$fieldOptions = is_array(data_get($field, 'options')) ? data_get($field, 'options') : [];
							$select2Type = (count($fieldOptions) <= 10) ? 'selecter' : 'large-data-selecter';
						?>
						<select id="<?php echo e($fieldId); ?>" name="<?php echo e($fieldName); ?>" class="form-control <?php echo e($select2Type); ?>">
							<option value="" <?php if(empty(old($fieldOld))): echo 'selected'; endif; ?>>
								<?php echo e(t('Select')); ?>

							</option>
							<?php if(!empty($fieldOptions)): ?>
								<?php $__currentLoopData = $fieldOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$optionId = data_get($option, 'id');
									?>
									<option value="<?php echo e($optionId); ?>" <?php if($defaultValue == $optionId): echo 'selected'; endif; ?>>
										<?php echo e(data_get($option, 'value')); ?>

									</option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
				<?php echo $fieldQueryString; ?>

				<div style="clear:both"></div>
			
			<?php endif; ?>
			<?php if(in_array(data_get($field, 'type'), ['date', 'date_time', 'date_range'])): ?>
			
				
				<div class="block-title has-arrow sidebar-header">
					<h5>
						<span class="fw-bold">
							<?php echo e(data_get($field, 'name')); ?>

						</span> <?php echo $clearFilterBtn; ?>

					</h5>
				</div>
				<?php
					$datePickerClass = '';
					if (in_array(data_get($field, 'type'), ['date', 'date_time'])) {
						$datePickerClass = ' cf-date';
					}
					if (data_get($field, 'type') == 'date_range') {
						$datePickerClass = ' cf-date_range';
					}
				?>
				<div class="block-content list-filter">
					<div class="filter-content row px-1 gx-1 gy-1">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<input id="<?php echo e($fieldId); ?>"
								   name="<?php echo e($fieldName); ?>"
								   type="text"
								   placeholder="<?php echo e(data_get($field, 'name')); ?>"
								   class="form-control input-md<?php echo e($datePickerClass); ?>"
								   value="<?php echo e(strip_tags($defaultValue)); ?>"
								   autocomplete="off"
							>
						</div>
						<?php /*?><div class="col-lg-3 col-md-12 col-sm-12">
							<button class="btn btn-default btn-block btn-sm-1 " type="submit">{{ t('go') }}</button>
						</div><?php */?>
					</div>
				</div>
				<?php echo $fieldQueryString; ?>

				<div style="clear:both"></div>
			
			<?php endif; ?>
			
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--	</form>-->
	<div style="clear:both"></div>
<?php endif; ?>

<?php $__env->startSection('after_styles'); ?>
	<link href="<?php echo e(url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script src="<?php echo e(url('assets/plugins/momentjs/moment.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')); ?>" type="text/javascript"></script>
	<script>
		$(document).ready(function ()
		{
			/* Select */
//			$('#cfForm').find('select').change(function() {
//				/* Get full field's ID */
//				var fullFieldId = $(this).attr('id');
//				
//				/* Get full field's ID without dots */
//				var jsFullFieldId = fullFieldId.split('.').join('');
//				
//				/* Get real field's ID */
//				var tmp = fullFieldId.split('.');
//				if (typeof tmp[1] !== 'undefined') {
//					var fieldId = tmp[1];
//				} else {
//					return false;
//				}
//				
//				/* Get saved QueryString */
//				var fieldQueryString = $('#' + jsFullFieldId + 'QueryString').val();
//				
//				/* Add the field's value to the QueryString */
//				if (fieldQueryString !== '') {
//					fieldQueryString = fieldQueryString + '&';
//				}
//				fieldQueryString = fieldQueryString + 'cf['+fieldId+']=' + $(this).val();
//				
//				/* Redirect to the new search URL */
//				var searchUrl = baseUrl + '?' + fieldQueryString;
//				redirect(searchUrl);
//			});
			
			/* Radio & Checkbox */
//			$('#cfForm').find('input[type=radio], input[type=checkbox]').click(function() {
//				/* Get full field's ID */
//				var fullFieldId = $(this).attr('id');
//				
//				/* Get full field's ID without dots */
//				var jsFullFieldId = fullFieldId.split('.').join('');
//				
//				/* Get real field's ID */
//				var tmp = fullFieldId.split('.');
//				if (typeof tmp[1] !== 'undefined') {
//					var fieldId = tmp[1];
//					if (typeof tmp[2] !== 'undefined') {
//						var fieldOptionId = tmp[2];
//					}
//				} else {
//					return false;
//				}
//				
//				/* Get saved QueryString */
//				var fieldQueryString = $('#' + jsFullFieldId + 'QueryString').val();
//				
//				/* Check if field is checked */
//				if ($(this).prop('checked') == true) {
//					/* Add the field's value to the QueryString */
//					if (fieldQueryString != '') {
//						fieldQueryString = fieldQueryString + '&';
//					}
//					if (typeof fieldOptionId !== 'undefined') {
//						fieldQueryString = fieldQueryString + 'cf[' + fieldId + '][' + fieldOptionId + ']=' + rawurlencode($(this).val());
//					} else {
//						fieldQueryString = fieldQueryString + 'cf[' + fieldId + ']=' + $(this).val();
//					}
//				}
//				
//				/* Redirect to the new search URL */
//				var searchUrl = baseUrl + '?' + fieldQueryString;
//				redirect(searchUrl);
//			});
			
			/*
			 * Custom Fields Date Picker
			 * https://www.daterangepicker.com/#options
			 */
			
			$('#cfForm .cf-date').daterangepicker({
				autoUpdateInput: false,
				autoApply: true,
				showDropdowns: true,
				minYear: parseInt(moment().format('YYYY')) - 100,
				maxYear: parseInt(moment().format('YYYY')) + 20,
				locale: {
					format: '<?php echo e(t('datepicker_format')); ?>',
					applyLabel: "<?php echo e(t('datepicker_applyLabel')); ?>",
					cancelLabel: "<?php echo e(t('datepicker_cancelLabel')); ?>",
					fromLabel: "<?php echo e(t('datepicker_fromLabel')); ?>",
					toLabel: "<?php echo e(t('datepicker_toLabel')); ?>",
					customRangeLabel: "<?php echo e(t('datepicker_customRangeLabel')); ?>",
					weekLabel: "<?php echo e(t('datepicker_weekLabel')); ?>",
					daysOfWeek: [
						"<?php echo e(t('datepicker_sunday')); ?>",
						"<?php echo e(t('datepicker_monday')); ?>",
						"<?php echo e(t('datepicker_tuesday')); ?>",
						"<?php echo e(t('datepicker_wednesday')); ?>",
						"<?php echo e(t('datepicker_thursday')); ?>",
						"<?php echo e(t('datepicker_friday')); ?>",
						"<?php echo e(t('datepicker_saturday')); ?>"
					],
					monthNames: [
						"<?php echo e(t('January')); ?>",
						"<?php echo e(t('February')); ?>",
						"<?php echo e(t('March')); ?>",
						"<?php echo e(t('April')); ?>",
						"<?php echo e(t('May')); ?>",
						"<?php echo e(t('June')); ?>",
						"<?php echo e(t('July')); ?>",
						"<?php echo e(t('August')); ?>",
						"<?php echo e(t('September')); ?>",
						"<?php echo e(t('October')); ?>",
						"<?php echo e(t('November')); ?>",
						"<?php echo e(t('December')); ?>"
					],
					firstDay: 1
				},
				singleDatePicker: true,
				startDate: moment().format('<?php echo e(t('datepicker_format')); ?>')
			});
			$('#cfForm .cf-date').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format')); ?>'));
			});
			
			
			$('#cfForm .cf-date_range').daterangepicker({
				autoUpdateInput: false,
				autoApply: true,
				showDropdowns: false,
				minYear: parseInt(moment().format('YYYY')) - 100,
				maxYear: parseInt(moment().format('YYYY')) + 20,
				locale: {
					format: '<?php echo e(t('datepicker_format')); ?>',
					applyLabel: "<?php echo e(t('datepicker_applyLabel')); ?>",
					cancelLabel: "<?php echo e(t('datepicker_cancelLabel')); ?>",
					fromLabel: "<?php echo e(t('datepicker_fromLabel')); ?>",
					toLabel: "<?php echo e(t('datepicker_toLabel')); ?>",
					customRangeLabel: "<?php echo e(t('datepicker_customRangeLabel')); ?>",
					weekLabel: "<?php echo e(t('datepicker_weekLabel')); ?>",
					daysOfWeek: [
						"<?php echo e(t('datepicker_sunday')); ?>",
						"<?php echo e(t('datepicker_monday')); ?>",
						"<?php echo e(t('datepicker_tuesday')); ?>",
						"<?php echo e(t('datepicker_wednesday')); ?>",
						"<?php echo e(t('datepicker_thursday')); ?>",
						"<?php echo e(t('datepicker_friday')); ?>",
						"<?php echo e(t('datepicker_saturday')); ?>"
					],
					monthNames: [
						"<?php echo e(t('January')); ?>",
						"<?php echo e(t('February')); ?>",
						"<?php echo e(t('March')); ?>",
						"<?php echo e(t('April')); ?>",
						"<?php echo e(t('May')); ?>",
						"<?php echo e(t('June')); ?>",
						"<?php echo e(t('July')); ?>",
						"<?php echo e(t('August')); ?>",
						"<?php echo e(t('September')); ?>",
						"<?php echo e(t('October')); ?>",
						"<?php echo e(t('November')); ?>",
						"<?php echo e(t('December')); ?>"
					],
					firstDay: 1
				},
				startDate: moment().format('<?php echo e(t('datepicker_format')); ?>'),
				endDate: moment().add(1, 'days').format('<?php echo e(t('datepicker_format')); ?>')
			});
			$('#cfForm .cf-date_range').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format')); ?>') + ' - ' + picker.endDate.format('<?php echo e(t('datepicker_format')); ?>'));
			});
		});
	</script>
<?php $__env->stopSection(); ?><?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/search/inc/sidebar/fields.blade.php ENDPATH**/ ?>