<?php

class QueryBuilderDeleteTest extends \Test\TestCases\DatabaseTestCase
{
    public function testShouldDeleteRows()
    {
        $queryBuilder = new \Orm\QueryBuilder\QueryBuilder();
        $delete = $queryBuilder->delete()
            ->from('delete_table')
            ->where('id=1')
            ->orWhere('id=2');
        $delete->execute();

        $this->assertEquals(2, $delete->getAffectedRows());

        $stmt = $this->getConnection()->getConnection()->query('SELECT * FROM delete_table');
        $stmt->execute();
        $this->assertEquals([[
            'id' => 3,
            'column1' => 1,
            'column2' => 'column2'
        ]], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    protected function getDataSet()
    {
        return new \PHPUnit\DbUnit\DataSet\ArrayDataSet([
            'delete_table' => [
                [
                    'id' => 1,
                    'column1' => 1,
                    'column2' => 'column2'
                ], [
                    'id' => 2,
                    'column1' => 1,
                    'column2' => 'column2'
                ], [
                    'id' => 3,
                    'column1' => 1,
                    'column2' => 'column2'
                ]
            ],
        ]);
    }
}