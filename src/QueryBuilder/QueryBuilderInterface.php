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

    /**
     * Building query with
     *
     * 'INSERT INTO...'
     */
    const DEFAULT_MODE = 0;

    /**
     * Building query with
     *
     * 'INSERT IGNORE INTO...'
     */
    const IGNORE_MODE = 1;

    /**
     * Building query with
     *
     * 'INSERT INTO ... ON DUPLICATE UPDATE ...'
     */
    const UPDATE_MODE = 2;

    /**
     * @param string $name Put the table name
     *
     * @return void
     */
    public function setTable(string $name): void ;

    /**
     * @param array $rows Put data for insert
     * Example:
     * [
     *      [
     *          'id' => 1,
     *          'name' => 'Foo',
     *      ],
     *      [
     *          'id' => 2,
     *          'name' => 'Bar',
     *      ],
     *      [
     *          'id' => 3,
     *          'name' => 'Baz',
     *      ],
     * ]
     *
     * @return void
     */
    public function setRows(array $rows): void ;

    /**
     * @param array $columns Put data for choosing columns to insert
     * Example:
     * ['id', 'name']
     *
     * @return void
     */
    public function setColumns(array $columns): void ;

    /**
     * @param integer $mode Put mode for choosing the type of a query
     * Example:
     * QueryBuilderInterface::DEFAULT_MODE
     *
     * @return void
     */
    public function setMode(int $mode): void ;

    /**
     * @param array $updateParams Put update rules if you choose update mode
     * Example:
     * [
     *      'name' => 'concat_ws(' ', name, VALUES(name))'
     * ]
     *
     * @return void
     */
    public function setUpdateParams(array $updateParams): void ;

    /**
     * Returning prepared Query
     *
     * @return QueryInterface
     */
    public function getQuery() : QueryInterface;
}
