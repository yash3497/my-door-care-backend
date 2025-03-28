@php
    //get selected language
    $lang = selectedLang();
    // about
    $about_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::ABOUT_SECTION);
    $about = App\Models\Admin\SiteSections::getData($about_slug)->first();

@endphp
<section class="happy pt-80 bg_img-2" data-background="{{ asset('public/frontend') }}/images/element/shape1.png">
    <div class="container mx-auto">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-12">
                <div>
                    <img src="{{ get_image(@$about->value->image, 'site-section') }}" alt="image">
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 my-auto left-content">
                <h5 class="sub-top"><i class="las la-paw"></i> {{ @$about->value->language->$lang->sub_heading }}</h5>
                <h2>{{ @$about->value->language->$lang->heading }}</h2>
                <p>{{ @$about->value->language->$lang->description }}</p>

            </div>
        </div>
    </div>
</section>

</section>
