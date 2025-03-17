<?php
	$sectionOptions = $getSearchFormOp ?? [];
	$sectionData ??= [];
	
	// Get Search Form Options
	$enableFormAreaCustomization = data_get($sectionOptions, 'enable_extended_form_area') ?? '0';
	$hideTitles = data_get($sectionOptions, 'hide_titles') ?? '0';
	
	$headerTitle = data_get($sectionOptions, 'title_' . config('app.locale'));
	$headerTitle = (!empty($headerTitle)) ? replaceGlobalPatterns($headerTitle) : null;
	
	$headerSubTitle = data_get($sectionOptions, 'sub_title_' . config('app.locale'));
	$headerSubTitle = (!empty($headerSubTitle)) ? replaceGlobalPatterns($headerSubTitle) : null;
	
	$parallax = data_get($sectionOptions, 'parallax') ?? '0';
	$hideForm = data_get($sectionOptions, 'hide_form') ?? '0';
	$displayStatesSearchTip = config('settings.list.display_states_search_tip');
	
	$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' hidden-sm' : '';
?>
<?php if(isset($enableFormAreaCustomization) && $enableFormAreaCustomization == '1'): ?>
	
	<?php if(isset($firstSection) && !$firstSection): ?>
		<div class="p-0 mt-lg-4 mt-md-3 mt-3"></div>
	<?php endif; ?>
	
	<?php
		$parallax = ($parallax == '1') ? ' parallax' : '';
	?>

	<?php $__env->startSection('before_styles'); ?>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

   <?php $__env->stopSection(); ?>

	<div class="container">
	<div id="carouselHome" class="carousel slide slider" data-ride="carousel" data-interval="2000" data-pause="false">
	<div class="carousel-indicators">
	    <?php if(isset($slider)): ?>
		   <?php $__currentLoopData = $slider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		     <?php if($key === 0): ?>
			   <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="<?php echo e($key); ?>" class="active" aria-current="true" aria-label="Slide <?php echo e($key); ?>"></button>
			 <?php else: ?>
			   <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="<?php echo e($key); ?>" aria-label="Slide <?php echo e($key); ?>"></button>
			 <?php endif; ?>
		   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</div>
	<div class="carousel-inner">
	   <?php if(isset($slider)): ?>
		   <?php $__currentLoopData = $slider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		     <?php if($key === 0): ?>
			   <div class="carousel-item active">
			      <img src="<?php echo url('/uploads/').'/'.$node->image_name; ?>" class="d-block w-100 bannar-image" alt="banner">
			   </div>
			 <?php else: ?>
			   <div class="carousel-item">
			      <img src="<?php echo url('/uploads/').'/'.$node->image_name; ?>" class="d-block w-100 bannar-image" alt="banner">
			   </div>
			 <?php endif; ?>
		   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</div>
	<button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Previous</span>
	</button>
	<button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Next</span>
	</button>
	</div>
	</div>
	

    <!-- <div class="d-none"> -->
	<!-- <div class="d-none d-md-block d-lg-block d-xl-block"> -->
		<!-- <div class="top-post my-4 d-flex">
			<div class="col-6 d-none d-md-block d-lg-block d-xl-block"> 
				<h1 style="font-weight: bold;">SellSmart, BuyBetter Your Ultimate Marketplace</h1>
				<h5>Buyme.lk: Simplifying Buying and Selling. Your go-to platform for seamless transactions and smart commerce.</h5>  
			</div>
			<div class="col-6">
			    <img alt="homepage" class="d-none d-md-block d-lg-block d-xl-block" src="<?php echo e(asset('images/homepage-image1.png')); ?>" >
			</div>
		</div>
	</div> -->
	
<?php else: ?>
	
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="intro only-search-bar<?php echo e($hideOnMobile); ?>">
		<div class="container text-center">
			
			<?php if($hideForm != '1'): ?>
				<form id="search" name="search" action="<?php echo e(\App\Helpers\UrlGen::searchWithoutQuery()); ?>" method="GET">
					<div class="row search-row animated fadeInUp">
						
						<div class="col-md-5 col-sm-12 search-col relative mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
							<div class="search-col-inner">
								<i class="fas <?php echo e((config('lang.direction')=='rtl') ? 'fa-angle-double-left' : 'fa-angle-double-right'); ?> icon-append"></i>
								<div class="search-col-input">
									<input class="form-control has-icon" name="q" placeholder="<?php echo e(t('what')); ?>" type="text" value="">
								</div>
							</div>
						</div>
						
						<input type="hidden" id="lSearch" name="l" value="">
						
						<div class="col-md-5 col-sm-12 search-col relative locationicon mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
							<div class="search-col-inner">
								<i class="fas fa-map-marker-alt icon-append"></i>
								<div class="search-col-input">
									<?php if($displayStatesSearchTip): ?>
										<input class="form-control locinput input-rel searchtag-input has-icon"
											   id="locSearch"
											   name="location"
											   placeholder="<?php echo e(t('where')); ?>"
											   type="text"
											   value=""
											   data-bs-placement="top"
											   data-bs-toggle="tooltipHover"
											   title="<?php echo e(t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name')); ?>"
										>
									<?php else: ?>
										<input class="form-control locinput input-rel searchtag-input has-icon"
											   id="locSearch"
											   name="location"
											   placeholder="<?php echo e(t('where')); ?>"
											   type="text"
											   value=""
										>
									<?php endif; ?>
								</div>
							</div>
						</div>
						
						<div class="col-md-2 col-sm-12 search-col">
							<div class="search-btn-border bg-primary">
								<button class="btn btn-primary btn-search btn-block btn-gradient" >
									<i class="fas fa-search"></i> <strong><?php echo e(t('find')); ?></strong>
								</button>
							</div>
						</div>
					
					</div>
				</form>
			<?php endif; ?>
		
		</div>
	</div>
	
<?php endif; ?>


<?php $__env->startSection('after_scripts'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		document.getElementById('carouselHome').focus();
	
			
// Function to click the button
function clickButton() {
    // Select the button using a query selector
    const button = document.querySelector('.carousel-control-next');
    if (button) {
        button.click();
    } else {
        console.error('Button not found!');
    }
}

// Call clickButton every 10 seconds (5000 milliseconds)
setInterval(clickButton, 10000);

 
 
 
    
    });	
</script>

<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/home/inc/search.blade.php ENDPATH**/ ?>