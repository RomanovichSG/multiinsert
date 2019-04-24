<?php

namespace MultiInsert\Component\MultiInsert;

use InvalidArgumentException;
use MultiInsert\Component\QueryBuilder\QueryBuilderInterface;

/**
 * Class MultiInsert
 *
 * @package MultiInsert\Component\MultiInsert
 */
class MultiInsert
{

    /**
     * @var QueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * @var array
     */
    protected $rows;

    /**
     * @var int
     */
    protected $chunkSize = 50;

    /**
     * MultiInsert constructor.
     *
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(QueryBuilderInterface $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

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
    public function setRows(array $rows): void
    {
        $this->rows = $rows;
    }

    /**
     * @param string $name Put the table name
     */
    public function setTable(string $name): void
    {
        $this->queryBuilder->setTable($name);
    }

    /**
     * @param array $columns Put data for choosing columns to insert
     * Example:
     * ['id', 'name']
     */
    public function setColumns(array $columns): void
    {
        $this->queryBuilder->setColumns($columns);
    }

    /**
     * @param integer $mode Put mode for choosing the type of a query
     * Example:
     * QueryBuilderInterface::DEFAULT_MODE
     */
    public function setMode(int $mode): void
    {
        $this->queryBuilder->setMode($mode);
    }

    /**
     * @param array $updateParams Put update rules if you choose update mode
     * Example:
     * [
     *      'name' => 'concat_ws(' ', name, VALUES(name))'
     * ]
     */
    public function setUpdateParams(array $updateParams): void
    {
        $this->queryBuilder->setUpdateParams($updateParams);
    }

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
    public function setChunkSize(int $size): void
    {
        if ($size < 1) {
            throw new InvalidArgumentException('Chunk size must be greater than zero');
        }

        $this->chunkSize = $size;
    }

    /**
     * Execute queries
     */
    public function execute(): void
    {
        if ($this->rows === null) {
            throw new InvalidArgumentException('You must put rows to start inserting');
        }

        $chunks = array_chunk($this->rows, $this->chunkSize);

        foreach ($chunks as $chunk) {
            if (is_array($chunk) && !empty($chunk)) {
                $this->queryBuilder->setRows($chunk);
                $this->queryBuilder->getQuery()->execute();
            }
        }
    }
}
