<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312133026 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, project_name VARCHAR(255) DEFAULT NULL, project_short_description LONGTEXT DEFAULT NULL, project_description LONGTEXT DEFAULT NULL, project_sector VARCHAR(255) DEFAULT NULL, project_state VARCHAR(255) DEFAULT NULL, project_clientes_users VARCHAR(255) DEFAULT NULL, project_potentialy_users VARCHAR(255) DEFAULT NULL, project_potentialy_companies VARCHAR(255) DEFAULT NULL, project_aprox_facturation1 VARCHAR(255) DEFAULT NULL, project_aprox_facturation2 VARCHAR(255) DEFAULT NULL, project_aprox_facturation3 VARCHAR(255) DEFAULT NULL, project_competitors VARCHAR(255) DEFAULT NULL, project_team_number VARCHAR(255) DEFAULT NULL, project_team VARCHAR(255) DEFAULT NULL, project_date DATETIME DEFAULT NULL, INDEX IDX_2FB3D0EEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE project');
    }
}
