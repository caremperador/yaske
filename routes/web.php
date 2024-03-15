<?php


use App\Models\Video;
use App\Models\DiasPremiumUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ApiTMDBController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\PuntuacionController;
use App\Http\Controllers\DiasPremiumController;
use App\Http\Controllers\TokenPremiumController;
use App\Http\Controllers\EstructuraWebController;
use App\Http\Controllers\TransaccionesP2pController;
use App\Http\Controllers\UsuariosCompradoresController;
use App\Http\Controllers\AdminConfiguracionPaisController;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('responseCache:60');
Route::get('/proximamente', function () {
    return view('paginaProximamente');
})->name('proximamente');



Route::controller(VideoController::class)->group(function () {
    Route::get('/videos', 'index')->name('videos.index');
    Route::get('/videos/create', 'create')->name('videos.create')->middleware('auth');
    Route::post('/videos', 'store')->name('videos.store')->middleware('auth');
    Route::get('/video/{video}', 'show')->name('videos.show');
    Route::get('/videos/{video}/edit', 'edit')->name('videos.edit')->middleware('auth');
    Route::put('/videos/{video}', 'update')->name('videos.update')->middleware('auth');
    Route::get('/video/mostrar/{video}/{idioma}', 'mostrarVideo')->name('videos.mostrarVideo');
    Route::get('/capitulos/crear', 'createCapitulos')->name('capitulos.create');
    Route::post('/capitulos/crear', 'storeCapitulos')->name('capitulos.store');
    Route::post('/videos/reportar-enlace/{video}', 'reportarEnlaceCaido')->name('reportar.enlace');
    Route::get('/videos/enlaces-caidos', 'mostrarVideosConEnlacesCaidos')->name('videos.enlaces_caidos')->middleware('auth');
    Route::delete('/enlace-caido/{enlace}', 'deleteEnlaceCaido')->name('delete.enlaceCaido')->middleware('auth');
    Route::get('/premium', 'vistapremium')->name('premium');
});



Route::controller(ApiTMDBController::class)->group(function () {
    Route::get('/buscar-pelicula-tmdb/{id}', 'buscarPeliculaTMDB');
    Route::get('/buscar-serie-tmdb/{id}', 'buscarSerieTMDB');
});

// Puedes añadir rutas adicionales para las listas si aún no las tienes
Route::controller(ListaController::class)->group(function () {
    Route::get('/listas', 'index')->name('listas.index');
    Route::get('/listas/create', 'create')->name('listas.create')->middleware('auth');
    Route::post('/listas', 'store')->name('listas.store')->middleware('auth');
    Route::get('/listas/{lista}', 'show')->name('listas.show');
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
    Route::get('/tipos/video/{tipoSlug}', 'show')->name('tipos.show');
    Route::get('/tipo/{tipoSlug}/{categoria?}', 'show_con_listas')->name('tipos.show_con_listas');
});


Route::get('/estrenos-gratis', [VideoController::class, 'estrenosGratis'])->name('videos.estrenos_gratis');

