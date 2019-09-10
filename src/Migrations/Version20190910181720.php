<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190910181720 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE todo (id INT AUTO_INCREMENT NOT NULL, contact_id INT NOT NULL, worker_id INT NOT NULL, description LONGTEXT NOT NULL, medium VARCHAR(255) DEFAULT NULL, duration INT DEFAULT NULL, priority INT DEFAULT NULL, date_planed DATETIME DEFAULT NULL, date_deadline DATETIME DEFAULT NULL, completed TINYINT(1) NOT NULL, date_created DATETIME DEFAULT NULL, INDEX IDX_5A0EB6A0E7A1254A (contact_id), INDEX IDX_5A0EB6A06B20BA36 (worker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT FK_5A0EB6A0E7A1254A FOREIGN KEY (contact_id) REFERENCES worker (id)');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT FK_5A0EB6A06B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE todo');
    }
}
