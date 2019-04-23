<?php

namespace MultiInsert\Component\MultiInsert;

use MultiInsert\Component\QueryBuilder\QueryBuilderInterface;

/**
 * Class MultiInsert
 *
 * @package MultiInsert\Component\MultiInsert
 */
class MultiInsert implements MultiInsertInterface
{

    /**
     * @var QueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $rows;

    /**
     * @var array
     */
    protected $columns;

    /**
     * @var int
     */
    protected $mode;

    /**
     * @var array
     */
    protected $updateParams;

    /**
     * @var int
     */
    protected $chunkSize = 50;

    /**
     * @inheritDoc
     */
    public function __construct(QueryBuilderInterface $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @inheritDoc
     */
    public function setTable(string $name): void
    {
        $this->table = $name;
    }

    /**
     * @inheritDoc
     */
    public function setRows(array $rows): void
    {
        $this->rows = $rows;
    }

    /**
     * @inheritDoc
     */
    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    /**
     * @inheritDoc
     */
    public function setMode(int $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * @inheritDoc
     */
    public function setUpdateParams(array $updateParams): void
    {
        $this->updateParams = $updateParams;
    }

    /**
     * @inheritDoc
     *
     * @throws \InvalidArgumentException
     */
    public function setChunkSize(int $size): void
    {
        if ($size < 1) {
            throw new \InvalidArgumentException('Chunk size must be greater than zero');
        }

        $this->chunkSize = $size;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        if ($this->rows === null) {
            return;
        }

        $chunks = array_chunk($this->rows, $this->chunkSize);

        foreach ($chunks as $chunk) {
            if (!is_array($chunk) || empty($chunk)) {
                continue;
            }

            $qb = $this->queryBuilder;
            $qb->setRows($chunk);

            if ($this->table !== null) {
                $qb->setTable($this->table);
            }

            if ($this->columns !== null) {
                $qb->setColumns($this->columns);
            }

            if ($this->mode !== null) {
                $qb->setMode($this->mode);
            }

            if ($this->updateParams !== null) {
                $qb->setUpdateParams($this->updateParams);
            }

            $qb->getQuery()
                ->execute();
        }
    }
}
