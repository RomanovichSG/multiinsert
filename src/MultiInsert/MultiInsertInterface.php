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

    /**
     * @param string $name Put the table name
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
     */
    public function setRows(array $rows): void ;

    /**
     * @param array $columns Put data for choosing columns to insert
     * Example:
     * ['id', 'name']
     */
    public function setColumns(array $columns): void ;

    /**
     * @param integer $mode Put mode for choosing the type of a query
     * Example:
     * QueryBuilderInterface::DEFAULT_MODE
     */
    public function setMode(int $mode): void ;

    /**
     * @param array $updateParams Put update rules if you choose update mode
     * Example:
     * [
     *      'name' => 'concat_ws(' ', name, VALUES(name))'
     * ]
     */
    public function setUpdateParams(array $updateParams): void ;

    /**
     * @param integer $size Put a size of wanted chunks
     * Example:
     * For the next data
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
     * with the chunkSize = 2 will be executed two queries
     * ... (`name`) VALUES ('Foo','Bar');
     * ... (`name`) VALUES ('Baz');
     */
    public function setChunkSize(int $size): void ;

    /**
     * Execute queries
     */
    public function execute(): void;
}
