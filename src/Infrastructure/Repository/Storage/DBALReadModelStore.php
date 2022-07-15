<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Repository\Storage;

use Jtrw\Micro\Poc\Rpc\Domain\Entity\EntityInterface;
use Jtrw\Micro\Poc\Rpc\Domain\Repository\ReadModelStoreInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Statement as DriverStatement;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;

/**
 * Class DBALReadModelStore.
 *
 * @SuppressWarnings(PHPMD)
 */
class DBALReadModelStore implements ReadModelStoreInterface
{
    /**
     * Create binary uuid primary key.
     *
     * @var bool
     */
    private bool $useBinary = true;

    /**
     * Database connection object.
     *
     * @var Connection
     */
    private Connection $connection;

    /**
     * Database table name.
     *
     * @var string
     */
    private string $tableName;

    /**
     * Table primary key.
     *
     * @var string
     */
    private string $primaryKey;

    /**
     * Query statement object.
     *
     * @var DriverStatement|null
     */
    private ?DriverStatement $findStatement = null;

    /**
     * DBALReadModelStore constructor.
     *
     * @param Connection $connection
     * @param string     $tableName
     * @param string     $primaryKey
     */
    public function __construct(
        Connection $connection,
        string $tableName,
        string $primaryKey
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->primaryKey = $primaryKey;
    }

    /**
     * Finds an object by its primary key / identifier.
     *
     * @param mixed $uuid
     *
     * @return mixed[]|null
     *
     * @throws DBALException
     */
    public function findOne($uuid): ?array
    {
        $statement = $this->prepareLoadStatement();
        $statement->bindValue(1, $uuid);
        $statement->execute();
        $row = $statement->fetch();

        if (false === $row) {
            throw new NotFoundException(sprintf('ReadModel not found for aggregate with id %s for table %s', $uuid, $this->tableName));
        }

        return $row;
    }

    /**
     * Prepare query.
     *
     * @return DriverStatement
     *
     * @throws DBALException
     */
    private function prepareLoadStatement(): DriverStatement
    {
        if (null === $this->findStatement) {
            $query = 'SELECT ' . $this->primaryKey . ' , id, parent_id, name, status, url, created_at, updated_at
                FROM ' . $this->tableName . '
                WHERE ' . $this->primaryKey . ' = ?;';
            $this->findStatement = $this->connection->prepare($query);
        }

        return $this->findStatement;
    }

