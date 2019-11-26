<?php

namespace Orm\QueryBuilder;

use Orm\DatabaseConnection\Collection\Collection;
use Orm\DatabaseConnection\DatabaseResults;
use Orm\Orm;
use Orm\QueryBuilder\SubQuery\SubQuery;

/**
 * Class Query
 * @package Orm\QueryBuilder
 */
abstract class Query
{
    /** @var DatabaseResults $databaseResults */
    private $databaseResults;

    /**
     * @return Query
     */
    public function execute(): self
    {
        $query = $this->getSubQuery();
        $databaseConnection = Orm::getDatabaseConnection();
        $this->databaseResults = $databaseConnection->getDefaultConnection()->execute($query, $query->getBinds());

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->databaseResults->getCollection();
    }

    /**
     * @return int
     */
    public function getLastInsertId(): int
    {
        return $this->databaseResults->getLastInsertId();
    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {

        return $this->databaseResults->getAffectedRows();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getSubQuery();
    }

    /**
     * @return SubQuery
     */
    abstract protected function getSubQuery(): SubQuery;
}