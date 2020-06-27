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

// Route::get('/', function () {
//     return view('index');
// });

// Route::get('/mitra', function () {
//     return view('mitra');
// });

Route::get('/', 'PagesController@home')->name('landing');

Route::group(['middleware' => 'auth'], function () {
    
    Route::resource('projek', 'ProjekController');
    // SAMA DENGAN (menghemat baris kode)
    // Route::get('projek', 'ProjekController@index')->name('projek.index');
    // Route::get('projek/create', 'ProjekController@create')->name('projek.create');
    // Route::post('projek', 'ProjekController@store')->name('projek.store');
    // Route::get('projek/{$id}', 'ProjekController@show')->name('projek.index');
    // Route::get('projek/{$id}/edit', 'ProjekController@edit')->name('projek.edit');
    // Route::patch('projek/{$id}', 'ProjekController@update')->name('projek.update');
    // Route::delete('projek/{$id}', 'ProjekController@delete')->name('projek.delete');

    Route::resource('provinsi', 'ProvinsiController');

    Route::resource('kategori', 'KategoriController');

    Route::resource('label', 'LabelController');

    Route::resource('permissions', 'PermissionController');

});

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {
    
    Route::get('/', 'DashboardController@dashboard')->name('dashboard');
    
    Route::resource('mitra', 'MitraController');
    Route::get('api-mitra', 'MitraController@apiMitra')->name('api.mitra');
    
    Route::resource('users', 'UserController');
    Route::get('api-users', 'UserController@apiUsers')->name('api.users');
    
    Route::resource('roles', 'RoleController');
    Route::get('api-roles', 'RoleController@apiRoles')->name('api.roles');

    Route::resource('permissions', 'PermissionController');
    Route::get('api-permissions', 'PermissionController@apiPermissions')->name('api.permissions');
    
    Route::get('roles-permissions', 'RolePermissionController@index')->name('roles-permissions.index');
});

Route::get('/pendaftaran', 'PendaftaranController@index');
Route::get('/pendaftaran/create', 'PendaftaranController@create')->name('frotn.projek.create');
Route::get('/pendaftaran/{id}', 'PendaftaranController@show');
Route::post('/pendaftaran', 'PendaftaranController@store');
Route::delete('/pendaftaran/{pendaftaran}', 'PendaftaranController@destroy');
Route::get('/pendaftaran/{pendaftaran}/edit', 'PendaftaranController@edit');
Route::patch('/pendaftaran/{pendaftaran}', 'PendaftaranController@update');

Route::get('/validasi', 'ValidasiController@index');
Route::get('/validasi/create', 'ValidasiController@create');
Route::get('/validasi/{id}', 'ValidasiController@show');
Route::post('/validasi', 'ValidasiController@store');

Route::get('/kota','KotaController@show')->name('kota.show');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
