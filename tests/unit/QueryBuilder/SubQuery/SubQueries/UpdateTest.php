<?php

class UpdateTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldConstructUpdate()
    {
        $update = new \Orm\QueryBuilder\SubQuery\SubQueries\Update('tableName');
        $this->assertInstanceOf(\Orm\QueryBuilder\Query::class, $update);

        $traits = [
            get_class_methods(\Orm\QueryBuilder\SubQuery\QueryTraits\WhereSubQuery::class),
            get_class_methods(\Orm\QueryBuilder\SubQuery\QueryTraits\OrderBySubQuery::class),
        ];

        $methods = get_class_methods($update);

        foreach ($traits as $traitMethods) {
            foreach ($traitMethods as $method) {
                $this->assertContains($method, $methods);
            }
        }
    }

    public function testShouldSetupUpdate()
    {
        $updateQuery = new \Orm\QueryBuilder\SubQuery\SubQueries\Update('test_table');
        $updateQuery->set([
            'column' => 'value',
            'column2' => 'value2',
            'column3' => 'value3',
        ]);

        $property = (new ReflectionClass($updateQuery))->getProperty('set');
        $property->setAccessible(true);

        $this->assertEquals([
            ['column', 'value'],
            ['column2', 'value2'],
            ['column3', 'value3'],
        ], $property->getValue($updateQuery));
    }

    public function testShouldBuildSubQuery()
    {
        $update = new \Orm\QueryBuilder\SubQuery\SubQueries\Update('update_table');

        $results = $update->set([
            'column1' => 'value1',
            'column2' => 'value2'
        ])
            ->where('column1=?', [1])
            ->orWhere('column1=?', [2])
            ->andWhere('column2 LIKE ?', ['value2']);

        $reflectionClass = new \ReflectionClass($update);
        $method = $reflectionClass->getMethod('getSubQuery');
        $method->setAccessible(true);
        $query = $method->invoke($update);

        $this->assertEquals("UPDATE update_table SET column1=?, column2=? WHERE column1=? OR (column1=? AND (column2 LIKE ?))", $query->__toString());
    }
}
