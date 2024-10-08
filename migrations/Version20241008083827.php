<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008083827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE family_member_family_member (family_member_source INT NOT NULL, family_member_target INT NOT NULL, INDEX IDX_2E75238F5556F6C (family_member_source), INDEX IDX_2E75238ECB03FE3 (family_member_target), PRIMARY KEY(family_member_source, family_member_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE family_member_family_member ADD CONSTRAINT FK_2E75238F5556F6C FOREIGN KEY (family_member_source) REFERENCES family_member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_member_family_member ADD CONSTRAINT FK_2E75238ECB03FE3 FOREIGN KEY (family_member_target) REFERENCES family_member (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family_member_family_member DROP FOREIGN KEY FK_2E75238F5556F6C');
        $this->addSql('ALTER TABLE family_member_family_member DROP FOREIGN KEY FK_2E75238ECB03FE3');
        $this->addSql('DROP TABLE family_member_family_member');
    }
}
