<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190129162008 extends AbstractMigration implements ContainerAwareInterface
{
    /** @var EntityManager */
    private EntityManager $em;

    /**
     * Events store table name.
     *
     * @var string
     */
    private string $tableName = 'events';

    /**
     * @var bool
     */
    private bool $useBinary = false;

    /**
     * Migration description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create table `events`';
    }

    public function up(Schema $schema): void
    {
        $this->configureSchema($schema);
        $this->em->flush();
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable($this->tableName);
        $this->em->flush();
    }

    public function setContainer(?ContainerInterface $container = null): void
    {
        /** @var EntityManager em */
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    /**
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
     * @param Schema|null $schema
     *
     * @return Table
     */
    public function configureTable(?Schema $schema = null): Table
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
        $table->addColumn('playhead', 'integer', ['unsigned' => true]);
        $table->addColumn('payload', 'text');
        $table->addColumn('metadata', 'text');
        $table->addColumn('recorded_on', 'datetime');
        $table->addColumn('type', 'string', ['length' => 255]);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['uuid', 'playhead']);

        return $table;
    }
}
