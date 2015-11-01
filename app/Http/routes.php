<?php

Route::get('/', function () {
    return view('welcome');
});


// Registration routes...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');


Route::group(['prefix' => 'painel'], function () {

    Route::group(['middleware' => 'auth'], function()
    {

      //Controller do Backend
      Route::get('/', 'BackendController@index');

      //Eventos
      Route::get('/eventos', 'Backend\EventosController@index');
      Route::get('/eventos/criar', 'Backend\EventosController@create');
      Route::post('/eventos/criar', 'Backend\EventosController@store');
      Route::get('/eventos/editar/{id}', 'Backend\EventosController@edit');
      Route::post('/eventos/editar/{id}', 'Backend\EventosController@update');
      Route::get('/eventos/excluir/{id}', 'Backend\EventosController@destroy');

      //Departamentos
      Route::get('/departamentos', 'Backend\DepartamentosController@index');
      Route::post('/departamentos/criar', 'Backend\DepartamentosController@store');
      Route::get('/departamentos/editar/{id}', 'Backend\DepartamentosController@edit');
      Route::get('/departamentos/excluir/{id}', 'Backend\DepartamentosController@destroy');
      Route::post('/departamentos/editar/{id}', 'Backend\DepartamentosController@update');

      //Categorias
      Route::get('/categorias', 'Backend\CategoriasController@index');
      Route::post('/categorias/criar', 'Backend\CategoriasController@store');
      Route::get('/categorias/editar/{id}', 'Backend\CategoriasController@edit');
      Route::get('/categorias/excluir/{id}', 'Backend\CategoriasController@destroy');
      Route::post('/categorias/editar/{id}', 'Backend\CategoriasController@update');

      //Faz o Logout
      Route::get('auth/logout', 'Backend\Auth\AuthController@getLogout');

    });

    //Rotas que só podem ser visitadas caso o usuário não esteja logado.
    Route::group(['middleware' => 'guest'], function()
    {
      Route::get('auth/login', 'Backend\Auth\AuthController@getLogin');
      Route::post('auth/login', 'Backend\Auth\AuthController@postLogin');
    });


});
