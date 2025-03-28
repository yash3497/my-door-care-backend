<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Language;
use App\Constants\LanguageConst;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class SetupSectionsController extends Controller
{
    protected $languages;

    public function __construct()
    {
        $this->languages = Language::whereNot('code', LanguageConst::NOT_REMOVABLE)->get();
    }

    /**
     * Register Sections with their slug
     * @param string $slug
     * @param string $type
     * @return string
     */
    public function section($slug, $type)
    {
        $sections = [
            'banner'    => [
                'view'      => "bannerView",
                'update'    => "bannerUpdate",
            ],
            'call-to-action'    => [
                'view'      => "callToActionView",
                'update'    => "callToActionUpdate",
            ],
            'about'    => [
                'view'      => "aboutView",
                'update'    => "aboutUpdate",
            ],
            'app-download'    => [
                'view'      => "appDownloadView",
                'update'    => "appDownloadUpdate",
            ],
            'login'    => [
                'view'      => "loginView",
                'update'    => "loginUpdate",
            ],
            'user-register'    => [
                'view'      => "userRegisterView",
                'update'    => "userRegisterUpdate",
            ],
            'contact'    => [
                'view'      => "contactView",
                'update'    => "contactUpdate",
            ],
            'best-care'    => [
                'view'      => "bestCareView",
                'update'    => "bestCareUpdate",
            ],
            'why-choose-us'    => [
                'view'      => "whyChooseUsView",
                'update'    => "whyChooseUsUpdate",
                'itemStore'     => "whyChooseUsItemStore",
                'itemUpdate'    => "whyChooseUsItemUpdate",
                'itemDelete'    => "whyChooseUsItemDelete",
            ],
            'feature'    => [
                'view'      => "featureView",
                'update'    => "featureUpdate",
                'itemStore'     => "featureItemStore",
                'itemUpdate'    => "featureItemUpdate",
                'itemDelete'    => "featureItemDelete",
            ],
            'footer'    => [
                'view'      => "footerView",
                'update'    => "footerUpdate",
                'itemStore'     => "footerItemStore",
                'itemUpdate'    => "footerItemUpdate",
                'itemDelete'    => "footerItemDelete",
            ],
            'blog'    => [
                'view'      => "blogView",
                'update'    => "blogUpdate",
                'itemStore'     => "blogItemStore",
                'itemUpdate'    => "blogItemUpdate",
                'itemDelete'    => "blogItemDelete",
            ],

            'glance'  => [
                'view'          => "glanceView",
                'update'        => "glanceUpdate",
                'itemUpdate'    => "glanceItemUpdate",
            ],

        ];

        if (!array_key_exists($slug, $sections)) abort(404);
        if (!isset($sections[$slug][$type])) abort(404);
        $next_step = $sections[$slug][$type];
        return $next_step;
    }

    /**
     * Method for getting specific step based on incomming request
     * @param string $slug
     * @return method
     */
    public function sectionView($slug)
    {
        $section = $this->section($slug, 'view');
        return $this->$section($slug);
    }

    /**
     * Method for distribute store method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionItemStore(Request $request, $slug)
    {
        $section = $this->section($slug, 'itemStore');
        return $this->$section($request, $slug);
    }

    /**
     * Method for distribute update method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionItemUpdate(Request $request, $slug)
    {
        $section = $this->section($slug, 'itemUpdate');
        return $this->$section($request, $slug);
    }

    /**
     * Method for distribute delete method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionItemDelete(Request $request, $slug)
    {
        $section = $this->section($slug, 'itemDelete');
        return $this->$section($request, $slug);
    }

    /**
     * Method for distribute update method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionUpdate(Request $request, $slug)
    {
        $section = $this->section($slug, 'update');
        return $this->$section($request, $slug);
    }

    /**
     * Mehtod for show banner section page
     * @param string $slug
     * @return view
     */
    public function bannerView($slug)
    {
        $page_title = "Banner Section";
        $section_slug = Str::slug(SiteSectionConst::BANNER_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.banner-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    /**
     * Mehtod for update banner section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function bannerUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'heading' => "required|string|max:100",
            'sub_heading' => "required|string|max:255",
            'left_button_text' => "required|string|max:50",
            'left_button_link' => "nullable|max:255",
            'right_button_text' => "required|string|max:50",
            'right_button_link' => "nullable|max:255",
        ];


        $slug = Str::slug(SiteSectionConst::BANNER_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        $data['image'] = $section->value->image ?? "";
        if ($request->hasFile("image")) {
            $data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }

        $data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    //banner section end

    //call to action start
    public function callToActionView($slug)
    {
        $page_title = "Call To Action Section";
        $section_slug = Str::slug(SiteSectionConst::CALL_TO_ACTION_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.call-to-action-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    public function callToActionUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'heading' => "required|string|max:100",
            'button_text' => "required|string|max:50",
            'button_link' => "nullable",

        ];

        $slug = Str::slug(SiteSectionConst::CALL_TO_ACTION_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        $data['image'] = $section->value->image ?? "";
        if ($request->hasFile("image")) {
            $data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }

        $data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    //call to action section end

    //about section start
    public function aboutView($slug)
    {
        $page_title = "About Section";
        $section_slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.about-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    public function aboutUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'heading' => "required|string|max:100",
            'sub_heading' => "required|string|max:255",
            'description' => "required|string",
            'button_text' => "required|string|max:50",
            'button_link' => "nullable|max:255",
        ];

        $slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        $data['image'] = $section->value->image ?? "";
        if ($request->hasFile("image")) {
            $data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }
        $data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    //about section end
    //app download section start
    public function appDownloadView($slug)
    {
        $page_title = "App Download Section";
        $section_slug = Str::slug(SiteSectionConst::APP_DOWNLOAD_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.app-download-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }
    public function appDownloadUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'heading' => "required|string|max:100",
            'sub_heading' => "required|string|max:255",
            'description' => "required|string",

        ];

        $slug = Str::slug(SiteSectionConst::APP_DOWNLOAD_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        $data['image'] = $section->value->image ?? "";
        if ($request->hasFile("image")) {
            $data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }
        $data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    //app download section end
    //Login section start
    public function loginView($slug)
    {
        $page_title = "Login Section";
        $section_slug = Str::slug(SiteSectionConst::LOGIN);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.login-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }
    public function loginUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'heading' => "required|string|max:100",
        ];

        $slug = Str::slug(SiteSectionConst::LOGIN);
        $section = SiteSections::where("key", $slug)->first();
        $data['image'] = $section->value->image ?? "";
        if ($request->hasFile("image")) {
            $data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }
        $data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    //Login section end
    //User register section start
    public function userRegisterView($slug)
    {
        $page_title = "User Register Section";
        $section_slug = Str::slug(SiteSectionConst::USER_REGISTER);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.user-register-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }
    public function userRegisterUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'heading' => "required|string|max:100",
        ];

        $slug = Str::slug(SiteSectionConst::USER_REGISTER);
        $section = SiteSections::where("key", $slug)->first();
        $data['image'] = $section->value->image ?? "";
        if ($request->hasFile("image")) {
            $data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }
        $data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    //User Register section end

    //contact section start
    public function contactView($slug)
    {
        $page_title = "Contact Section";
        $section_slug = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.contact-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    public function contactUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'heading' => "required|string|max:100",
            'sub_heading' => "required|string|max:255",
        ];

        $slug = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        $data['image'] = $section->value->image ?? "";
        if ($request->hasFile("image")) {
            $data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }

        $data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    //contact section end

    //best care section start
    /**
     * Mehtod for show about section page
     * @param string $slug
     * @return view
     */
    public function bestCareView($slug)
    {
        $page_title = "Best Care Section";
        $section_slug = Str::slug(SiteSectionConst::BEST_CARE_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.best-care-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    /**
     * Mehtod for update about section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function bestCareUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'sub_heading' => "required|string|max:255",
            'heading' => "required|string|max:100",

        ];

        $slug = Str::slug(SiteSectionConst::BEST_CARE_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        $data['left_image'] = $section->value->left_image ?? "";
        if ($request->hasFile("left_image")) {
            $data['left_image']      = $this->imageValidate($request, "left_image", $section->value->left_image ?? null);
        }
        $data['right_image'] = $section->value->right_image ?? "";
        if ($request->hasFile("right_image")) {
            $data['right_image']      = $this->imageValidate($request, "right_image", $section->value->right_image ?? null);
        }
        $data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    //about section end


    //why feature start
    /**
     * Mehtod for show feature section page
     * @param string $slug
     * @return view
     */
    public function featureView($slug)
    {
        $page_title = "Feature Section";
        $section_slug = Str::slug(SiteSectionConst::FEATURE_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.feature-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    /**
     * Mehtod for update feature section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function featureUpdate(Request $request, $slug)
    {

        $basic_field_name = [
            'sub_heading' => "required|string|max:100",
            'heading' => "required|string|max:255",
            'type' => "required|string|max:255",
        ];
        $slug = Str::slug(SiteSectionConst::FEATURE_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }


        if ($request->hasFile("image")) {
            $section_data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }

    /**
     * Mehtod for store feature item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function featureItemStore(Request $request, $slug)
    {

        $basic_field_name = [
            'item_type'   => "required|string|max:100",
            'item_title'   => "required|string|max:100",
            'item_description'   => "required|string|max:80",
        ];


        $language_wise_data = $this->contentValidate($request, $basic_field_name, "feature-add");
        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::FEATURE_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }


        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;

        $section_data['items'][$unique_id]['id'] = $unique_id;
        $section_data['items'][$unique_id]['image'] = "";

        if ($request->hasFile("image")) {
            $section_data['items'][$unique_id]['image'] = $this->imageValidate($request, "image", $section->value->items->image ?? null);
        }

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;



        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Section item added successfully!']]);
    }

    /**
     * Mehtod for update feature item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function featureItemUpdate(Request $request, $slug)
    {


        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'item_type_edit'   => "required|string|max:100",
            'item_title_edit'   => "required|string|max:100",
            'item_description_edit'  => "required|string|max:80",
        ];

        $slug = Str::slug(SiteSectionConst::FEATURE_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

        $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "feature-edit");

        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function ($language) {
            return replace_array_key($language, "_edit");
        }, $language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;

        if ($request->hasFile("image")) {
            $section_values['items'][$request->target]['image']    = $this->imageValidate($request, "image", $section_values['items'][$request->target]['image'] ?? null);
        }


        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Information updated successfully!']]);
    }

    /**
     * Mehtod for delete feature item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function featureItemDelete(Request $request, $slug)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::FEATURE_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

        try {
            $image_link = get_files_path('site-section') . '/' . $section_values['items'][$request->target]['image'];
            unset($section_values['items'][$request->target]);
            delete_file($image_link);
            $section->update([
                'value'     => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section item delete successfully!']]);
    }
    //feature end

    //footer start
    /**
     * Mehtod for show footer section page
     * @param string $slug
     * @return view
     */
    public function footerView($slug)
    {
        $page_title = "Footer Section";
        $section_slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.footer-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    /**
     * Mehtod for update footer section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function footerUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'heading' => "required|string|max:100",
            'footer_description' => "required|string",
            'newsletter_description' => "required|string",

        ];
        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }


        if ($request->hasFile("image")) {
            $section_data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;


        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }

    /**
     * Mehtod for store footer item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function footerItemStore(Request $request, $slug)
    {
        $basic_field_name = [
            'item_title'   => "required|string|max:100",
            'item_social_icon'   => "required|string|max:100",
            'item_link'     => "required|string|max:255",
        ];

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "footer-add");
        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;
        $section_data['items'][$unique_id]['image'] = "";

        if ($request->hasFile("image")) {
            $section_data['items'][$unique_id]['image'] = $this->imageValidate($request, "image", $section->value->items->image ?? null);
        }

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Section item added successfully!']]);
    }

    /**
     * Mehtod for update footer item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function footerItemUpdate(Request $request, $slug)
    {

        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'item_title_edit'   => "required|string|max:100",
            'item_social_icon_edit'   => "required|string|max:100",
            'item_link_edit'     => "required|string|max:255",
        ];

        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

        $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "footer-edit");
        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function ($language) {
            return replace_array_key($language, "_edit");
        }, $language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;

        if ($request->hasFile("image")) {
            $section_values['items'][$request->target]['image']    = $this->imageValidate($request, "image", $section_values['items'][$request->target]['image'] ?? null);
        }

        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Information updated successfully!']]);
    }

    /**
     * Mehtod for delete services item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function footerItemDelete(Request $request, $slug)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

        try {
            $image_link = get_files_path('site-section') . '/' . $section_values['items'][$request->target]['image'];
            unset($section_values['items'][$request->target]);
            delete_file($image_link);
            $section->update([
                'value'     => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section item delete successfully!']]);
    }
    //footer end

    //=======================================Banner section Start =====================================
    public function blogView($slug)
    {
        $page_title = "Blog Section";
        $section_slug = Str::slug(SiteSectionConst::BLOG_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;
        $blogs = Blog::latest()->paginate(10);

        return view('admin.sections.setup-sections.blog-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
            'blogs'
        ));
    }
    public function blogUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'sub_heading' => "required|string|max:100",
            'heading' => "required|string|max:100",

        ];
        $slug = Str::slug(SiteSectionConst::BLOG_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }

        if ($request->hasFile("image")) {
            $section_data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;


        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    public function blogItemStore(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'en_title'          => "required|string",
            'en_description'    => "required|string",
            'tags'              => 'required|array',
            'tags.*'            => 'required|string|max:30',
            'image'             => 'required|image|mimes:png,jpg,jpeg,svg,webp',
        ]);



        $title_filed = [
            'title'     => "required|string",
        ];
        $description_filed = [
            'description'     => "required|string",
        ];

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'blog-add');
        }
        $validated = $validator->validate();

        // Multiple language data set

        $language_wise_title = $this->contentValidate($request, $title_filed);
        $language_wise_description = $this->contentValidate($request, $description_filed);

        $title_data['language'] = $language_wise_title;
        $description_data['language'] = $language_wise_description;

        $validated['admin_id']         = auth()->user()->id;
        $validated['title']            = $title_data;
        $validated['description']      = $description_data;
        $validated['slug']             = Str::slug($title_data['language']['en']['title']);
        $validated['tag']              = $request->tags;
        $validated['created_at']       = now();


        // Check Image File is Available or not
        if ($request->hasFile('image')) {
            $image = get_files_from_fileholder($request, 'image');
            $upload = upload_files_from_path_dynamic($image, 'blog');
            $validated['image'] = $upload;
        }


        try {
            Blog::create($validated);
        } catch (Exception $e) {

            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Section item added successfully!']]);
    }
    public function blogEdit($id)
    {
        $page_title = "Blog Edit";
        $languages = $this->languages;
        $data = Blog::findOrFail($id);
        return view('admin.sections.setup-sections.blog-section-edit', compact(
            'page_title',
            'languages',
            'data',
        ));
    }

    public function blogItemUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'en_title'          => "required|string",
            'en_description'    => "required|string",
            'tags'              => 'required|array',
            'tags.*'            => 'required|string|max:30',
            'image'             => 'nullable|image|mimes:png,jpg,jpeg,svg,webp',
            'target'        => 'required|integer',
        ]);



        $title_filed = [
            'title'     => "required|string",
        ];
        $description_filed = [
            'description'     => "required|string",
        ];

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'blog-add');
        }
        $validated = $validator->validate();
        $blog = Blog::findOrFail($validated['target']);

        // Multiple language data set

        $language_wise_title = $this->contentValidate($request, $title_filed);
        $language_wise_description = $this->contentValidate($request, $description_filed);

        $title_data['language'] = $language_wise_title;
        $description_data['language'] = $language_wise_description;

        $validated['admin_id']         = auth()->user()->id;
        $validated['title']            = $title_data;
        $validated['description']      = $description_data;
        $validated['slug']             = Str::slug($title_data['language']['en']['title']);
        $validated['tag']              = $request->tags;
        $validated['created_at']       = now();


        // Check Image File is Available or not
        if ($request->hasFile('image')) {
            $image = get_files_from_fileholder($request, 'image');
            $upload = upload_files_from_path_dynamic($image, 'blog');
            $validated['image'] = $upload;
        }


        try {
            $blog->update($validated);
        } catch (Exception $e) {

            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Section item updated successfully!']]);
    }
    public function blogItemDelete(Request $request)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);

        $blog = Blog::findOrFail($request->target);

        try {
            $image_link = get_files_path('blog') . '/' . $blog->image;
            delete_file($image_link);
            $blog->delete();
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['BLog delete successfully!']]);
    }

    //=======================================Banner section End ==========================================

    //Services Started
    /**
     * Mehtod for show services section page
     * @param string $slug
     * @return view
     */
    public function whyChooseUsView($slug)
    {
        $page_title = "Why Choose Us Section";
        $section_slug = Str::slug(SiteSectionConst::WHY_CHOOSE_US_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.why-choose-us-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    /**
     * Mehtod for update services section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function whyChooseUsUpdate(Request $request, $slug)
    {
        $basic_field_name = [
            'sub_heading' => "required|string|max:100",
            'heading' => "required|string|max:255",
        ];

        $slug = Str::slug(SiteSectionConst::WHY_CHOOSE_US_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }


        if ($request->hasFile("image")) {
            $section_data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);

        $update_data['key']    = $slug;
        $update_data['value']  = $section_data;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }

    /**
     * Mehtod for store services item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function whyChooseUsItemStore(Request $request, $slug)
    {
        $basic_field_name = [
            'item_title'   => "required|string|max:100",
            'item_description'   => "required|string",
        ];
        $language_wise_data = $this->contentValidate($request, $basic_field_name, "why-choose-us-add");
        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::WHY_CHOOSE_US_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;
        $section_data['items'][$unique_id]['image'] = "";

        if ($request->hasFile("image")) {
            $section_data['items'][$unique_id]['image'] = $this->imageValidate($request, "image", $section->value->items->image ?? null);
        }

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Section item added successfully!']]);
    }

    /**
     * Mehtod for update services item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function whyChooseUsItemUpdate(Request $request, $slug)
    {

        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'item_title_edit'   => "required|string|max:100",
            'item_description_edit'   => "required|string",
        ];

        $slug = Str::slug(SiteSectionConst::WHY_CHOOSE_US_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

        $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "solution-edit");
        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function ($language) {
            return replace_array_key($language, "_edit");
        }, $language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;

        if ($request->hasFile("image")) {
            $section_values['items'][$request->target]['image']    = $this->imageValidate($request, "image", $section_values['items'][$request->target]['image'] ?? null);
        }

        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Information updated successfully!']]);
    }

    /**
     * Mehtod for delete services item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function whyChooseUsItemDelete(Request $request, $slug)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::WHY_CHOOSE_US_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

        try {
            $image_link = get_files_path('site-section') . '/' . $section_values['items'][$request->target]['image'];
            unset($section_values['items'][$request->target]);
            delete_file($image_link);
            $section->update([
                'value'     => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section item delete successfully!']]);
    }

    /**
     * Method for getting specific step based on incomming request
     * @param string $slug
     * @return method
     */
    public function glanceView($slug)
    {
        $page_title = "Glance Section";
        $section_slug = Str::slug(SiteSectionConst::GLANCE_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.glance-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    /**
     * Mehtod for update glance section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function glanceUpdate(Request $request)
    {
        $basic_field_name = ['heading' => "required|string|max:100", 'sub_heading' => "required|string|max:255"];

        $slug = Str::slug(SiteSectionConst::GLANCE_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        $data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }

    /**
     * Mehtod for update glance section item information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function glanceItemUpdate(Request $request, $slug)
    {
        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'title_edit'     => "required|string|max:255",
            'number_edit'    => "required|numeric",
        ];

        $slug = Str::slug(SiteSectionConst::GLANCE_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

        $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "solution-edit");
        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function ($language) {
            return replace_array_key($language, "_edit");
        }, $language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;

        if ($request->hasFile("image")) {
            $section_values['items'][$request->target]['image']    = $this->imageValidate($request, "image", $section_values['items'][$request->target]['image'] ?? null);
        }

        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Information updated successfully!']]);
    }

    /**
     * Method for get languages form record with little modification for using only this class
     * @return array $languages
     */
    public function languages()
    {
        $languages = Language::whereNot('code', LanguageConst::NOT_REMOVABLE)->select("code", "name")->get()->toArray();
        $languages[] = [
            'name'      => LanguageConst::NOT_REMOVABLE_CODE,
            'code'      => LanguageConst::NOT_REMOVABLE,
        ];
        return $languages;
    }

    /**
     * Method for validate request data and re-decorate language wise data
     * @param object $request
     * @param array $basic_field_name
     * @return array $language_wise_data
     */
    public function contentValidate($request, $basic_field_name, $modal = null)
    {
        $languages = $this->languages();

        $current_local = get_default_language_code();
        $validation_rules = [];
        $language_wise_data = [];
        foreach ($request->all() as $input_name => $input_value) {
            foreach ($languages as $language) {
                $input_name_check = explode("_", $input_name);
                $input_lang_code = array_shift($input_name_check);
                $input_name_check = implode("_", $input_name_check);
                if ($input_lang_code == $language['code']) {
                    if (array_key_exists($input_name_check, $basic_field_name)) {
                        $langCode = $language['code'];
                        if ($current_local == $langCode) {
                            $validation_rules[$input_name] = $basic_field_name[$input_name_check];
                        } else {
                            $validation_rules[$input_name] = str_replace("required", "nullable", $basic_field_name[$input_name_check]);
                        }
                        $language_wise_data[$langCode][$input_name_check] = $input_value;
                    }
                    break;
                }
            }
        }
        if ($modal == null) {
            $validated = Validator::make($request->all(), $validation_rules)->validate();
        } else {
            $validator = Validator::make($request->all(), $validation_rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with("modal", $modal);
            }
            $validated = $validator->validate();
        }

        return $language_wise_data;
    }

    /**
     * Method for validate request image if have
     * @param object $request
     * @param string $input_name
     * @param string $old_image
     * @return boolean|string $upload
     */
    public function imageValidate($request, $input_name, $old_image)
    {
        if ($request->hasFile($input_name)) {
            $image_validated = Validator::make($request->only($input_name), [
                $input_name         => "image|mimes:png,jpg,webp,jpeg,svg",
            ])->validate();

            $image = get_files_from_fileholder($request, $input_name);
            $upload = upload_files_from_path_dynamic($image, 'site-section', $old_image);
            return $upload;
        }

        return false;
    }
}
