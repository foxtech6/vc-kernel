<?php

namespace Foxtech\Kernel\SystemControllers;

use Foxtech\Kernel\AbstractController;
use Foxtech\Kernel\Exceptions\NotFoundException;

/**
 * Class NotFoundController
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 28.01.2019
 */
class NotFoundController extends AbstractController
{
    /**
     * Render 404 page
     *
     * @throws NotFoundException
     */
    public function index(): void
    {
        $this->render('404');
    }
}
