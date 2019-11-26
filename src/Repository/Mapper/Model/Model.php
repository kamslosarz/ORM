<?php

namespace Orm\Repository\Mapper\Model;

use Orm\Orm;
use Orm\QueryBuilder\QueryBuilder;
use Orm\SchemaBuilder\Table\Column\Column;
use Orm\SchemaBuilder\Table\Table;

abstract class Model implements ModelInterface
{
    private $primaryKey = null;
    private $data = [];
    private $table;

    public function __construct(array $data = [])
    {
        $this->table = Orm::getSchema()->getMapper()->getModelTable($this->getModelName());
        $this->data = $data;
    }

    public function save(): bool
    {
        $primaryKey = $this->data[$this->primaryKey];

        if (!$primaryKey) {
            $results = (new QueryBuilder())
                ->insert()
                ->into($this->table->getName())
                ->columns($this->table->getColumnsNames())
                ->values($this->getValues())
                ->execute();

            $this->data[$this->primaryKey] = $results->getLastInsertId();
        } else {
            (new QueryBuilder())
                ->update($this->table->getName())
                ->set($this->data)
                ->execute();
        }

        return $this->data[$this->primaryKey];
    }

    public function delete(): bool
    {
        return false;
    }

    private function getValues()
    {
        $values = function () {
            /** @var Column $column */
            foreach ($this->getTable()->getColumns() as $column) {
                yield [$column->getName() => $this->data[$column->getName()]] ?? $column->getDefault();
            }
        };

        return iterator_to_array($values());
    }

    protected function getTable(): Table
    {
        return $this->table;
    }

    abstract protected function getModelName(): string;
}