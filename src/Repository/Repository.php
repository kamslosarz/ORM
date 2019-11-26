<?php

namespace Orm\Repository;

use Orm\Orm;
use Orm\QueryBuilder\QueryBuilder;
use Orm\SchemaBuilder\Table\Table;

class Repository
{
    private $table;
    private $queryBuilder;
    private $mapper;

    public function __construct(Table $table, QueryBuilder $queryBuilder)
    {
        $schema = Orm::getSchema();
        $this->table = $table;
        $this->mapper = $schema->getMapper();
        $this->queryBuilder = $queryBuilder;
    }

    public function getAll()
    {
        return $this->mapper->getModelCollection(
            $this->table,
            $this->queryBuilder->select('*')
                ->from($this->table->getName())
                ->execute()
                ->getCollection());
    }
}
