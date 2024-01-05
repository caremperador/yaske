<?php


use App\Models\Video;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CategoriaController;


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

Route::get('/',[HomeController::class,'index'])->name('home');

Route::controller(VideoController::class)->group(function () {
    Route::get('/videos', 'index')->name('videos.index');
    Route::get('/videos/create', 'create')->name('videos.create')->middleware('auth');
    Route::post('/videos', 'store')->name('videos.store')->middleware('auth');
    Route::get('/video/{video}', 'show')->name('videos.show')->middleware('auth');
});

// Puedes añadir rutas adicionales para las listas si aún no las tienes
Route::controller(ListaController::class)->group(function () {
    Route::get('/listas', 'index')->name('listas.index');
    Route::get('/listas/create', 'create')->name('listas.create')->middleware('auth');
    Route::post('/listas', 'store')->name('listas.store')->middleware('auth');
    Route::get('/listas/{lista}', 'show')->name('listas.show')->middleware('auth');
});


// Puedes añadir más rutas relacionadas con categorías aquí
Route::controller(CategoriaController::class)->group(function () {
    Route::get('/categorias', 'index')->name('categorias.index')->middleware('auth');
    Route::get('/categorias/create', 'create')->name('categorias.create')->middleware('auth');
    Route::post('/categorias', 'store')->name('categorias.store')->middleware('auth');
});

// Puedes añadir más rutas relacionadas con tipos aquí
Route::controller(TipoController::class)->group(function () {
    Route::get('/tipos', 'index')->name('tipos.index')->middleware('auth');
    Route::get('/tipos/create', 'create')->name('tipos.create')->middleware('auth');
    Route::post('/tipos', 'store')->name('tipos.store')->middleware('auth');
    Route::get('/tipos/video/{tipoSlug}', 'show')->name('tipos.show')->middleware('auth');
    Route::get('/tipos/lista/{tipoSlug}', 'show_con_listas')->name('tipos.show_con_listas')->middleware('auth');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

    
    // Route::get('/v/{video}', 'edit')->name('videos.edit')->middleware('auth');
    // Route::get('/v/{video}', 'update')->name('videos.update')->middleware('auth');