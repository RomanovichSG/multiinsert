<?php

namespace MultiInsert\Component\Query;

/**
 * Class AbstractQuery
 *
 * @package MultiInsert\Component\Query
 */
abstract class AbstractQuery implements QueryInterface
{

    /**
     * @var string
     */
    protected $query;

    /**
     * @var array
     */
    protected $params;

    /**
     * @inheritDoc
     */
    public function setSqlQuery(string $query): void
    {
        $this->query = $query;
    }

    /**
     * @inheritDoc
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $this->process();
    }

    abstract protected function process() : void ;
}
