<?php

class SelectTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldConstructSelect()
    {
        $select = new \Orm\QueryBuilder\SubQuery\SubQueries\Select('column1, column2');
        $this->assertInstanceOf(\Orm\QueryBuilder\Query::class, $select);

        $traits = [
            get_class_methods(\Orm\QueryBuilder\SubQuery\QueryTraits\WhereSubQuery::class),
            get_class_methods(\Orm\QueryBuilder\SubQuery\QueryTraits\LimitSubQuery::class),
            get_class_methods(\Orm\QueryBuilder\SubQuery\QueryTraits\OrderBySubQuery::class),
            get_class_methods(\Orm\QueryBuilder\SubQuery\QueryTraits\LeftJoinSubQuery::class),
        ];

        $methods = get_class_methods($select);

        foreach ($traits as $traitMethods) {
            foreach ($traitMethods as $method) {
                $this->assertContains($method, $methods);
            }
        }
    }

    public function testShouldSetUpSelectFromProperty()
    {
        $select = new \Orm\QueryBuilder\SubQuery\SubQueries\Select('*');
        $select->from('test_table_name');

        $reflectionClass = new \ReflectionClass($select);
        $property = $reflectionClass->getProperty('from');
        $property->setAccessible(true);

        $this->assertEquals('test_table_name', $property->getValue($select));
    }

    public function testShouldBuildSubQuery()
    {
        $select = new \Orm\QueryBuilder\SubQuery\SubQueries\Select('*');
        $select->from('tableName')
            ->join('testTableRelation', 'tableName.id==testTableRelation.id')
            ->where('whereColumn=1')
            ->orWhere('orWhereColumn=1')
            ->andWhere('andWhereColumn=1')
            ->orWhere('orWhereColumn=2')
            ->andWhere('andWhereColumn=2')
            ->limit(0, 2)
            ->orderBy('orderBY', 'desc')
            ->groupBy('groupBy')
            ->addOrderBy('addOrderBy', 'asc');

        $reflectionClass = new \ReflectionClass($select);
        $method = $reflectionClass->getMethod('getSubQuery');
        $method->setAccessible(true);
        $query = $method->invoke($select);

        $this->assertEquals('SELECT * FROM tableName LEFT JOIN (testTableRelation) ON (tableName.id==testTableRelation.id) WHERE whereColumn=1 OR (orWhereColumn=1 AND (andWhereColumn=1 OR (orWhereColumn=2 AND (andWhereColumn=2)))) GROUP BY groupBy ORDER BY orderBY DESC, addOrderBy ASC LIMIT 0, 2', $query->__toString());
    }
}