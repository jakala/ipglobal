<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212013209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO product(name, quantity) VALUES ('ipad',0),
                                           ('pc',10),
                                           ('blaqberry', 4),
                                           ('nokia', 6),
                                           ('android',80);");

        $this->addSql("INSERT INTO user(name) values ('Jesus'), ('Marcos'), ('Pablo'), ('Jose')");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
