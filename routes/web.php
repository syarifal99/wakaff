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

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['middleware' => 'auth'], function () {
    
    Route::resource('projek', 'ProjekController');
    
    Route::get('donasi/{id}/{jenis}', 'DonasiController@create')->name('donasi.create');
    Route::post('donasi', 'DonasiController@store')->name('donasi.store');

    Route::resource('provinsi', 'ProvinsiController');

    Route::resource('kota', 'KotaController');

    Route::resource('kategori', 'KategoriController');

    Route::resource('label', 'LabelController');

    Route::resource('permissions', 'PermissionController');

});

// Route::group(['prefix' => 'dashboard', 'middleware' => ['role:admin']], function () {
// Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'role:admin']], function () {
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {

    Route::get('/', 'DashboardController@dashboard')->name('dashboard');

    Route::group(['middleware' => 'role:admin|superadmin|mitra'], function () {


        Route::resource('mitra', 'MitraController');
        Route::get('api-mitra', 'MitraController@apiMitra')->name('api.mitra');

        Route::get('project/get-all', 'ProjectController@getAll')->name('project.getAll');
        Route::resource('project', 'ProjectController');
        Route::get('api-project', 'ProjectController@apiProject')->name('api.project');
        Route::get('project/{id}/export-pdf', 'ProjectController@exportPDF')->name('project.export.pdf');

        Route::get('project/validasi/{id}', 'ValidasiController@validasi');

        Route::resource('pendanaan', 'PendanaanController');
        Route::get('pendanaan/aset/yoii','PendanaanController@pendanaanaset')->name('pendanaan.aset');
        Route::get('api-pendanaan-aset', 'PendanaanController@apiPendanaanaset')->name('api.pendanaanaset');

        Route::get('api-pendanaan', 'PendanaanController@apiPendanaan')->name('api.pendanaan');
        Route::get('api-pendanaan-admin', 'PendanaanController@admintai')->name('api.pendanaan.admin');

        Route::get('api-pendanaan-tai', 'PendanaanController@apiPendanaanaset')->name('api.pendanaan-tai');
        Route::get('api-pendanaan-admin-tai', 'PendanaanController@adminsupertai')->name('api.pendanaan.admin-tai');

        Route::post('api-pencairan/{id}/update-status', 'PencairanController@updateStatus')->name('api.pencairan.updateStatus');
        Route::resource('pencairan', 'PencairanController');
        Route::get('api-pencairan', 'PencairanController@apipencairan')->name('api.pencairan');
        Route::get('api-mitra-pencairan/{id}', 'PencairanController@apiMitraPencairan')->name('api.mitrapencairan');
        route::get('pencairan/mitra/{id}','PencairanController@mitra');

        Route::resource('progres', 'ProgresController');
        Route::get('api-progres', 'ProgresController@apipencairan')->name('api.progres');

        Route::get('progres/aset/yoii','ProgresController@progresaset')->name('progres.aset');
        Route::get('api-progres-aset', 'ProgresController@apiProgresaset')->name('api.progresaset');

        Route::resource('monitoring', 'MonitoringController');
        Route::get('api-monitoring', 'MonitoringController@apiMonitoring')->name('api.monitoring');

        Route::resource('users', 'UserController');
        Route::get('api-users', 'UserController@apiUsers')->name('api.users');

        Route::get('kabar/get-all', 'KabarController@getAll')->name('kabar.getAll');
        Route::post('kabar/image/upload', 'KabarController@uploadImage')->name('kabar.image');
        Route::get('kabar/{id}','KabarController@index');
        Route::resource('kabar', 'KabarController');
        Route::get('api-kabar', 'KabarController@apiKabar')->name('api.kabar');

        Route::resource('roles', 'RoleController');
        Route::get('api-roles', 'RoleController@apiRoles')->name('api.roles');

        Route::resource('permissions', 'PermissionController');
        Route::get('api-permissions', 'PermissionController@apiPermissions')->name('api.permissions');

        Route::get('roles-permissions', 'RolePermissionController@index')->name('roles-permissions.index');
    });
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
