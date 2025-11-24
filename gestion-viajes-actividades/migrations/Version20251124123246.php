<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251124123246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actividades (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(60) NOT NULL, fecha_celebracion DATETIME NOT NULL, lugar VARCHAR(60) NOT NULL, viajero_id_id INT NOT NULL, INDEX IDX_73D548DE36C0D361 (viajero_id_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE actividades ADD CONSTRAINT FK_73D548DE36C0D361 FOREIGN KEY (viajero_id_id) REFERENCES viajero (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actividades DROP FOREIGN KEY FK_73D548DE36C0D361');
        $this->addSql('DROP TABLE actividades');
    }
}
