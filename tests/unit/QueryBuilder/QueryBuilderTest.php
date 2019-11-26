<?php

namespace unit\QueryBuilder;

use Orm\QueryBuilder\QueryBuilder;
use Orm\QueryBuilder\SubQuery\SubQueries\Select;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testShouldCreateSelectBuilder()
    {
        $queryBuilder = new QueryBuilder();
        $select = $queryBuilder->select('COUNT(*)');

        $this->assertInstanceOf(Select::class, $select);
    }
}