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

if (Auth::user()) {
    $recommend = App\Models\Post::with('category', 'city', 'pictures')
    ->where('view_by',Auth::user()->id)
        ->whereNotNull('view_at') // Ensure view_at is not null
        ->orderBy('view_at', 'desc')
        ->limit(20)
        ->get();
} else {
    $recommend = [];
}

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

@includeFirst(
    [
        config('larapen.core.customizedViewPath') . 'search.inc.posts.widget.' . $firstWidgetType,
        'search.inc.posts.widget.' . $firstWidgetType,
    ],
    ['widget' => $firstWidget, 'sectionOptions' => $sectionOptions]
)
<div class="d-none">
    @if (!empty($textTitle) || !empty($textBody))
        @includeFirst(
            [config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'],
            ['hideOnMobile' => $hideOnMobile]
        )
        <div class="container{{ $hideOnMobile }}">
            <div class="card">
                <div class="card-body">
                    @if (!empty($textTitle))
                        <h2 class="card-title">{{ $textTitle }}</h2>
                    @endif
                    @if (!empty($textBody))
                        <div>{!! $textBody !!}</div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
