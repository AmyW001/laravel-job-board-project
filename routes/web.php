<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// main page
Route::get('/', [ListingController::class, 'index']);

//show 'create' form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// store listing data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// update listing (from edit page)
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// show single listing 
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// show register/create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//create new user
Route::post('/users', [UserController::class, 'store']);

// log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// log user in
Route::post('/users/authenticate', [UserController::class, 'authenticate']);



// WITHOUT CONTROLLER:

// All listings
// Route::get('/', function () {
//     return view('listings', [
//         'listings' => Listing::all(),
//     ]);
// });



// Single listing
// With route model binding
// Route::get('/listing/{listing}', function (Listing $listing) {
//     return view('listing', [
//         'listing' => $listing,
//     ]);
// });
// Alternative way for single listing: 
// Route::get('/listing/{id}', function ($id) {

//     $listing = Listing::find($id);

//     if (!$listing) {
//         abort(404);
//     }

//     return view('listing', [
//         'listing' => Listing::find($id),
//     ]);
// });






// // route examples, setting headers
// Route::get('/hello', function () {
//     return response("<h1>Hello World</h1>")
//         ->header('Content-Type', 'text/plain');
// });

// // route examples, setting wildcard endpoints
// // debugging options 
// // - dd(); die and dump
// // - ddd(); die and dump and debug
// Route::get('/post/{id}', function ($id) {
//     return response("This is post number " . $id);
// })->where('id', '[0-9]+');

// // get parameters out of query string
// // /search?name=brad
// Route::get('/search', function (Request $request) {
//     return ($request->name);
// });
