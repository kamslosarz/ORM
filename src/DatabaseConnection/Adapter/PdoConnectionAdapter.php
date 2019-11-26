<?php

namespace Orm\DatabaseConnection\Adapter;

use Orm\DatabaseConnection\DatabaseException;
use Orm\DatabaseConnection\DatabaseResults;

class PdoConnectionAdapter implements PdoConnectionInterface
{
    private $pdo;

    public function __construct(\PDO $PDO)
    {
        $this->pdo = $PDO;
    }

    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    /**
     * @param $query
     * @param array $binds
     * @return DatabaseResults
     * @throws DatabaseException
     */
    public function execute($query, array $binds = []): DatabaseResults
    {
        $this->pdo->beginTransaction();
        $stmt = $this->pdo->prepare($query);

        $this->handlePdoError($this->pdo->errorInfo(), $query);
        $stmt->execute($binds);

        $this->handlePdoError($this->pdo->errorInfo(), $query, function () {
            $this->pdo->rollBack();

            throw new DatabaseException(sprintf('Unable to execute query'));
        });

        $this->pdo->commit();

        return (new DatabaseResults($stmt->fetchAll(\PDO::FETCH_ASSOC)))
            ->setLastInsertId($this->pdo->lastInsertId())
            ->setAffectedRows($stmt->rowCount());
    }

    /**
     * @param $errorInfo
     * @param $query
     * @param callable|null $callback
     * @throws DatabaseException
     */
    private function handlePdoError($errorInfo, $query, callable $callback = null)
    {
        if ($errorInfo[0] !== '00000') {
            $errorInfo[] = $query;

            if (is_callable($callback)) {
                $callback();
            }

            throw new DatabaseException(sprintf('%s#%s %s in %s', ...$errorInfo));
        }
    }
}