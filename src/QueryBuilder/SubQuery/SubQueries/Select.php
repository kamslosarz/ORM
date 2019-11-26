<?php

namespace Orm\QueryBuilder\SubQuery\SubQueries;

use Orm\QueryBuilder\Query;
use Orm\QueryBuilder\SubQuery\QueryTraits\GroupBySubQuery;
use Orm\QueryBuilder\SubQuery\QueryTraits\LeftJoinSubQuery;
use Orm\QueryBuilder\SubQuery\QueryTraits\LimitSubQuery;
use Orm\QueryBuilder\SubQuery\QueryTraits\OrderBySubQuery;
use Orm\QueryBuilder\SubQuery\QueryTraits\WhereSubQuery;
use Orm\QueryBuilder\SubQuery\SubQuery;

class Select extends Query
{
    use WhereSubQuery, LimitSubQuery, OrderBySubQuery, LeftJoinSubQuery, GroupBySubQuery;

    private $select;
    private $from;

    public function __construct($select)
    {
        $this->select = $select;
    }

    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }

    protected function getSubQuery(): SubQuery
    {
        $subQuery = (new SubQuery())->addSubQuery(sprintf('SELECT %s FROM %s', $this->select, $this->from));

        $this->buildJoins($subQuery);
        $this->buildWhere($subQuery);
        $this->buildGroupBy($subQuery);
        $this->buildOrderBy($subQuery);
        $this->buildLimit($subQuery);

        return $subQuery;
    }
}