<?php

namespace App\Cli;

use DI\Container;

abstract class CliAction
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getContainer(): Container
    {
        return $this->container;
    }
}