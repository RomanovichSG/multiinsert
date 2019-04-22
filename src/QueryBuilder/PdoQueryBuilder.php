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
     * @var array
     */
    private $params;

    /**
     * PdoQueryBuilder constructor.
     *
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    protected function buildQuery(): QueryInterface
    {
        $query = $this->getNewQuery();
        $query->setSqlQuery($this->buildSqlQuery());
        $query->setParams($this->getParams());

        return $query;
    }

    protected function getNewQuery() : PdoQuery
    {
        return new PdoQuery($this->connection);
    }

    private function buildSqlQuery() : string
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

    private function getParams() : array
    {
        return $this->params;
    }

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
}
