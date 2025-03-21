
<?php $filterSlug = str($filter->name)->slug(); ?>
<li filter-name="<?php echo e($filter->name); ?>"
	filter-type="<?php echo e($filter->type); ?>"
	class="nav-item dropdown <?php echo e(request()->query($filter->name)?'active':''); ?>">
	<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		<?php echo e($filter->label); ?> <span class="caret"></span>
	</a>
	<div class="dropdown-menu p-0">
		<div class="backpack-filter mb-0">
			<div class="input-group date">
				<span class="input-group-text"><i class="fa fa-calendar"></i></span>
				<input class="form-control float-end"
					   id="daterangepicker-<?php echo e($filterSlug); ?>"
					   type="text"
					   <?php if($filter->currentValue): ?>
					   <?php
						   $dates = (array)json_decode($filter->currentValue);
						   $start_date = $dates['from'];
						   $end_date = $dates['to'];
						   $date_range = implode(' ~ ', $dates);
						   $date_range = str_replace('-', '/', $date_range);
						   $date_range = str_replace('~', '-', $date_range);
				
					   ?>
					   placeholder="<?php echo e($date_range); ?>"
						<?php endif; ?>
				>
				<span class="input-group-text daterangepicker-<?php echo e($filterSlug); ?>-clear-button">
					<a href=""><i class="fa fa-times"></i></a>
				</span>
			</div>
		</div>
	</div>
</li>







<?php $__env->startPush('crud_list_styles'); ?>
	
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
	<style>
		.input-group.date {
			width: 320px;
			max-width: 100%;
		}
		
		.daterangepicker.dropdown-menu {
			z-index: 3001 !important;
		}
		.daterangepicker {
			padding: 0;
		}
	</style>
<?php $__env->stopPush(); ?>





<?php $__env->startPush('crud_list_scripts'); ?>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<script>
		
		function applyDateRangeFilter(start, end) {
			if (start && end) {
				var dates = {
					'from': start.format('YYYY-MM-DD'),
					'to': end.format('YYYY-MM-DD')
				};
				var value = JSON.stringify(dates);
			} else {
				//this change to empty string,because addOrUpdateUriParameter method just judgment string
				var value = '';
			}
			var parameter = '<?php echo e($filter->name); ?>';
			
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
		}
		
		jQuery(document).ready(function ($) {
			var dateRangeInput = $('#daterangepicker-<?php echo e($filterSlug); ?>').daterangepicker({
					timePicker: false,
					ranges: {
						'Today': [moment().startOf('day'), moment().endOf('day')],
						'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
						'Last 7 Days': [moment().subtract(6, 'days'), moment()],
						'Last 30 Days': [moment().subtract(29, 'days'), moment()],
						'This Month': [moment().startOf('month'), moment().endOf('month')],
						'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
					},
						<?php if($filter->currentValue): ?>
							startDate: moment("<?php echo e($start_date); ?>"),
							endDate: moment("<?php echo e($end_date); ?>"),
						<?php endif; ?>
						alwaysShowCalendars: true,
					autoUpdateInput: true
				},
				function (start, end) {
					applyDateRangeFilter(start, end);
				});
			
			$('li[filter-name=<?php echo e($filter->name); ?>]').on('hide.bs.dropdown', function () {
				if ($('.daterangepicker').is(':visible'))
					return false;
			});
			
			$('li[filter-name=<?php echo e($filter->name); ?>]').on('filter:clear', function (e) {
				// console.log('daterangepicker filter cleared');
				//if triggered by remove filters click just remove active class,no need to send ajax
				$('li[filter-name=<?php echo e($filter->name); ?>]').removeClass('active');
			});
			
			// datepicker clear button
			$(".daterangepicker-<?php echo e($filterSlug); ?>-clear-button").click(function (e) {
				e.preventDefault();
				applyDateRangeFilter(null, null);
			})
		});
	</script>
<?php $__env->stopPush(); ?>


<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/filters/date_range.blade.php ENDPATH**/ ?>