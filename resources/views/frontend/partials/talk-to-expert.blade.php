@php
    //get selected language
    $lang = selectedLang();
    // call to action
    $call_to_action_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::CALL_TO_ACTION_SECTION);
    $call_to_action = App\Models\Admin\SiteSections::getData($call_to_action_slug)->first();

@endphp
<section class="join ptb-60">
    <div class="container mx-auto">
        <div class="sec-bg">
            <div class="d-lg-flex d-block justify-content-between call-to-action">
                <h2 class="title">{{ @$call_to_action->value->language->$lang->heading }}</h2>
                <a href="{{ $call_to_action->value->language->$lang->button_link ?? route('contact') }}"
                    class="btn--base ">{{ @$call_to_action->value->language->$lang->button_text }} <i
                        class="las la-arrow-alt-circle-right ps-1"></i></a>
            </div>
        </div>
    </div>
</section>
