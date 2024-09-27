<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome(){
        return view('welcome');
    }

    public function privacyPolicy(){
        return view('front.privacy-policy');
    }

    public function termsAndConditions(){
        return view('front.terms-and-conditions');
    }
}
