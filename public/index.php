<?php

use App\Controllers\ArticleController;
use App\Core\Application;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application();

$app->router->get('/', [ArticleController::class, 'home']);

$app->router->post('/', [ArticleController::class, 'storeComment']);

$app->router->post('/sort', [ArticleController::class, 'sortComments']);

$app->router->get('/about', [ArticleController::class, 'about']);

$app->run();
