<?php declare(strict_types=1);

namespace App\Lib;

use DI\DependencyException;
use DI\NotFoundException;
use PDO;
use DI\Container;
/**
 * Class Database
 * @package App\Lib\Common
 * @codeCoverageIgnore
 */
class Database
{
    private static $instance;

    private $connection;

    /**
     * Database constructor.
     * @param Container $container
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function __construct(Container $container)
    {
        $databaseConfig = $container->get('env');
        $this->connection = new PDO(sprintf(
            "mysql:host=%s;port=%u;dbname=%s;",
            $databaseConfig['host'],
            $databaseConfig['port'],
            $databaseConfig['database']
        ),
            $databaseConfig['user'],
            $databaseConfig['password']
        );
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Returning instance of currency class
     *
     * @param Container $container
     * @return Database
     * @throws DependencyException
     * @throws NotFoundException
     */
    public static function getInstance(Container $container):Database
    {
        if (is_null(self::$instance)) {
            static::$instance = new static($container);
        }

        return static::$instance;
    }

    public function getConnection():PDO
    {
        return $this->connection;
    }

    public function __destruct()
    {
        $this->connection = null;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}
