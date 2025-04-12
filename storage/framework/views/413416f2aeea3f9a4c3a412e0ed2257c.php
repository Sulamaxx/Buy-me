<?php
$sectionOptions = $getTextAreaOp ?? [];
$sectionData ??= [];

// Fallback Language
$textTitle = data_get($sectionOptions, 'title_' . config('appLang.abbr'));
$textTitle = replaceGlobalPatterns($textTitle);

$textBody = data_get($sectionOptions, 'body_' . config('appLang.abbr'));
$textBody = replaceGlobalPatterns($textBody);

// Current Language
if (!empty(data_get($sectionOptions, 'title_' . config('app.locale')))) {
    $textTitle = data_get($sectionOptions, 'title_' . config('app.locale'));
    $textTitle = replaceGlobalPatterns($textTitle);
}

if (!empty(data_get($sectionOptions, 'body_' . config('app.locale')))) {
    $textBody = data_get($sectionOptions, 'body_' . config('app.locale'));
    $textBody = replaceGlobalPatterns($textBody);
}

$hideOnMobile = data_get($sectionOptions, 'hide_on_mobile') == '1' ? ' hidden-sm' : '';

// $recommend = App\Models\Post::with('pictures')
//     ->where('view_by', Auth::user()->id)
//     ->whereNotNull('view_at') // Ensure view_at is not null
//     ->orderBy('view_at', 'desc')
//     ->get()
//     ->groupBy('category_id')
//     ->take(3) // Group posts by category_id
//     ->map(function ($posts) {
//         // For each group, take only 4 posts and order them by view_at
//         $category = $posts->first()->category; // Get the category details (name and description)

//         return [
//             'category' => $category, // Include category name and description
//             'posts' => $posts->take(4), // Limit to the first 4 posts, ordered by view_at
//         ];
//     });

$categoryIds = App\Models\Post::with('pictures')
    ->where('view_by', request()->header('X-Forwarded-For') ?? request()->ip())
    ->whereNotNull('view_at')
    ->orderBy('view_at', 'desc')
    ->get()
    ->groupBy('category_id')
    ->take(3)
    ->map(function ($posts) {
        return $posts->first()->category_id;
    })
    ->values();

$recommend = collect($categoryIds)->map(function ($categoryId) {
    $category = App\Models\Category::find($categoryId); // Get the category details

    $posts = App\Models\Post::with('pictures')
        ->where('category_id', $categoryId)
        ->orderBy('created_at', 'desc') // Order by latest posts
        ->take(4)
        ->get();

    return [
        'category' => $category,
        'posts' => $posts,
    ];
});

// Log::info($recommend);

// $recommend = [
//     [
//         'id' => 1,
//         'title' => 'Exclusive Deals',
//         'picture' => ['filename' => 'https://example.com/images/laptop.jpg'],
//         'description' => 'Tailored offers based on your interests.',
//     ],
//     [
//         'id' => 2,
//         'title' => 'Best Value Items',
//         'picture' => ['filename' => 'https://example.com/images/laptop.jpg'],
//         'description' => 'Discover deals curated just for you.',
//     ],
//     [
//         'id' => 3,
//         'title' => 'Handpicked Offers',
//         'picture' => ['filename' => 'https://example.com/images/laptop.jpg'],
//         'description' => 'A selection of ads we think you\'ll love.',
//     ],
// ];

$firstWidget = [];
$firstWidgetType = 'dummy3';

// Set widget data with fetched
$firstWidget['posts'] = $recommend;
$firstWidget['totalPosts'] = count($recommend);
$firstWidget['title'] = 'Recommend For You';

?>

<?php echo $__env->first(
    [
        config('larapen.core.customizedViewPath') . 'search.inc.posts.widget.' . $firstWidgetType,
        'search.inc.posts.widget.' . $firstWidgetType,
    ],
    ['widget' => $firstWidget, 'sectionOptions' => $sectionOptions]
, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="d-none">
    <?php if(!empty($textTitle) || !empty($textBody)): ?>
        <?php echo $__env->first(
            [config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'],
            ['hideOnMobile' => $hideOnMobile]
        , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="container<?php echo e($hideOnMobile); ?>">
            <div class="card">
                <div class="card-body">
                    <?php if(!empty($textTitle)): ?>
                        <h2 class="card-title"><?php echo e($textTitle); ?></h2>
                    <?php endif; ?>
                    <?php if(!empty($textBody)): ?>
                        <div><?php echo $textBody; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/home/inc/text-area.blade.php ENDPATH**/ ?>