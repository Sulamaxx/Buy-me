

<?php
	$bulkActionAllowed = (
		isset($xPanel)
		&& (
			$xPanel->hasButton('bulk_deletion_button')
			|| $xPanel->hasButton('bulk_activation_button')
			|| $xPanel->hasButton('bulk_deactivation_button')
			|| $xPanel->hasButton('bulk_approval_button')
			|| $xPanel->hasButton('bulk_disapproval_button')
		)
	);
?>

<?php $__env->startSection('header'); ?>
	<div class="row page-titles">
		<div class="col-md-6 col-12 align-self-center">
			<h2 class="mb-0">
				<span class="text-capitalize"><?php echo $xPanel->entityNamePlural; ?></span>
				<small id="tableInfo"><?php echo e(trans('admin.all')); ?></small>
			</h2>
		</div>
		<div class="col-md-6 col-12 align-self-center d-none d-md-flex justify-content-end">
			<ol class="breadcrumb mb-0 p-0 bg-transparent">
				<li class="breadcrumb-item"><a href="<?php echo e(admin_url()); ?>"><?php echo e(trans('admin.dashboard')); ?></a></li>
				<li class="breadcrumb-item"><a href="<?php echo e(url($xPanel->route)); ?>" class="text-capitalize"><?php echo $xPanel->entityNamePlural; ?></a></li>
				<li class="breadcrumb-item active d-flex align-items-center"><?php echo e(trans('admin.list')); ?></li>
			</ol>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="row">
		<div class="col-12">
			
			<?php if(isTranslatableModel($xPanel->model)): ?>
			<div class="card mb-0 rounded">
				<div class="card-body">
					<h3 class="card-title"><i class="fa fa-question-circle"></i> <?php echo e(trans('admin.Help')); ?></h3>
					<p class="card-text">
						<?php echo trans('admin.help_translatable_table'); ?>

						<?php if(config('larapen.admin.show_translatable_field_icon')): ?>
							&nbsp;<?php echo trans('admin.help_translatable_column'); ?>

						<?php endif; ?>
					</p>
				</div>
			</div>
			<?php endif; ?>
			
			<div class="card rounded">
				
				<div class="card-header <?php echo e($xPanel->hasAccess('create')?'with-border':''); ?>">
					<?php echo $__env->make('admin.panel.inc.button_stack', ['stack' => 'top'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<div id="datatable_button_stack" class="float-end text-end"></div>
				</div>
				
				
				<?php if($xPanel->filtersEnabled()): ?>
					<div class="card-body">
						<?php echo $__env->make('admin.panel.inc.filters_navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
				<?php endif; ?>
				
				<div class="card-body">
					
					<div id="loadingData"></div>
					
					<form id="bulkActionForm" action="<?php echo e(url($xPanel->getRoute() . '/bulk_actions')); ?>" method="POST">
						<?php echo csrf_field(); ?>

						
						<table id="crudTable" class="dataTable table table-bordered table-striped display dt-responsive nowrap" style="width:100%">
							<thead>
							<tr>
								<?php if($xPanel->details_row): ?>
									<th data-orderable="false"></th> 
								<?php endif; ?>
	
								
								<?php $__currentLoopData = $xPanel->columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($column['type'] == 'checkbox'): ?>
									<th <?php echo e(isset($column['orderable']) ? 'data-orderable=' .var_export($column['orderable'], true) : ''); ?>

										class="dt-checkboxes-cell dt-checkboxes-select-all sorting_disabled"
										tabindex="0"
										aria-controls="massSelectAll"
										rowspan="1"
										colspan="1"
										style="width: 14px; text-align: center; padding-right: 10px;"
										data-col="0"
										aria-label=""
									>
										<input type="checkbox" id="massSelectAll" name="massSelectAll">
									</th>
									<?php else: ?>
									<th <?php echo e(isset($column['orderable']) ? 'data-orderable=' .var_export($column['orderable'], true) : ''); ?>>
										<?php echo $column['label']; ?>

									</th>
									<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	
								<?php if( $xPanel->buttons->where('stack', 'line')->count() ): ?>
									<th data-orderable="false"><?php echo e(trans('admin.actions')); ?></th>
								<?php endif; ?>
							</tr>
							</thead>
	
							<tbody>
							</tbody>
	
							<tfoot>
							<tr>
								<?php if($xPanel->details_row): ?>
									<th></th> 
								<?php endif; ?>
	
								
								<?php $__currentLoopData = $xPanel->columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<th><?php echo e($column['label']); ?></th>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	
								<?php if( $xPanel->buttons->where('stack', 'line')->count() ): ?>
									<th><?php echo e(trans('admin.actions')); ?></th>
								<?php endif; ?>
							</tr>
							</tfoot>
						</table>
						
					</form>

				</div>

				<?php echo $__env->make('admin.panel.inc.button_stack', ['stack' => 'bottom'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				
        	</div>
    	</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
    
	
	<link href="<?php echo e(asset('assets/plugins/datatables/css/dataTables.bootstrap.css')); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo e(asset('assets/plugins/datatables/css/dataTables.bootstrap5.css')); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo e(asset('assets/plugins/datatables/extensions/Responsive-2.2.9/css/responsive.bootstrap5.css')); ?>" rel="stylesheet" type="text/css" />
	
    
    <?php echo $__env->yieldPushContent('crud_list_styles'); ?>
    
    <style>
		<?php if($bulkActionAllowed): ?>
			/* tr > td:first-child, */
			table.dataTable > tbody > tr:not(.no-padding) > td:first-child {
				width: 30px;
				white-space: nowrap;
				text-align: center;
			}
		<?php endif; ?>
		
		/* Fix the 'Actions' column size */
		/* tr > td:last-child, */
		table.dataTable > tbody > tr:not(.no-padding) > td:last-child,
		table:not(.dataTable) > tbody > tr > td:last-child {
			width: 10px;
			white-space: nowrap;
		}
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    
	<script src="<?php echo e(asset('assets/plugins/datatables/js/jquery.dataTables.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/plugins/datatables/js/dataTables.bootstrap5.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('assets/plugins/datatables/extensions/Responsive-2.2.9/js/dataTables.responsive.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('assets/plugins/datatables/extensions/Responsive-2.2.9/js/responsive.bootstrap5.js')); ?>" type="text/javascript"></script>
	
	

    <?php if(isset($xPanel->exportButtons) and $xPanel->exportButtons): ?>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap.min.js" type="text/javascript"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" type="text/javascript"></script>
        <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js" type="text/javascript"></script>
        <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js" type="text/javascript"></script>
    <?php endif; ?>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
	
			/* DEBUG */
			/* If don't want your end users to see the alert() message during error. */
			/* $.fn.dataTable.ext.errMode = 'throw'; */

            <?php if($xPanel->exportButtons): ?>
            	var dtButtons = function(buttons){
                    var extended = [];
                    for(var i = 0; i < buttons.length; i++){
                        var item = {
                            extend: buttons[i],
                            exportOptions: {
                                columns: [':visible']
                            }
                        };
                        switch(buttons[i]){
                            case 'pdfHtml5':
                                item.orientation = 'landscape';
                                break;
                        }
                        extended.push(item);
                    }
                    return extended;
                }
            <?php endif; ?>
			
            var table = $("#crudTable").DataTable({
				"pageLength": <?php echo e($xPanel->getDefaultPageLength()); ?>,
				"lengthMenu": [[10, 25, 50, 100, 250, 500], [10, 25, 50, 100, 250, 500]],
				/* Disable initial sort */
				"aaSorting": [],
				"language": {
					"emptyTable":     "<?php echo e(trans('admin.emptyTable')); ?>",
					"info":           "<?php echo e(trans('admin.info')); ?>",
					"infoEmpty":      "<?php echo e(trans('admin.infoEmpty')); ?>",
					"infoFiltered":   "<?php echo e(trans('admin.infoFiltered')); ?>",
					"infoPostFix":    "<?php echo e(trans('admin.infoPostFix')); ?>",
					"thousands":      "<?php echo e(trans('admin.thousands')); ?>",
					"lengthMenu":     "<?php echo e(trans('admin.lengthMenu')); ?>",
					"loadingRecords": "<?php echo e(trans('admin.loadingRecords')); ?>",
					"processing":     "<?php echo e(trans('admin.processing')); ?>",
					"search":         "<?php echo e(trans('admin.search')); ?>",
					"zeroRecords":    "<?php echo e(trans('admin.zeroRecords')); ?>",
					"paginate": {
						"first":      "<?php echo e(trans('admin.paginate.first')); ?>",
						"last":       "<?php echo e(trans('admin.paginate.last')); ?>",
						"next":       "<?php echo e(trans('admin.paginate.next')); ?>",
						"previous":   "<?php echo e(trans('admin.paginate.previous')); ?>"
					},
					"aria": {
						"sortAscending":  "<?php echo e(trans('admin.aria.sortAscending')); ?>",
						"sortDescending": "<?php echo e(trans('admin.aria.sortDescending')); ?>"
					}
				},
				responsive: true,

				<?php if($xPanel->ajaxTable): ?>
					"ajax": {
						"url": "<?php echo e(url($xPanel->route . '/search') . '?' . request()->getQueryString()); ?>",
						"type": "POST",
						beforeSend: function () {
							/* Loading (Show) */
							let loadingDataEl = $('#loadingData');
							loadingDataEl.busyLoad('hide');
							loadingDataEl.busyLoad('show', {
								text: "<?php echo e(t('loading_wd')); ?>",
								custom: createCustomSpinnerEl()
							});
						}
					},
	                /* "processing": true, */
	                "serverSide": true,
				<?php endif; ?>
			
				<?php if($bulkActionAllowed): ?>
					/* Mass Select All */
					'columnDefs': [{
						'targets': [0],
						'orderable': false
					}],
				<?php endif; ?>

				<?php if($xPanel->exportButtons): ?>
					/* Show the export datatable buttons */
					dom: '<"p-l-0 col-md-6"l>B<"p-r-0 col-md-6"f>rt<"col-md-6 p-l-0"i><"col-md-6 p-r-0"p>',
					buttons: dtButtons([
						'copyHtml5',
						'excelHtml5',
						'csvHtml5',
						'pdfHtml5',
						'print',
						'colvis'
					]),
				<?php endif; ?>
	
				<?php if($xPanel->hideSearchBar): ?>
					searching: false,
				<?php endif; ?>
				
				/* Fire some actions after the data has been retrieved and renders the table */
				/* NOTE: This only fires once though. */
				'initComplete': function(settings, json) {
					/* $('[data-bs-toggle="tooltip"]').tooltip(); */
					/* $('[data-bs-toggle="tooltipHover"]').tooltip(); */
					
					/* Enable the tooltip */
					/* To prevent the tooltip in bootstrap doesn't work after ajax, use selector on exist element like body */
					let bodyEl = $('body');
					bodyEl.tooltip({selector: '[data-bs-toggle="tooltip"]'});
					bodyEl.tooltip({selector: '[data-bs-toggle="tooltipHover"]'});
				},
				
				/* Called before the DataTable redraw the table */
				preDrawCallback : function (settings) {},
				
				/* Called after the DataTable redraw the table */
				drawCallback : function() {
					/* Loading (Hide) */
					let loadingDataEl = $('#loadingData');
					loadingDataEl.busyLoad('hide');
					
					/* Page Info */
					let info = this.api().page.info();
					let textInfo = "<?php echo e(trans('admin.info')); ?>";
					textInfo = textInfo.replace('_START_', (info.recordsTotal > 0) ? (info.start + 1) : 0);
					textInfo = textInfo.replace('_END_', info.end);
					textInfo = textInfo.replace('_TOTAL_', addThousandsSeparator(info.recordsTotal, '<?php echo e(trans('admin.thousands')); ?>'));
					if (info.recordsTotal <= 0) {
						textInfo = '<?php echo e(trans('admin.infoEmpty')); ?>';
					}
					$('#tableInfo').html(textInfo);
				}
			});
			
			/* Set how DataTables will report detected errors */
			$.fn.dataTable.ext.errMode = function (settings, techNote, message) {
				if (
					typeof settings.jqXHR !== 'undefined'
					&& typeof settings.jqXHR.responseJSON !== 'undefined'
					&& typeof settings.jqXHR.responseJSON.message !== 'undefined'
				) {
					message = settings.jqXHR.responseJSON.message;
				}
				
				jsAlert(message, 'error', false);
			};
			
            <?php if($xPanel->exportButtons): ?>
				/* Move the datatable buttons in the top-right corner and make them smaller */
				table.buttons().each(function(button) {
					if (button.node.className.indexOf('buttons-columnVisibility') === -1) {
						button.node.className = button.node.className + " btn-sm";
					}
				});
				$(".dt-buttons").appendTo($('#datatable_button_stack'));
            <?php endif; ?>
			
            $.ajaxPrefilter(function(options, originalOptions, xhr) {
	            let token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                }
            });
			
            /* Make the delete button work in the first result page */
            registerDeleteButtonAction();
			
            /* Make the delete button work on subsequent result pages */
            $('#crudTable').on('draw.dt', function () {
                registerDeleteButtonAction();

                <?php if($xPanel->details_row): ?>
					registerDetailsRowButtonAction();
                <?php endif; ?>
            }).dataTable();
			
            function registerDeleteButtonAction() {
				let deleteBtnEl = $('[data-button-type=delete]');
				
				deleteBtnEl.unbind('click');
                /* CRUD Delete */
                /* Ask for confirmation before deleting an item */
				deleteBtnEl.click(function(e) {
                    e.preventDefault();
					
					let jsThis = this;
					
					Swal.fire({
						position: 'top',
						text: langLayout.confirm.message.question,
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: langLayout.confirm.button.yes,
						cancelButtonText: langLayout.confirm.button.no
					}).then((result) => {
						if (result.isConfirmed) {
							
							if (isDemoDomain()) {
								/* Delete the row from the table */
								$(jsThis).closest('tr').remove();
								
								return false;
							}
							
							deleteEntry(jsThis);
							
						} else if (result.dismiss === Swal.DismissReason.cancel) {
							pnAlert(langLayout.confirm.message.cancel, 'info');
						}
					});
                });
            }
            
            function deleteEntry(jsThis) {
				let deleteButtonEl = $(jsThis);
				let deleteButtonUrl = deleteButtonEl.attr('href');
				let deleteButtonTr = deleteButtonEl.closest('tr');
				
				
				/* Make the AJAX request */
				let ajax = $.ajax({
					url: deleteButtonUrl,
					type: 'DELETE',
					beforeSend: function () {
						/* Hide & disable the element's line's Tooltip(s) */
						let tooltipEl = deleteButtonTr.find('[data-bs-toggle="tooltip"]');
						tooltipEl.tooltip('hide');
						tooltipEl.tooltip('disable');
					}
				});
				ajax.done(function(xhr) {
					/* Show an alert with the result */
					pnAlert(langLayout.confirm.message.success, 'success');
					
					/* Delete the row from the table */
					deleteButtonTr.remove();
					
					/* Reload data after row deletion */
					table.ajax.reload(null, false);
				});
				ajax.fail(function(xhr) {
					let message = getJqueryAjaxError(xhr);
					if (message !== null) {
						pnAlert(message, 'error');
					}
				});
			}
			
			/* Mass Select All */
			$('body').on('change', '#massSelectAll', function() {
				let rows, checked, colIndex;
				rows = $('#crudTable').find('tbody tr');
				checked = $(this).prop('checked');
				colIndex = <?php echo e((isset($xPanel->details_row) && $xPanel->details_row) ? 1 : 0); ?>;
				$.each(rows, function() {
					$($(this).find('td').eq(colIndex)).find('input').prop('checked', checked);
				});
			});
			
			/* Bulk Items Deletion */
			$('.bulk-action').click(function(e) {
				e.preventDefault();
				
				let clickedEl = $(this);
				let selectedItems = $('input[name="entryId[]"]:checked');
				
				if (selectedItems.length > 0) {
					Swal.fire({
						position: 'top',
						text: langLayout.confirm.message.question,
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: langLayout.confirm.button.yes,
						cancelButtonText: langLayout.confirm.button.no
					}).then((result) => {
						if (result.isConfirmed) {
							
							if (isDemoDomain()) {
								/* Delete the row from the table */
								$.each(selectedItems, function() {
									if (clickedEl.attr('name') === 'deletion') {
										$(this).closest('tr').remove();
									}
								});
								
								return false;
							}
							
							let formEl = $('#bulkActionForm');
							bulkActions(formEl, clickedEl);
							
						} else if (result.dismiss === Swal.DismissReason.cancel) {
							pnAlert(langLayout.confirm.message.cancel, 'info');
						}
					});
				} else {
					let message = "<?php echo e(trans('admin.Please select at least one item below')); ?>";
					jsAlert(message, 'warning');
				}
				
				return false;
			});
			
			function bulkActions(formEl, clickedEl)
			{
				let submitUrl = $(formEl).attr('action');
				
				/* Get all checked checkboxes */
				let selectedItems = $('input[name="entryId[]"]:checked');
				
				/* Form POST data init. */
				let requestInputs = {
					'action': clickedEl.attr('name'), /* Add the clicked button */
					'entryId[]': []
				};
				
				/* Get all checked checkboxes to pass to the jQuery AJAX request */
				selectedItems.each(function() {
					requestInputs['entryId[]'].push($(this).val());
				});
				
				/* Make the AJAX request */
				let ajax = $.ajax({
					url: submitUrl,
					type: 'POST',
					data: requestInputs,
					beforeSend: function () {
						selectedItems.each(function() {
							let thisEl = $(this);
							let thisElTr = thisEl.closest('tr');
							
							/* Hide & disable the element's line's Tooltip(s) */
							let tooltipEl = thisElTr.find('[data-bs-toggle="tooltip"]');
							tooltipEl.tooltip('hide');
							tooltipEl.tooltip('disable');
						});
					}
				});
				ajax.done(function(xhr) {
					if (typeof xhr.success === 'undefined' || typeof xhr.message === 'undefined') {
						return false;
					}
					
					/* Show an alert with the result */
					let messageType = xhr.success ? 'success' : 'error';
					pnAlert(xhr.message, messageType);
					
					/* Delete the row from the table */
					$.each(selectedItems, function() {
						if (clickedEl.attr('name') === 'deletion') {
							$(this).parentsUntil('tr').parent().remove();
						}
					});
					
					/* Reload data after row deletion */
					table.ajax.reload(null, false);
					
					return false;
				});
				ajax.fail(function(xhr) {
					let message = getJqueryAjaxError(xhr);
					if (message !== null) {
						pnAlert(message, 'error');
					}
					
					return false;
				});
			}

            <?php if($xPanel->details_row): ?>
				function registerDetailsRowButtonAction() {
					/* Add event listener for opening and closing details */
					$('#crudTable tbody').on('click', 'td .details-row-button', function() {
						let tr = $(this).closest('tr');
						let btn = $(this);
						let row = table.row( tr );
	
						if (row.child.isShown()) {
							
							/* This row is already open - close it */
							$(this).removeClass('fa-minus-square').addClass('fa-plus-square');
							$('div.table_row_slider', row.child()).slideUp(function() {
								row.child.hide();
								tr.removeClass('shown');
							});
							
						} else {
							
							/* Open this row */
							$(this).removeClass('fa-plus-square').addClass('fa-minus-square');
							
							/* Get the details with ajax */
							let ajax = $.ajax({
								url: '<?php echo e(request()->url()); ?>/'+btn.data('entry-id')+'/details',
								type: 'GET',
							});
							ajax.done(function(xhr) {
								row.child("<div class='table_row_slider'>" + xhr + "</div>", 'no-padding').show();
								tr.addClass('shown');
								$('div.table_row_slider', row.child()).slideDown();
								registerDeleteButtonAction();
							});
							ajax.fail(function(xhr) {
								row.child("<div class='table_row_slider'><?php echo e(trans('admin.details_row_loading_error')); ?></div>").show();
								tr.addClass('shown');
								$('div.table_row_slider', row.child()).slideDown();
							});
							
						}
					});
				}
	
				registerDetailsRowButtonAction();
            <?php endif; ?>

        });

		/**
		 * Add Thousands Separator (for DataTable Info)
		 * @param nStr
		 * @param separator
		 * @returns {*}
		 */
		function addThousandsSeparator(nStr, separator = ',') {
			nStr += '';
			nStr = nStr.replace(separator, '');
			let x = nStr.split('.');
			let x1 = x[0];
			let x2 = x.length > 1 ? '.' + x[1] : '';
			let rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + separator + '$2');
			}
			return x1 + x2;
		}
    </script>

    
    <?php echo $__env->yieldPushContent('crud_list_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/list.blade.php ENDPATH**/ ?>