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
     * @param string $query
     */
    public function setSqlQuery(string $query): void ;

    /**
     * @param array $params
     */
    public function setParams(array $params): void ;

    public function execute(): void ;
}
