@php
    //get selected language
    $lang = selectedLang();
    // about
    $blog_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::BLOG_SECTION);
    $blog = App\Models\Admin\SiteSections::getData($blog_slug)->first();

@endphp
<section class="blog ptb-80 bg_img" data-background="{{ asset('public/frontend') }}/images/element/bg1.png">
    <div class="container mx-auto">
        <div class="text-content text-center">
            <h5 class="sub-top"><i class="las la-paw"></i>{{ @$blog->value->language->$lang->sub_heading }}</h5>
            <h2 class="title">{{ @$blog->value->language->$lang->heading }}</h2>
            <div class="row g-5 ptb-40">
                @forelse ($blogs as $blog)
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-thumb">
                                <a href="{{ route('blog.details', [$blog->id, $blog->slug]) }}">
                                    <img src="{{ get_image($blog->image, 'blog') }}" class="img-fluid main-img"
                                        alt="image">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('blog.details', [$blog->id, $blog->slug]) }}">
                                    <h5 class="text-capitalize fw-bold fs-4 title">
                                        {{ @$blog->title->language->$lang->title }}
                                    </h5>
                                </a>
                                <p class="card-text py-2">{!! textLength(@$blog->description->language->$lang->description) !!}</p>
                                <a href="{{ route('blog.details', [$blog->id, $blog->slug]) }}"
                                    class="link">{{ __('Read More') }}
                                    <i class="las la-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="baybs-data">
                                <p>Data Not Found !</p>
                            </div>
                        </div>
                    </div>
                @endforelse


            </div>
        </div>
</section>
