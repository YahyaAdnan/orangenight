<?php

use Illuminate\Support\Facades\Route;
use Stevebauman\Location\Facades\Location;
use Illuminate\Http\Request;

// Route::get('/test', function (Request $request) {
//     // dd(request()->cookies->all());
// });

Route::get('agreement/{agreement}', function (App\Models\Agreement $agreement) {
    $contract = $agreement->contract;
    return view('app.agreement.view', ['agreement' => $agreement, 'contract' => $contract]);
})->name('agreements.show');
