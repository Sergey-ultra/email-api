<?php


use App\Controller\UserController;
use Bramus\Router\Router;



$router = new Router();

$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '404, route not found!';
});

$router->setBasePath('/');
//echo json_encode(var_dump($router));


$router->mount('/api/v1/users', function () use ($router) {

    $router->get('/', function () {
        (new UserController())->index();
    });


    $router->get('/{id}', function ($id) {
        (new UserController)->show($id);
    });

    $router->post('/', function () {
        (new UserController)->store();
    });

    $router->patch('/', function () {
        (new UserController)->update();
    });

    $router->delete('/{id}', function ($id) {
        (new UserController)->delete($id);
    });
});


$router->run();


