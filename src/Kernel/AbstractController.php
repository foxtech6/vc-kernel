<?php

namespace Foxtech\Kernel;

use Foxtech\Kernel\Exceptions\NotFoundException;

/**
 * Class AbstractController
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 28.01.2019
 */
abstract class AbstractController
{
    /**
     * Path to views
     */
    protected const VIEW_PATH = PROJECT_PATH . '/views/%s.php';

    /**
     * Path to layouts
     */
    protected const LAYOUT_PATH = PROJECT_PATH . '/views/layouts/';

    /**
     * Params send to view
     *
     * @var array
     */
    private $params;

    /**
     * Which view include
     *
     * @var string
     */
    private $view;

    /**
     * Show if request is ajax
     *
     * @var bool
     */
    private $isAjax;

    /**
     * View render
     *
     * @param string $view   Params send to view
     * @param array  $params Which view include
     *
     * @return self Return controller object
     * @throws NotFoundException
     */
    public function render(string $view, array $params = []): self
    {
        $this->view = sprintf(self::VIEW_PATH, $view);

        if (!is_readable($this->view)) {
            throw new NotFoundException('View ' . $view . ' not found');
        }

        $this->params = $params;

        return $this;
    }

    /**
     * Set request is ajax
     */
    public function isAjax(): void
    {
        $this->isAjax = true;
    }

    /**
     * Get error to view
     *
     * @param AbstractRequest $request Validator where isset error
     */
    public function withErrors(AbstractRequest $request): void
    {
        if ($request->getErrors()) {
            $this->params['errors'] = $request->getErrors();
        }
    }

    /**
     * Controller destructor
     * include view
     */
    public function __destruct()
    {
        if ($this->isAjax) {
            return;
        }

        if ($this->params) {
            extract($this->params);
        }

        require_once self::LAYOUT_PATH . 'header.html';

        if ($this->view) {
            require_once $this->view;
        }

        require_once self::LAYOUT_PATH . 'footer.html';
    }
}
