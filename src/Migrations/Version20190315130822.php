<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315130822 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fsu_profiles (id INT AUTO_INCREMENT NOT NULL, sector_id INT DEFAULT NULL, profil_name VARCHAR(255) DEFAULT NULL, INDEX IDX_88E3A157DE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fsu_profiles_users (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, profil_id INT DEFAULT NULL, sector_id INT DEFAULT NULL, profil_profesional_description VARCHAR(255) DEFAULT NULL, profile_date DATETIME DEFAULT NULL, INDEX IDX_E99B63F2A76ED395 (user_id), INDEX IDX_E99B63F2275ED078 (profil_id), INDEX IDX_E99B63F2DE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fsu_sectores (id INT AUTO_INCREMENT NOT NULL, sector_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fsu_profiles ADD CONSTRAINT FK_88E3A157DE95C867 FOREIGN KEY (sector_id) REFERENCES fsu_sectores (id)');
        $this->addSql('ALTER TABLE fsu_profiles_users ADD CONSTRAINT FK_E99B63F2A76ED395 FOREIGN KEY (user_id) REFERENCES fsu_users (id)');
        $this->addSql('ALTER TABLE fsu_profiles_users ADD CONSTRAINT FK_E99B63F2275ED078 FOREIGN KEY (profil_id) REFERENCES fsu_profiles (id)');
        $this->addSql('ALTER TABLE fsu_profiles_users ADD CONSTRAINT FK_E99B63F2DE95C867 FOREIGN KEY (sector_id) REFERENCES fsu_sectores (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fsu_profiles_users DROP FOREIGN KEY FK_E99B63F2275ED078');
        $this->addSql('ALTER TABLE fsu_profiles DROP FOREIGN KEY FK_88E3A157DE95C867');
        $this->addSql('ALTER TABLE fsu_profiles_users DROP FOREIGN KEY FK_E99B63F2DE95C867');
        $this->addSql('DROP TABLE fsu_profiles');
        $this->addSql('DROP TABLE fsu_profiles_users');
        $this->addSql('DROP TABLE fsu_sectores');
    }
}
