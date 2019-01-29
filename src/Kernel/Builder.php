<?php

namespace Foxtech\Kernel;

use Foxtech\Kernel\Exceptions\NotFoundException;
use Foxtech\Kernel\SystemControllers\NotFoundController;
use Throwable;

/**
 * Class Builder
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 27.01.2019
 */
class Builder
{
    /**
     * Route object
     *
     * @var Route
     */
    private $route;

    /**
     * Mapper for request
     *
     * @var RequestMapper
     */
    private $requestMapper;

    /**
     * Builder constructor
     *
     * @param Route         $route         Route object
     * @param RequestMapper $requestMapper Mapper for request
     */
    public function __construct(Route $route, RequestMapper $requestMapper)
    {
        $this->route = $route;
        $this->requestMapper = $requestMapper;
    }

    /**
     * Build all applications
     */
    public function build(): void
    {
        try {
            $controllerParams = $this->route->getController($this->requestMapper->getClientRoute());

            $controller = array_shift($controllerParams);
            $action = array_shift($controllerParams);
            $requestHandler= array_shift($controllerParams);

            $this->callController($controller, $action, $requestHandler);
        } catch (Throwable $e) {
            (new NotFoundController())->index();
        }
    }

    /**
     * Call route handler - controller
     *
     * @param string $controllerName Controller name
     * @param string $actionName     Method name in controller
     * @param string $requestHandler Validator for request
     *
     * @throws NotFoundException
     */
    private function callController(string $controllerName, string $actionName, string $requestHandler = null): void
    {
        if ($requestHandler) {
            /* @var $requestHandler AbstractRequest */
            $requestHandler = new $requestHandler($this->requestMapper->getParams());
            $requestHandler->handle();

            (new $controllerName())->{$actionName}($requestHandler);
            return;
        }

        (new $controllerName())->{$actionName}();
    }
}
