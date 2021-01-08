<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108104923 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE docteur ADD username VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_83A7A439F85E0677 ON docteur (username)');
        $this->addSql('ALTER TABLE patient ADD username VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBF85E0677 ON patient (username)');
        $this->addSql('ALTER TABLE prise_rdv ADD CONSTRAINT FK_467916926AA8D4DD FOREIGN KEY (id_docteur_id) REFERENCES docteur (id)');
        $this->addSql('ALTER TABLE prise_rdv ADD CONSTRAINT FK_46791692CE0312AE FOREIGN KEY (id_patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE specialite_docteur ADD CONSTRAINT FK_BCAEB6BD2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE specialite_docteur ADD CONSTRAINT FK_BCAEB6BDCF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_83A7A439F85E0677 ON docteur');
        $this->addSql('ALTER TABLE docteur DROP username, DROP roles, DROP password, CHANGE id id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_1ADAD7EBF85E0677 ON patient');
        $this->addSql('ALTER TABLE patient DROP username, DROP roles, DROP password, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE prise_rdv DROP FOREIGN KEY FK_467916926AA8D4DD');
        $this->addSql('ALTER TABLE prise_rdv DROP FOREIGN KEY FK_46791692CE0312AE');
        $this->addSql('ALTER TABLE specialite_docteur DROP FOREIGN KEY FK_BCAEB6BD2195E0F0');
        $this->addSql('ALTER TABLE specialite_docteur DROP FOREIGN KEY FK_BCAEB6BDCF22540A');
    }
}
