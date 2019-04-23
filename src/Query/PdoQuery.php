<?php

namespace MultiInsert\Component\Query;

/**
 * Class Query
 *
 * @package MultiInsert\Component\Query
 */
class PdoQuery extends AbstractQuery
{

    /**
     * @var \PDO
     */
    private $connection;

    /**
     * PdoQuery constructor.
     *
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Executing query using \PDO connection
     */
    protected function process(): void
    {
        $this->connection
            ->prepare($this->query)
            ->execute($this->params);
    }
}
