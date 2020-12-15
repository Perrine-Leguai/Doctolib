<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215161554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
       $this->addSql('CREATE TABLE specialite_docteur (specialite_id INT NOT NULL, docteur_id INT NOT NULL, INDEX IDX_BCAEB6BD2195E0F0 (specialite_id), INDEX IDX_BCAEB6BDCF22540A (docteur_id), PRIMARY KEY(specialite_id, docteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE specialite_docteur ADD CONSTRAINT FK_BCAEB6BD2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE specialite_docteur ADD CONSTRAINT FK_BCAEB6BDCF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE specialite_docteur DROP FOREIGN KEY FK_BCAEB6BDCF22540A');
        $this->addSql('ALTER TABLE specialite_docteur DROP FOREIGN KEY FK_BCAEB6BD2195E0F0');
        $this->addSql('DROP TABLE specialite_docteur');
    }
}