//criticas
Route::post('/criticas', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::get('/criticas/{comentario}/edit', [ComentarioController::class, 'edit'])->name('comentarios.edit');
Route::put('/criticas/{comentario}', [ComentarioController::class, 'update'])->name('comentarios.update');

Route::get('/videos/search', [VideoController::class, 'search'])->name('videos.search');
Route::get('/todos-los-videos', [VideoController::class, 'admin_todos_los_videos'])->name('admin.todos_los_videos');
Route::post('/video/{video}', [VideoController::class, 'destroy'])->name('admin.video_delete');

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
    ->name('seleccionarRevendedor')->middleware('auth');

Route::get('/seleccionar-revendedor/filtrar', [TransaccionesP2pController::class, 'seleccionarRevendedorFiltrado'])->name('seleccionarRevendedorFiltrado');
Route::get('/enviar-comprobante/{seller_id?}', [TransaccionesP2pController::class, 'index_envio_comprobante'])->name('envio_comprobante.index')->middleware('auth');

Route::post('/enviar-comprobante', [TransaccionesP2pController::class, 'store_envio_comprobante'])->name('envio_comprobante.store')->middleware('auth');

Route::get('/revisar-comprobante', [TransaccionesP2pController::class, 'show_transacciones'])->name('transacciones.show')->middleware('isRevendedor');


Route::post('/conectar-desconectar', [TransaccionesP2pController::class, 'conectarDesconectar'])
    ->name('conectar.desconectar')
    ->middleware('isRevendedor');



// Mostrar perfil de revendedor
Route::get('/perfil/{slug}', [TransaccionesP2pController::class, 'mostrarPerfil'])
    ->name('perfilRevendedor');

//configuracion revendedor
Route::get('/configuracion-revendedor', [TransaccionesP2pController::class, 'index_configuracion_revendedor'])
    ->name('configuracion_revendedor.index')->middleware('isRevendedor');
Route::post('/configuracion-revendedor', [TransaccionesP2pController::class, 'store_configuracion_revendedor'])
    ->name('configuracion_revendedor.store')->middleware('isRevendedor');


// Mostrar formulario de métodos de pago
Route::get('/revendedor-metodos-pago', [TransaccionesP2pController::class, 'index_metodos_pago'])
    ->name('metodos_pago.index')
    ->middleware('isRevendedor');

Route::post('/revendedor-metodos-pago', [TransaccionesP2pController::class, 'store_metodos_pago'])
    ->name('metodos_pago.store')
    ->middleware('isRevendedor');

// editar perfil de revendedor
Route::post('/actualizar-perfil-revendedor', [TransaccionesP2pController::class, 'store_perfil_revendedor'])->name('perfil_revendedor.store')->middleware('isRevendedor');
Route::get('/actualizar-perfil-revendedor', [TransaccionesP2pController::class, 'index_perfil_revendedor'])->name('perfil_revendedor.index')->middleware('isRevendedor');


Route::get('/actualizar-foto-perfil', [UsuariosCompradoresController::class, 'index_cambiar_foto_perfil'])
    ->name('cambiar_foto_perfil.index')
    ->middleware('auth');
Route::post('/actualizar-foto-perfil', [UsuariosCompradoresController::class, 'store_cambiar_foto_perfil'])
    ->name('cambiar_foto_perfil.store')
    ->middleware('auth');
Route::get('/dashboard-profil', [EstructuraWebController::class, 'index'])
    ->name('dashboard-profil.index')
    ->middleware('auth');

// Rutas para la configuración de precios por país por parte del administrador

Route::get('/configuracion-pais', [AdminConfiguracionPaisController::class, 'index'])->name('admin.configuracion.pais');
Route::post('/configuracion-pais', [AdminConfiguracionPaisController::class, 'store'])->name('admin.configuracion.pais.store');


// Ruta para aprobar una transacción
Route::post('/transacciones/aprobar/{transaction}', [DiasPremiumController::class, 'aprobarTransaccion'])->name('transacciones.aprobar')->middleware('isRevendedor');

Route::post('/transacciones/cancelar/{transaction}', [DiasPremiumController::class, 'cancelarTransaccionCliente'])->name('transacciones.cancelar');
Route::post('/transacciones/rechazar/{transaction}', [DiasPremiumController::class, 'rechazarTransaccion'])->name('transacciones.rechazar')->middleware('isRevendedor');

Route::get('/transacciones/rechazadas', [DiasPremiumController::class, 'verTransaccionesRechazadas'])->name('transacciones.rechazadas');
Route::get('/transacciones/aprobadas', [DiasPremiumController::class, 'verTransaccionesAprobadas'])->name('transacciones.aprobadas');


// Ruta para rechazar una transacción
Route::get('/transacciones/comprobante/{transaction}', [DiasPremiumController::class, 'estadoTransaccion'])->name('transacciones.estado');

//transaccion aprobada
Route::get('/transaccion-aprobada', [DiasPremiumController::class, 'transaccionAprobada'])->name('transaccion.aprobada')->middleware('auth');


// Route::get('/netflix/peliculas-{categoria}', [NetflixController::class, 'peliculasCategoria'])->name('netflix.peliculas-categoria');

Route::get('/{tipo}/{plataforma?}/{categoria?}', [PlataformaController::class, 'filtrarVideosPorTipoYCategoria'])->name('videos.filtrar')->middleware('responseCache:60');




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
