<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->post('/auth', 'AuthController::auth');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/dashboard', 'DashboardController::index',['filter' => 'auth']);
$routes->get('/getdata_score', 'DashboardController::getdata',['filter' => 'auth']);
$routes->group('master', ['filter' => 'auth'], static function ($routes) {
    $routes->group('users', static function ($routes) {
        $routes->get('list', 'UserController::index');
        $routes->post('data', 'UserController::getData');
        $routes->get('form', 'UserController::create');
        $routes->get('edit/(:any)', 'UserController::edit/$1');
        $routes->post('store', 'UserController::store');
        $routes->post('update', 'UserController::update');
        $routes->get('delete/(:any)', 'UserController::delete/$1');
        $routes->get('profile', 'ProfileController::index');
        $routes->post('log_activity', 'ProfileController::getLogActivity');

    });
    $routes->group('school', static function ($routes) {
        $routes->get('list', 'SchoolController::index');
        $routes->post('data', 'SchoolController::getData');
        $routes->get('form', 'SchoolController::create');
        $routes->get('edit/(:any)', 'SchoolController::edit/$1');
        $routes->post('store', 'SchoolController::store');
        $routes->post('update', 'SchoolController::update');
        $routes->get('delete/(:any)', 'SchoolController::delete/$1');
        $routes->get('view/(:any)', 'SchoolController::view/$1');
        $routes->post('bookmark', 'SchoolController::bookmark');
        $routes->post('unbookmark', 'SchoolController::unbookmark');
    });

});

$routes->group('setting', ['filter' => 'auth'], static function ($routes) {
    $routes->group('criteria', static function ($routes) {
        $routes->get('list', 'CriteriaController::index');
        $routes->post('data', 'CriteriaController::getData');
        $routes->get('form', 'CriteriaController::create');
        $routes->get('edit/(:any)', 'CriteriaController::edit/$1');
        $routes->post('store', 'CriteriaController::store');
        $routes->post('update', 'CriteriaController::update');
        $routes->get('delete/(:any)', 'CriteriaController::delete/$1');
    });
    $routes->group('question', static function ($routes) {
        $routes->get('list', 'QuestionController::index');
        $routes->post('data', 'QuestionController::getData');
        $routes->get('form', 'QuestionController::create');
        $routes->get('edit/(:any)', 'QuestionController::edit/$1');
        $routes->post('store', 'QuestionController::store');
        $routes->post('update', 'QuestionController::update');
        $routes->get('delete/(:any)', 'QuestionController::delete/$1');
        $routes->get('view/(:any)', 'QuestionController::view/$1');
    });

});

$routes->group('evaluation', ['filter' => 'auth'], static function ($routes) {
    $routes->get('list', 'EvaluationController::index');
    $routes->post('data', 'EvaluationController::getData');
    $routes->get('form', 'EvaluationController::create');
    $routes->post('store', 'EvaluationController::store');
    $routes->get('view/(:any)', 'EvaluationController::view/$1');
    $routes->get('getdata_chart', 'EvaluationController::getdataChart/$1');
});

