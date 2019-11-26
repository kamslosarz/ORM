<?php

namespace Orm\SchemaBuilder;

use Orm\SchemaBuilder\Table\Table;

class SchemaBuilder
{
    private $schema;

    public function addTable(Table $table): self
    {
        $this->schema['tables'][] = $table;

        return $this;
    }

    public function build(): array
    {
        return $this->schema;
    }
}