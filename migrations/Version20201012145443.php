<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201012145443 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, desciption LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_entity ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article_entity ADD CONSTRAINT FK_64EFD3E812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_64EFD3E812469DE2 ON article_entity (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_entity DROP FOREIGN KEY FK_64EFD3E812469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP INDEX IDX_64EFD3E812469DE2 ON article_entity');
        $this->addSql('ALTER TABLE article_entity DROP category_id');
    }
}
