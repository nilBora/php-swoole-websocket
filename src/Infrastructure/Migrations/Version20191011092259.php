<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191011092259 extends AbstractMigration
{
    /**
     * Migration description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create table `items`';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE items
            (
                uuid uuid
                    constraint items_pk
                        primary key,
                id serial,
                parent_id int,
                name varchar,
                url varchar,
                status smallint default 0,
                created_at timestamp default now(),
                updated_at timestamp default null
            );
        ');

        $this->addSql('CREATE UNIQUE index items_id_uindex on items (id);');
        $this->addSql('CREATE INDEX items_parent_id_INDEX on items (parent_id);');
        //$this->addSql('CREATE INDEX items_status_INDEX on items (status);');

        $this->addSql('
            CREATE OR REPLACE FUNCTION update_update_at_column()
                RETURNS TRIGGER AS $$
            BEGIN
                IF row(NEW.*) IS DISTINCT FROM row(OLD.*) THEN
                    NEW.updated_at = now();
                    RETURN NEW;
                ELSE
                    RETURN OLD;
                END IF;
            END;
            $$ language \'plpgsql\';
		');

        $this->addSql('
            CREATE TRIGGER update_items_modtime BEFORE UPDATE ON items FOR EACH ROW EXECUTE PROCEDURE update_update_at_column();
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP FUNCTION update_update_at_column;');
        $this->addSql('DROP TRIGGER update_items_modtime;');
        $this->addSql('DROP TABLE items;');
    }
}
