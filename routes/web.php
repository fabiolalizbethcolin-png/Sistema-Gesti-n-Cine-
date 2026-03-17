<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;

// =====================
// RUTAS PÚBLICAS - TODOS PUEDEN VER
// =====================
Route::get('/', [PeliculaController::class, 'inicio'])->name('inicio');
Route::get('/cartelera', [ClientController::class, 'cartelera'])->name('cliente.cartelera');
Route::get('/funciones-disponibles', [ClientController::class, 'funciones'])->name('cliente.funciones');

// =====================
// REGISTRO Y LOGIN (PÚBLICOS)
// =====================
Route::get('/register', fn() => view('register'))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================
// RUTAS PROTEGIDAS - SOLO USUARIOS REGISTRADOS
// =====================
Route::middleware(['auth'])->group(function () {
    // Compras y boletos
    Route::get('/comprar/{funcion}', [ClientController::class, 'comprar'])->name('cliente.comprar');
    Route::post('/comprar/{funcion}', [ClientController::class, 'guardarCompra'])->name('cliente.comprar.guardar');
    Route::get('/boletos', [ClientController::class, 'boletos'])->name('cliente.boletos');
    
    // Perfil de usuario (opcional)
    Route::get('/perfil', [ClientController::class, 'perfil'])->name('cliente.perfil');
    
    // Redirigir a cartelera después de login
    Route::get('/inicio', fn() => redirect()->route('cliente.cartelera'))->name('inicio.redirect');
});

// =====================
// RUTAS DE ADMIN - SOLO ADMINISTRADORES
// =====================
Route::middleware(['auth', 'admin'])->group(function () {
    // 🔴 NUEVA RUTA PARA EL DASHBOARD ADMIN
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Desbloquear usuarios
    Route::get('/admin/unban', [AdminController::class, 'unlockForm'])->name('admin.unbanForm');
    Route::post('/admin/unban', [AdminController::class, 'unlockUser'])->name('admin.unlockUser');

    // CRUD Películas (usa las vistas existentes en /peliculas)
    Route::resource('peliculas', PeliculaController::class);
    Route::post('/peliculas/restore/{id}', [PeliculaController::class, 'restore'])->name('peliculas.restore');

    // CRUD Funciones (usa las vistas existentes en /funciones)
    Route::resource('funciones', FuncionController::class);

    // Activar / Desactivar Funciones
    Route::patch('funciones/{id}/activar', [FuncionController::class, 'activar'])->name('funciones.activar');
    Route::patch('funciones/{id}/desactivar', [FuncionController::class, 'desactivar'])->name('funciones.desactivar');
});

// =====================
// PRUEBA LOG
// =====================
Route::get('/prueba-log', function () {
    \Log::info('Probando log');
    return 'listo';
});