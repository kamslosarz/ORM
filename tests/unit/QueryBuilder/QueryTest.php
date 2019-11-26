<?php

use Mockery as m;

class QueryTest extends \Test\TestCases\DatabaseTestCase
{
    public function testShouldExecuteSubQuery()
    {
        $queryMock = m::mock(\Orm\QueryBuilder\Query::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $subQuery =
            m::mock(\Orm\QueryBuilder\SubQuery\SubQuery::class)
                ->shouldReceive('__toString')
                ->andReturn('SELECT * FROM `test_table`')
                ->getMock()
                ->shouldReceive('getBinds')
                ->andReturn([])
                ->getMock();

        $queryMock
            ->shouldReceive('getSubQuery')
            ->andReturn($subQuery);

        /** @var \Orm\QueryBuilder\Query $queryMock */
        $queryMock->execute();

        $this->assertInstanceOf(\Orm\DatabaseConnection\Collection\Collection::class, $queryMock->getCollection());
        $this->assertEquals(1, $queryMock->getLastInsertId());

        $queryMock->shouldHaveReceived('getSubQuery');
        $subQuery->shouldHaveReceived('__toString');
        $subQuery->shouldHaveReceived('getBinds');
    }

    protected function getDataSet()
    {
        return new \PHPUnit\DbUnit\DataSet\ArrayDataSet([
            'test_table' => [
                [
                    'field' => 1
                ]
            ]
        ]);
    }
}