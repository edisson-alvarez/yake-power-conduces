<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Login::index');
$routes->post('/login/autenticar', 'Login::autenticar');
$routes->get('/logout', 'Login::cerrarSesion');
$routes->get('/inicio', 'Home::index');
$routes->get('/conduces', 'Conduces::index');

$routes->get('/conduces/crear', 'Conduces::crear');
$routes->post('/conduces/guardar', 'Conduces::guardar');
$routes->get('/conduces/editar/(:num)', 'Conduces::editar/$1');
$routes->post('/conduces/actualizar/(:num)', 'Conduces::actualizar/$1');
$routes->get('/conduces/eliminar/(:num)', 'Conduces::eliminar/$1');