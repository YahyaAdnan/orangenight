<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    // dd($customerDetails = auth()->user()->salesMan->customers->pluck('id'));
});

Route::get('test/{agreement}', function (App\Models\Agreement $agreement) {
    $contract = $agreement->contract;
    return view('app.agreement.view', ['agreement' => $agreement, 'contract' => $contract]);
});
