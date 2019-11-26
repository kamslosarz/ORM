<?php

use Mockery as m;
use PHPUnit\Framework\TestCase;

class LeftJoinSubQueryTest extends TestCase
{
    public function testShouldAddJoin()
    {
        $leftJoinSubQuery = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\LeftJoinSubQuery::class);

        $leftJoinSubQuery->join('some_table', 'some_table.id=some_other_table.some_table_id')
            ->addJoin('some_table', 'some_table.id=some_other_table_other.some_table_id');

        $property = (new ReflectionClass($leftJoinSubQuery))->getProperty('joins');
        $property->setAccessible(true);

        $this->assertEquals([
            ['some_table', 'some_table.id=some_other_table.some_table_id'],
            ['some_table', 'some_table.id=some_other_table_other.some_table_id']
        ], $property->getValue($leftJoinSubQuery));
    }

    /**
     * @doesNotPerformAssertions
     * @throws ReflectionException
     */
    public function testShouldBuildJoins()
    {
        $leftJoinSubQuery = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\LeftJoinSubQuery::class);

        $leftJoinSubQuery->join('some_table', 'some_table.id=some_other_table.some_table_id')
            ->addJoin('some_table', 'some_table.id=some_other_table_other.some_table_id');

        $subQueryMock = m::mock(\Orm\QueryBuilder\SubQuery\SubQuery::class)
            ->shouldReceive('addSubQuery')
            ->with(' LEFT JOIN (some_table) ON (some_table.id=some_other_table.some_table_id)')
            ->once()
            ->getMock()
            ->shouldReceive('addSubQuery')
            ->with(' LEFT JOIN (some_table) ON (some_table.id=some_other_table_other.some_table_id)')
            ->once()
            ->getMock();

        $buildMethod = (new ReflectionClass($leftJoinSubQuery))->getMethod('buildJoins');
        $buildMethod->setAccessible(true);
        $buildMethod->invokeArgs($leftJoinSubQuery, [&$subQueryMock]);

        $subQueryMock->shouldHaveReceived('addSubQuery')->twice();
    }
}