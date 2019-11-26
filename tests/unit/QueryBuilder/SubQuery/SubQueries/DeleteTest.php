<?php

class DeleteTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldConstructDelete()
    {
        $delete = new \Orm\QueryBuilder\SubQuery\SubQueries\Delete();
        $this->assertInstanceOf(\Orm\QueryBuilder\Query::class, $delete);
    }

    public function testShouldSetUpDeleteFromProperty()
    {
        $delete = new \Orm\QueryBuilder\SubQuery\SubQueries\Delete();
        $delete->from('delete_table');

        $reflectionClass = new \ReflectionClass($delete);
        $property = $reflectionClass->getProperty('from');
        $property->setAccessible(true);

        $this->assertEquals('delete_table', $property->getValue($delete));
    }

    public function testShouldBuildSubQuery()
    {
        $delete = new \Orm\QueryBuilder\SubQuery\SubQueries\Delete();

        $delete->from('delete_Table');
        $delete->where('id=1');
        $delete->orWhere('id=2');
        $delete->andWhere('test=?', [1]);

        $reflectionClass = new \ReflectionClass($delete);
        $method = $reflectionClass->getMethod('getSubQuery');
        $method->setAccessible(true);
        /** @var \Orm\QueryBuilder\SubQuery\SubQuery $subQuery */
        $subQuery = $method->invoke($delete);

        $this->assertEquals([1], $subQuery->getBinds());
        $this->assertEquals('DELETE FROM delete_Table WHERE id=1 OR (id=2 AND (test=?))', $subQuery->__toString());
    }
}