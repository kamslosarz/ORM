<?php

use Mockery as m;

class WhereSubQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldSetWhere()
    {
        /** @var \Orm\QueryBuilder\SubQuery\QueryTraits\WhereSubQuery $whereSubQuery */
        $whereSubQuery = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\WhereSubQuery::class);

        $whereSubQuery->where('column1=?', [1])
            ->andWhere('column2=2')
            ->orWhere('column3=3')
            ->andWhere('column4=? OR column5=?', [4, 5]);


        $property = (new ReflectionClass($whereSubQuery))->getProperty('where');
        $property->setAccessible(true);

        $this->assertEquals([
            ['column1=?', [1]],
            ['and', 'column2=2', []],
            ['or', 'column3=3', []],
            ['and', 'column4=? OR column5=?', [4, 5]],
        ], $property->getValue($whereSubQuery));
    }


    /**
     * @doesNotPerformAssertions
     * @throws ReflectionException
     */
    public function testShouldBuildWhere()
    {
        $whereSubQuery = m::mock(\Orm\QueryBuilder\SubQuery\QueryTraits\WhereSubQuery::class);

        $whereSubQuery->where('column1=?', [1])
            ->andWhere('column2=2')
            ->orWhere('column3=:parameter AND column3=:parameter2', ['parameter' => 2, 'parameter2' => 3])
            ->andWhere('column4=? OR column5=?', [4, 5]);

        $subQueryMock = m::mock(\Orm\QueryBuilder\SubQuery\SubQuery::class)
            ->shouldReceive('addSubQuery')
            ->with(' WHERE ')
            ->once()
            ->getMock()
            ->shouldReceive('addSubQuery')
            ->with('column1=?')
            ->once()
            ->getMock()
            ->shouldReceive('addSubQuery')
            ->with('column2=2')
            ->once()
            ->getMock()
            ->shouldReceive('addSubQuery')
            ->with('column3=:parameter AND column3=:parameter2')
            ->once()
            ->getMock()
            ->shouldReceive('addSubQuery')
            ->with('column4=? OR column5=?')
            ->once()
            ->getMock()
            ->shouldReceive('pushBind')
            ->with(1)
            ->once()
            ->getMock()
            ->shouldReceive('pushBind')
            ->with(4)
            ->once()
            ->getMock()
            ->shouldReceive('pushBind')
            ->with(5)
            ->once()
            ->getMock()
            ->shouldReceive('addSeparator')
            ->with('and')
            ->once()
            ->getMock()
            ->shouldReceive('inBracket')
            ->once()
            ->getMock()
            ->shouldReceive('addSeparator')
            ->with('or')
            ->once()
            ->getMock()
            ->shouldReceive('addBind')
            ->withArgs(['parameter', 2])
            ->once()
            ->getMock()
            ->shouldReceive('addBind')
            ->withArgs(['parameter2', 3])
            ->once()
            ->getMock()
            ->shouldReceive('endBrackets')
            ->once()
            ->getMock();

        $method = (new ReflectionClass($whereSubQuery))->getMethod('buildWhere');
        $method->setAccessible(true);
        $method->invokeArgs($whereSubQuery, [&$subQueryMock]);

        $subQueryMock->shouldHaveReceived('endBrackets')->times(1);
        $subQueryMock->shouldHaveReceived('inBracket')->times(3);
        $subQueryMock->shouldHaveReceived('addBind')->times(2);
        $subQueryMock->shouldHaveReceived('addSeparator')->times(3);
        $subQueryMock->shouldHaveReceived('pushBind')->times(3);
        $subQueryMock->shouldHaveReceived('addSubQuery')->times(5);
    }
}