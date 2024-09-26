<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240926084333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE family_tree (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_public TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_tree_user (family_tree_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FBDE26136A9FB01E (family_tree_id), INDEX IDX_FBDE2613A76ED395 (user_id), PRIMARY KEY(family_tree_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE family_tree_user ADD CONSTRAINT FK_FBDE26136A9FB01E FOREIGN KEY (family_tree_id) REFERENCES family_tree (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_tree_user ADD CONSTRAINT FK_FBDE2613A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family_tree_user DROP FOREIGN KEY FK_FBDE26136A9FB01E');
        $this->addSql('ALTER TABLE family_tree_user DROP FOREIGN KEY FK_FBDE2613A76ED395');
        $this->addSql('DROP TABLE family_tree');
        $this->addSql('DROP TABLE family_tree_user');
    }
}
