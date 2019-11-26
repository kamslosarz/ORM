<?php

use Orm\SchemaBuilder\Factory\SchemaFactory;

class SchemaBuilderTest extends \Test\TestCases\DatabaseTestCase
{
    public function testShouldBuildSchema()
    {
        $schemaBuilder = new \Orm\SchemaBuilder\SchemaBuilder();

        $schema = $schemaBuilder
            ->addTable(SchemaFactory::createTable('users')
                ->addColumn(SchemaFactory::createColumn('id')
                    ->setPrimaryKey(true)
                    ->setRequired(true)
                    ->setType('integer')
                    ->setAutoIncrement(true))
                ->setPrimaryKey('id')
                ->addColumn(SchemaFactory::createColumn('username')
                    ->setType('varchar')
                    ->setSize(255)
                    ->setRequired(true)))
            ->addTable(SchemaFactory::createTable('addressees')
                ->setPrimaryKey('address_id')
                ->addColumn(SchemaFactory::createColumn('address_id')
                    ->setPrimaryKey(true)
                    ->setRequired('true')
                    ->setAutoIncrement(true)
                    ->setType('integer'))
                ->addColumn(SchemaFactory::createColumn('address')
                    ->setType('varchar')
                    ->setSize(255)
                    ->setRequired(true))
            )->build();

        $this->assertCount(2, $schema['tables']);
        $this->assertEquals('users', $schema['tables'][0]->getName());
        $this->assertEquals('addressees', $schema['tables'][1]->getName());
    }

    protected function getDataSet()
    {
        return new \PHPUnit\DbUnit\DataSet\ArrayDataSet([]);
    }
}