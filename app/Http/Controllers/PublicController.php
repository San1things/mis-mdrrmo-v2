<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home(){
        return view('home');
    }
    public function about(){
        return view('about');
    }
    public function announcements(){
        return view('announcements');
    }
    public function faqs(){
        return view('faq');
    }
}
