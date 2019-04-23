<?php

namespace MultiInsert\Component\Query;

/**
 * Interface QueryInterface
 *
 * @package MultiInsert\Component\Query
 */
interface QueryInterface
{

    /**
     * Set sql query to the object.
     *
     * @param string $query Put Sql query to process.
     * Example: 'INSERT INTO `table` (column1, column2, ...)
     * VALUES (value1, value2, ...)'
     *
     * @return void
     */
    public function setSqlQuery(string $query): void ;

    /**
     * Set values for the query
     *
     * @param array $params Put array with values to process
     * ['Foo','Bar']
     */
    public function setParams(array $params): void ;

    /**
     * Execute the query using your Connection (driver, adapter or smth)
     */
    public function execute(): void ;
}
