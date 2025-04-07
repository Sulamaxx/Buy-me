


<?php
    $displayStatesSearchTip = config('settings.list.display_states_search_tip'); 
?>

<?php $__env->startSection('search'); ?>
<div class="container search-container d-md-none" style="width: 100vw;padding:0%;margin:0%">
	<form id="search" name="search" action="<?php echo e(\App\Helpers\UrlGen::searchWithoutQuery()); ?>" method="GET">
		<div class="row search-row animated fadeInUp border-null" >

			<div class="col-6 col-lg-6 col-md-5 col-sm-12 search-col relative mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
				<div class="search-col-inner">
					<div class="search-col-input" style="margin-left: 0px;width: 100%;">
						<input class="form-control" name="q" placeholder="<?php echo e(t('what')); ?>" type="text" value="" style="border-radius:0% !important;">
					</div>
				</div>
			</div>

			<input type="hidden" id="lSearch" name="l" value="">

			<div class="col-4 col-lg-4 col-md-5 col-sm-12 search-col relative locationicon mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
				<div class="search-col-inner">
					<div class="search-col-input" style="margin-left: 0px; width: 100%;">
						<?php if($displayStatesSearchTip): ?>
							<input class="form-control locinput input-rel searchtag-input"
							style="border-radius:0% !important;"
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
							<input class="form-control locinput input-rel searchtag-input"
							style="border-radius:0% !important;"
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

			<div class="col-2 col-lg-2 col-md-2 col-sm-12 search-col" style="border-left: 1px solid black;">
				<div class="search-btn-border bg-primary">
					<button class="btn btn-primary btn-search btn-block" style="width: 100%;border-radius: 0px !important;background-color: #e5e5e5 !important;padding:0px">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" style="width: 1.5em; height: 1.5em;">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
						</svg>
					</button>
				</div>
			</div>

		</div>
	</form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="main-container main-container-mobile" id="homepage">
		
		<?php if(session()->has('flash_notification')): ?>
			<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php
				$paddingTopExists = true;
			?>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
		<?php if(!empty($sections)): ?>

		    <?php
             Log::info('sections - '.print_r($sections,true));
            ?>
			<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			    
				<?php
					$section ??= [];
					$sectionView = data_get($section, 'view');
					$sectionData = (array)data_get($section, 'data');
				?>
				<?php if(!empty($sectionView) && view()->exists($sectionView)): ?>
					<?php echo $__env->first(
						[
							config('larapen.core.customizedViewPath') . $sectionView,
							$sectionView
						],
						[
							'sectionData' => $sectionData,
							'firstSection' => $loop->first,
							'slider' => isset($slider) ? $slider : []
						]
					, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
		
	</div>
	<style>
        @media (max-width: 767px) {
            .main-container-mobile {
                margin-top: 40px;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/home/index.blade.php ENDPATH**/ ?>