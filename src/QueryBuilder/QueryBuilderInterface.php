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
     * @return $this
     */
    public function setTable(string $name): self ;

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
     * @return $this
     */
    public function setRows(array $rows): self ;

    /**
     * @param array $columns Put data for choosing columns to insert
     * Example:
     * ['id', 'name']
     *
     * @return $this
     */
    public function setColumns(array $columns): self ;

    /**
     * @param integer $mode Put mode for choosing the type of a query
     * Example:
     * QueryBuilderInterface::DEFAULT_MODE
     *
     * @return $this
     */
    public function setMode(int $mode): self ;

    /**
     * @param array $updateParams Put update rules if you choose update mode
     * Example:
     * [
     *      'name' => 'concat_ws(' ', name, VALUES(name))'
     * ]
     *
     * @return $this
     */
    public function setUpdateParams(array $updateParams): self ;

    /**
     * Returning prepared Query
     *
     * @return QueryInterface
     */
    public function getQuery() : QueryInterface;
}
