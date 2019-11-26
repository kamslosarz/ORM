<?php

namespace Orm\SchemaBuilder\Factory;


use Orm\SchemaBuilder\Table\Column\Column;
use Orm\SchemaBuilder\Table\Table;

class SchemaFactory
{
    public static function createTable($tableName): Table
    {
        return new Table($tableName);
    }

    public static function createColumn($columnName): Column
    {
        return new Column($columnName);
    }
}