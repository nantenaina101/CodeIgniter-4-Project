<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Home::index');

$routes->post('save', 'AuthController::save');
$routes->post('login', 'AuthController::login');
//$routes->get('dashboard', 'DashboardController::index');
$routes->get('logout', 'AuthController::logout', ['as' => 'user.logout']);

/*$routes->group('',['filter'=>'auth_filter'], function($routes){
	$routes->get('dashboard', 'DashboardController::index');
});*/

$routes->group('', ['filter' => 'check_filter'], function ($routes) {
    $routes->get('/', 'AuthController::index');
    $routes->get('inscription', 'AuthController::register');
});

// ADMIN LTE
$routes->group('user', ['filter' => 'auth_filter'], function ($routes) {
    $routes->get('home', 'UserController::index', ['as' => 'user.home']);
    $routes->get('profil', 'UserController::profil', ['as' => 'user.profil']);
    $routes->get('contact', 'EmailController::index', ['as' => 'user.contact']);
    $routes->post('send', 'EmailController::send', ['as' => 'email.send']);
    $routes->get('email', 'UserController::email', ['as' => 'user.email']);

    // CRUD AJAX ADD, RETRIEVE, UPDATE AND DELETE COUNTRY
    $routes->get('countries', 'CountryController::index', ['as' => 'user.country']);
    $routes->post('addCountry', 'CountryController::addCountry', ['as' => 'user.addCountry']);
    $routes->get('listCountry', 'CountryController::listCountry', ['as' => 'user.listCountry']);
    $routes->post('updateCountry', 'CountryController::updateCountry', ['as' => 'user.updateCountry']);
    $routes->get('deleteCountry/(:num)', 'CountryController::deleteCountry/$1', ['as' => 'user.deleteCountry']);

    // CRUD AJAX ADD, RETRIEVE, UPDATE AND DELETE POST WITH IMAGE UPLOAD
    $routes->get('posts', 'PostController::index', ['as' => 'user.posts']);
    $routes->post('add_post', 'PostController::add_post', ['as' => 'user.add_post']);
    $routes->get('listPost', 'PostController::listPost', ['as' => 'user.listPost']);
    $routes->post('update_post', 'PostController::update_post', ['as' => 'user.update_post']);
    $routes->post('deletePost', 'PostController::deletePost', ['as' => 'user.deletePost']);
});

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
