<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215161832 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient_docteur (patient_id INT NOT NULL, docteur_id INT NOT NULL, INDEX IDX_DEC4F1D26B899279 (patient_id), INDEX IDX_DEC4F1D2CF22540A (docteur_id), PRIMARY KEY(patient_id, docteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_docteur ADD CONSTRAINT FK_DEC4F1D26B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_docteur ADD CONSTRAINT FK_DEC4F1D2CF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient_docteur DROP FOREIGN KEY FK_DEC4F1D2CF22540A');
        $this->addSql('ALTER TABLE patient_docteur DROP FOREIGN KEY FK_DEC4F1D26B899279');
        $this->addSql('DROP TABLE patient_docteur');
    }
}
