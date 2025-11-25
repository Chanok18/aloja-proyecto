<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

   
#RUTAS PuBLICAS * sin logearse *
// Pagina principal con busqueda de hospedajes
Route::get('/', [App\Http\Controllers\HospedajePublicoController::class, 'index'])->name('home');
Route::get('/hospedajes', [App\Http\Controllers\HospedajePublicoController::class, 'index'])->name('hospedajes.publico.index');
// Detalle de un hospedaje específico
Route::get('/hospedajes/{id}', [App\Http\Controllers\HospedajePublicoController::class, 'show'])->name('hospedajes.publico.show');

require __DIR__.'/auth.php';
// RUTAS DEL CHATBOT (NUEVO)
Route::post('/chatbot/mensaje', [App\Http\Controllers\ChatbotController::class, 'enviarMensaje'])
    ->name('chatbot.mensaje');
Route::get('/chatbot/historial', [App\Http\Controllers\ChatbotController::class, 'obtenerHistorial'])
    ->name('chatbot.historial');
 

#RUTAS DE RESERVAS *debe logearse*
Route::middleware(['auth'])->group(function () {
    
    //Crear una nueva reserva
    Route::post('/reservas', [App\Http\Controllers\ReservaController::class, 'store'])->name('reservas.store');
    
    //Ver confirmacion de reserva
    Route::get('/reservas/confirmacion/{id}', [App\Http\Controllers\ReservaController::class, 'confirmacion'])->name('reservas.confirmacion');
    
    //Lista de mis reservas
    Route::get('/mis-reservas', [App\Http\Controllers\ReservaController::class, 'misReservas'])->name('reservas.mis-reservas');
    
    //Cancelar una reserva
    Route::post('/reservas/{id}/cancelar', [App\Http\Controllers\ReservaController::class, 'cancelar'])->name('reservas.cancelar');
});


//RUTAS DE PAGOS *dbe logearse*
Route::middleware(['auth'])->group(function () {
    
    // Formulario de pago
    Route::get('/pagos/crear/{reserva}', [App\Http\Controllers\PagoController::class, 'create'])->name('pagos.create');
    
    // Procesar pago
    Route::post('/pagos', [App\Http\Controllers\PagoController::class, 'store'])->name('pagos.store');
    
    Route::get('/pagos/exito/{pago}', [App\Http\Controllers\PagoController::class, 'success'])->name('pagos.success');
});


// DASHBOARD GENERAL (Redirige según rol)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        // Redirigir automáticamente según el rol
        if ($user->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->rol === 'anfitrion') {
            return redirect()->route('anfitrion.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');
    
    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//RUTAS PARA ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard del admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // CRUD de hospedajes
    Route::resource('hospedajes', \App\Http\Controllers\Admin\AdminHospedajeController::class);

    // Gestión de fotos de hospedajes (NUEVO)
    Route::delete('hospedajes/{hospedaje}/fotos/{foto}', [\App\Http\Controllers\Admin\AdminHospedajeController::class, 'eliminarFoto'])
        ->name('hospedajes.fotos.eliminar');
    Route::patch('hospedajes/{hospedaje}/fotos/{foto}/principal', [\App\Http\Controllers\Admin\AdminHospedajeController::class, 'marcarPrincipal'])
        ->name('hospedajes.fotos.principal');
    
    // CRUD de reservas
    Route::resource('reservas', \App\Http\Controllers\Admin\AdminReservaController::class);
    
    //CRUD de pagos
    Route::resource('pagos', \App\Http\Controllers\Admin\AdminPagoController::class);
    
    //CRUD de reseñas
    Route::resource('resenas', \App\Http\Controllers\Admin\AdminResenaController::class);
});

//RUTAS PARA ANFITRION
Route::middleware(['auth', 'role:anfitrion'])->prefix('anfitrion')->name('anfitrion.')->group(function () {
    
    // Dashboard del anfitrión
    Route::get('/dashboard', function () {
        return view('anfitrion.dashboard');
    })->name('dashboard');
    
    // Gestión de fotos de hospedajes (NUEVO)
    Route::delete('hospedajes/{hospedaje}/fotos/{foto}', [\App\Http\Controllers\Anfitrion\AnfitrionHospedajeController::class, 'eliminarFoto'])
        ->name('hospedajes.fotos.eliminar');
    Route::patch('hospedajes/{hospedaje}/fotos/{foto}/principal', [\App\Http\Controllers\Anfitrion\AnfitrionHospedajeController::class, 'marcarPrincipal'])
        ->name('hospedajes.fotos.principal');

    Route::get('/reservas', [\App\Http\Controllers\Anfitrion\AnfitrionReservaController::class, 'index'])
        ->name('reservas.index');
    
    Route::get('/reservas/{id}', [\App\Http\Controllers\Anfitrion\AnfitrionReservaController::class, 'show'])
        ->name('reservas.show');
    // CRUD de sus propios hospedajes
    Route::resource('hospedajes', \App\Http\Controllers\Anfitrion\AnfitrionHospedajeController::class);

    // Ver reservas de sus hospedajes
    Route::get('/reservas', [\App\Http\Controllers\Anfitrion\AnfitrionReservaController::class, 'index'])
        ->name('reservas.index');
    
    // Ver detalle de una reserva
    Route::get('/reservas/{id}', [\App\Http\Controllers\Anfitrion\AnfitrionReservaController::class, 'show'])
        ->name('reservas.show');
});


//RUTAS PARA VIAJERO
Route::middleware(['auth', 'role:viajero'])->prefix('viajero')->name('viajero.')->group(function () {
    
    //Dashboard del viajero
    Route::get('/dashboard', function () {
        return view('viajero.dashboard');
    })->name('dashboard');
});