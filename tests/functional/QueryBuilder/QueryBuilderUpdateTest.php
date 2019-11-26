<?php

class QueryBuilderUpdateTest extends \Test\TestCases\DatabaseTestCase
{
    public function testShouldUpdateRows()
    {
        $queryBuilder = new \Orm\QueryBuilder\QueryBuilder();
        $databaseResults = $queryBuilder->update('update_table')
            ->set([
                'column1' => 2,
                'column2' => 'some value'
            ])
            ->where('id=1')
            ->orWhere('id=2')
            ->execute();

        $this->assertEquals(2, $databaseResults->getAffectedRows());

        $pdo = $this->getConnection()->getConnection();
        $stmt = $pdo->query('SELECT * FROM update_table where id=1 OR id=2');
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->assertEquals(2, $items[0]['column1']);
        $this->assertEquals(2, $items[1]['column1']);
    }

    protected function getDataSet()
    {
        return new \PHPUnit\DbUnit\DataSet\ArrayDataSet([
            'update_table' => [
                [
                    'id' => 1,
                    'column1' => 1,
                    'column2' => 'column2'
                ], [
                    'id' => 2,
                    'column1' => 1,
                    'column2' => 'column2'
                ]
            ],
        ]);
    }
}