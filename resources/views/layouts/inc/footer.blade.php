@php
    $socialLinksAreEnabled = (
        config('settings.social_link.facebook_page_url')
        || config('settings.social_link.twitter_url')
        || config('settings.social_link.youtube_url')
        || config('settings.social_link.instagram_url')
    );
@endphp
<footer class="main-footer">
    <div class="footer-content" style="background-color: #dcdcdc;border-top:none">
        <!-- Desktop View -->
        <div class="container d-none d-sm-block d-md-block d-lg-block">
            <div class="row">
                <div class="col-md-3">
                    <a href="{{ url('/') }}" class="navbar-brand logo logo-title">
                        <img src="{{ config('settings.app.logo_url') }}"
                             alt="{{ strtolower(config('settings.app.name')) }}"
                             class="main-logo footer-main-logo"
                             data-bs-placement="bottom"
                             data-bs-toggle="tooltip"
                        />
                    </a>
                </div>
                <div class="col-md-9">
                    <ul class="list-inline text-right">
                        <li class="list-inline-item"><a href="#" class="footer-link">Stay Safe</a></li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item"><a href="#" class="footer-link">FAQ</a></li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item"><a href="#" class="footer-link">Anti-Scam</a></li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item"><a href="#" class="footer-link">Terms</a></li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item"><a href="#" class="footer-link">Privacy</a></li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item"><a href="#" class="footer-link">Blog</a></li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item"><a href="#" class="footer-link">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="margin-left: -20px; margin-top:10px">
                    <p class="copy-info">© {{ date('Y') }} {{ config('settings.app.name') }}. {{ t('all_rights_reserved') }}.</p>
                </div>
                <div class="col-md-6 text-right">
                    @if ($socialLinksAreEnabled)
                        <ul class="list-inline d-inline-block">
                            @if (config('settings.social_link.facebook_page_url'))
                                <li class="list-inline-item">
                                    <a href="{{ config('settings.social_link.facebook_page_url') }}">
                                        <img src="/images/social/facebook.png" alt="Facebook" class="social-icon">
                                    </a>
                                </li>
                            @endif
                            @if (config('settings.social_link.twitter_url'))
                                <li class="list-inline-item">
                                    <a href="{{ config('settings.social_link.twitter_url') }}">
                                        <img src="/images/social/x.png" alt="X" class="social-icon">
                                    </a>
                                </li>
                            @endif
                            @if (config('settings.social_link.youtube_url'))
                                <li class="list-inline-item">
                                    <a href="{{ config('settings.social_link.youtube_url') }}">
                                        <img src="/images/social/youtube.png" alt="YouTube" class="social-icon">
                                    </a>
                                </li>
                            @endif
                            @if (config('settings.social_link.instagram_url'))
                                <li class="list-inline-item">
                                    <a href="{{ config('settings.social_link.instagram_url') }}">
                                        <img src="/images/social/instagram.png" alt="Instagram" class="social-icon">
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                    <a href="tel:0112356356" class="btn btn-orange">
                        <img src="/images/social/phone.png" alt="Phone">
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile View -->
        <div class="container d-block d-sm-none">
            <div class="text-center">
                <a href="{{ url('/') }}" class="navbar-brand logo logo-title">
                    <img src="{{ config('settings.app.logo_url') }}"
                         alt="{{ strtolower(config('settings.app.name')) }}"
                         class="main-logo footer-main-logo"
                         data-bs-placement="bottom"
                         data-bs-toggle="tooltip"
                    />
                </a>
            </div>
            <div class="text-center">
                <ul class="list-unstyled">
                    <li><a href="#" class="footer-link">Stay Safe</a></li>
                    <li><a href="#" class="footer-link">FAQ</a></li>
                    <li><a href="#" class="footer-link">Anti-Scam</a></li>
                    <li><a href="#" class="footer-link">Terms</a></li>
                    <li><a href="#" class="footer-link">Privacy</a></li>
                    <li><a href="#" class="footer-link">Blog</a></li>
                    <li><a href="#" class="footer-link">Contact Us</a></li>
                </ul>
            </div>
            <div class="text-center">
                <a href="tel:0112356356" class="btn btn-orange">
                    <img src="/images/social/phone.png" alt="Phone">
                </a>
            </div>
            <div class="text-center">
                @if ($socialLinksAreEnabled)
                    <ul class="list-inline">
                        @if (config('settings.social_link.facebook_page_url'))
                            <li class="list-inline-item">
                                <a href="{{ config('settings.social_link.facebook_page_url') }}">
                                    <img src="/images/social/facebook.png" alt="Facebook" class="social-icon">
                                </a>
                            </li>
                        @endif
                        @if (config('settings.social_link.twitter_url'))
                            <li class="list-inline-item">
                                <a href="{{ config('settings.social_link.twitter_url') }}">
                                    <img src="/images/social/x.png" alt="Twitter" class="social-icon">
                                </a>
                            </li>
                        @endif
                        @if (config('settings.social_link.youtube_url'))
                            <li class="list-inline-item">
                                <a href="{{ config('settings.social_link.youtube_url') }}">
                                    <img src="/images/social/youtube.png" alt="YouTube" class="social-icon">
                                </a>
                            </li>
                        @endif
                        @if (config('settings.social_link.instagram_url'))
                            <li class="list-inline-item">
                                <a href="{{ config('settings.social_link.instagram_url') }}">
                                    <img src="/images/social/instagram.png" alt="Instagram" class="social-icon">
                                </a>
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
            <div class="text-center">
                <p class="copy-info">© {{ date('Y') }} {{ config('settings.app.name') }}. {{ t('all_rights_reserved') }}.</p>
            </div>
        </div>
    </div>
</footer>

<style>
    /* .btn-orange {
        background-color: orange;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
    }
    .btn-orange:hover {
        background-color: darkorange;
        color: white;
    } */
    .footer-link {
        color: black !important;
        text-decoration: none;
    }
    .footer-link:hover {
        text-decoration: underline;
    }
    .social-icon {
        width: 24px; /* Adjust size as needed */
        height: 24px;
        margin: 0 5px;
    }
    .phone-icon {
        width: 20px; /* Adjust size as needed */
        height: 20px;
        margin-right: 5px;
    }
</style>