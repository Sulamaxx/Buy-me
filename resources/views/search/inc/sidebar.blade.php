<!-- this (.mobile-filter-sidebar) part will be position fixed in mobile version -->
<div class="col-md-3 page-sidebar mobile-filter-sidebar pb-4">
	<aside>
 	@if (isset($leftAdvertising) && !empty($leftAdvertising))
			@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.left','layouts.inc.advertising.left'], ['paddingTopExists' => true])
			@php
				$paddingTopExists = false;
			@endphp
		@else
			@php
				if (isset($paddingTopExists) && $paddingTopExists) {
					$paddingTopExists = false;
				}
			@endphp
		@endif

		<div class="sidebar-modern-inner enable-long-words">
			
			@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.fields', 'search.inc.sidebar.fields'])
			@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.price', 'search.inc.sidebar.price'])
			@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.categories', 'search.inc.sidebar.categories'])

            @includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.cities', 'search.inc.sidebar.cities'])
			@if (!config('settings.list.hide_date'))
				@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.date', 'search.inc.sidebar.date'])
			@endif
			
			
		</div>
	</aside>
</div>

@section('after_scripts')
    @parent
    <script>
        var baseUrl = '{{ request()->url() }}';
    </script>
@endsection
