<?php

namespace MultiInsert\Component\QueryBuilder;

use MultiInsert\Component\Query\QueryInterface;

/**
 * Interface QueryBuilderInterface
 *
 * @package MultiInsert\Component\QueryBuilder
 */
interface QueryBuilderInterface
{
    const DEFAULT_MODE = 0;

    const IGNORE_MODE = 1;

    const UPDATE_MODE = 2;

    public function setTable(string $name): self ;

    public function setRows(array $rows): self ;

    public function setColumns(array $columns): self ;

    public function setMode(int $mode): self ;

    public function setUpdateParams(array $updateParams): self ;

    public function getQuery() : QueryInterface;
}
