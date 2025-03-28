@php
    //get selected language
    $lang = selectedLang();
    // header slider
    $feature_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::FEATURE_SECTION);
    $feature = App\Models\Admin\SiteSections::getData($feature_slug)->first();

@endphp

<section class="feature-section pt-80">
    <div class="container">
        <div class="text-content text-center">
            <h5 class="sub-top"><i class="las la-paw"></i> {{ @$feature->value->language->$lang->sub_heading }}</h5>
            <h2 class="title">{{ @$feature->value->language->$lang->heading }}</h2>
        </div>
        <div class="feature-area">
            <div class="feature-swtch text-center pb-5">
                <h3 class="title">{{ @$feature->value->language->$lang->type }}</h3>
                <div class="row justify-content-center">
                    <div class="col-lg-2 col-md-4 col-sm-4">
                        <div class="toggle-container">
                            <div class="switch-toggles two active">
                                <input type="hidden" name="switch">
                                <label class="switch" data-value="enable" id="switchbaby">{{ __('Baby') }}</label>
                                <label class="switch" data-value="disable" id="switchpet">{{ __('Pets') }}</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row g-5 align-items-center  justify-content-center ptb-60">
                    @if ($feature->value->items)
                        @foreach ($feature->value->items as $item)
                            <div
                                class="col-xl-3 col-lg-4 col-md-6 col-sm-6 {{ @$item->language->$lang->item_type }}-feature">
                                <div class="card">
                                    <div class="thumb">
                                        <img src="{{ get_image(@$item->image, 'site-section') }}" alt="icon">
                                    </div>
                                    <div>
                                        <h3>{{ @$item->language->$lang->item_title }}</h3>
                                        <p>{{ textLength(@$item->language->$lang->item_description, 80) }}</p>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif



                </div>


            </div>
        </div>
</section>
