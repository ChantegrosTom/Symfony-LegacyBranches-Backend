<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007071429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_has_family_member (event_id INT NOT NULL, family_member_id INT NOT NULL, INDEX IDX_8EB48B0B71F7E88B (event_id), INDEX IDX_8EB48B0BBC594993 (family_member_id), PRIMARY KEY(event_id, family_member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_has_family_member ADD CONSTRAINT FK_8EB48B0B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_has_family_member ADD CONSTRAINT FK_8EB48B0BBC594993 FOREIGN KEY (family_member_id) REFERENCES family_member (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_has_family_member DROP FOREIGN KEY FK_8EB48B0B71F7E88B');
        $this->addSql('ALTER TABLE event_has_family_member DROP FOREIGN KEY FK_8EB48B0BBC594993');
        $this->addSql('DROP TABLE event_has_family_member');
    }
}
