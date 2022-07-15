<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190228013425 extends AbstractMigration implements ContainerAwareInterface
{
    /** @var EntityManager */
    private EntityManager $em;

    /**
     * Migration description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create tables `enqueue_job_unique` and `enqueue_job`';
    }

    public function up(Schema $schema): void
    {
        $schema->createSequence('enqueue_job_id_seq');
        $table = $schema->createTable('enqueue_job_unique');
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->setPrimaryKey(['name']);

        $this->em->flush();

        $this->addSql('            
            CREATE TABLE enqueue_job
            (
              id          INT                            NOT NULL,
              root_job_id INT                            DEFAULT NULL,
              owner_id    VARCHAR(255)                   DEFAULT NULL,
              name        VARCHAR(255)                   NOT NULL,
              status      VARCHAR(255)                   NOT NULL,
              interrupted BOOLEAN                        NOT NULL,
              "unique"    BOOLEAN                        NOT NULL,
              created_at  TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
              started_at  TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
              stopped_at  TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
              data        JSON                           DEFAULT NULL,
              PRIMARY KEY (id)
            );
        ');

        $this->addSql('CREATE INDEX IDX_C206D624295AA268 ON enqueue_job (root_job_id);');
        $this->addSql('COMMENT ON COLUMN enqueue_job.data IS \'(DC2Type:json_array)\';');
        $this->addSql('ALTER TABLE enqueue_job
              ADD CONSTRAINT FK_C206D624295AA268 FOREIGN KEY (root_job_id) REFERENCES enqueue_job (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
        ');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('enqueue_job_unique');
        $schema->dropTable('enqueue_job');
        $schema->dropSequence('enqueue_job_id_seq');
        $this->em->flush();
    }

    public function setContainer(?ContainerInterface $container = null): void
    {
        /** @var EntityManager em */
        $this->em = $container->get('doctrine.orm.entity_manager');
    }
}
