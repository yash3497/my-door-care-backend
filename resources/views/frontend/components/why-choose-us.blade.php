@php
    //get selected language
    $lang = selectedLang();
    // about
    $why_choose_us_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::WHY_CHOOSE_US_SECTION);
    $why_choose_us = App\Models\Admin\SiteSections::getData($why_choose_us_slug)->first();

@endphp
<section class="why-choose-us ptb-80 bg_img-2" data-background="{{ asset('public/frontend') }}/images/element/shape1.png">
    <div class="container mx-auto">
        <div class="top">
            <h5 class="sub-top"><i class="las la-paw"></i>{{ @$why_choose_us->value->language->$lang->sub_heading }}</h5>
            <h2 class="title">{{ @$why_choose_us->value->language->$lang->heading }}</h2>
        </div>
        <div class="row align-items-center mb-40-none">
            <div class="col-lg-6 col-12 mb-40">
                <div class="row g-4 pt-40">
                    @if ($why_choose_us->value->items)
                        @foreach ($why_choose_us->value->items as $item)
                            <div class="col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="thumb">
                                        <img src="{{ get_image($item->image, 'site-section') }}" alt="icon">
                                    </div>
                                    <div>
                                        <h3>{{ @$item->language->$lang->item_title }}</h3>
                                        <p>{{ @$item->language->$lang->item_description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-12 mb-40">
                <div class="choice-us-img text-center">
                    <img src="{{ get_image(@$why_choose_us->value->image, 'site-section') }}" alt="image">
                </div>
            </div>
        </div>
    </div>
</section>
