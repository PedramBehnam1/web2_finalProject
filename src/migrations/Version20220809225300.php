<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220809225300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dorm ADD editor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dorm ADD CONSTRAINT FK_F88135C47E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dorm ADD CONSTRAINT FK_F88135C46995AC4C FOREIGN KEY (editor_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F88135C47E3C61F9 ON dorm (owner_id)');
        $this->addSql('CREATE INDEX IDX_F88135C46995AC4C ON dorm (editor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dorm DROP FOREIGN KEY FK_F88135C47E3C61F9');
        $this->addSql('ALTER TABLE dorm DROP FOREIGN KEY FK_F88135C46995AC4C');
        $this->addSql('DROP INDEX IDX_F88135C47E3C61F9 ON dorm');
        $this->addSql('DROP INDEX IDX_F88135C46995AC4C ON dorm');
        $this->addSql('ALTER TABLE dorm DROP editor_id');
    }
}
