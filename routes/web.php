<?php

Route::group([
    'prefix'     => 'dev/webservice-preview',
    'middleware' => 'web',
    'namespace'  => 'Larangular\WebServicePreview\Http\Controllers',
    'as'         => 'larangular.webservice-preview.',
], function () {
    Route::get('/', 'WebServicePreview\Gateway@index');
    Route::get('{provider}/{service?}', 'WebServicePreview\Gateway@show')
         ->name('service.form');
    Route::post('{provider}/{service?}', 'WebServicePreview\Gateway@serviceResponse')
         ->name('service.response');
});
