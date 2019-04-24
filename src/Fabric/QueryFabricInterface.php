<?php


namespace MultiInsert\Component\Fabric;

use MultiInsert\Component\Query\QueryInterface;

/**
 * Interface QueryFabricInterface
 *
 * @package MultiInsert\Component\Fabric
 */
interface QueryFabricInterface
{

    /**
     * @return QueryInterface
     */
    public function createQuery() : QueryInterface ;
}
