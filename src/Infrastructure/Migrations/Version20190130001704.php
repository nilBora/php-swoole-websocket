<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190130001704 extends AbstractMigration
{
    /**
     * Migration description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create table `sagas`';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE sagas
            (
                id uuid not null
                    constraint sagas_pkey
                        primary key,
                saga_id varchar(32) not null,
                status  integer     not null,
                values  jsonb       not null,
                recorded_on TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
            );
        ');

        $this->addSql('CREATE INDEX IF NOT EXISTS sagas_id ON sagas (saga_id);');
        $this->addSql('CREATE INDEX IF NOT EXISTS sagas_values_index	ON sagas USING GIN (values);');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE sagas');
    }
}
