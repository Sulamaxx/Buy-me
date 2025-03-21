

<li filter-name="<?php echo e($filter->name); ?>"
	filter-type="<?php echo e($filter->type); ?>"
	class="nav-item dropdown <?php echo e(request()->query($filter->name)?'active':''); ?>">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		<?php echo e($filter->label); ?> <span class="caret"></span>
	</a>
    <ul class="dropdown-menu">
		<a class="dropdown-item" parameter="<?php echo e($filter->name); ?>" dropdownkey="" href="">-</a>
		<div role="separator" class="dropdown-divider"></div>
		<?php if(is_array($filter->values) && count($filter->values)): ?>
			<?php $__currentLoopData = $filter->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($key == 'dropdown-separator'): ?>
					<div role="separator" class="dropdown-divider"></div>
				<?php else: ?>
					<li class="dropdown-item <?php echo e(($filter->isActive() && $filter->currentValue == $key)?'active':''); ?>">
						<a  parameter="<?php echo e($filter->name); ?>" href="" key="<?php echo e($key); ?>"><?php echo e($value); ?></a>
					</li>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
    </ul>
  </li>








<?php $__env->startPush('crud_list_styles'); ?>
	<style>
		.navbar-filters .dropdown-menu {
			max-height: 320px;
			overflow-y: auto;
		}
	</style>
<?php $__env->stopPush(); ?>





<?php $__env->startPush('crud_list_scripts'); ?>
    <script>
		jQuery(document).ready(function($) {
			$("li.dropdown[filter-name=<?php echo e($filter->name); ?>] .dropdown-menu li a").click(function(e) {
				e.preventDefault();

				var value = $(this).attr('key');
				var parameter = $(this).attr('parameter');

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
					// mark dropdown items active accordingly
					if (URI(newUrl).hasQuery('<?php echo e($filter->name); ?>', true)) {
						$("li[filter-name=<?php echo e($filter->name); ?>]").removeClass('active').addClass('active');
						$("li[filter-name=<?php echo e($filter->name); ?>] .dropdown-menu li").removeClass('active');
						$(this).parent().addClass('active');
					}
					else
					{
						$("li[filter-name=<?php echo e($filter->name); ?>]").trigger("filter:clear");
					}
			    <?php endif; ?>
			});

			// clear filter event (used here and by the Remove all filters button)
			$("li[filter-name=<?php echo e($filter->name); ?>]").on('filter:clear', function(e) {
				// console.log('dropdown filter cleared');
				$("li[filter-name=<?php echo e($filter->name); ?>]").removeClass('active');
				$("li[filter-name=<?php echo e($filter->name); ?>] .dropdown-menu li").removeClass('active');
			});
		});
	</script>
<?php $__env->stopPush(); ?>


<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/filters/dropdown.blade.php ENDPATH**/ ?>