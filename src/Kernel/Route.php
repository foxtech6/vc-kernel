<?php

namespace Foxtech\Kernel;

use LogicException;
use Foxtech\Kernel\Exceptions\NotFoundException;
use ReflectionException;
use InvalidArgumentException;

/**
 * Class Route
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 27.01.2019
 */
class Route
{
    /**
     * List all routes
     *
     * @var array
     */
    private $routes = [];

    /**
     * Class for handle controller parameters
     *
     * @var ControllerHandler
     */
    private $controllerHandler;

    /**
     * Method for add new route and his controller handler
     *
     * @param string $route      New route
     * @param string $controller Handler for new route
     *
     * @throws LogicException
     */
    public function add(string $route, string $controller): void
    {
        // TODO
        //if (!preg_match('/^[a-z][0-9][/]+$/', $route)) {
        //    throw new \Exception('Bad route');
        //}

        $controllerParams = explode('@', $controller);

        if (2 !== count($controllerParams)) {
            throw new InvalidArgumentException('Bad controller params' . $controller);
        }

        try {
            $this->routes[$route] = $this->getControllerHandler()->handle($controllerParams);
        } catch (ReflectionException $e) {
            throw new LogicException('Controller section is invalid');
        }
    }

    /**
     * Get params for handle route
     *
     * @param string $route Route for handle
     *
     * @return array Return params for handle
     * @throws NotFoundException
     */
    public function getController(string $route) : array
    {
        if (!$route) {
            $route = '/';
        }

        if (!isset($this->routes[$route])) {
            throw new NotFoundException('Not Found Controller');
        }

        return $this->routes[$route];
    }

    /**
     * Singleton for return controller handler
     *
     * @return ControllerHandler Return controller handler object
     */
    private function getControllerHandler(): ControllerHandler
    {
        if (!$this->controllerHandler) {
            $this->controllerHandler = new ControllerHandler();
        }

        return $this->controllerHandler;
    }
}