    /**
     * Finds all objects in the repository.
     *
     * @return mixed[]
     *
     * @throws DBALException
     */
    public function findAll(): array
    {
        $query = 'SELECT ' . $this->primaryKey . ' , id, parent_id, name, status, url, created_at, updated_at
                FROM ' . $this->tableName;
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @param mixed[]       $criteria
     * @param string[]|null $orderBy
     * @param int|null      $limit
     * @param int|null      $offset
     *
     * @return mixed[]
     *
     * @throws DBALException
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
    {
        $query = 'SELECT ' . $this->primaryKey . ' , id, parent_id, name, status, url, created_at, updated_at
                FROM ' . $this->tableName;
        [$values, $conditions] = $this->gatherConditions($criteria);

        if ($conditions) {
            $query .= '
                WHERE ' . implode(' AND ', $conditions);
        }

        if (null !== $orderBy) {
            $query .= ' ORDER BY ' . implode(', ', $orderBy);
        }

        if (null !== $limit) {
            $query .= ' LIMIT ' . $limit;
        }

        if ($offset > 0) {
            $query .= ' OFFSET ' . $offset;
        }
        $statement = $this->connection->prepare($query);

        foreach ($values as $param => $value) {
            $statement->bindValue($param, $value, ParameterType::INTEGER);
        }
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Gathers conditions for an update or delete call.
     *
     * @param mixed[] $identifiers Input array of columns to values
     *
     * @return string[][] a triplet with:
     *                    - the second key being the values
     *                    - the third key being the conditions
     */
    private function gatherConditions(array $identifiers): array
    {
        $values = [];
        $conditions = [];
        $valueKey = 0;

        foreach ($identifiers as $columnName => $value) {
            ++$valueKey;
            $values[$valueKey] = $value;
            $conditions[] = $columnName . ' = ?';
        }

        return [$values, $conditions];
    }

    /**
     * Finds a single object by a set of criteria.
     *
     * @param mixed[] $criteria
     *
     * @return mixed[]|null
     *
     * @throws DBALException
     */
    public function findOneBy(array $criteria): ?array
    {
        [$values, $conditions] = $this->gatherConditions($criteria);
        $query = 'SELECT ' . $this->primaryKey . ' , id, parent_id, name, status, url, created_at, updated_at
                FROM ' . $this->tableName . '
                WHERE ' . implode(' AND ', $conditions);
        $query .= ' LIMIT 1';
        $statement = $this->connection->prepare($query);

        foreach ($values as $i => $value) {
            $statement->bindValue($i, $value);
        }
        $statement->execute();
        $row = $statement->fetch();

        if (false === $row) {
            throw new NotFoundException(sprintf('ReadModel not found for aggregate with id %s for table %s', implode(', ', $criteria), $this->tableName));
        }

        return $row;
    }

    /**
     * Insert new item into storage.
     *
     * @param EntityInterface $entity
     *
     * @throws ConnectionException
     * @throws DBALEventStoreException
     */
    public function insertOne(EntityInterface $entity): void
    {
        $this->connection->beginTransaction();

        try {
            $this->insert($this->connection, $entity->getPrimaryKeyValue(), $entity->normalize());
            $this->connection->commit();
        } catch (DBALException $exception) {
            $this->connection->rollBack();

            throw new DBALEventStoreException($exception->getMessage(), (int) $exception->getCode(), $exception);
        }
    }

    /**
     * Insert new item data to store.
     *
     * @param Connection $connection
     * @param string|int $primaryKeyValue
     * @param mixed[]    $data
     *
     * @throws DBALException
     */
    private function insert(Connection $connection, $primaryKeyValue, array $data): void
    {
        $insert = [];
        $insert[$this->primaryKey] = $primaryKeyValue;

        foreach ($data as $key => $value) {
            $insert[$this->toSnakeCase($key)] = $value;
        }
        $connection->insert($this->tableName, $insert);
    }

    /**
     * Convert CamelCase to snake_case.
     *
     * @param string $str
     * @param string $glue
     *
     * @return string
     */
    private function toSnakeCase(string $str, string $glue = '_'): string
    {
        return preg_replace_callback('/[A-Z]/', static function ($matches) use ($glue) {
            return $glue . strtolower($matches[0]);
        }, $str);
    }

    /**
     * Update one item in store.
     *
     * @param EntityInterface $entity
     *
     * @throws ConnectionException
     * @throws DBALEventStoreException
     */
    public function updateOne(EntityInterface $entity): void
    {
        $this->connection->beginTransaction();

        try {
            $this->update($this->connection, $entity->normalize(), [$this->primaryKey => $entity->getPrimaryKeyValue()]);
            $this->connection->commit();
        } catch (DBALException $exception) {
            $this->connection->rollBack();

            throw new DBALEventStoreException($exception->getMessage(), (int) $exception->getCode(), $exception);
        }
    }

    /**
     * Update item(s) data to store.
     *
     * @param Connection $connection
     * @param mixed[]    $data
     * @param mixed[]    $conditions
     *
     * @throws DBALException
     */
    private function update(Connection $connection, array $data, array $conditions): void
    {
        $update = [];

        foreach ($data as $key => $value) {
            $update[$this->toSnakeCase($key)] = $value;
        }
        $connection->update($this->tableName, $update, $conditions);
    }

    /**
     * Append new snapshot payload into storage.
     *
     * @param EntityInterface $entity
     *
     * @throws ConnectionException
     * @throws DBALEventStoreException
     */
    public function deleteOne(EntityInterface $entity): void
    {
        $this->connection->beginTransaction();

        try {
            $this->delete($this->connection, [$this->primaryKey => $entity->getPrimaryKeyValue()]);
            $this->connection->commit();
        } catch (DBALException $exception) {
            $this->connection->rollBack();

            throw new DBALEventStoreException($exception->getMessage(), (int) $exception->getCode(), $exception);
        }
    }

    /**
     * Insert new item data to store.
     *
     * @param Connection $connection
     * @param mixed[]    $conditions
     *
     * @throws DBALException
     */
    private function delete(Connection $connection, array $conditions): void
    {
        $connection->delete($this->tableName, $conditions);
    }

    /**
     * Configure table schema.
     *
     * @param Schema $schema
     *
     * @return Table|null
     */
    public function configureSchema(Schema $schema): ?Table
    {
        if ($schema->hasTable($this->tableName)) {
            return null;
        }

        return $this->configureTable($schema);
    }

    /**
     * Configure table.
     *
     * @param Schema|null $schema
     *
     * @return Table
     */
    private function configureTable(?Schema $schema = null): Table
    {
        $schema = $schema ?: new Schema();
        $uuidColumnDefinition = [
            'type' => 'guid',
            'params' => [
                'length' => 36,
            ],
        ];

        if ($this->useBinary) {
            $uuidColumnDefinition['type'] = 'binary';
            $uuidColumnDefinition['params'] = [
                'length' => 16,
                'fixed' => true,
            ];
        }

        $table = $schema->createTable($this->tableName);
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('uuid', $uuidColumnDefinition['type'], $uuidColumnDefinition['params']);
        $table->addColumn('parent_id', 'integer', ['unsigned' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('url', 'string', ['length' => 255]);
        $table->addColumn('status', 'smallint', ['length' => 1]);
        $table->addColumn('created_at', 'time');
        $table->addColumn('updated_at', 'time');
        $table->setPrimaryKey(['uuid']);
        $table->addUniqueIndex(['id']);
        $table->addIndex(['parent_id']);

        return $table;
    }
}
