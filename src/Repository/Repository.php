<?php declare(strict_types=1);

namespace App\Repository;

use App\Lib\Database;
use DI\Container;
use PDO;

/**
 * Class Repository
 *
 * @package App\Repository
 */
abstract class Repository
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Returning container
     *
     * @return Container
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * Returning pdo connection
     *
     * @return PDO
     */
    protected function getPDO():PDO
    {
        return Database::getInstance($this->container)->getConnection();
    }
}
