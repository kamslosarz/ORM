<?php

class InsertTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldConstructInsert()
    {
        $insert = new \Orm\QueryBuilder\SubQuery\SubQueries\Insert();
        $this->assertInstanceOf(\Orm\QueryBuilder\Query::class, $insert);
    }

    public function testShouldSetUpInsertIntoProperty()
    {
        $insert = new \Orm\QueryBuilder\SubQuery\SubQueries\Insert();
        $insert->into('test_table_name');

        $reflectionClass = new \ReflectionClass($insert);
        $property = $reflectionClass->getProperty('into');
        $property->setAccessible(true);

        $this->assertEquals('test_table_name', $property->getValue($insert));
    }

    public function testShouldSetUpInsertValuesProperty()
    {
        $insert = new \Orm\QueryBuilder\SubQuery\SubQueries\Insert();
        $insert->values([[1], [2]]);

        $reflectionClass = new \ReflectionClass($insert);
        $property = $reflectionClass->getProperty('values');
        $property->setAccessible(true);

        $this->assertEquals([[1], [2]], $property->getValue($insert));
    }

    public function testShouldSetUpInsertColumnsProperty()
    {
        $insert = new \Orm\QueryBuilder\SubQuery\SubQueries\Insert();
        $insert->columns(['column1', 'column2']);

        $reflectionClass = new \ReflectionClass($insert);
        $property = $reflectionClass->getProperty('columns');
        $property->setAccessible(true);

        $this->assertEquals(['column1', 'column2'], $property->getValue($insert));
    }

    public function testShouldBuildSubQuery()
    {
        $insert = new \Orm\QueryBuilder\SubQuery\SubQueries\Insert();

        $insert->into('insert_Table');
        $insert->columns(['column1', 'column2']);
        $insert->values([[1, 2], [1, 2]]);

        $reflectionClass = new \ReflectionClass($insert);
        $method = $reflectionClass->getMethod('getSubQuery');
        $method->setAccessible(true);
        /** @var \Orm\QueryBuilder\SubQuery\SubQuery $subQuery */
        $subQuery = $method->invoke($insert);
        $this->assertEquals('INSERT INTO insert_Table (column1,column2) VALUES (?,?), (?,?)', $subQuery->__toString());
        $this->assertEquals([1,2,1,2], $subQuery->getBinds());
    }
}