<?php

namespace Orm\Repository\Mapper;

use Orm\DatabaseConnection\Collection\Collection;
use Orm\Repository\Mapper\ModelCollection\ModelCollection;
use Orm\Schema\Schema;
use Orm\SchemaBuilder\Table\Table;

class Mapper
{
    private $config;
    private $schema;
    private $modelMap;
    private $modelNamespaceTables;

    public function __construct(array $config, Schema $schema)
    {
        $this->config = $config;
        $this->schema = $schema;
        $this->prepareModelMap();
    }

    private function prepareModelMap(): void
    {
        /** @var Table $table */
        foreach ($this->schema->getTables() as $table) {
            $modelNamespace = sprintf('%s//%s', $this->config['modelNamespace'], $table->getModelName());
            $this->modelMap[$table->getModelName()] = $modelNamespace;
            $this->modelNamespaceTables[$modelNamespace] = $table;
        }
    }

    public function getModelTable($modelNamespace): Table
    {
        return $this->modelNamespaceTables[$modelNamespace];
    }

    public function getModelCollection(Table $table, Collection $collection): ModelCollection
    {
        return new ModelCollection(iterator_to_array((function () use ($table, $collection) {
            foreach ($collection as $data) {
                $modelNamespace = $this->modelMap[$table->getModelName()];

                yield new $modelNamespace($data);
            }
        })()));
    }
}