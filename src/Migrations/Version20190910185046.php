<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190910185046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE todo CHANGE medium medium VARCHAR(255) DEFAULT NULL, CHANGE duration duration INT DEFAULT NULL, CHANGE priority priority INT DEFAULT NULL, CHANGE date_planed date_planed DATETIME DEFAULT NULL, CHANGE date_deadline date_deadline DATETIME DEFAULT NULL, CHANGE completed completed DATETIME DEFAULT NULL, CHANGE date_created date_created DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE todo CHANGE medium medium VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE duration duration INT DEFAULT NULL, CHANGE priority priority INT DEFAULT NULL, CHANGE date_planed date_planed DATETIME DEFAULT \'NULL\', CHANGE date_deadline date_deadline DATETIME DEFAULT \'NULL\', CHANGE completed completed TINYINT(1) NOT NULL, CHANGE date_created date_created DATETIME DEFAULT \'NULL\'');
    }
}
