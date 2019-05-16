<?php

namespace Foxtech\Kernel;

use PDO;
use Exception;

/**
 * Class AbstractModel
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 16.05.2019
 */
abstract class AbstractModel
{
    /**
     * Connection to db
     *
     * @var PDO
     */
    protected $db;

    /**
     * AbstractModel constructor
     *
     * @throws Exception
     */
    public function __construct()
    {
        $credentials = $this->getConfig();

        if (!is_array($credentials) || empty($credentials)) {
            throw new Exception('Incorrect config');
        }

        $this->connection($credentials['host'], $credentials['db'], $credentials['user'], $credentials['pass']);
    }

    /**
     * Get connection to db
     *
     * @param string $host Host where is db
     * @param string $db   Db name
     * @param string $user Username to db
     * @param string $pass Password to db
     */
    protected function connection(string $host, string $db, string $user, string $pass): void
    {
        if (!$this->db) {
            $this->db = new PDO(
                sprintf('mysql:host=%s;dbname=%s', $host, $db),
                $user,
                $pass,
                [PDO::ATTR_PERSISTENT => true]
            );
        }
    }

    /**
     * @return array Return config
     */
    private function getConfig(): array
    {
        return require_once PROJECT_PATH . '/config/db.php';
    }
}