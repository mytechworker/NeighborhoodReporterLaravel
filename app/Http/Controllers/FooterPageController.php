<?php

namespace App\Http\Controllers;

use App\Page;
use App\PressRelease;
use Illuminate\Http\Request;

class FooterPageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug','About')->first();
        $press_releases = PressRelease::get();
        if((count(array($page)) > 0 ) || count(array($press_releases)) > 0)
        {
            return view('about',compact('page','press_releases'));
        }
    }

    public function community_guidelines()
    {
        $page = Page::where('slug','community-guidelines')->first();
        return view('community_guidelines',compact('page'));
    }

    public function posting_instructions()
    {
        $page = Page::where('slug','posting-instructions')->first();
        return view('posting_instructions',compact('page'));
    }

    public function terms()
    {
        $page = Page::where('slug','terms')->first();
        return view('terms',compact('page'));
    }

    public function privacy()
    {
        $page = Page::where('slug','privacy')->first();
        return view('privacy',compact('page'));
    }

    public function contact_us()
    {
        $page = Page::where('slug','contact-us')->first();
        return view('contact_us',compact('page'));
    }
}
