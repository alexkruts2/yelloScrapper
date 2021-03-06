<?php

use App\Api\V1\Controllers\ArticleController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['middleware' => ['dingo']], function ($api) {
    $api->get('getArticles', ['as' => 'api.getArticles', 'uses' => ArticleController::class . '@getArticles']);
    $api->get('getLicense', ['as' => 'api.getLicense', 'uses' => ArticleController::class . '@getLicense']);
});