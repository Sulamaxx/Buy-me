@php
	$packages ??= [];
	$message ??= '';
	$createAccountUrl ??= '';
@endphp
<div id="subsPackages">
	
	<p class="text-center">
		{{ t('subs_packages_hint') }}
	</p>
    <!-- subscription Packages start -->
    <select class="form-control selecter select2-hidden-accessible" onChange="filtersubs()" name="combid" id="combid" >
    
    <?php
    foreach($sccombinations as $combiddata)
    {
        if($opensubs==$combiddata->id)
        {
            $seltxt=" selected ";
        }
        else
        {
            $seltxt=" ";
        }
        ?>
    <option value="{{$combiddata->id}}" {{$seltxt}} >{{$combiddata->description}}</option>
    <?php
     } 
        ?>
	</select>
    <!-- subscription Packages end -->
	<div class="row mt-5 mb-md-5 justify-content-center">
		@if (is_array($packages) && count($packages) > 0)
			@foreach($packages as $package)
				@php
					$boxClass = (data_get($package, 'recommended') == 1) ? ' border-color-primary' : '';
					$boxHeaderClass = (data_get($package, 'recommended') == 1) ? ' bg-primary border-color-primary text-white' : '';
					$boxBtnClass = (data_get($package, 'recommended') == 1) ? ' btn-primary' : ' btn-outline-primary';
				@endphp
				<div class="col-md-3">
					<div class="card mb-4 box-shadow{{ $boxClass }}">
						<div class="card-header text-center{{ $boxHeaderClass }}">
							<h4 class="my-0 fw-normal pb-0 h4">{{ data_get($package, 'short_name') }}</h4>
						</div>
						<div class="card-body">
							<h1 class="text-center">
								<span class="fw-bold">
									{{ data_get($package, 'price_formatted') }}
								</span>
								<small class="text-muted">/ {{ data_get($package, 'interval', '--') }}</small>
							</h1>
							<ul class="list list-border text-center mt-3 mb-4">
								@if (is_array(data_get($package, 'description_array')) && count(data_get($package, 'description_array')) > 0)
									@foreach(data_get($package, 'description_array') as $option)
										<li>{!! $option !!}</li>
									@endforeach
								@else
									<li> *** </li>
								@endif
							</ul>
							@php
								$pricingUrl = url('account/subscription');
								$pricingUrl = $pricingUrl . '?package=' . data_get($package, 'id');
							@endphp
							<a href="{{ $pricingUrl }}" class="btn btn-lg btn-block{{ $boxBtnClass }}">
								{{ t('get_started') }}
							</a>
						</div>
					</div>
				</div>
			@endforeach
		@else
			<div class="col-md-6 col-sm-12 text-center">
				<div class="card bg-light">
					<div class="card-body">
						{{ $message ?? null }}
					</div>
				</div>
			</div>
		@endif
	</div>

</div>
<!-- subscription Packages start -->
<script>
    function filtersubs()
    {
        var elemntval = document.getElementById("combid").value;
        var url = '<?php echo(url('pricing')); ?>' +"/"+ elemntval;
        $(location).attr('href', url);
        
    }
</script>
<!-- subscription Packages end -->
