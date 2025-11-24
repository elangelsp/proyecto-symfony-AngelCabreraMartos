<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251124120550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE logistica (id INT AUTO_INCREMENT NOT NULL, tipo_viaje VARCHAR(20) NOT NULL, destino_lugar VARCHAR(255) NOT NULL, medio_transporte VARCHAR(40) NOT NULL, salida DATETIME NOT NULL, llegada DATETIME NOT NULL, viajero_id_id INT NOT NULL, INDEX IDX_5D33CC2136C0D361 (viajero_id_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE proyecto (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(40) NOT NULL, descripcion LONGTEXT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE viajero (id INT AUTO_INCREMENT NOT NULL, nombre_completo VARCHAR(40) NOT NULL, referencia LONGTEXT DEFAULT NULL, telefono INT NOT NULL, ciudad VARCHAR(40) NOT NULL, pais VARCHAR(40) NOT NULL, imagen VARCHAR(255) DEFAULT NULL, proyecto_id_id INT NOT NULL, INDEX IDX_43FE43117DAF9E19 (proyecto_id_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE logistica ADD CONSTRAINT FK_5D33CC2136C0D361 FOREIGN KEY (viajero_id_id) REFERENCES viajero (id)');
        $this->addSql('ALTER TABLE viajero ADD CONSTRAINT FK_43FE43117DAF9E19 FOREIGN KEY (proyecto_id_id) REFERENCES proyecto (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logistica DROP FOREIGN KEY FK_5D33CC2136C0D361');
        $this->addSql('ALTER TABLE viajero DROP FOREIGN KEY FK_43FE43117DAF9E19');
        $this->addSql('DROP TABLE logistica');
        $this->addSql('DROP TABLE proyecto');
        $this->addSql('DROP TABLE viajero');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
