<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

/*
|--------------------------------------------------------------------------
| INICIO
|--------------------------------------------------------------------------
*/

$routes->get('/', 'UsuarioController::inicio');

/*
|--------------------------------------------------------------------------
| USUARIO
|--------------------------------------------------------------------------
*/

$routes->get('/usuario/inicio', 'UsuarioController::inicio');

$routes->get('/usuario/login', 'UsuarioController::login');
$routes->post('/usuario/iniciarSesion', 'UsuarioController::iniciarSesion');

$routes->get('/usuario/registro', 'UsuarioController::registro');
$routes->post('/usuario/registrar', 'UsuarioController::registrar');

$routes->get('/usuario/principal', 'UsuarioController::principal');

$routes->get('/usuario/cerrarSesion', 'UsuarioController::cerrarSesion');

$routes->get('/usuario/perfil', 'UsuarioController::perfil');

$routes->get('/usuario/servicios', 'UsuarioController::servicios');

$routes->get('/usuario/politica_privacidad', 'UsuarioController::politica_privacidad');

$routes->get('/usuario/cambiarPass', 'UsuarioController::cambiarPass');
$routes->post('/usuario/actualizarPass', 'UsuarioController::actualizarPass');

$routes->get('/usuario/estadistica', 'UsuarioController::estadistica');

$routes->get('/usuario/mostrar', 'UsuarioController::mostrar');

$routes->get('/usuario/seleccionarDispositivo', 'UsuarioController::seleccionarDispositivo');
$routes->post('/usuario/cambiarDispositivo', 'UsuarioController::cambiarDispositivo');

/*
|--------------------------------------------------------------------------
| RECUPERACIÓN DE CONTRASEÑA
|--------------------------------------------------------------------------
*/

$routes->get('/usuario/recuperar', 'ContraseñaController::recuperar');

$routes->post(
    '/usuario/enviarRecuperacion',
    'ContraseñaController::enviarRecuperacion'
);

$routes->get(
    '/usuario/restablecer/(:any)',
    'ContraseñaController::restablecer/$1'
);

$routes->post(
    '/usuario/guardarNuevaContrasena',
    'ContraseñaController::guardarNuevaContrasena'
);

$routes->get(
    '/usuario/probarCorreo',
    'ContraseñaController::probarCorreo'
);

/*
|--------------------------------------------------------------------------
| ECO-TACHOS
|--------------------------------------------------------------------------
*/

/* Lista de tachos */

$routes->get(
    '/mis-tachos',
    'TachosController::mistachos'
);

$routes->get(
    '/usuario/mis-tachos',
    'TachosController::mistachos'
);

/* Registrar Eco-Tacho */

$routes->get(
    '/registrar-tacho',
    'TachosController::registrar'
);

$routes->post(
    '/guardar-tacho',
    'TachosController::guardar'
);

/* Seleccionar Eco-Tacho */

$routes->get(
    '/seleccionar-tacho/(:num)',
    'TachosController::seleccionar/$1'
);

$routes->get(
    '/tachos/seleccionar/(:num)',
    'TachosController::seleccionar/$1'
);

/* Unirse a Eco-Tacho */

$routes->get(
    '/unirse-tacho',
    'TachosController::unirse'
);

$routes->post(
    '/procesar-union',
    'TachosController::procesarUnion'
);

/* Buscar Eco-Tacho por código */

$routes->post(
    '/buscar-tacho-por-codigo',
    'TachosController::buscarPorCodigo'
);

/* Asignar propietario */

$routes->post(
    '/asignar-tacho',
    'TachosController::asignarPropietario'
);

/* Eliminar Eco-Tacho */

$routes->post(
    '/eliminar-tacho/(:num)',
    'TachosController::eliminar/$1'
);

/*
|--------------------------------------------------------------------------
| ESTADÍSTICAS
|--------------------------------------------------------------------------
*/

$routes->get(
    '/estadisticas-tacho/(:num)',
    'EstadisticaController::show/$1'
);

/*
|--------------------------------------------------------------------------
| GESTIÓN DEL ECO-TACHO
|--------------------------------------------------------------------------
*/

/* Página para propietario y administrador */

$routes->get(
    '/gestionar-tacho/(:num)',
    'TachosController::gestionar/$1'
);

/* Página de usuarios: solamente propietario */

$routes->get(
    '/usuarios-tacho/(:num)',
    'TachosController::usuarios/$1'
);

/* Cambiar rol de usuario */

$routes->post(
    '/usuarios-tacho/cambiar-rol',
    'TachosController::cambiarRol'
);

/*
|--------------------------------------------------------------------------
| CONTROL DE LOS TACHOS
|--------------------------------------------------------------------------
|
| Permite abrir/cerrar:
|   - plástico / vidrio
|   - orgánico
|   - papel
|
| El Controller verifica que el usuario sea
| propietario o administrador.
|
|--------------------------------------------------------------------------
*/

$routes->post(
    '/tacho/control',
    'TachosController::control'
);

/*
|--------------------------------------------------------------------------
| ESTADO DEL TACHO
|--------------------------------------------------------------------------
|
| Consulta:
|   - alerta de llenado
|   - distancia
|
|--------------------------------------------------------------------------
*/

$routes->get(
    '/tacho/estado',
    'TachosController::estado'
);

/*
|--------------------------------------------------------------------------
| CAMBIAR BOLSA
|--------------------------------------------------------------------------
|
| El propietario o administrador confirma que
| la bolsa fue cambiada.
|
|--------------------------------------------------------------------------
*/

$routes->post(
    '/tacho/cambiar-bolsa',
    'TachosController::cambiarBolsa'
);

/*
|--------------------------------------------------------------------------
| PAGOS
|--------------------------------------------------------------------------
*/


$routes->group('pagos', function ($routes) {
    $routes->get('checkout', 'Pagos::checkout');
    $routes->get('crear-preferencia', 'Pagos::crearPreferencia');
    $routes->get('exito', 'Pagos::exito');
    $routes->get('error', 'Pagos::error');
    $routes->get('pendiente', 'Pagos::pendiente');
    $routes->post('webhook', 'Pagos::webhook');
});

$routes->get('seleccionar-tacho/(:num)', 'UsuarioController::seleccionarTacho/$1');