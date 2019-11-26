<?php

class QueryBuilderSelectTest extends \Test\TestCases\DatabaseTestCase
{
    public function testShouldSelectCollection()
    {
        $queryBuilder = new \Orm\QueryBuilder\QueryBuilder();

        $collection = $queryBuilder->select('field, fourthField, orderField')
            ->from('test_table')
            ->limit(0, 10)
            ->orderBy('orderField', 'desc')
            ->groupBy('orderField')
            ->addOrderBy('field', 'asc')
            ->execute()
            ->getCollection();

        $this->assertCount(10, $collection);

        $expectedArray = [];
        for ($i = 99; $i >= 90; $i--) {
            $expectedArray[] = [
                'field' => "$i",
                'fourthField' => 'fourthField',
                'orderField' => ($i + 1) . ''
            ];
        }

        $this->assertEquals($collection->__toArray(), $expectedArray);
    }

    public function testShouldSelectGroupedCollection()
    {
        $queryBuilder = new \Orm\QueryBuilder\QueryBuilder();
        $collection = $queryBuilder->select('*')
            ->from('test_table')
            ->groupBy('fifthField')
            ->execute()
            ->getCollection();

        $this->assertCount(1, $collection);
    }

    public function testShouldJoinTable()
    {
        $queryBuilder = new \Orm\QueryBuilder\QueryBuilder();

        //dorobić parsowanie
        $collection = $queryBuilder->select('*')
            ->from('test_table')
            ->join('test_table_joins', 'field=test_table_field')
            ->limit(0, 1)
            ->execute()
            ->getCollection();

        $this->assertEquals([
            'field' => '1',
            'secondField' => '2',
            'thirdField' => 'thirdField',
            'fourthField' => 'fourthField',
            'fifthField' => '0',
            'orderField' => '2',
            'id' => '1',
            'test_table_field' => '1',
            'joinedField' => 'joinedField',
        ], $collection->first());

    }

    protected function getDataSet()
    {
        $testTable = [];
        $testTableJoins = [];
        for ($i = 1; $i < 100; $i++) {
            $testTable[] = [
                'field' => $i,
                'secondField' => 2,
                'thirdField' => 'thirdField',
                'fourthField' => 'fourthField',
                'fifthField' => '0',
                'orderField' => $i + 1,
            ];
            $testTableJoins[] = [
                'id' => $i,
                'test_table_field' => $i,
                'joinedField' => 'joinedField',
            ];
        }

        return new \PHPUnit\DbUnit\DataSet\ArrayDataSet([
            'test_table' => $testTable,
            'test_table_joins' => $testTableJoins
        ]);
    }
}