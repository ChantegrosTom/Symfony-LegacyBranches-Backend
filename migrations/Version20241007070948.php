<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007070948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_member (id INT AUTO_INCREMENT NOT NULL, family_tree_id INT NOT NULL, parent_1_id INT DEFAULT NULL, parent_2_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birth_name VARCHAR(255) DEFAULT NULL, birth_location VARCHAR(255) DEFAULT NULL, death_location VARCHAR(255) DEFAULT NULL, birth_certificate VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B9D4AD6D6A9FB01E (family_tree_id), INDEX IDX_B9D4AD6DCD306A4E (parent_1_id), INDEX IDX_B9D4AD6DDF85C5A0 (parent_2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE family_member ADD CONSTRAINT FK_B9D4AD6D6A9FB01E FOREIGN KEY (family_tree_id) REFERENCES family_tree (id)');
        $this->addSql('ALTER TABLE family_member ADD CONSTRAINT FK_B9D4AD6DCD306A4E FOREIGN KEY (parent_1_id) REFERENCES family_member (id)');
        $this->addSql('ALTER TABLE family_member ADD CONSTRAINT FK_B9D4AD6DDF85C5A0 FOREIGN KEY (parent_2_id) REFERENCES family_member (id)');
        $this->addSql('ALTER TABLE event ADD event_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7401B253C FOREIGN KEY (event_type_id) REFERENCES event_type (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7401B253C ON event (event_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7401B253C');
        $this->addSql('ALTER TABLE family_member DROP FOREIGN KEY FK_B9D4AD6D6A9FB01E');
        $this->addSql('ALTER TABLE family_member DROP FOREIGN KEY FK_B9D4AD6DCD306A4E');
        $this->addSql('ALTER TABLE family_member DROP FOREIGN KEY FK_B9D4AD6DDF85C5A0');
        $this->addSql('DROP TABLE event_type');
        $this->addSql('DROP TABLE family_member');
        $this->addSql('DROP INDEX IDX_3BAE0AA7401B253C ON event');
        $this->addSql('ALTER TABLE event DROP event_type_id');
    }
}
