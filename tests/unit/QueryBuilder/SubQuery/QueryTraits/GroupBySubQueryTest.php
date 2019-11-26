<?php

use Mockery as m;

class GroupBySubQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldSetGroupBy()
    {
        $groupBySubQueryTest = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\GroupBySubQuery::class);

        $groupBySubQueryTest->groupBy('group_field')
            ->addGroupBy('second_group_field');

        $property = (new ReflectionClass($groupBySubQueryTest))->getProperty('groupBy');
        $property->setAccessible(true);

        $this->assertEquals([
            'group_field',
            'second_group_field'
        ], $property->getValue($groupBySubQueryTest));
    }

    /**
     * @doesNotPerformAssertions
     * @throws ReflectionException
     */
    public function testShouldBuildGroupBy()
    {
        $groupBySubQueryTest = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\GroupBySubQuery::class);

        $groupBySubQueryTest->groupBy('second_group_by_column')
            ->addGroupBy('second_group_by_column')
            ->addGroupBy('another_group_by_column');

        $subQueryMock = m::mock(\Orm\QueryBuilder\SubQuery\SubQuery::class)
            ->shouldReceive('addSubQuery')
            ->with(' GROUP BY ')
            ->getMock()
            ->shouldReceive('addSubQuery')
            ->with('second_group_by_column')
            ->getMock()
            ->shouldReceive('addSubQuery')
            ->with('second_group_by_column')
            ->getMock()
            ->shouldReceive('addSubQuery')
            ->with('another_group_by_column')
            ->getMock()
            ->shouldReceive('addSeparator')
            ->with(',')
            ->getMock();

        $method = (new ReflectionClass($groupBySubQueryTest))->getMethod('buildGroupBy');
        $method->setAccessible(true);
        $method->invokeArgs($groupBySubQueryTest, [&$subQueryMock]);

        $subQueryMock->shouldHaveReceived('addSubQuery')->times(4);
        $subQueryMock->shouldHaveReceived('addSeparator')->times(2);
    }
}