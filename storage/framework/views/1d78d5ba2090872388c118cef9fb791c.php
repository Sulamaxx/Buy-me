


<?php
    $displayStatesSearchTip = config('settings.list.display_states_search_tip');
	
?>

<?php $__env->startSection('search'); ?>
    
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
                //  Log::info('sections - '.print_r($sections,true));
            ?>
            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $section ??= [];
                    $sectionView = data_get($section, 'view');
                    $sectionData = (array) data_get($section, 'data');
                ?>
                <?php if(!empty($sectionView) && view()->exists($sectionView)): ?>
                    <?php echo $__env->first(
                        [config('larapen.core.customizedViewPath') . $sectionView, $sectionView],
                        [
                            'sectionData' => $sectionData,
                            'firstSection' => $loop->first,
                            'slider' => isset($slider) ? $slider : [],
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
    <style>
        @media (min-width: 768px) {
            .navbar-desktop {
                justify-content: end;
            }

            .category-options {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
            }

            .category-item {
                margin-right: 0;
            }
        }

        @media (min-width: 1024px) {
            .margin-l-null {
                margin-left: 0% !important;
                padding-left: 0px;
                padding-right: 0px;
            }

            .font-size-d {
                font-size: 13px !important;
            }
        }

        @media (min-width: 1440px) {
            .margin-l-null {
                margin-left: 2.5vw !important;
            }

            .font-size-d {
                font-size: 16px !important;
            }
        }

        
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/home/index.blade.php ENDPATH**/ ?>