<?php

namespace Orm\QueryBuilder\SubQuery\SubQueries;

use Orm\QueryBuilder\Query;
use Orm\QueryBuilder\SubQuery\QueryTraits\OrderBySubQuery;
use Orm\QueryBuilder\SubQuery\QueryTraits\WhereSubQuery;
use Orm\QueryBuilder\SubQuery\SubQuery;

class Update extends Query
{
    private $table;
    private $set = [];

    use WhereSubQuery, OrderBySubQuery;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function set(array $set): self
    {
        foreach ($set as $parameter => $value) {
            $this->set[] = [$parameter, $value];
        }

        return $this;
    }

    protected function getSubQuery(): SubQuery
    {
        $subQuery = new SubQuery();
        $this->buildUpdate($subQuery);
        $this->buildWhere($subQuery);
        $this->buildOrderBy($subQuery);

        return $subQuery;
    }

    private function buildUpdate(SubQuery &$subQuery): void
    {
        $subQuery->addSubQuery(sprintf('UPDATE %s ', $this->table));
        if (!empty($this->set)) {
            $subQuery->addSubQuery('SET ');
            $count = count($this->set);
            $index = 1;
            foreach ($this->set as $set) {
                $subQuery->addSubQuery(sprintf('%s=?', $set[0]))
                    ->pushBind($set[1]);
                if ($index++ < $count) {
                    $subQuery->addSeparator(',');
                }
            }
        }
    }
}