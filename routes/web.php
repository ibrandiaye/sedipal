<?php

use App\Http\Controllers\HomeController;
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

Route::get('/','HomeController@home')->name('home');
Route::get('/detail/produit/{produit_id}','HomeController@getProduitDepotById')->name('detail.produit');
Route::resource('fournisseur',FournisseurController::class);
Route::resource('produit',ProduitController::class);
Route::resource('depot',DepotController::class);
Route::resource('entree',EntreeController::class);
Route::resource('client',ClientController::class);
Route::resource('sortie',SortieController::class);

