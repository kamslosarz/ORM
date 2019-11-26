<?php

use Mockery as m;

class DatabaseConnectionTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldCreateDatabaseConnection()
    {
        $databaseConnection = new \Orm\DatabaseConnection\DatabaseConnection([
            'TEST' => [
                'sqlite::memory:'
            ],
            'default' => 'TEST'
        ]);
        $this->assertInstanceOf(\Orm\DatabaseConnection\DatabaseConnection::class, $databaseConnection);
    }

    public function testShouldSetDefaultDatabaseConnection()
    {
        /** @var \Orm\DatabaseConnection\DatabaseConnection $databaseConnection */
        $databaseConnection = m::mock(\Orm\DatabaseConnection\DatabaseConnection::class, [[
            'TEST' => [
                'sqlite::memory:'
            ],
            'sqlite' => [
                'sqlite::memory:'
            ],
            'default' => 'TEST'
        ]])->makePartial();

        $databaseConnection->setDefault('sqlite');
        $this->assertEquals(['sqlite::memory:'], $databaseConnection->getDefault());
    }
}
