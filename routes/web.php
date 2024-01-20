<?php


use App\Models\Video;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PuntuacionController;
use App\Http\Controllers\TokenPremiumController;
use App\Http\Controllers\DiasPremiumController;
use App\Http\Controllers\TransaccionesP2pController;



Route::get('/', [HomeController::class, 'index'])->name('home');

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

//criticas
Route::post('/criticas', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::get('/criticas/{comentario}/edit', [ComentarioController::class, 'edit'])->name('comentarios.edit');
Route::put('/criticas/{comentario}', [ComentarioController::class, 'update'])->name('comentarios.update');

Route::get('/videos/search', [VideoController::class, 'search'])->name('videos.search');

// token premium
Route::get('/generar-token', [TokenPremiumController::class, 'index'])->name('generar.token')->middleware('isRevendedor');
Route::post('/generar-token', [TokenPremiumController::class, 'store'])->name('generar.token')->middleware('isRevendedor');

// activar gasto de dias premium
Route::post('/videos/{video_id}/activar-dia-premium', [DiasPremiumController::class, 'gastarDiaPremium'])->name('activar-dia-premium');



// Rutas para comprar y vender días premium
Route::get('/comprar-dias-revendedor', [DiasPremiumController::class, 'index_comprar_dias_revendedor'])->name('comprar_dias_revendedor.index');

// Ruta para procesar la compra de días premium para revendedores
Route::post('/comprar-dias-revendedor', [DiasPremiumController::class, 'store_comprar_dias_revendedor'])->name('comprar_dias_revendedor.store');

// Ruta para mostrar el formulario de venta de días premium
Route::get('/vender-dias-premium', [DiasPremiumController::class, 'index_vender_dias_directo'])->name('vender_dias_directo.index');

// Ruta para procesar la venta de días premium
Route::post('/vender-dias-premium', [DiasPremiumController::class, 'store_vender_dias_directo'])->name('vender_dias_directo.store');


// transacciones p2p

Route::get('/seleccionar-revendedor', [TransaccionesP2pController::class, 'seleccionarRevendedor'])
    ->name('seleccionarRevendedor');

Route::get('/enviar-comprobante/{seller_id?}', [TransaccionesP2pController::class, 'index_envio_comprobante'])->name('envio_comprobante.index');

Route::post('/enviar-comprobante', [TransaccionesP2pController::class, 'store_envio_comprobante'])->name('envio_comprobante.store');

Route::get('/revisar-comprobante', [TransaccionesP2pController::class, 'show_transacciones'])->name('transacciones.show');

Route::delete('/cancelar-comprobante/{transaction}', [TransaccionesP2pController::class, 'cancelar_transacciones'])
    ->name('transacciones.cancelar');



// Mostrar perfil de revendedor
Route::get('/perfil/{slug}', [TransaccionesP2pController::class, 'mostrarPerfil'])
    ->name('perfilRevendedor');

//configuracion revendedor
Route::get('/configuracion-revendedor', [TransaccionesP2pController::class, 'index_configuracion_revendedor'])
    ->name('configuracion_revendedor.index');
Route::post('/configuracion-revendedor', [TransaccionesP2pController::class, 'store_configuracion_revendedor'])
    ->name('configuracion_revendedor.store');


// Mostrar formulario de métodos de pago
Route::get('/revendedor-metodos-pago', [TransaccionesP2pController::class, 'index_metodos_pago'])
    ->name('metodos_pago.index')
    ->middleware('auth'); 

Route::post('/revendedor-metodos-pago', [TransaccionesP2pController::class, 'store_metodos_pago'])
    ->name('metodos_pago.store')
    ->middleware('auth');

// editar perfil de revendedor
Route::post('/actualizar-perfil-revendedor', [TransaccionesP2pController::class, 'store_perfil_revendedor'])->name('perfil_revendedor.store');
Route::get('/actualizar-perfil-revendedor', [TransaccionesP2pController::class, 'index_perfil_revendedor'])->name('perfil_revendedor.index');


//puntuaciones
// Ruta para puntuar un video.
Route::post('/videos/{video}/puntuar', [PuntuacionController::class, 'store'])
    ->name('videos.puntuar')
    ->middleware('auth');

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