<?php declare(strict_types=1);

namespace App\Middleware;

use DI\Container;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpNotFoundException;

class CliRequest
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     * @throws HttpNotFoundException
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        $commands = $this->container->get('commands');
        $argv = $request->getServerParams()['argv'];
        $command = $argv[1] ?? null;

        if (!$command || !array_key_exists($command, $commands)) {
            throw new HttpNotFoundException($request);
        }

        $action = new $commands[$command]['action']($this->container);

        $action(...array_slice($argv, 2));

        return $handler->handle($request);
    }
}