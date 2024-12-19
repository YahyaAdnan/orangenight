<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test/{agreement}', function (App\Models\Agreement $agreement) {
    $contract = $agreement->contract;
    return view('app.agreement.view', ['agreement' => $agreement, 'contract' => $contract]);
});
