<?php
	// Categories' Listings Pages
	$noIndexCategoriesPermalinkPages ??= false;
	$noIndexCategoriesQueryStringPages ??= false;
	
	// Cities' Listings Pages
	$noIndexCitiesPermalinkPages ??= false;
	$noIndexCitiesQueryStringPages ??= false;
	
	// Users' Listings Pages
	$noIndexUsersByIdPages ??= false;
	$noIndexUsersByUsernamePages ??= false;
	
	// Tags' Listings Pages
	$noIndexTagsPages ??= false;
	
	// Filters (and Orders) on Listings Pages (Except Pagination)
	$noIndexFiltersOnEntriesPages ??= false;
	
	// "No result" Pages (Empty Searches Results Pages)
	$noIndexNoResultPages ??= false;
	
	// Listings Report Pages
	$noIndexListingsReportPages ??= false;
	
	// All Website Pages
	$noIndexAllPages = (config('settings.seo.no_index_all'));
?>
<?php if(
		$noIndexAllPages
		|| $noIndexCategoriesPermalinkPages
		|| $noIndexCategoriesQueryStringPages
		|| $noIndexCitiesPermalinkPages
		|| $noIndexCitiesQueryStringPages
		|| $noIndexUsersByIdPages
		|| $noIndexUsersByUsernamePages
		|| $noIndexTagsPages
		|| $noIndexFiltersOnEntriesPages
		|| $noIndexNoResultPages
		|| $noIndexListingsReportPages
	): ?>
	<meta name="robots" content="noindex,nofollow">
	<meta name="googlebot" content="noindex">
<?php endif; ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/common/meta-robots.blade.php ENDPATH**/ ?>