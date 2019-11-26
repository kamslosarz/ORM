<?php

namespace Orm\DatabaseConnection;

use Orm\DatabaseConnection\Collection\Collection;

class DatabaseResults
{
    private $resultsCollection;
    private $lastInsertId;
    private $affectedRows;

    public function __construct(array $results = [])
    {
        $this->resultsCollection = new Collection($results);
    }

    public function getCollection(): Collection
    {
        return $this->resultsCollection;
    }

    public function getLastInsertId(): int
    {
        return $this->lastInsertId;
    }

    public function setLastInsertId($lastInsertId): self
    {
        $this->lastInsertId = $lastInsertId;

        return $this;
    }

    public function getAffectedRows(): int
    {
        return $this->affectedRows;
    }

    public function setAffectedRows($affectedRows): self
    {
        $this->affectedRows = $affectedRows;

        return $this;
    }
}