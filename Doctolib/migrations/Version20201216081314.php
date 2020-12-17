<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216081314 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prise_rdv (id INT AUTO_INCREMENT NOT NULL, id_docteur_id INT DEFAULT NULL, id_patient_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_467916926AA8D4DD (id_docteur_id), INDEX IDX_46791692CE0312AE (id_patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prise_rdv ADD CONSTRAINT FK_467916926AA8D4DD FOREIGN KEY (id_docteur_id) REFERENCES docteur (id)');
        $this->addSql('ALTER TABLE prise_rdv ADD CONSTRAINT FK_46791692CE0312AE FOREIGN KEY (id_patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE docteur CHANGE numero_ordre numero_ordre VARCHAR(9) NOT NULL');
        $this->addSql('ALTER TABLE patient CHANGE numero_carte_vitale numero_carte_vitale VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE prise_rdv');
        $this->addSql('ALTER TABLE docteur CHANGE numero_ordre numero_ordre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE patient CHANGE numero_carte_vitale numero_carte_vitale VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
