<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250513194501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__books AS SELECT id, title, isbn, image, author FROM books
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE books
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE books (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO books (id, title, isbn, image, author) SELECT id, title, isbn, image, author FROM __temp__books
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__books
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE book
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__books AS SELECT id, title, isbn, image, author FROM books
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE books
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE books (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, isbn INTEGER NOT NULL, image VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO books (id, title, isbn, image, author) SELECT id, title, isbn, image, author FROM __temp__books
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__books
        SQL);
    }
}
