<?php

namespace MultiInsert\Component\QueryBuilder;

use MultiInsert\Component\Query\QueryInterface;

abstract class AbstractQueryBuilder implements QueryBuilderInterface
{

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $rows;

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var integer
     */
    protected $mode = QueryBuilderInterface::DEFAULT_MODE;

    /**
     * @var array
     */
    protected $updateParams = [];

    /**
     * @inheritDoc
     */
    public function setTable(string $name): QueryBuilderInterface
    {
       $this->table = $name;

       return $this;
    }

    /**
     * @inheritDoc
     */
    public function setRows(array $rows): QueryBuilderInterface
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setColumns(array $columns): QueryBuilderInterface
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setMode(int $mode): QueryBuilderInterface
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setUpdateParams(array $updateParams): QueryBuilderInterface
    {
        $this->updateParams = $updateParams;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getQuery(): QueryInterface
    {
        if (empty($this->table)) {
            throw new \BadMethodCallException('Table name was not set');
        }

        if (empty($this->rows)) {
            throw new \BadMethodCallException('Rows data were not set');
        }

        return $this->buildQuery();
    }

    abstract protected function buildQuery() : QueryInterface ;
}
