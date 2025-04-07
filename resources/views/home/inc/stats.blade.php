@php
    use Illuminate\Support\Facades\Http;

    $wanted_posts = App\Models\Post::with('category', 'city', 'pictures')->where('post_type_id', 2)->get();

    // $wantedPosts = [
    //     [
    //         'id' => 1,
    //         'title' => 'Wanted: Used Laptop in Good Condition',
    //         'picture' => ['filename' => 'https://example.com/images/laptop.jpg'],
    //         'category' => ['name' => 'Electronics'],
    //         'city' => ['name' => 'Colombo'],
    //         'price_formatted' => 'LKR 50,000',
    //         'created_at' => '2025-04-01T10:00:00Z',
    //     ],
    //     [
    //         'id' => 2,
    //         'title' => 'Wanted: Mountain Bike',
    //         'picture' => ['filename' => 'https://example.com/images/bike.jpg'],
    //         'category' => ['name' => 'Sports'],
    //         'city' => ['name' => 'Kandy'],
    //         'price_formatted' => 'LKR 15,000',
    //         'created_at' => '2025-04-01T09:30:00Z',
    //     ],
    //     [
    //         'id' => 3,
    //         'title' => 'Wanted: Graphic Design Books',
    //         'picture' => ['filename' => 'https://example.com/images/books.jpg'],
    //         'category' => ['name' => 'Books'],
    //         'city' => ['name' => 'Galle'],
    //         'price_formatted' => 'LKR 5,000',
    //         'created_at' => '2025-04-01T09:00:00Z',
    //     ],
    // ];

    // Set section options (similar to $getStatsOp)
    $sectionOptions = $getStatsOp ?? [];

    // Prepare widget data
    $sectionData ??= [];
    $widget = [];
    $widgetType = 'dummy2';

    // Set widget data with fetched wanted posts
    $widget['posts'] = $wanted_posts;
    $widget['totalPosts'] = count($wanted_posts);
    $widget['title'] = 'Wanted Ads';
    $widget['link_text'] = 'See All Wanted Ads';
    $widget['link'] = url('/posts/wanted'); // Adjust the link to point to a "wanted" ads page
@endphp

@includeFirst(
    [
        config('larapen.core.customizedViewPath') . 'search.inc.posts.widget.' . $widgetType,
        'search.inc.posts.widget.' . $widgetType,
    ],
    ['widget' => $widget, 'sectionOptions' => $sectionOptions]
)

@php

    $recently_view = App\Models\Post::with('category', 'city', 'pictures')->orderBy('view_at', 'desc')->get();

    $topPosts = [
        [
            'id' => 1,
            'title' => 'Wanted: Used Laptop in Good Condition',
            'picture' => ['filename' => 'https://example.com/images/laptop.jpg'],
            'category' => ['name' => 'Electronics'],
            'city' => ['name' => 'Colombo'],
            'price_formatted' => 'LKR 50,000',
            'created_at' => '2025-04-01T10:00:00Z',
        ],
        [
            'id' => 2,
            'title' => 'Wanted: Mountain Bike',
            'picture' => ['filename' => 'https://example.com/images/bike.jpg'],
            'category' => ['name' => 'Sports'],
            'city' => ['name' => 'Kandy'],
            'price_formatted' => 'LKR 15,000',
            'created_at' => '2025-04-01T09:30:00Z',
        ],
        [
            'id' => 3,
            'title' => 'Wanted: Graphic Design Books',
            'picture' => ['filename' => 'https://example.com/images/books.jpg'],
            'category' => ['name' => 'Books'],
            'city' => ['name' => 'Galle'],
            'price_formatted' => 'LKR 5,000',
            'created_at' => '2025-04-01T09:00:00Z',
        ],
        [
            'id' => 4,
            'title' => 'Wanted: Second-Hand Camera',
            'picture' => ['filename' => 'https://example.com/images/camera.jpg'],
            'category' => ['name' => 'Photography'],
            'city' => ['name' => 'Negombo'],
            'price_formatted' => 'LKR 30,000',
            'created_at' => '2025-04-01T08:30:00Z',
        ],
        [
            'id' => 5,
            'title' => 'Wanted: Vintage Vinyl Records',
            'picture' => ['filename' => 'https://example.com/images/records.jpg'],
            'category' => ['name' => 'Music'],
            'city' => ['name' => 'Jaffna'],
            'price_formatted' => 'LKR 10,000',
            'created_at' => '2025-04-01T08:00:00Z',
        ],
        [
            'id' => 6,
            'title' => 'Wanted: Used Laptop in Good Condition',
            'picture' => ['filename' => 'https://example.com/images/laptop.jpg'],
            'category' => ['name' => 'Electronics'],
            'city' => ['name' => 'Colombo'],
            'price_formatted' => 'LKR 50,000',
            'created_at' => '2025-04-01T10:00:00Z',
        ],
        [
            'id' => 7,
            'title' => 'Wanted: Mountain Bike',
            'picture' => ['filename' => 'https://example.com/images/bike.jpg'],
            'category' => ['name' => 'Sports'],
            'city' => ['name' => 'Kandy'],
            'price_formatted' => 'LKR 15,000',
            'created_at' => '2025-04-01T09:30:00Z',
        ],
        [
            'id' => 8,
            'title' => 'Wanted: Graphic Design Books',
            'picture' => ['filename' => 'https://example.com/images/books.jpg'],
            'category' => ['name' => 'Books'],
            'city' => ['name' => 'Galle'],
            'price_formatted' => 'LKR 5,000',
            'created_at' => '2025-04-01T09:00:00Z',
        ],
    ];

    $sectionData ??= [];
    $widget = (array) data_get($sectionData, 'premium');
    //$widget = (array)data_get($sectionData, 'latest');
    $widgetType = 'dummy';
    $widget['posts'] = $recently_view;
    $widget['totalPosts'] = count($recently_view);
    $widget['title'] = 'Recently Viewed Ads';
    $widget['link_text'] = 'See All Recently Viewed Ads';
@endphp
@includeFirst(
    [
        config('larapen.core.customizedViewPath') . 'search.inc.posts.widget.' . $widgetType,
        'search.inc.posts.widget.' . $widgetType,
    ],
    ['widget' => $widget, 'sectionOptions' => $sectionOptions]
)
