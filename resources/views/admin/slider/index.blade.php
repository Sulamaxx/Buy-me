@extends('admin.layouts.master')

@section('header')
	<div class="row page-titles">
		<div class="col-md-6 col-12 align-self-center">
			<h2 class="mb-0">
				
				<small id="tableInfo">Slider Update</small>
			</h2>
		</div>
		<div class="col-md-6 col-12 align-self-center d-none d-md-flex justify-content-end">
			<ol class="breadcrumb mb-0 p-0 bg-transparent">
				<li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
				<li class="breadcrumb-item active d-flex align-items-center">{{ trans('admin.list') }}</li>
			</ol>
		</div>
	</div>
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			
			<div class="card mb-0 rounded">
				<div class="card-body">
					<h3 class="card-title"><i class="fa fa-question-circle"></i> {{ trans('admin.Help') }}</h3>
					<p class="card-text">
						{!! trans('admin.help_translatable_table') !!}
						@if (config('larapen.admin.show_translatable_field_icon'))
							&nbsp;{!! trans('admin.help_translatable_column') !!}
						@endif
					</p>
				</div>
			</div>
			
			<div class="card rounded">
				
				<div class="card-header">
					<a href="{{ url('admin/sliders/create') }}" class="btn btn-primary shadow ladda-button" data-style="zoom-in">
						<span class="ladda-label">
							<i class="fas fa-plus"></i> {{ trans('admin.add') }} Slider
						</span>
					</a>
					<div id="datatable_button_stack" class="float-end text-end"></div>
				</div>
				
				
				
				<div class="card-body">
					
					<div id="loadingData"></div>
					
					<table id="example" class="display" style="width:100%">
						<thead>
							<tr>
								<th>Id</th>
								<th>Image</th>
								<th>Name</th>
								<th>Expired Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($users))
							  @foreach($users as $user)
							    <tr>
									<td>{{$user->id}}</td>
									<td>
										<img src="{!! url('/uploads/').'/'.$user->image_name !!}" alt="" style="width: 100px;">
									</td>
									<td>{{$user->image_name}}</td>
									<td>{{$user->exf_time}}</td>
									<td>
									<a href="{{ url('admin/sliders/edit', [$user->id]) }}" class="btn btn-xs btn-primary" data-style="zoom-in">
										<span class="ladda-label">
											Edit
										</span>
									</a>
									<!-- <button class="btn btn-danger shadow ladda-button" data-style="zoom-in">
										<span class="ladda-label">
											Delete
										</span>
									</button> -->
									<a href="{{ url('admin/sliders/delete') }}" class="btn btn-xs btn-danger teste" data-id="{{$user->id}}" data-button-type="delete">
										<i class="far fa-trash-alt"></i> {{ trans('admin.delete') }}</a>
									@if($user->isactive === 1)
										<a href="{{ url('admin/sliders/active') }}" class="btn btn-xs btn-secondary testeNew" data-id="{{$user->id}}" data-button-type="0">
											Inactive</a>
									@else
									    <a href="{{ url('admin/sliders/active') }}" class="btn btn-xs btn-warning testeNew" data-id="{{$user->id}}" data-button-type="1">
										   Active</a>
									@endif
									
								</tr>
							  @endforeach
							@endif
							
						</tbody>
					</table>
				</div>

				
				
        	</div>
    	</div>
	</div>
@endsection

@section('after_styles')
    {{-- DATA TABLES --}}
	{{--<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />--}}
	<link href="{{ asset('assets/plugins/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/datatables/css/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/datatables/extensions/Responsive-2.2.9/css/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
	
    {{-- CRUD LIST CONTENT - crud_list_styles stack --}}
    @stack('crud_list_styles')
    
    <style>
		
			/* tr > td:first-child, */
			table.dataTable > tbody > tr:not(.no-padding) > td:first-child {
				width: 30px;
				white-space: nowrap;
				text-align: center;
			}
		
		
		/* Fix the 'Actions' column size */
		/* tr > td:last-child, */
		table.dataTable > tbody > tr:not(.no-padding) > td:last-child,
		table:not(.dataTable) > tbody > tr > td:last-child {
			width: 10px;
			white-space: nowrap;
		}
    </style>
@endsection

@section('after_scripts')
    {{-- DATA TABLES SCRIPT --}}
	<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/datatables/js/dataTables.bootstrap5.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/datatables/extensions/Responsive-2.2.9/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/datatables/extensions/Responsive-2.2.9/js/responsive.bootstrap5.js') }}" type="text/javascript"></script>
	
	<script type="text/javascript">

	$(function () {
		
		var table = $('#example').DataTable({
			order: [[2, 'asc']],
				rowGroup: {
					dataSrc: 2
				}
			});
		
	});


	jQuery(document).ready(function($) {
		$('.teste').on('click', function(e) {
			console.log('testetestetesteteste');
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
						let id = $(this).data("id") ;
						let deleteButtonUrl = $('.teste').attr('href');
                        console.log('deleteButtonUrl', deleteButtonUrl);
						$.ajax({
						url: deleteButtonUrl + '/' + id,
						type: "get",
						dataType: 'json',
						success: function (response) {
							console.log(response, 'response');
							if(response.error === false){
								pnAlert(response.message, 'success');
							
								window.location.reload();
							}else{
								pnAlert(response.message, 'error');
			
								window.location.reload();
							}
						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log(textStatus, errorThrown);
						}
						});
					} else if (result.dismiss === Swal.DismissReason.cancel) {
						pnAlert(langLayout.confirm.message.cancel, 'info');
					}
				});
			});

			$('.testeNew').on('click', function(e) {
			console.log('testeNewtesteNew');
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
						let id = $(this).data("id") ;
						let val = $(this).data("button-type") ;
						let deleteButtonUrl = $('.testeNew').attr('href');
                        console.log('testeNew', deleteButtonUrl);
						$.ajax({
						url: deleteButtonUrl + '/' + id + '/' + val,
						type: "get",
						dataType: 'json',
						success: function (response) {
							console.log(response, 'response');
							if(response.error === false){
								pnAlert(response.message, 'success');
							
								window.location.reload();
							}else{
								pnAlert(response.message, 'error');
			
								window.location.reload();
							}
						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log(textStatus, errorThrown);
						}
						});
					} else if (result.dismiss === Swal.DismissReason.cancel) {
						pnAlert(langLayout.confirm.message.cancel, 'info');
					}
				});
			});
	});
</script>
@endsection
