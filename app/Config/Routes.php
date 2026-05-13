<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================
// PUBLIC ROUTES
// ============================================================
$routes->get('/', 'Home::index');

// ============================================================
// AUTH ROUTES
// ============================================================
$routes->group('auth', function ($routes) {
    $routes->get('login',          'Auth::login');
    $routes->post('login',         'Auth::doLogin');
    $routes->get('register',       'Auth::register');
    $routes->post('register',      'Auth::doRegister');
    $routes->get('forgot',         'Auth::forgot');
    $routes->post('forgot',        'Auth::doForgot');
    $routes->get('reset/(:any)',   'Auth::reset/$1');
    $routes->post('reset/(:any)',  'Auth::doReset/$1');
    $routes->get('logout',         'Auth::logout');
});

// ============================================================
// GENERATOR (authenticated only)
// ============================================================
$routes->get('generator',          'Generator::index',            ['filter' => 'auth']);
$routes->post('generator/generate','Generator::generate',         ['filter' => 'auth']);
$routes->get('generator/download/(:num)', 'Generator::download/$1', ['filter' => 'auth']);

// ============================================================
// DASHBOARD (authenticated users)
// ============================================================
$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/',              'Dashboard::index');
    $routes->get('history',        'Dashboard::history');
    $routes->get('saved',          'Dashboard::saved');
    $routes->post('save-prompt/(:num)', 'Dashboard::savePrompt/$1');
    $routes->post('delete-prompt/(:num)', 'Dashboard::deletePrompt/$1');
    $routes->get('profile',        'Dashboard::profile');
    $routes->post('profile',       'Dashboard::updateProfile');
});

// ============================================================
// ADMIN ROUTES
// ============================================================
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('/',              'Admin\AdminDashboard::index');
    $routes->get('users',                  'Admin\Users::index');
    $routes->get('users/create',           'Admin\Users::create');
    $routes->post('users/create',          'Admin\Users::store');
    $routes->get('users/(:num)',                    'Admin\Users::show/$1');
    $routes->get('users/(:num)/edit',              'Admin\Users::edit/$1');
    $routes->post('users/(:num)/edit',             'Admin\Users::update/$1');
    $routes->post('users/(:num)/toggle',           'Admin\Users::toggle/$1');
    $routes->post('users/(:num)/set-plan',         'Admin\Users::setPlan/$1');
    $routes->post('users/(:num)/reset-password',   'Admin\Users::resetPassword/$1');
    $routes->post('users/(:num)/delete',           'Admin\Users::delete/$1');
    $routes->get('templates',      'Admin\Templates::index');
    $routes->get('templates/create','Admin\Templates::create');
    $routes->post('templates',     'Admin\Templates::store');
    $routes->get('templates/(:num)/edit', 'Admin\Templates::edit/$1');
    $routes->post('templates/(:num)', 'Admin\Templates::update/$1');
    $routes->post('templates/(:num)/delete', 'Admin\Templates::delete/$1');
    $routes->get('platforms',      'Admin\Platforms::index');
    $routes->get('styles',         'Admin\Styles::index');
    $routes->get('prompts',        'Admin\Prompts::index');
    $routes->get('analytics',      'Admin\Analytics::index');
});
