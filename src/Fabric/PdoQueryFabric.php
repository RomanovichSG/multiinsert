<?php

namespace MultiInsert\Component\Fabric;

use MultiInsert\Component\Query\PdoQuery;
use MultiInsert\Component\Query\QueryInterface;
use PDO;

/**
 * Class PdoQueryFabric
 *
 * @package MultiInsert\Component\Fabric
 */
class PdoQueryFabric implements QueryFabricInterface
{

    /**
     * @var PDO
     */
    private $connection;

    /**
     * PdoQueryFabric constructor.
     *
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return PdoQuery
     */
    public function createQuery(): QueryInterface
    {
        return new PdoQuery($this->connection);
    }
}