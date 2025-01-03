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

Route::get('deliveries/{delivery}', function (App\Models\Delivery $delivery) {
    if($delivery->status != 'deliveries')
    return view('app.deliveries.view', ['delivery' => $delivery]);
})->name('deliveries.show');

Route::get('receipt/{receipt}', function (App\Models\Receipt $receipt) {
    return view('app.receipt.view', ['receipt' => $receipt]);
})->name('receipt.show');


// Route::get('receipt/{receipt}', function (App\Models\Receipt $receipt) {
//     return view('app.receipt.view', ['receipt' => $receipt]);
// })->name('receipt.show');