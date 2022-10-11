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

Route::get('/','DashboardController@home')->name('home');
Route::get('/detail/produit/{produit_id}','DashboardController@getProduitDepotById')->name('detail.produit');
Route::get('/undepot/{id}','DashboardController@getByDepot')->name('un.depot');
Route::get('/facture/sortie','FactureController@fac')->name('facture.fac');
Route::resource('fournisseur',FournisseurController::class);
Route::resource('produit',ProduitController::class);
Route::resource('depot',DepotController::class);
Route::resource('entree',EntreeController::class);
Route::resource('client',ClientController::class);
Route::resource('sortie',SortieController::class);
Route::resource('retour',RetourController::class);
Route::resource('transfert',TransfertController::class);
Route::resource('chauffeur',ChauffeurController::class);
Route::middleware(['auth', 'admin'])->group(function(){
    Route::get('/user/{user}/edit', 'Auth\RegisterController@edit')->name('user.edit');
    Route::patch('/user/{user}', 'Auth\RegisterController@update')->name('user.update');
    Route::get('/user', 'Auth\RegisterController@index')->name('user.index');
    Route::delete('/user/{user}', 'Auth\RegisterController@delete')->name('user.destroy');
});

Auth::routes();
Route::post('/stock/produit','DashboardController@getProduitDepotByIdBetweenToDate')->name('detail.produit.between.to.date');

Route::post('/json/chauffeur', 'ChauffeurController@storeJson')->name('json.chauffeur.store');
Route::post('/json/fournisseur', 'FournisseurController@storeJson')->name('json.fournisseur.store');
Route::post('/json/client', 'ClientController@storeJson')->name('json.client.store');

Route::post('/chercher/produit', 'DashboardController@chercherProduit')->name('chercher.produit');
Route::post('/chercher/sortie/date', 'SortieController@getByDateAndClient')->name('date.client.sortie');
Route::get('/valider/transfert/{id}','TransfertController@valide')->name('valider.transfert');
Route::get('/non-valider/transfert','TransfertController@allTansfertForMyDepotNoValidate')->name('nonvalider.transfert');

Route::get('/chercher/produit/{id}', 'DashboardController@chercherProduitGet')->name('get.chercher.produit');

Route::get('/get/by/facture/{facture_id}', 'SortieController@getByFacture')->name('get.by.facture');

Route::post('/storeRetourFacture', 'RetourController@storeRetourFacture')->name('facture.retour.store');

Route::get('/facture/{facture_id}', 'FactureController@getById')->name('facture.show');
Route::get('/impression/facture/{facture_id}', 'FactureController@impression')->name('facture.impression');

