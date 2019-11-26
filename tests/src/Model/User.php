<?php

namespace Test\Model;

use Orm\Repository\Mapper\Model\Model;

class User extends Model
{
    protected function getModelName(): string
    {
        return self::class;
    }
}