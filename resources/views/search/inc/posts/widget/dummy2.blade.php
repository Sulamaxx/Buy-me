@php
    $widget ??= [];
    $posts = data_get($widget, 'posts');
    // $posts = (array) data_get($widget, 'posts');
    $totalPosts = (int) data_get($widget, 'totalPosts', 0);

    $sectionOptions ??= [];
    $hideOnMobile = data_get($sectionOptions, 'hide_on_mobile') == '1' ? ' hidden-sm' : '';
    $carouselEl = '_' . createRandomString(6);

    $isFromHome ??= false;
@endphp


<div class="container{{ $isFromHome ? '' : ' my-3' }}{{ $hideOnMobile }}">
    <div class="col-xl-12 content-box layout-section" style="background-color: transparent">
        <div class="row row-featured">
            <div class="col-xl-12 box-title" style="background-color: transparent !important">
                <div class="inner" style="background-color: transparent">
                    <h2 style="display: flex; align-items: center;">
                        <span class="title-3"
                            style="font-weight: bold">{{ data_get($widget, 'title', t('Latest Listings')) }}</span>
                        <div
                            style="width: 30px; height: 2px; background-color: #52AB4A; margin-left: 5px;margin-top:13px">
                        </div>
                        <a href="{{ data_get($widget, 'link') }}" class="sell-your-item"
                            style="margin-left: auto;color:#666666;font-weight:bold">
                            {{ data_get($widget, 'link_text', t('View more')) }} <i class="fas fa-chevron-right"
                                style="color:#52AB4A"></i><i class="fas fa-chevron-right" style="color:#52AB4A"></i>
                        </a>
                    </h2>
                </div>
            </div>

            <div class="col-xl-12" style="background-color: transparent">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 g-2 g-md-3"
                    style="background-color: transparent">
                    @if (count($posts) > 0)
                        @foreach ($posts as $key => $post)
                            <div class="col">
                                <div class="card" style="border-radius: 0%;min-height: 275px">
                                    @if (data_get($post, 'picture.filename'))
                                        <div style="position: relative; overflow: hidden; height: 150px;">
                                            <a href="{{ \App\Helpers\UrlGen::post($post) }}">
                                                {{-- @php
                                                    echo imgTag('app/default/picture.jpg', 'medium', [
                                                        'class' => 'card-img-top',
                                                        'alt' => data_get($post, 'title'),
                                                    ]);
                                                @endphp --}}
                                                @php
                                                    Log::info('picture - ' . data_get($post, 'picture.filename'));
                                                    echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                        'class' => 'card-img-top',
                                                        'alt' => data_get($post, 'title'),
                                                    ]);
                                                @endphp
                                            </a>
                                        </div>
                                    @endif
                                    <div class="card-body"
                                        style="display: flex; flex-direction: column; min-height: 180px;">
                                        <h5 class="card-title"
                                            style="font-size: 1rem; margin-bottom: 5px;font-weight:bold">
                                            <a href="{{ \App\Helpers\UrlGen::post($post) }}" style="color: #666666;">
                                                {{ str(data_get($post, 'title'))->limit(50) }}
                                            </a>
                                        </h5>
                                        <div>
                                            <p class="card-text"
                                                style="font-size: 0.8rem; color: #52AB4A; margin-bottom: 3px;">
                                                <i class="fas fa-folder"></i> {{ data_get($post, 'category.name') }}
                                                @if (data_get($post, 'city.name'))
                                                    <i class="fas fa-map-marker-alt" style="margin-left: 5px;"></i>
                                                    {{ data_get($post, 'city.name') }}
                                                @endif
                                            </p>
                                            <p class="card-text"
                                                style="font-size: 0.9rem; color: #52AB4A; margin-bottom: 5px;font-weight:bold">
                                                {!! data_get($post, 'price_formatted') !!}
                                            </p>
                                        </div>
                                        <p class="card-text"
                                            style="font-size: 0.7rem; color: #999; text-align: right; margin-top: auto; margin-bottom: 0;">
                                            <i class="far fa-clock"></i>
                                            {{ \Carbon\Carbon::parse(data_get($post, 'created_at'))->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
