<?php
	$fields ??= [];
	$errors ??= [];
	$oldInput ??= [];
	
	if (empty($languageCode)) {
		$languageCode = config('app.locale', session('langCode'));
	}
?>
<?php if(!empty($fields)): ?>
	<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
			$modelFieldId = data_get($field, 'id');
			$modelFieldType = data_get($field, 'type');
			$modelDefaultValue = data_get($field, 'default_value');
			
			// Fields parameters
			$fieldId = 'cf.' . $modelFieldId;
			$fieldName = 'cf[' . $modelFieldId . ']';
			$fieldOld = 'cf.' . $modelFieldId;
			
			// Errors & Required CSS
			$requiredClass = (data_get($field, 'required') == 1) ? 'required' : '';
			$errorClass = (isset($errors[$fieldOld])) ? ' is-invalid' : '';
			
			// Get the default value
			$defaultValue = $oldInput[$modelFieldId] ?? $modelDefaultValue;
			
			// Get field other attributes
			$fieldOptions = data_get($field, 'options') ?? [];
			$fieldOptions = is_array($fieldOptions) ? $fieldOptions : [];
		?>
		
		<?php if($modelFieldType == 'checkbox'): ?>
			
			
			<div class="row mb-3 <?php echo e($requiredClass); ?>" style="margin-top: -10px;">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>"></label>
				<div class="col-md-8">
					<div class="form-check pt-2">
						<input id="<?php echo e($fieldId); ?>"
							   name="<?php echo e($fieldName); ?>"
							   value="1"
							   type="checkbox"
							   class="form-check-input<?php echo e($errorClass); ?>"
								<?php echo e(($defaultValue=='1') ? 'checked="checked"' : ''); ?>

						>
						<label class="form-check-label" for="<?php echo e($fieldId); ?>">
							<?php echo e(data_get($field, 'name')); ?>

						</label>
					</div>
					<div class="form-text text-muted"><?php echo data_get($field, 'help'); ?></div>
				</div>
			</div>
		
		<?php elseif($modelFieldType == 'checkbox_multiple'): ?>
			
			<?php if(!empty($fieldOptions)): ?>
				
				<div class="row mb-3 <?php echo e($requiredClass); ?>" style="margin-top: -10px;">
					<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
						<?php echo e(data_get($field, 'name')); ?>

						<?php if(data_get($field, 'required') == 1): ?>
							<sup>*</sup>
						<?php endif; ?>
					</label>
					<?php
						$cmFieldStyle = (count($fieldOptions) > 12) ? ' style="height: 250px; overflow-y: scroll;"' : '';
					?>
					<div class="col-md-8"<?php echo $cmFieldStyle; ?>>
						<?php $__currentLoopData = $fieldOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								$modelOptionId = data_get($option, 'id');
								
								// Get the default value
								$defaultValue = (is_array($modelDefaultValue)) ? data_get($modelDefaultValue, $modelOptionId . '.id') : $modelDefaultValue;
								$defaultValue = data_get($oldInput, $modelFieldId . '.' . $modelOptionId, $defaultValue);
							?>
							<div class="form-check pt-2">
								<input id="<?php echo e($fieldId . '.' . $modelOptionId); ?>"
									   name="<?php echo e($fieldName . '[' . $modelOptionId . ']'); ?>"
									   value="<?php echo e($modelOptionId); ?>"
									   type="checkbox"
									   class="form-check-input<?php echo e($errorClass); ?>"
										<?php echo e(($defaultValue == $modelOptionId) ? 'checked="checked"' : ''); ?>

								>
								<label class="form-check-label" for="<?php echo e($fieldId . '.' . $modelOptionId); ?>">
									 <?php echo e(data_get($option, 'value')); ?>

								</label>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<div class="form-text text-muted"><?php echo data_get($field, 'help'); ?></div>
					</div>
				</div>
			<?php endif; ?>
			
		<?php elseif($modelFieldType == 'file'): ?>
			
			
			<div class="row mb-3 <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e(data_get($field, 'name')); ?>

					<?php if(data_get($field, 'required') == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<div class="mb10">
						<input id="<?php echo e($fieldId); ?>" name="<?php echo e($fieldName); ?>" type="file" class="file<?php echo e($errorClass); ?>">
					</div>
					<div class="form-text text-muted">
						<?php echo data_get($field, 'help'); ?> <?php echo e(t('file_types', ['file_types' => showValidFileTypes('file')], 'global', $languageCode)); ?>

					</div>
					<?php if(!empty($modelDefaultValue) && $disk->exists($modelDefaultValue)): ?>
						<div>
							<a class="btn btn-default" href="<?php echo e(privateFileUrl($modelDefaultValue, null)); ?>" target="_blank">
								<i class="fas fa-paperclip"></i> <?php echo e(t('Download')); ?>

							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		
		<?php elseif($modelFieldType == 'radio'): ?>
			
			<?php if(!empty($fieldOptions)): ?>
				
				<div class="row mb-3 <?php echo e($requiredClass); ?>">
					<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
						<?php echo e(data_get($field, 'name')); ?>

						<?php if(data_get($field, 'required') == 1): ?>
							<sup>*</sup>
						<?php endif; ?>
					</label>
					<div class="col-md-8">
						<?php $__currentLoopData = $fieldOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								$modelOptionId = data_get($option, 'id');
							?>
							<div class="form-check pt-2">
								<input id="<?php echo e($fieldId); ?>"
									   name="<?php echo e($fieldName); ?>"
									   value="<?php echo e($modelOptionId); ?>"
									   type="radio"
									   class="form-check-input<?php echo e($errorClass); ?>"
										<?php echo e(($defaultValue == $modelOptionId) ? 'checked="checked"' : ''); ?>

								>
								<label class="form-check-label" for="<?php echo e($fieldName); ?>">
									<?php echo e(data_get($option, 'value')); ?>

								</label>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<div class="form-text text-muted"><?php echo data_get($field, 'help'); ?></div>
				</div>
			<?php endif; ?>
		
		<?php elseif($modelFieldType == 'select'): ?>
			
			
			<div class="row mb-3 <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label<?php echo e($errorClass); ?>" for="<?php echo e($fieldId); ?>">
					<?php echo e(data_get($field, 'name')); ?>

					<?php if(data_get($field, 'required') == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<?php
						$select2Type = (count($fieldOptions) <= 10) ? 'selecter' : 'large-data-selecter';
					?>
					<select id="<?php echo e($fieldId); ?>" name="<?php echo e($fieldName); ?>" class="form-control <?php echo e($select2Type . $errorClass); ?>">
						<option value="<?php echo e($modelDefaultValue); ?>" <?php if(empty(old($fieldOld)) || old($fieldOld)==$modelDefaultValue): echo 'selected'; endif; ?>>
							<?php echo e(t('Select', [], 'global', $languageCode)); ?>

						</option>
						<?php if(!empty($fieldOptions)): ?>
							<?php $__currentLoopData = $fieldOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
									$modelOptionId = data_get($option, 'id');
								?>
								<option value="<?php echo e($modelOptionId); ?>" <?php if($defaultValue == $modelOptionId): echo 'selected'; endif; ?>>
									<?php echo e(data_get($option, 'value')); ?>

								</option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</select>
					<div class="form-text text-muted"><?php echo data_get($field, 'help'); ?></div>
				</div>
			</div>
		
		<?php elseif($modelFieldType == 'textarea'): ?>
			
			
			<div class="row mb-3 <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e(data_get($field, 'name')); ?>

					<?php if(data_get($field, 'required') == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<?php
						$fieldMax = (int)data_get($field, 'max');
						$fieldMaxAttr = !empty($fieldMax) ? ' maxlength="'. $fieldMax .'"' : '';
					?>
					<textarea style="height: 100px;" class="form-control<?php echo e($errorClass); ?>"
						  id="<?php echo e($fieldId); ?>"
						  name="<?php echo e($fieldName); ?>"
						   
						  rows="30"<?php echo $fieldMaxAttr; ?>

					><?php echo e($defaultValue); ?></textarea>
					<div class="form-text text-muted"><?php echo data_get($field, 'help'); ?></div>
				</div>
			</div>
		
		<?php elseif($modelFieldType == 'url'): ?>
			
			
			<div class="row mb-3 <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e(data_get($field, 'name')); ?>

					<?php if(data_get($field, 'required') == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="text"
						   placeholder="<?php echo e(data_get($field, 'name')); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?>"
						   value="<?php echo e($defaultValue); ?>">
					<div class="form-text text-muted"><?php echo data_get($field, 'help'); ?></div>
				</div>
			</div>
		
		<?php elseif($modelFieldType == 'number'): ?>
			
			
			<div class="row mb-3 <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e(data_get($field, 'name')); ?>

					<?php if(data_get($field, 'required') == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<?php
						$fieldMax = (int)data_get($field, 'max');
						$fieldMaxAttr = !empty($fieldMax) ? ' max="'. $fieldMax .'"' : '';
					?>
					<!-- field cust #001 -->
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="number"
						   placeholder="<?php echo data_get($field, 'help'); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?>"
						   value="<?php echo e($defaultValue); ?>"<?php echo $fieldMaxAttr; ?>>
					<div class="form-text text-muted"></div>
				</div>
			</div>
		
		<?php elseif($modelFieldType == 'date'): ?>
			
			
			<div class="row mb-3 <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e(data_get($field, 'name')); ?>

					<?php if(data_get($field, 'required') == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="text"
						   placeholder="<?php echo e(data_get($field, 'name')); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?> cf-date"
						   value="<?php echo e($defaultValue); ?>"
						   autocomplete="off"
					>
					<div class="form-text text-muted"><?php echo data_get($field, 'help'); ?></div>
				</div>
			</div>
			
		<?php elseif($modelFieldType == 'date_time'): ?>
			
			
			<div class="row mb-3 <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e(data_get($field, 'name')); ?>

					<?php if(data_get($field, 'required') == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="text"
						   placeholder="<?php echo e(data_get($field, 'name')); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?> cf-date_time"
						   value="<?php echo e($defaultValue); ?>"
						   autocomplete="off"
					>
					<div class="form-text text-muted"><?php echo data_get($field, 'help'); ?></div>
				</div>
			</div>
			
		<?php elseif($modelFieldType == 'date_range'): ?>
			
			
			<div class="row mb-3 <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e(data_get($field, 'name')); ?>

					<?php if(data_get($field, 'required') == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="text"
						   placeholder="<?php echo e(data_get($field, 'name')); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?> cf-date_range"
						   value="<?php echo e($defaultValue); ?>"
						   autocomplete="off"
					>
					<div class="form-text text-muted"><?php echo data_get($field, 'help'); ?></div>
				</div>
			</div>
			
		<?php elseif($modelFieldType == 'label'): ?>
			
			
			<div class="row mb-8 <?php echo e($requiredClass); ?>">
				<label class="col-md-9 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e(data_get($field, 'name')); ?>

					<?php if(data_get($field, 'required') == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
	 
			</div>
			<BR>
			
		<?php else: ?>
			
			
			<div class="row mb-3 <?php echo e($requiredClass); ?>">
				<label class="col-md-3 col-form-label" for="<?php echo e($fieldId); ?>">
					<?php echo e(data_get($field, 'name')); ?>

					<?php if(data_get($field, 'required') == 1): ?>
						<sup>*</sup>
					<?php endif; ?>
				</label>
				<div class="col-md-8">
					<?php
						$fieldMax = (int)data_get($field, 'max');
						$fieldMaxAttr = !empty($fieldMax) ? ' maxlength="'. $fieldMax .'"' : '';
					?>
					<!-- field cust #001 -->
					<input id="<?php echo e($fieldId); ?>"
						   name="<?php echo e($fieldName); ?>"
						   type="text"
						   placeholder="<?php echo data_get($field, 'help'); ?>"
						   class="form-control input-md<?php echo e($errorClass); ?>"
						   value="<?php echo e($defaultValue); ?>"<?php echo $fieldMaxAttr; ?>>
					<div class="form-text text-muted"></div>
				</div>
			</div>
			
		<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<script>
	$(function() {
		/*
		 * Custom Fields Date Picker
		 * https://www.daterangepicker.com/#options
		 */
		
		let dateEl = $('#cfContainer .cf-date');
		dateEl.daterangepicker({
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
		dateEl.on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format')); ?>'));
		});
		
		
		let dateTimeEl = $('#cfContainer .cf-date_time');
		dateTimeEl.daterangepicker({
			autoUpdateInput: false,
			autoApply: true,
			showDropdowns: false,
			minYear: parseInt(moment().format('YYYY')) - 100,
			maxYear: parseInt(moment().format('YYYY')) + 20,
			locale: {
				format: '<?php echo e(t('datepicker_format_datetime')); ?>',
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
			timePicker: true,
			timePicker24Hour: true,
			startDate: moment().format('<?php echo e(t('datepicker_format_datetime')); ?>')
		});
		dateTimeEl.on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format_datetime')); ?>'));
		});
		
		
		let dateRangeEl = $('#cfContainer .cf-date_range');
		dateRangeEl.daterangepicker({
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
		dateRangeEl.on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('<?php echo e(t('datepicker_format')); ?>') + ' - ' + picker.endDate.format('<?php echo e(t('datepicker_format')); ?>'));
		});
	});
</script>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/post/createOrEdit/inc/fields.blade.php ENDPATH**/ ?>