<?php

class SubQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldBuildSubQuery()
    {
        $subQuery = new \Orm\QueryBuilder\SubQuery\SubQuery();

        $subQuery->addSubQuery('SELECT * FROM `test_table`')
            ->addSubQuery(' WHERE column=:parameterName')
            ->addSeparator('and')
            ->inBracket()
            ->addSubQuery('column2=2')
            ->addSeparator('or')
            ->addSubQuery('column3=3')
            ->addSeparator('or')
            ->inBracket()
            ->addSubQuery('column2=3')
            ->addSeparator('and')
            ->addSubQuery('column3=4');

        $this->assertEquals('SELECT * FROM `test_table` WHERE column=:parameterName AND (column2=2 OR column3=3 OR (column2=3 AND column3=4))', $subQuery->__toString());
    }

    public function testShouldSetBinds()
    {
        $subQuery = new \Orm\QueryBuilder\SubQuery\SubQuery();
        $subQuery->pushBind(1234);
        $subQuery->addBind('test', 123);
        $subQuery->addBind('test2', 123);
        $subQuery->pushBind(1234);

        $this->assertEquals([
            1234,
            'test' => 123,
            'test2' => 123,
            1234,
        ], $subQuery->getBinds());
    }
}