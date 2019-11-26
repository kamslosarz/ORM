<?php

use Mockery as m;

class OrderBySubQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldSetOrderBy()
    {
        $orderBySubQuery = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\OrderBySubQuery::class)
            ->makePartial();

        $orderBySubQuery->orderBY('test', 'asc');
        $orderBySubQuery->addOrderBY('test2', 'desc');

        $reflectionClass = new \ReflectionClass($orderBySubQuery);
        $orderBy = $reflectionClass->getProperty('orderBy');
        $orderBy->setAccessible(true);

        $this->assertEquals([
            'test' => 'asc',
            'test2' => 'desc'
        ], $orderBy->getValue($orderBySubQuery));
    }

    /**
     * @doesNotPerformAssertions
     * @throws ReflectionException
     */
    public function testShouldBuildOrderBy()
    {
        $orderBySubQuery = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\OrderBySubQuery::class)
            ->makePartial();

        $orderBySubQuery->orderBy('column', 'desc')
            ->addOrderBy('column2', 'asc');

        $subQueryMock = m::mock(\Orm\QueryBuilder\SubQuery\SubQuery::class)
            ->shouldReceive('addSubQuery')
            ->with(' ORDER BY ')
            ->once()
            ->getMock()
            ->shouldReceive('addSubQuery')
            ->with('column DESC')
            ->once()
            ->getMock()
            ->shouldReceive('addSubQuery')
            ->with('column2 ASC')
            ->once()
            ->getMock()
            ->shouldReceive('addSeparator')
            ->with(',')
            ->once()
            ->getMock();

        $methodBuildOrderBy = (new \ReflectionClass($orderBySubQuery))->getMethod('buildOrderBy');
        $methodBuildOrderBy->setAccessible(true);
        $methodBuildOrderBy->invokeArgs($orderBySubQuery, [&$subQueryMock]);

        $subQueryMock->shouldHaveReceived('addSubQuery')->times(3);
        $subQueryMock->shouldHaveReceived('addSeparator')->once(1);
    }
}