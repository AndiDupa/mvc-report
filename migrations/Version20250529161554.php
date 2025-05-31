<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529161554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_name VARCHAR(255) NOT NULL, room_desc VARCHAR(255) NOT NULL, room_items CLOB DEFAULT NULL --(DC2Type:json)
            , room_direction CLOB NOT NULL --(DC2Type:json)
            )
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE books
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE books (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE "BINARY", isbn VARCHAR(255) NOT NULL COLLATE "BINARY", image VARCHAR(255) NOT NULL COLLATE "BINARY", author VARCHAR(255) NOT NULL COLLATE "BINARY")
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE room
        SQL);
    }
}
