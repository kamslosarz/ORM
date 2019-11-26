<?php

use Orm\DatabaseConnection\Adapter\PdoConnectionAdapter;
use Orm\DatabaseConnection\DatabaseConnection;

class DatabaseConnectionFunctionalTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldConstructDatabaseDefaultConnection()
    {
        $databaseConnection = new DatabaseConnection([
            'sqlite' => [
                'sqlite::memory:',
            ],
            'default' => 'sqlite'
        ]);

        $this->assertInstanceOf(DatabaseConnection::class, $databaseConnection);
        $this->assertInstanceOf(PdoConnectionAdapter::class, $databaseConnection->getDefaultConnection());
        $this->assertInstanceOf(\PDO::class, $databaseConnection->getDefaultConnection()->getPdo());
    }

    public function testShouldChangeDefaultConnection()
    {
        /** @var DatabaseConnection $databaseConnection */
        $databaseConnection = new DatabaseConnection([
            'sqlite' => [
                'sqlite::memory:',
            ],
            'sqlite2' => [
                'sqlite::memory:',
                'username',
                'password'
            ],
            'default' => 'sqlite'
        ]);

        $databaseConnection->setDefault('sqlite2');

        $this->assertEquals([
            'sqlite::memory:',
            'username',
            'password'
        ], $databaseConnection->getDefault());
    }
}