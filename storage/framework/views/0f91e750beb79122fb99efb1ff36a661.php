
<?php $filterSlug = str($filter->name)->slug(); ?>
<li filter-name="<?php echo e($filter->name); ?>"
	filter-type="<?php echo e($filter->type); ?>"
	class="dropdown <?php echo e(request()->query($filter->name) ? 'active' : ''); ?>">
	<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo e($filter->label); ?> <span class="caret"></span></a>
	<div class="dropdown-menu pt-0 pb-0">
		<div class="input-group backpack-filter mb-0">
			<div class="input-group">
				<input class="form-control float-end"
					   id="text-filter-<?php echo e($filterSlug); ?>"
					   type="text"
					   <?php if($filter->currentValue): ?>
					   value="<?php echo e($filter->currentValue); ?>"
					   <?php endif; ?>
				>
				<span class="input-group-text">
					<a class="text-filter-<?php echo e($filterSlug); ?>-clear-button" href=""><i class="fa fa-times"></i></a>
				</span>
			</div>
		</div>
	</div>
</li>








<?php $__env->startPush('crud_list_scripts'); ?>
	
	<script>
		jQuery(document).ready(function($) {
			$('#text-filter-<?php echo e($filterSlug); ?>').on('change', function(e) {
				
				var parameter = '<?php echo e($filter->name); ?>';
				var value = $(this).val();
				
				// behaviour for ajax table
				var ajaxTable = $('#crudTable').DataTable();
				var currentUrl = ajaxTable.ajax.url();
				var newUrl = addOrUpdateUriParameter(currentUrl, parameter, value);
				
				// replace the datatables ajax url with newUrl and reload it
				newUrl = normalizeAmpersand(newUrl.toString());
				ajaxTable.ajax.url(newUrl).load();
				
				// mark this filter as active in the navbar-filters
				if (URI(newUrl).hasQuery('<?php echo e($filter->name); ?>', true)) {
					$('li[filter-name=<?php echo e($filter->name); ?>]').removeClass('active').addClass('active');
				} else {
					$('li[filter-name=<?php echo e($filter->name); ?>]').trigger('filter:clear');
				}
			});
			
			$('li[filter-name=<?php echo e($filterSlug); ?>]').on('filter:clear', function(e) {
				$('li[filter-name=<?php echo e($filter->name); ?>]').removeClass('active');
				$('#text-filter-<?php echo e($filterSlug); ?>').val('');
			});
			
			// datepicker clear button
			$(".text-filter-<?php echo e($filterSlug); ?>-clear-button").click(function(e) {
				e.preventDefault();
				
				$('li[filter-name=<?php echo e($filterSlug); ?>]').trigger('filter:clear');
				$('#text-filter-<?php echo e($filterSlug); ?>').val('');
				$('#text-filter-<?php echo e($filterSlug); ?>').trigger('change');
			})
		});
	</script>
<?php $__env->stopPush(); ?>


<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/filters/text.blade.php ENDPATH**/ ?>