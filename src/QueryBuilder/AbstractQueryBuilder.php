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
     * @var array
     */
    private $params;

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

        $query = $this->getNewQuery();
        $query->setSqlQuery($this->buildSqlQuery());
        $query->setParams($this->getParams());

        return $query;
    }

    /**
     * Process of building prepared for the PDO a MySql query
     *
     * @return string
     */
    protected function buildSqlQuery() : string
    {
        $queryPrefix = '';
        $querySuffix = '';

        $firstRow = reset($this->rows);
        $currentColumns = $this->columns ?: array_keys($firstRow);
        $columnsNames = implode('`, `', $currentColumns);
        $columns = array_flip($currentColumns);

        switch ($this->mode) {
            case self::DEFAULT_MODE:
                $queryPrefix .= 'INSERT';
                break;
            case self::IGNORE_MODE:
                $queryPrefix .= 'INSERT IGNORE';
                break;
            case self::UPDATE_MODE:
                $queryPrefix .= 'INSERT';
                $querySuffix .= ' ON DUPLICATE KEY UPDATE ';
                $updateRule = $this->buildUpdateQueryParams($columns, $this->updateParams);

                if (empty($updateRule)) {
                    throw new \InvalidArgumentException('Rule for update mode can\'t be empty');
                }

                $querySuffix .= $updateRule;

                break;
            default :
                throw new \InvalidArgumentException("Unknown insert mode - {$this->mode}");
        }

        $queryPrefix .= " INTO `{$this->table}` (`{$columnsNames}`) VALUES ";

        $this->params = array_reduce(
            $this->rows,
            function ($params, $item) use ($columns) {
                if (!empty($columns)) {
                    $item = array_intersect_key($item, $columns);
                    $item = array_replace($columns, $item);
                }

                return array_merge($params, array_values($item));
            },
            []
        );

        $columnsCount = count($columns);
        $values = rtrim(str_repeat('?,', $columnsCount), ',');

        return "{$queryPrefix} ({$values}) {$querySuffix}";
    }

    /**
     * Values for the query
     *
     * @return array
     */
    protected function getParams() : array
    {
        return $this->params;
    }

    /**
     * @param array $currentColumns
     * @param array $updateParams
     *
     * @return string
     */
    private function buildUpdateQueryParams(array $currentColumns, array $updateParams) : string
    {
        $params = array_intersect_key($updateParams, $currentColumns);

        if (empty($params)) {
            return '';
        }

        $a = '';
        foreach ($params as $columnName => $rule) {
            $a .= "`{$columnName}` = {$rule['rule']},";
        }

        return rtrim($a, ',');
    }

    /* Implement the way of creating new Query */
    abstract protected function getNewQuery() : QueryInterface ;
}
