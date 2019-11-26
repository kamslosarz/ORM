<?php

namespace Orm\DatabaseConnection\Adapter;

use Orm\DatabaseConnection\DatabaseResults;

interface PdoConnectionInterface
{
    public function execute($query, array $binds = []): DatabaseResults;

    public function getPdo(): \PDO;
}