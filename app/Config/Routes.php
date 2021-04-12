<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Surveys::index');
// $routes->get('/result', 'Surveys::result');
// $routes->get('/', 'WordGenerators::index');
// $routes->get('/', 'Courses::index');
// $routes->get('courses/destroy/:(any)', 'Courses::index/destroy/$1');
// $routes->get('/', 'Products::index');
// $routes->get('products/show/:(any)', 'Products::index/show/$1');
// $routes->get('products/edit/:(any)', 'Products::index/edit/$1');
// $routes->get('products/destroy/:(any)', 'Products::index/destroy/$1');

// $routes->get('/', 'Students::index');
// $routes->get('students/profile', 'Students::profile');

// $routes->get('/', 'Ecommerce::index');
// $routes->get('Ecommerce/login', 'Ecommerce::login');
// $routes->get('Ecommerce/create', 'Ecommerce::create');
// $routes->get('Ecommerce/cart', 'Ecommerce::cart');
// $routes->get('Ecommerce/checkout_success', 'Ecommerce::checkout_success');

// $routes->get('/', 'LeadsAndClients::index');


// $routes->get('/', 'Players::index');

// $routes->get('/', 'Dashboard::index');
// $routes->get('/signin', 'Users::signin');
// $routes->get('/signup', 'Users::signup');
// $routes->get('/dashboard/admin', 'Dashboard::admin');
// $routes->get('/users/new', 'Users::new');
// $routes->get('/users/edit/:(any)', 'Users::edit/$1');
// $routes->get('/users/show', 'Messages::show');
// $routes->get('/users/show/:(any)', 'Users::show/$1');
// $routes->get('/users/profile', 'Users::profile');
// $routes->get('/dashboard', 'Dashboard::dashboard');

$routes->get('/', 'Post::index');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
