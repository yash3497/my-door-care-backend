<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Admin\Language;
use App\Models\Admin\UsefulLink;
use App\Providers\Admin\BasicSettingsProvider;


class SiteController extends Controller
{
    public function index()
    {
        $page_title = "Home";
        $blogs = Blog::orderBy('id', "DESC")->paginate(2);
        return view('frontend.index', compact('page_title', 'blogs'));
    }
    public function about()
    {
        $page_title = 'About Us';
        return view('frontend.about', compact('page_title'));
    }
    public function services()
    {
        $page_title = 'Services';
        return view('frontend.services', compact('page_title'));
    }
    public function blog()
    {
        $page_title = 'Blog';
        $blogs = Blog::orderBy('id', "DESC")->paginate(12);

        return view('frontend.blog', compact('page_title', 'blogs'));
    }
    public function blogDetails($id, $slug)
    {
        $page_title = "Blog Details";
        $blog = Blog::where('id', $id)->where('slug', $slug)->first();
        $recentPost = Blog::where('id', "!=", $id)->latest()->limit(3)->get();
        return view('frontend.blog-details', compact('page_title', 'blog', 'recentPost'));
    }


    public function contact()
    {
        $page_title = 'Contact Us';
        return view('frontend.contact', compact('page_title'));
    }
    public function changeLanguage($lang = null)
    {
        session()->put('local', $lang);
        return back()->with(['success' => ['Language Switch Successfully']]);
    }

    public function usefullLink($slug)
    {
        $useful_link = UsefulLink::where("slug", $slug)->first();

        if (!$useful_link) abort(404);
        $basic_settings = BasicSettingsProvider::get();
        $app_local = get_default_language_code();
        $page_title = $useful_link->title?->language?->$app_local?->title ?? $basic_settings->site_name;
        return view('frontend.pages.useful-link', compact('page_title', 'useful_link'));
    }
}
