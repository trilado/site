<?php
/*
 * Copyright (c) 2011, Valdirene da Cruz Neves Júnior <linkinsystem666@gmail.com>
 * All rights reserved.
 */


/**
 * As rotas são para reescrita de URL. Veja um exemplo:
 * Route::add('^([\d]+)-([a-z0-9\-]+)$','home/view/$1/$2');
 * 
 * Também é possível criar prefixos. Veja um exemplo:
 * Route::prefix('admin');
 */

//about
Route::add('^license$', 'home/about/license');
Route::add('^about$', 'home/about/about');
Route::add('^features$', 'home/about/features');
Route::add('^team$', 'home/about/team');

//api
Route::add('^(\d\.\d)/api/?$', 'api/index/$1');
Route::add('^(\d\.\d)/api/(class|file)/(.+)$', 'api/render/$1/$3/$2');
Route::add('^(\d\.\d)/guide(/(.*))?$', 'guide/render/$1/$3');
