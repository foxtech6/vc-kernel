<?php

namespace Foxtech\Kernel;

use ReflectionClass;
use ReflectionException;

/**
 * Class ControllerHandler
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 27.01.2019
 */
class ControllerHandler
{
    /**
     * Where controller are
     */
    public const CONTROLLER_NAMESPACE = 'App\Controllers\\';

    /**
     * Handle controller parameters
     *
     * @param array $controllerParams Parameters from route
     *
     * @return array Return controller params
     * @throws ReflectionException
     */
    public function handle(array $controllerParams): array
    {
        $controller = new ReflectionClass(self::CONTROLLER_NAMESPACE . array_shift($controllerParams));

        $actionName = array_shift($controllerParams);
        $actionArguments = $controller->getMethod($actionName)->getParameters();

        $requestHandler = null;

        if ($actionArguments) {
            $requestHandler = array_shift($actionArguments)->getClass();
        }

        return [$controller->name, $actionName, $requestHandler->name ?? null];
    }
}
