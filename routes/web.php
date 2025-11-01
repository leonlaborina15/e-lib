<?php

return [

    'home' => 'AuthController@login',
    'login' => 'AuthController@login',
    'register' => 'AuthController@register',
    'logout' => 'AuthController@logout',

    'dashboard' => 'DashboardController@index',

    'books' => 'BookController@index',
    'books/show' => 'BookController@show',
    'books/create' => 'BookController@create',
    'books/edit' => 'BookController@edit',
    'books/delete' => 'BookController@delete',
    'books/read' => 'BookController@read',
    'books/download' => 'BookController@download',
    'books/search' => 'BookController@search',
    'books/toggleFavorite' => 'BookController@toggleFavorite',
    'books/favorites' => 'BookController@favorites',
    'books/history' => 'BookController@history',

    'users' => 'UserController@index',
    'users/create' => 'UserController@create',
    'users/edit' => 'UserController@edit',
    'users/delete' => 'UserController@delete',
    'profile' => 'UserController@profile',

    'logs' => 'UserController@logs',

    // Website Reviews routes
    'reviews' => 'ReviewController@index',
    'reviews/store' => 'ReviewController@store',

];
?>