


<?php
    $displayStatesSearchTip = config('settings.list.display_states_search_tip');
	$cats = App\Models\Category::where('parent_id', null)->get();
?>

<?php $__env->startSection('search'); ?>
    <div class="container search-container d-md-none" style="width: 100vw;padding:0%;margin:0%">
        <form id="search" name="search" action="<?php echo e(\App\Helpers\UrlGen::searchWithoutQuery()); ?>" method="GET">
            <div class="row search-row animated fadeInUp border-null">
                <div class="col-8 col-xl-8 col-lg-8 col-md-8 col-sm-8 search-col relative mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
                    <div class="search-col-inner">
                        <div class="search-col-input" style="margin-left: 0px; width: 100%;">
                            <input class="form-control font-size-d" name="q" placeholder="<?php echo e(t('what')); ?>"
                                type="text" value="" style="border-radius:0% !important;">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="lSearch" name="l" value="">
                <div class="col-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 search-col" style="border-left: 1px solid black;">
                    <div class="search-btn-border">

                        <button class="btn btn-primary btn-search"
                            style="width: 100%; border-radius: 0px !important; background-color: #e5e5e5 !important; padding: 0px;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black"
                                style="width: 1.5em; height: 1.5em;">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 search-col" style="border-left: 1px solid black;">
                    <div class="search-btn-border">
                        <button type="button" id="toggleFilter" class="btn btn-primary btn-search"
                            style="width: 100%; border-radius: 0px !important; background-color: #e5e5e5 !important; padding: 0px;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black"
                                style="width: 1.5em; height: 1.5em;">
                                <path d="M3 6h18v2H3V6zm4 4h10v2H7v-2zm4 4h6v2h-6v-2z" />
                            </svg>
                        </button>

                    </div>
                </div>
            </div>

            
            <div id="filterPanel" class="filter-panel" style="display: none;">
                <div class="filter-section">
                    <h5>Price Range</h5>
                    <input type="number" name="minPrice" placeholder="Min Price" class="form-control mb-2">
                    <input type="number" name="maxPrice" placeholder="Max Price" class="form-control">
                </div>
                <div class="filter-section">
                    <h5>Categories</h5>
                    <div class="category-options">
                        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="category-item">
                                <input type="radio" name="c" value="<?php echo e($cat['id']); ?>"> <?php echo e($cat['name']); ?>

                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="filter-section">
                    <h5>Location</h5>
                    <input type="text" id="locationFilter" name="location" class="form-control mb-2"
                        placeholder="Filter locations...">
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

        .filter-panel {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border: 1px solid #ddd;
            padding: 15px;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .filter-section {
            margin-bottom: 20px;
        }

        .filter-section h5 {
            margin-bottom: 10px;
            font-size: 16px;
        }

        details {
            margin-bottom: 10px;
        }

        summary {
            cursor: pointer;
            padding: 5px;
        }

        label {
            display: block;
            margin: 5px 0;
        }

        .category-item {
            display: block;
            margin: 5px 0;
        }

        .category-item input[type="radio"] {
            margin-right: 5px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    <script>
        $(document).ready(function() {
            // Toggle filter panel
            $('#toggleFilter').click(function() {
                $('#filterPanel').slideToggle(300);
            });

            // Filter locations dynamically
            $('#locationFilter').on('input', function() {
                let filter = $(this).val().toLowerCase();
                $('#locationList .location-item').each(function() {
                    let locationText = $(this).text().toLowerCase();
                    $(this).toggle(locationText.includes(filter));
                });
                if (!filter) {
                    $('#lSearch').val('');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/home/index.blade.php ENDPATH**/ ?>