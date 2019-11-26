<?php

class PdoConnectionAdapterTest extends \Test\TestCases\DatabaseTestCase
{
    public function testShouldExecuteSqlCommand()
    {
        $sql = 'SELECT * FROM `test` WHERE `testField` LIKE ?';
        $binds = ['testFieldValue'];

        $pdoConnectionAdapter = new \Orm\DatabaseConnection\Adapter\PdoConnectionAdapter(self::$pdo);
        $results = $pdoConnectionAdapter->execute($sql, $binds);

        $this->assertInstanceOf(\Orm\DatabaseConnection\DatabaseResults::class, $results);
        $this->assertEquals([['testField' => 'testFieldValue']], $results->getCollection()->__toArray());
    }

    /**
     * @return string
     */
    protected function getDataSetStructure(): string
    {
        return "CREATE TABLE `test` (testField VARCHAR(255) DEFAULT NULL);";
    }

    protected function getDataSet()
    {
        return new \PHPUnit\DbUnit\DataSet\ArrayDataSet([
            'test' => [
                ['testField' => 'testFieldValue']
            ]
        ]);
    }
}