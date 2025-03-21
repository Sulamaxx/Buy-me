<nav class="navbar navbar-expand-lg navbar-filters mb-0 py-1 px-3">
	
	<a class="nav-item d-none d-lg-block">
		<span class="fas fa-filter"></span>
	</a>
	<button class="navbar-toggler"
			type="button"
			data-bs-toggle="collapse"
			data-bs-target="#bs-example-navbar-collapse-1"
			aria-controls="bs-example-navbar-collapse-1"
			aria-expanded="false"
			aria-label="Toggle filters"
	>
		<i class="fas fa-filter"></i> <?php echo e(trans('admin.Filters')); ?>

	</button>
	
	
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			
			<?php $__currentLoopData = $xPanel->filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo $__env->make($filter->view, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<li>
				<a href="#" id="remove_filters_button" class="nav-link <?php echo e(count(request()->input()) != 0 ? '' : 'invisible'); ?>">
					<i class="fa fa-eraser"></i> <?php echo e(trans('admin.Remove filters')); ?>

				</a>
			</li>
		</ul>
	</div>
</nav>


<?php $__env->startPush('crud_list_styles'); ?>
	<style>
		.navbar-filters .nav > li > a {
			position: relative;
			display: block;
			padding: 10px 15px;
		}
		
		.backpack-filter label {
			color: #868686;
			font-weight: 600;
			text-transform: uppercase;
		}
		
		.navbar-filters {
			min-height: 25px;
			border-radius: 0;
			margin-bottom: 10px;
			background: #f9f9f9;
			border-color: #f4f4f4;
		}
		
		.navbar-filters .navbar-collapse {
			padding: 0;
		}
		
		.navbar-filters .navbar-toggle {
			padding: 10px 15px;
			border-radius: 0;
		}
		
		.navbar-filters .navbar-brand {
			height: 25px;
			padding: 5px 15px;
			font-size: 14px;
			text-transform: uppercase;
		}
		
		@media (min-width: 768px) {
			.navbar-filters .navbar-nav > li > a {
				padding-top: 5px;
				padding-bottom: 5px;
			}
		}
		
		@media (max-width: 768px) {
			.navbar-filters .navbar-nav {
				/* margin: 0; */
			}
		}
	</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('crud_list_scripts'); ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/URI.js/1.18.2/URI.min.js" type="text/javascript"></script>
	<script>
		function addOrUpdateUriParameter(uri, parameter, value) {
			var newUrl = normalizeAmpersand(uri);
			
			newUrl = URI(newUrl).normalizeQuery();
			
			if (newUrl.hasQuery(parameter)) {
				newUrl.removeQuery(parameter);
			}
			
			if (value != '') {
				newUrl = newUrl.addQuery(parameter, value);
			}
			
			return newUrl.toString();
		}
		
		function normalizeAmpersand(string) {
			return string.replace(/&amp;/g, "&").replace(/amp%3B/g, "");
		}
		
		/* Button to remove all filters */
		jQuery(document).ready(function ($) {
			$("#remove_filters_button").click(function (e) {
				e.preventDefault();
				
				<?php if(!$xPanel->ajaxTable()): ?>
					/* Behaviour for normal table */
					var cleanUrl = '<?php echo e(request()->url()); ?>';
					
					/* Refresh the page to the cleanUrl */
					window.location.href = cleanUrl;
				<?php else: ?>
					/* Behaviour for ajax table */
					var newUrl = '<?php echo e(url($xPanel->route . '/search')); ?>';
					var ajaxTable = $("#crudTable").DataTable();
					
					/* Replace the datatables ajax url with newUrl and reload it */
					ajaxTable.ajax.url(newUrl).load();
					
					/* Clear all filters */
					$(".navbar-filters li[filter-name]").trigger('filter:clear');
				<?php endif; ?>
			});
		});
	</script>
<?php $__env->stopPush(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/inc/filters_navbar.blade.php ENDPATH**/ ?>