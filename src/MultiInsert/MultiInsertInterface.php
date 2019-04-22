<?php

namespace MultiInsert\Component\MultiInsert;

use MultiInsert\Component\QueryBuilder\QueryBuilderInterface;

/**
 * Interface MultiInsertInterface
 *
 * @package MultiInsert\Component\MultiInsert
 */
interface MultiInsertInterface
{

    /**
     * MultiInsertInterface constructor.
     *
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(QueryBuilderInterface $queryBuilder);

    public function setTable(string $name): void ;

    public function setRows(array $rows): void ;

    public function setColumns(array $columns): void ;

    public function setMode(int $mode): void ;

    public function setUpdateParams(array $updateParams): void ;

    public function setChunkSize(int $size): void ;

    public function execute(): void;
}
