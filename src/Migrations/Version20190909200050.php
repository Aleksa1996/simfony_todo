<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190909200050 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE worker_position (worker_id INT NOT NULL, position_id INT NOT NULL, INDEX IDX_4E7536A36B20BA36 (worker_id), INDEX IDX_4E7536A3DD842E46 (position_id), PRIMARY KEY(worker_id, position_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE worker_position ADD CONSTRAINT FK_4E7536A36B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE worker_position ADD CONSTRAINT FK_4E7536A3DD842E46 FOREIGN KEY (position_id) REFERENCES position (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE worker DROP FOREIGN KEY FK_9FB2BF62DD842E46');
        $this->addSql('DROP INDEX IDX_9FB2BF62DD842E46 ON worker');
        $this->addSql('ALTER TABLE worker DROP position_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE worker_position');
        $this->addSql('ALTER TABLE worker ADD position_id INT NOT NULL');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF62DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('CREATE INDEX IDX_9FB2BF62DD842E46 ON worker (position_id)');
    }
}
