<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
require_once './middlewares/UsuarioLogeadoMiddleware.php';
require_once './middlewares/PedidoValidarMiddleware.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/MenuController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/MesaController.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/usuario', function (RouteCollectorProxy $group) {
    $group->get('s/', \UsuarioController::class . ':TraerTodos');
    $group->get('/{nombre} {apellido}', \UsuarioController::class . ':TraerUno');
    $group->post('/alta', \UsuarioController::class . ':CargarUno')->add(new UsuarioLogeadoMiddleware());
    $group->post('s/modifica', \UsuarioController::class . ':ModificarUno');
    $group->get('/baja/{nombre} {apellido}', \UsuarioController::class . ':BorrarUno');
  });

  $app->group('/menu', function (RouteCollectorProxy $group) {
    $group->get('s/', \MenuController::class . ':TraerTodos');
    $group->get('/{menu}', \MenuController::class . ':TraerUno');
    $group->post('/alta', \MenuController::class . ':CargarUno');
    $group->post('s/modifica', \MenuController::class . ':ModificarUno');
    $group->get('/baja/{menu}', \MenuController::class . ':BorrarUno');
  });

  $app->group('/pedido', function (RouteCollectorProxy $group) {
    $group->get('s/', \PedidoController::class . ':TraerTodos');
    $group->get('/{pedido}', \PedidoController::class . ':TraerUno');
    $group->post('/alta', \PedidoController::class . ':CargarUno');
    $group->post('s/modifica', \PedidoController::class . ':ModificarUno');
    $group->get('/baja/{id_pedido}', \PedidoController::class . ':BorrarUno');
    $group->post('/', \PedidoController::class . ':CambiarEstado')->add(new PedidoValidarMiddleware());
  });

  $app->group('/mesa', function (RouteCollectorProxy $group) {
    $group->get('s/', \MesaController::class . ':TraerTodos');
    $group->get('/{id_mesa}', \MesaController::class . ':TraerUno');
    $group->post('/alta', \MesaController::class . ':CargarUno');
    $group->post('s/modifica', \MesaController::class . ':ModificarUno');
    $group->get('/baja/{id_mesa}', \MesaController::class . ':BorrarUno');
  });



$app->get('[/]', function (Request $request, Response $response) {    
    $payload = json_encode(array("mensaje" => "Slim Framework 4 PHP"));
    
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();

