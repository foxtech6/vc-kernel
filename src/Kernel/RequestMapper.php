<?php

namespace Foxtech\Kernel;

/**
 * Class RequestMapper
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 27.01.2019
 */
class RequestMapper
{
    /**
     * When client goes this route
     *
     * @var string
     */
    private $clientRoute;

    /**
     * Request params
     *
     * @var array
     */
    private $params;

    /**
     * Get request params
     *
     * @return array Return params
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Set request params
     *
     * @param array $params Params from client
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * Get client route
     *
     * @return string Return client route
     */
    public function getClientRoute(): string
    {
        return $this->clientRoute;
    }

    /**
     * Set client route
     *
     * @param string $clientRoute Client route
     */
    public function setClientRoute(string $clientRoute): void
    {
        $this->clientRoute = $clientRoute;
    }
}
