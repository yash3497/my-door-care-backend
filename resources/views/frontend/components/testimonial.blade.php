@php
    //get selected language
    $lang = selectedLang();
    // testimonial
    $testimonial_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::TESTIMONIAL_SECTION);
    $testimonial = App\Models\Admin\SiteSections::getData($testimonial_slug)->first();

@endphp
<section class="testimonial-section pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="section-header">
                    <span class="section-sub-titel"><i
                            class="{{ @$testimonial->value->language->$lang->social_icon }}"></i>
                        {{ @$testimonial->value->language->$lang->sub_heading }}</span>
                    <h2 class="section-title">{{ @$testimonial->value->language->$lang->heading }}</h2>
                    <p>{{ @$testimonial->value->language->$lang->description }}</p>
                </div>
            </div>
        </div>
        <div class="testimonial-slider-wrapper">
            <div class="testimonial-slider">
                <div class="swiper-wrapper">
                    @if (isset($testimonial->value->items))
                        @foreach ($testimonial->value->items ?? [] as $key => $item)
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="testimonial-user-area">
                                        <div class="user-area">
                                            <img src="{{ get_image($item->image, 'site-section') }}" alt="user">
                                        </div>
                                        <div class="title-area">
                                            <h5>{{ @$item->language->$lang->item_name }}</h5>
                                            <p>"{{ @$item->language->$lang->item_designation }}"</p>
                                        </div>
                                    </div>
                                    <h4 class="testimonial-title">{{ @$item->language->$lang->item_testimonial_title }}
                                    </h4>
                                    <p>{{ @$item->language->$lang->item_testimonial_description }}</p>
                                    <div class="testimonial-bottom-wrapper">
                                        <ul class="testimonial-icon-list">
                                            @php
                                                $rating = $item->language->$lang->item_testimonial_rating ?? 0;
                                            @endphp
                                            @for ($number = 1; $number <= $rating; $number++)
                                                <li><i class="las la-star"></i></li>
                                            @endfor

                                        </ul>
                                        <span class="testimonial-date"><i class="las la-history"></i>
                                            {{ date('Y-m-d', strtotime($item->created_at)) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif


                </div>
                <div class="slider-nav-area">
                    <div class="slider-prev slider-nav">
                        <i class="las la-angle-left"></i>
                    </div>
                    <div class="slider-next slider-nav">
                        <i class="las la-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
