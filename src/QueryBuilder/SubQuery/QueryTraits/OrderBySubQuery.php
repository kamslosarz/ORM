<?php

namespace Orm\QueryBuilder\SubQuery\QueryTraits;

use Orm\QueryBuilder\SubQuery\SubQuery;

trait OrderBySubQuery
{
    private $orderBy = [];
    private static $directions = [
        'asc' => 'ASC',
        'desc' => 'DESC'
    ];

    public function orderBy($column, $direction): self
    {
        return $this->addOrderBy($column, $direction);
    }

    public function addOrderBy($column, $direction): self
    {
        $this->orderBy[$column] = $direction;

        return $this;
    }

    private function buildOrderBy(SubQuery &$subQuery): void
    {
        if (!empty($this->orderBy)) {
            $subQuery->addSubQuery(' ORDER BY ');
            $index = 1;
            $size = sizeof($this->orderBy);
            foreach ($this->orderBy as $column => $direction) {
                $subQuery->addSubQuery(sprintf('%s %s', $column, self::$directions[$direction]));
                if ($index++ < $size) {
                    $subQuery->addSeparator(',');
                }
            }
        }
    }
}