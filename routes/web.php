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



// Rutas para comprar y vender días premium
Route::get('/comprar-dias-revendedor', [DiasPremiumController::class, 'showForm'])->name('diaspremium.showForm');

// Ruta para procesar la compra de días premium para revendedores
Route::post('/comprar-dias-revendedor', [DiasPremiumController::class, 'comprarDiasRevendedor'])->name('diaspremium.comprarDiasRevendedor');

// Ruta para mostrar el formulario de venta de días premium
Route::get('/vender-dias-premium', [DiasPremiumController::class, 'showSellForm'])->name('diaspremium.showSellForm');

// Ruta para procesar la venta de días premium
Route::post('/vender-dias-premium', [DiasPremiumController::class, 'venderDiasPremium'])->name('diaspremium.venderDiasPremium');

// activar gasto de dias premium
Route::post('/videos/{video_id}/activar-dia-premium', [DiasPremiumController::class, 'gastarDiaPremium'])->name('activar-dia-premium');


// transacciones p2p

Route::get('/seleccionar-revendedor', [TransaccionesP2pController::class, 'seleccionarRevendedor'])
    ->name('seleccionarRevendedor');

Route::get('/enviar-comprobante/{seller_id?}', [TransaccionesP2pController::class, 'index'])->name('photo.form');

Route::post('/enviar-comprobante', [TransaccionesP2pController::class, 'uploadPhotoUsuario'])->name('enviarComprobante.store');

Route::get('/revisar-comprobante', [TransaccionesP2pController::class, 'showTransaccionesVendedor'])->name('revisarComprobante');

Route::delete('/cancelar-comprobante/{transaction}', [TransaccionesP2pController::class, 'cancelarTransaccion'])
    ->name('cancelarComprobante.destroy');

Route::get('/perfil/{slug}', [TransaccionesP2pController::class, 'mostrarPerfil'])
    ->name('perfilRevendedor');


Route::get('/configuracion-revendedor', [TransaccionesP2pController::class, 'mostrarConfiguracion'])
    ->name('revendedor.configuracion');
Route::post('/configuracion-revendedor', [TransaccionesP2pController::class, 'guardarConfiguracion'])
    ->name('revendedor.configuracion.guardar');

// Mostrar formulario de métodos de pago
Route::get('/revendedor-metodos-pago', [TransaccionesP2pController::class, 'mostrarFormularioMetodosPago'])
    ->name('metodosPago')
    ->middleware('auth'); // Asegúrate de que solo los usuarios autenticados puedan acceder

// Procesar y guardar los métodos de pago
Route::post('/revendedor-metodos-pago', [TransaccionesP2pController::class, 'metodosPagoRevendedor'])
    ->name('metodosPago.guardar')
    ->middleware('auth');


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