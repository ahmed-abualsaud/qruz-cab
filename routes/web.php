<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/search', function () {

    $args['user_id'] = 1;
    $args['payment_method'] = "CASH";
    $args['s_address'] = "source address";
    $args['s_latitude'] = 30.35;
    $args['s_longitude'] = 30.35;
    $args['d_address'] = "destination address";
    $args['d_latitude'] = 30.35;
    $args['d_longitude'] = 30.35;

    $cabRequest = new App\Models\CabRequest;
    $cabRequestRepository = new App\Repository\Eloquent\Mutations\CabRequestRepository($cabRequest);
    return $cabRequestRepository->search($args);
});

Route::get('/accept', function () {

    $args['id'] = 1;
    $args['driver_id'] = 1;
    $args['vehicle_id'] = 1;

    $cabRequest = new App\Models\CabRequest;
    $cabRequestRepository = new App\Repository\Eloquent\Mutations\CabRequestRepository($cabRequest);
    return $cabRequestRepository->accept($args);
});

Route::get('/cancel', function () {

    $args['id'] = 1;
    $args['cancelled_by'] = 'driver';
    $args['cancel_reason'] = 'unknowen';

    $cabRequest = new App\Models\CabRequest;
    $cabRequestRepository = new App\Repository\Eloquent\Mutations\CabRequestRepository($cabRequest);
    return $cabRequestRepository->cancel($args);
});

Route::get('/arrived', function () {

    $args['id'] = 1;

    $cabRequest = new App\Models\CabRequest;
    $cabRequestRepository = new App\Repository\Eloquent\Mutations\CabRequestRepository($cabRequest);
    return $cabRequestRepository->arrived($args);
});

Route::get('/start', function () {

    $args['id'] = 1;

    $cabRequest = new App\Models\CabRequest;
    $cabRequestRepository = new App\Repository\Eloquent\Mutations\CabRequestRepository($cabRequest);
    return $cabRequestRepository->start($args);
});

Route::get('/end', function () {

    $args['id'] = 1;

    $cabRequest = new App\Models\CabRequest;
    $cabRequestRepository = new App\Repository\Eloquent\Mutations\CabRequestRepository($cabRequest);
    return $cabRequestRepository->end($args);
});

Route::get('/test', function () {

    //return App\Models\Driver::select('id', 'device_id')->whereIn('id', [1,2])->pluck('device_id');
    $temp = DB::table('cab_requests')
    ->where('id', 1)
    ->tap(function ($string) use (&$data) {
        $data = $string->get();
    })
    ->update(['status' => 'SEARCHING']);

    return $temp;

    return $data;
});
