<?php

namespace Orm\SchemaBuilder\Table;

use Orm\SchemaBuilder\Table\Column\Column;

class Table
{
    private $name;
    private $primaryKey;
    private $columns;
    private $foreignKeys;
    private $modelName;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addColumn(Column $column): self
    {
        $this->columns[$column->getName()] = $column;

        return $this;
    }

    public function addForeignKey($local, $foreign): self
    {
        $this->foreignKeys[$local] = $foreign;

        return $this;
    }

    public function setPrimaryKey($primaryKey): self
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getModelName(): string
    {
        if ($this->modelName) {

            return $this->modelName;
        }

        return str_replace(' ', '', ucwords(str_replace('_', ' ', $this->modelName)));
    }

    public function setModelName($modelName): self
    {
        $this->modelName = $modelName;

        return $this;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function __toArray(): array
    {
        return [
            'name' => $this->name,
            'primaryKey' => $this->primaryKey,
            'columns' => $this->columns,
            'foreignKeys' => $this->foreignKeys,
        ];
    }
}