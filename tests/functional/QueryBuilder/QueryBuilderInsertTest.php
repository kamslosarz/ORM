<?php

class QueryBuilderInsertTest extends \Test\TestCases\DatabaseTestCase
{
    public function testShouldInsertRows()
    {
        $insertValues = [[1, 1, 'column2 value'], [2, 1, 'second row column2 value']];
        $insertColumns = ['id', 'column1', 'column2'];
        $queryBuilder = new \Orm\QueryBuilder\QueryBuilder();
        $insert = $queryBuilder->insert()
            ->into('insert_table')
            ->columns($insertColumns)
            ->values($insertValues);

        $results = $insert->execute();

        $stmt = $this->getConnection()->getConnection()->query('SELECT * FROM insert_table');
        $stmt->execute();

        array_walk($insertValues, function (&$item) use ($insertColumns) {
            $item = array_combine($insertColumns, $item);
        });

        $this->assertEquals($insertValues, $stmt->fetchAll(PDO::FETCH_ASSOC));
        $this->assertEquals(2, $results->getLastInsertId());
    }

    protected function getDataSet()
    {
        return new \PHPUnit\DbUnit\DataSet\ArrayDataSet([]);
    }
}