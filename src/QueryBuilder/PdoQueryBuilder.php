<?php

namespace MultiInsert\Component\QueryBuilder;

use MultiInsert\Component\Query\PdoQuery;
use MultiInsert\Component\Query\QueryInterface;

/**
 * Class SqlQueryBuilder
 *
 * @package MultiInsert\Component\QueryBuilder
 */
class PdoQueryBuilder extends  AbstractQueryBuilder
{

    /**
     * @var \PDO
     */
    private $connection;

    /**
     * PdoQueryBuilder constructor.
     *
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * PdoQuery factory
     *
     * @return PdoQuery
     */
    protected function getNewQuery() : QueryInterface
    {
        return new PdoQuery($this->connection);
    }
}
