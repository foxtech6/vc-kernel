<?php

namespace Foxtech\Kernel;

use PDO;
use Exception;

/**
 * Class AbstractUpdate
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 16.05.2019
 */
abstract class AbstractUpdate extends AbstractModel
{
    /**
     * Execute migrations
     */
    abstract public function run(): void;
}