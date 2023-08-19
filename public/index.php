<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use MVC\Router;

$router = new Router();

// AREA PUBLICA
// Iniciar Sesion
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);
// Recuperar Password
$router->get('/forgot', [LoginController::class, 'olvide']);
$router->post('/forgot', [LoginController::class, 'olvide']);
$router->get('/recover', [LoginController::class, 'recuperar']);
$router->post('/recover', [LoginController::class, 'recuperar']);
// Crear cuenta
$router->get('/create-account', [LoginController::class, 'crear']);
$router->post('/create-account', [LoginController::class, 'crear']);
// Confirmar cuenta
$router->get('/confirm-account', [LoginController::class, 'confirmar']);
$router->get('/no-confirm-account', [LoginController::class, 'mensaje']);

//AREA PRIVADA
$router->get('/appointment', [CitaController::class, 'index']);

// API de citas
$router->get('/api/servicios', [APIController::class, 'index']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();