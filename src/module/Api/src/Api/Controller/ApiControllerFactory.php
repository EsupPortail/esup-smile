<?php

namespace Api\Controller;

use Interop\Container\ContainerInterface;

class ApiControllerFactory {

    public function __invoke(ContainerInterface $container)
    {
        $controller = new ApiController();
        return $controller;
    }
}