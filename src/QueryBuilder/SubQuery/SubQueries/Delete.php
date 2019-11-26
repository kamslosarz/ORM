<?php

namespace Orm\QueryBuilder\SubQuery\SubQueries;


use Orm\QueryBuilder\Query;
use Orm\QueryBuilder\SubQuery\QueryTraits\WhereSubQuery;
use Orm\QueryBuilder\SubQuery\SubQuery;

class Delete extends Query
{
    use WhereSubQuery;

    private $from;

    protected function getSubQuery(): SubQuery
    {
        $subQuery = new SubQuery();
        $subQuery->addSubQuery(sprintf('DELETE FROM %s', $this->from));
        $this->buildWhere($subQuery);

        return $subQuery;
    }

    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }
}