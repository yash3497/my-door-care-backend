@php
    //get selected language
    $lang = selectedLang();
    // Footer section
    $footer_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::FOOTER_SECTION);
    $footer = App\Models\Admin\SiteSections::getData($footer_slug)->first();

    $usefulLink = App\Models\Admin\UsefulLink::get();

@endphp
<footer class="footer-section pt-60">
    <div class="container mx-auto">
        <div class="footer-content">
            <div class="row">
                <div class="col-xl-4 col-lg-4 mb-50">
                    <div class="footer-widget">
                        <div class="footer-text">
                            <a href="{{ route('index') }}">
                                <img src="{{ get_logo(@$basic_settings) }}" alt="image">
                            </a>
                            <p>{{ @$footer->value->language->$lang->footer_description }}</p>
                        </div>
                        <div class="footer-social-icon">
                            <span>{{ __('Follow us') }}</span>
                            @if ($footer->value->items)
                                @foreach ($footer->value->items as $item)
                                    <a href="{{ @$item->language->$lang->item_link }}"><i
                                            class="{{ @$item->language->$lang->item_social_icon }} primery"
                                            title="{{ @$item->language->$lang->item_title }}"></i></a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>{{ __('Useful Links') }}</h3>
                        </div>
                        <ul>
                            @if (!$usefulLink->isEmpty())
                                @foreach ($usefulLink as $item)
                                    <li><a
                                            href="{{ url('link/' . $item->slug) }}">{{ @$item->title->language->$lang->title }}</a>
                                    </li>
                                @endforeach
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>{{ __('Subscribe') }}</h3>
                        </div>
                        <div class="footer-text mb-25">
                            <p>{{ @$footer->value->language->$lang->newsletter_description }}</p>
                        </div>
                        <div class="subscribe-form">
                            @include('frontend.components.subscribe-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area ptb-20">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center text-lg-left">
                    <div class="copyright-text">
                        <p>{{ __('Copyright') }} &copy; {{ date('Y') }}, {{ __('All Right Reserved') }} <a
                                href="{{ route('index') }}">
                                <span class="text--base">{{ __(@$basic_settings->site_name) }}</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
