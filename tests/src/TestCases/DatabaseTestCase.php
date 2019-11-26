<?php

namespace Test\TestCases;

use PHPUnit\DbUnit\TestCaseTrait;

abstract class DatabaseTestCase extends \PHPUnit\DbUnit\TestCase
{
    use TestCaseTrait;

    /** @var \PDO $pdo */
    protected static $pdo;

    public function getConnection(): \PHPUnit\DbUnit\Database\DefaultConnection
    {
        if (!self::$pdo) {
            \Orm\Orm::initialize([
                'driver' => [
                    'sqlite' => [
                        'sqlite::memory:',
                    ],
                    'default' => 'sqlite'
                ],
                'schema' => [
                    'definition' => include FIXTURES . '/schema.php',
                    'mapper' => [
                        'modelNamespace' => 'Test\Model'
                    ]
                ]
            ]);

            $defaultConnection = \Orm\Orm::getDatabaseConnection()->getDefaultConnection();
            self::$pdo = $defaultConnection->getPdo();
            self::$pdo->exec('UPDATE update_table SET column1=?, column2=?');
            $query = $this->getDataSetStructure();
            self::$pdo->exec($query);
            $this->handlePdoError($query);
        }

        return $this->createDefaultDBConnection(self::$pdo);
    }

    protected function getDataSetStructure(): string
    {
        return file_get_contents(FIXTURES . '/database.sql');
    }

    private function handlePdoError($query)
    {
        $errorInfo = self::$pdo->errorInfo();
        if ($errorInfo[0] !== '00000') {
            $errorInfo[] = $query;

            throw new \Exception(sprintf('%s#%s %s in %s', ...$errorInfo));
        }
    }
}