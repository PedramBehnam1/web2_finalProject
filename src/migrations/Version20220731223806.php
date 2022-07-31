<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220731223806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dorm (id INT AUTO_INCREMENT NOT NULL, university_id INT NOT NULL, name VARCHAR(255) NOT NULL, score INT NOT NULL, number_of_rooms INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_username VARCHAR(255) NOT NULL, updated_username VARCHAR(255) DEFAULT NULL, INDEX IDX_F88135C4309D1878 (university_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, dorm_id INT NOT NULL, room_number INT NOT NULL, capacity INT NOT NULL, maximum_capacity INT NOT NULL, is_empty TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_username VARCHAR(255) NOT NULL, updated_username VARCHAR(255) DEFAULT NULL, user_accounts LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_729F519BC8698A54 (dorm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_username VARCHAR(255) NOT NULL, updated_username VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dorm ADD CONSTRAINT FK_F88135C4309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BC8698A54 FOREIGN KEY (dorm_id) REFERENCES dorm (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BC8698A54');
        $this->addSql('ALTER TABLE dorm DROP FOREIGN KEY FK_F88135C4309D1878');
        $this->addSql('DROP TABLE dorm');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE university');
    }
}
