<?php

class RepositoryTest extends \Test\TestCases\DatabaseTestCase
{
    public function testShouldFetchRepository()
    {
        $table = new \Orm\SchemaBuilder\Table\Table('users');
        $table->setModelName('User');

        $queryBuilder = new \Orm\QueryBuilder\QueryBuilder();
        $repository = new \Orm\Repository\Repository($table, $queryBuilder);
        $modelCollection = $repository->getAll();

        $this->assertEquals([
            new \Test\Model\User([
                'id' => 1,
                'username' => 'testUser',
                'password' => md5('test')
            ]),
            new \Test\Model\User([
                'id' => 2,
                'username' => 'testUser2',
                'password' => md5('test')
            ]),
            new \Test\Model\User([
                'id' => 3,
                'username' => 'testUser3',
                'password' => md5('test')
            ]),
            new \Test\Model\User([
                'id' => 4,
                'username' => 'testUser4',
                'password' => md5('test')
            ])
        ], $modelCollection->__toArray());
    }

    protected function getDataSet()
    {
        return new \PHPUnit\DbUnit\DataSet\ArrayDataSet([
            'users' => [
                [
                    'id' => 1,
                    'username' => 'testUser',
                    'password' => md5('test')
                ], [
                    'id' => 2,
                    'username' => 'testUser2',
                    'password' => md5('test')
                ], [
                    'id' => 3,
                    'username' => 'testUser3',
                    'password' => md5('test')
                ], [
                    'id' => 4,
                    'username' => 'testUser4',
                    'password' => md5('test')
                ]
            ]
        ]);
    }
}