

<li filter-name="<?php echo e($filter->name); ?>"
	filter-type="<?php echo e($filter->type); ?>"
	class="nav-item dropdown <?php echo e(request()->query($filter->name)?'active':''); ?>"
>
	<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		<?php echo e($filter->label); ?> <span class="caret"></span>
	</a>
	<div class="dropdown-menu p-0">
		<div class="backpack-filter mb-0" style="min-width: 200px;">
			<select id="filter_<?php echo e($filter->name); ?>"
					name="filter_<?php echo e($filter->name); ?>"
					class="form-control input-sm select2"
					data-filter-type="select2"
					data-filter-name="<?php echo e($filter->name); ?>"
					placeholder="<?php echo e($filter->placeholder); ?>"
			>
				<option value="">-</option>
				<?php if(is_array($filter->values) && count($filter->values)): ?>
					<?php $__currentLoopData = $filter->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($key); ?>"
								<?php if($filter->isActive() && $filter->currentValue == $key): ?>
								selected
								<?php endif; ?>
						>
							<?php echo e($value); ?>

						</option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
			</select>
		</div>
	</div>
</li>







<?php $__env->startPush('crud_list_styles'); ?>
	
	<link href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css"/>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<style>
		.form-inline .select2-container {
			display: inline-block;
		}
		
		.select2-drop-active {
			border: none;
		}
		
		.select2-container .select2-choices .select2-search-field input, .select2-container .select2-choice, .select2-container .select2-choices {
			border: none;
		}
		
		.select2-container-active .select2-choice {
			border: none;
			box-shadow: none;
		}
	</style>
<?php $__env->stopPush(); ?>





<?php $__env->startPush('crud_list_scripts'); ?>
	
	<script src="<?php echo e(asset('assets/plugins/select2/js/select2.js')); ?>"></script>
	<script>
		jQuery(document).ready(function ($) {
			// trigger select2 for each untriggered select2 box
			$('.select2').each(function (i, obj) {
				if (!$(obj).data("select2")) {
					$(obj).select2({
						allowClear: true,
						placeholder: "<?php echo e($filter->placeholder ? $filter->placeholder : ' '); ?>",
						closeOnSelect: true,
						theme: "bootstrap"
					});
				}
			});
		});
	</script>
	
	<script>
		jQuery(document).ready(function ($) {
			$("select[name=filter_<?php echo e($filter->name); ?>]").change(function () {
				var value = $(this).val();
				var parameter = '<?php echo e($filter->name); ?>';
				
				<?php if(!$xPanel->ajaxTable()): ?>
				// behaviour for normal table
				var currentUrl = normalizeAmpersand('<?php echo e(request()->fullUrl()); ?>');
				var newUrl = addOrUpdateUriParameter(currentUrl, parameter, value);
				
				// refresh the page to the newUrl
				newUrl = normalizeAmpersand(newUrl.toString());
				window.location.href = newUrl;
				<?php else: ?>
				// behaviour for ajax table
				var ajaxTable = $("#crudTable").DataTable();
				var currentUrl = ajaxTable.ajax.url();
				var newUrl = addOrUpdateUriParameter(currentUrl, parameter, value);
				
				// replace the datatables ajax url with newUrl and reload it
				newUrl = normalizeAmpersand(newUrl.toString());
				ajaxTable.ajax.url(newUrl).load();
				
				// mark this filter as active in the navbar-filters
				if (URI(newUrl).hasQuery('<?php echo e($filter->name); ?>', true)) {
					$("li[filter-name=<?php echo e($filter->name); ?>]").removeClass('active').addClass('active');
				} else {
					$("li[filter-name=<?php echo e($filter->name); ?>]").trigger("filter:clear");
				}
				<?php endif; ?>
			});
			
			// when the dropdown is opened, autofocus on the select2
			$("li[filter-name=<?php echo e($filter->name); ?>]").on('shown.bs.dropdown', function () {
				$('#filter_<?php echo e($filter->name); ?>').select2('open');
			});
			
			// clear filter event (used here and by the Remove all filters button)
			$("li[filter-name=<?php echo e($filter->name); ?>]").on('filter:clear', function (e) {
				// console.log('select2 filter cleared');
				$("li[filter-name=<?php echo e($filter->name); ?>]").removeClass('active');
				/* $("li[filter-name=<?php echo e($filter->name); ?>] .select2").select2("val", ""); */
				$('#filter_<?php echo e($filter->name); ?>').val('');
			});
		});
	</script>
<?php $__env->stopPush(); ?>


<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/filters/select2.blade.php ENDPATH**/ ?>