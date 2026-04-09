<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// UsuarioController (registro, login, perfil, etc.)
$routes->get('/usuario/inicio', 'UsuarioController::inicio');


$routes->get('/usuario/login', 'UsuarioController::login');
$routes->post('/usuario/iniciarSesion', 'UsuarioController::iniciarSesion');
$routes->get('/usuario/principal', 'UsuarioController::principal');
$routes->get('/usuario/cerrarSesion', 'UsuarioController::cerrarSesion');
$routes->get('/usuario/perfil', 'UsuarioController::perfil');
$routes->get('/usuario/doctores', 'UsuarioController::doctores');
$routes->get('/usuario/servicios', 'UsuarioController::servicios');
$routes->get('/usuario/politica_privacidad', 'UsuarioController::politica_privacidad');
$routes->get('/usuario/cambiarPass', 'UsuarioController::cambiarPass');
$routes->post('/usuario/actualizarPass', 'UsuarioController::actualizarPass');

// ContraseñaController (recuperación de contraseña)
$routes->get('/usuario/recuperar', 'ContraseñaController::recuperar');
$routes->post('/usuario/enviarRecuperacion', 'ContraseñaController::enviarRecuperacion');
$routes->get('/usuario/restablecer/(:any)', 'ContraseñaController::restablecer/$1');
$routes->post('/usuario/guardarNuevaContrasena', 'ContraseñaController::guardarNuevaContrasena');

// Prueba de correo
$routes->get('/usuario/probarCorreo', 'ContraseñaController::probarCorreo');


$routes->get('/', 'UsuarioController::inicio');

// Mostrar formulario de registro
$routes->get('/usuario/registro', 'UsuarioController::registro');

// Procesar el formulario de registro
$routes->post('/usuario/registrar', 'UsuarioController::registrar');
