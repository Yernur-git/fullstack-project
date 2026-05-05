<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        $supported = ['en', 'ru', 'kk'];

        if (in_array($locale, $supported)) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        return redirect()->back();
    }
}