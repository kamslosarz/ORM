<?php

namespace Orm\Schema;

use Orm\Repository\Mapper\Mapper;

class Schema
{
    private $schema = [];
    private $mapper;

    public function __construct(array $config, array $schema)
    {
        $this->schema = $schema;
        $this->mapper = new Mapper($config['mapper'], $this);
    }

    public function getMapper(): Mapper
    {
        return $this->mapper;
    }

    public function getTables(): array
    {
        return $this->schema['tables'];
    }
}
