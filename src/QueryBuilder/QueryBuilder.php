<?php

namespace Orm\QueryBuilder;

use Orm\QueryBuilder\SubQuery\SubQueries\Delete;
use Orm\QueryBuilder\SubQuery\SubQueries\Insert;
use Orm\QueryBuilder\SubQuery\SubQueries\Select;
use Orm\QueryBuilder\SubQuery\SubQueries\Update;

class QueryBuilder
{
    public function select($select): Select
    {
        return new Select($select);
    }

    public function update($table): Update
    {
        return new Update($table);
    }

    public function insert(): Insert
    {
        return new Insert();
    }

    public function delete(): Delete
    {
        return new Delete();
    }
}