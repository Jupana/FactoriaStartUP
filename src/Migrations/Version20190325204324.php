<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190325204324 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fsu_profiles (id INT AUTO_INCREMENT NOT NULL, sector_id INT DEFAULT NULL, profil_name VARCHAR(255) DEFAULT NULL, INDEX IDX_88E3A157DE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fsu_users (id INT AUTO_INCREMENT NOT NULL, user_username VARCHAR(50) NOT NULL, user_password VARCHAR(255) NOT NULL, user_email VARCHAR(30) NOT NULL, user_name VARCHAR(255) DEFAULT NULL, user_surname_1 VARCHAR(255) DEFAULT NULL, user_surname_2 VARCHAR(255) DEFAULT NULL, user_birth_date DATETIME DEFAULT NULL, user_sex VARCHAR(255) DEFAULT NULL, user_street_type VARCHAR(255) DEFAULT NULL, user_street_name VARCHAR(255) DEFAULT NULL, user_street_number VARCHAR(255) DEFAULT NULL, user_block VARCHAR(255) DEFAULT NULL, user_apartment VARCHAR(255) DEFAULT NULL, user_city VARCHAR(255) DEFAULT NULL, user_postal_code VARCHAR(255) DEFAULT NULL, user_provincie VARCHAR(255) DEFAULT NULL, user_country VARCHAR(255) DEFAULT NULL, user_perfil_img VARCHAR(255) DEFAULT NULL, user_team_search VARCHAR(255) DEFAULT NULL, user_proyect_search VARCHAR(255) DEFAULT NULL, user_phone_number VARCHAR(255) DEFAULT NULL, user_inscription_date DATETIME DEFAULT NULL, user_latitud VARCHAR(255) DEFAULT NULL, user_longitud VARCHAR(255) DEFAULT NULL, user_IP VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_7A866DA918D3E277 (user_username), UNIQUE INDEX UNIQ_7A866DA9550872C (user_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fsu_sectores (id INT AUTO_INCREMENT NOT NULL, sector_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fsu_projects (project_id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, project_sector_id INT DEFAULT NULL, project_name VARCHAR(255) DEFAULT NULL, project_short_description LONGTEXT DEFAULT NULL, project_description LONGTEXT DEFAULT NULL, project_phase_idea TINYINT(1) DEFAULT NULL, project_phase_ideaMV TINYINT(1) DEFAULT NULL, project_phase_productoMV TINYINT(1) DEFAULT NULL, project_phase_productoFinal TINYINT(1) DEFAULT NULL, project_potentialy_users VARCHAR(255) DEFAULT NULL, project_potentialy_companies VARCHAR(255) DEFAULT NULL, project_aprox_facturation1 VARCHAR(255) DEFAULT NULL, project_aprox_facturation2 VARCHAR(255) DEFAULT NULL, project_aprox_facturation3 VARCHAR(255) DEFAULT NULL, project_competitors VARCHAR(255) DEFAULT NULL, project_team_number VARCHAR(255) DEFAULT NULL, project_team VARCHAR(255) DEFAULT NULL, project_date DATETIME DEFAULT NULL, INDEX IDX_5F4097C3A76ED395 (user_id), INDEX IDX_5F4097C3CFA98DB0 (project_sector_id), PRIMARY KEY(project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fsu_profiles_users (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, profil_id INT DEFAULT NULL, sector_id INT DEFAULT NULL, profil_profesional_description VARCHAR(255) DEFAULT NULL, profile_date DATETIME DEFAULT NULL, INDEX IDX_E99B63F2A76ED395 (user_id), INDEX IDX_E99B63F2275ED078 (profil_id), INDEX IDX_E99B63F2DE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fsu_profiles ADD CONSTRAINT FK_88E3A157DE95C867 FOREIGN KEY (sector_id) REFERENCES fsu_sectores (id)');
        $this->addSql('ALTER TABLE fsu_projects ADD CONSTRAINT FK_5F4097C3A76ED395 FOREIGN KEY (user_id) REFERENCES fsu_users (id)');
        $this->addSql('ALTER TABLE fsu_projects ADD CONSTRAINT FK_5F4097C3CFA98DB0 FOREIGN KEY (project_sector_id) REFERENCES fsu_sectores (id)');
        $this->addSql('ALTER TABLE fsu_profiles_users ADD CONSTRAINT FK_E99B63F2A76ED395 FOREIGN KEY (user_id) REFERENCES fsu_users (id)');
        $this->addSql('ALTER TABLE fsu_profiles_users ADD CONSTRAINT FK_E99B63F2275ED078 FOREIGN KEY (profil_id) REFERENCES fsu_profiles (id)');
        $this->addSql('ALTER TABLE fsu_profiles_users ADD CONSTRAINT FK_E99B63F2DE95C867 FOREIGN KEY (sector_id) REFERENCES fsu_sectores (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fsu_profiles_users DROP FOREIGN KEY FK_E99B63F2275ED078');
        $this->addSql('ALTER TABLE fsu_projects DROP FOREIGN KEY FK_5F4097C3A76ED395');
        $this->addSql('ALTER TABLE fsu_profiles_users DROP FOREIGN KEY FK_E99B63F2A76ED395');
        $this->addSql('ALTER TABLE fsu_profiles DROP FOREIGN KEY FK_88E3A157DE95C867');
        $this->addSql('ALTER TABLE fsu_projects DROP FOREIGN KEY FK_5F4097C3CFA98DB0');
        $this->addSql('ALTER TABLE fsu_profiles_users DROP FOREIGN KEY FK_E99B63F2DE95C867');
        $this->addSql('DROP TABLE fsu_profiles');
        $this->addSql('DROP TABLE fsu_users');
        $this->addSql('DROP TABLE fsu_sectores');
        $this->addSql('DROP TABLE fsu_projects');
        $this->addSql('DROP TABLE fsu_profiles_users');
    }
}
