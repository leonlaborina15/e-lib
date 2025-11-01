<?php


session_start();
define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/e-lib/public/');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/controllers/BaseController.php';

foreach (glob(BASE_PATH . '/app/models/*.php') as $model) {
    require_once $model;
}


$route = $_GET['route'] ?? 'home';

$routes = [
    'home' => 'HomeController@index',
    'login' => 'AuthController@login',
    'register' => 'AuthController@register',
    'logout' => 'AuthController@logout',
    'dashboard' => 'DashboardController@index',
    'books' => 'BookController@index',
    'books/view' => 'BookController@show',
    'books/download' => 'BookController@download',
    'books/show' => 'BookController@show',
    'books/read' => 'BookController@read',
    'books/create' => 'BookController@create',
    'books/edit' => 'BookController@edit',
    'books/delete' => 'BookController@delete',
    'books/favorite' => 'BookController@toggleFavorite',
    'books/toggleFavorite' => 'BookController@toggleFavorite',
    'books/search' => 'BookController@search',
    'favorites' => 'BookController@favorites',
    'history' => 'BookController@history',
    'reading-history' => 'BookController@history',
    'users' => 'UserController@index',
    'users/create' => 'UserController@create',
    'users/edit' => 'UserController@edit',
    'users/delete' => 'UserController@delete',
    'profile' => 'UserController@profile',
    'logs' => 'UserController@logs',
    'reviews' => 'ReviewController@index',
    'reviews/store' => 'ReviewController@store',
    'reviews/delete' => 'ReviewController@delete',
];

if (!isset($routes[$route])) {
    die("Route not found: $route");
}

list($controller, $method) = explode('@', $routes[$route]);
$controllerFile = BASE_PATH . '/app/controllers/' . $controller . '.php';

if (!file_exists($controllerFile)) {
    die("Controller not found: $controllerFile");
}

require_once $controllerFile;
$instance = new $controller();
$instance->$method();
?>