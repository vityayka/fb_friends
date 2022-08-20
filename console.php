<?php declare(strict_types=1);

use App\Cli\FindFbPath;
use App\Middleware\CliRequest;
use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->add(new CliRequest($container));
$container->set('env', [
    'host' => getenv('DB_HOST'),
    'port' => getenv('DB_PORT'),
    'database' => getenv('DB_NAME'),
    'user' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD')
]);

$container->set('commands', [
    'findFbPath' => [
        'action' => FindFbPath::class,
    ],
]);


$app->get('/', function ($request, $response) {
    return $response;
});

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();

