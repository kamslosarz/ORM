<?php

use Mockery as m;

class LimitSubQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldSetLimit()
    {
        /** @var \Orm\QueryBuilder\SubQuery\QueryTraits\LimitSubQuery $limitSubQuery */
        $limitSubQuery = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\LimitSubQuery::class)
            ->makePartial();

        $limitSubQuery->limit(10, 100);

        $property = (new \ReflectionClass($limitSubQuery))->getProperty('limit');
        $property->setAccessible(true);

        $this->assertEquals([10, 100], $property->getValue($limitSubQuery));
    }

    public function testShouldCheckIfHasLimit()
    {
        /** @var \Orm\QueryBuilder\SubQuery\QueryTraits\LimitSubQuery $limitSubQuery */
        $limitSubQuery = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\LimitSubQuery::class)
            ->makePartial();

        $limitSubQuery->limit(10, 100);

        $reflectionClass = new \ReflectionClass($limitSubQuery);

        $hasLimitMethod = $reflectionClass->getMethod('hasLimit');
        $hasLimitMethod->setAccessible(true);
        $results = $hasLimitMethod->invoke($limitSubQuery);

        $this->assertTrue($results);

        $property = $reflectionClass->getProperty('limit');
        $property->setAccessible(true);
        $property->setValue($limitSubQuery, []);

        $this->assertFalse($hasLimitMethod->invoke($limitSubQuery));
    }

    /**
     * @doesNotPerformAssertions
     * @throws ReflectionException
     */
    public function testShouldBuildLimitSubQuery()
    {
        $limitSubQuery = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\LimitSubQuery::class)
            ->makePartial();

        $limitSubQuery->limit(10, 100);

        $subQueryMock = m::mock(\Orm\QueryBuilder\SubQuery\SubQuery::class)
            ->shouldReceive('addSubQuery')
            ->with(' LIMIT 10, 100')
            ->once()
            ->getMock();

        $method = (new ReflectionClass($limitSubQuery))->getMethod('buildLimit');
        $method->setAccessible(true);
        $method->invokeArgs($limitSubQuery, [&$subQueryMock]);

        $subQueryMock->shouldHaveReceived('addSubQuery');
    }
}