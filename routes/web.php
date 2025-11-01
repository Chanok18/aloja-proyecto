<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Ruta pública (Home/Landing)
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación (Login, Register, etc.)
require __DIR__.'/auth.php';

// ========================================
// RUTAS PARA USUARIOS AUTENTICADOS
// ========================================

// Dashboard general (todos los usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        // Redirigir según el rol
        if ($user->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->rol === 'anfitrion') {
            return redirect()->route('anfitrion.dashboard');
        }
        
        return redirect()->route('viajero.dashboard');
    })->name('dashboard');
    
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================================
// RUTAS PARA ADMINISTRADOR
// ========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // CRUD Hospedajes (Admin ve TODOS)
    Route::resource('hospedajes', \App\Http\Controllers\Admin\AdminHospedajeController::class);
    
    // CRUD Reservas
    Route::get('/reservas', function () {
        return view('admin.reservas.index');
    })->name('reservas.index');
    
    // CRUD Pagos
    Route::get('/pagos', function () {
        return view('admin.pagos.index');
    })->name('pagos.index');
    
    // CRUD Reseñas
    Route::get('/resenas', function () {
        return view('admin.resenas.index');
    })->name('resenas.index');
    
    // Gestión de usuarios
    Route::get('/usuarios', function () {
        return view('admin.usuarios.index');
    })->name('usuarios.index');
});

// ========================================
// RUTAS PARA ANFITRIÓN
// ========================================
Route::middleware(['auth', 'role:anfitrion'])->prefix('anfitrion')->name('anfitrion.')->group(function () {
    
    // Dashboard Anfitrión
    Route::get('/dashboard', function () {
        return view('anfitrion.dashboard');
    })->name('dashboard');
    
    // Gestión de SUS hospedajes
    Route::get('/mis-hospedajes', function () {
        return view('anfitrion.hospedajes.index');
    })->name('hospedajes.index');
    
    // Ver reservas de sus propiedades
    Route::get('/reservas', function () {
        return view('anfitrion.reservas.index');
    })->name('reservas.index');
});

// ========================================
// RUTAS PARA VIAJERO
// ========================================
Route::middleware(['auth', 'role:viajero'])->prefix('viajero')->name('viajero.')->group(function () {
    
    // Dashboard Viajero
    Route::get('/dashboard', function () {
        return view('viajero.dashboard');
    })->name('dashboard');
    
    // Buscar hospedajes
    Route::get('/buscar', function () {
        return view('viajero.buscar');
    })->name('buscar');
    
    // Mis reservas
    Route::get('/mis-reservas', function () {
        return view('viajero.reservas.index');
    })->name('reservas.index');
    
    // Mis favoritos
    Route::get('/favoritos', function () {
        return view('viajero.favoritos');
    })->name('favoritos');
});