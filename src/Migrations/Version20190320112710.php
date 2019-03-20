<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190320112710 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fsu_projects ADD project_sector_id INT DEFAULT NULL, DROP project_sector, DROP project_clientes_users');
        $this->addSql('ALTER TABLE fsu_projects ADD CONSTRAINT FK_5F4097C3CFA98DB0 FOREIGN KEY (project_sector_id) REFERENCES fsu_sectores (id)');
        $this->addSql('CREATE INDEX IDX_5F4097C3CFA98DB0 ON fsu_projects (project_sector_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fsu_projects DROP FOREIGN KEY FK_5F4097C3CFA98DB0');
        $this->addSql('DROP INDEX IDX_5F4097C3CFA98DB0 ON fsu_projects');
        $this->addSql('ALTER TABLE fsu_projects ADD project_sector VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD project_clientes_users VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP project_sector_id');
    }
}
