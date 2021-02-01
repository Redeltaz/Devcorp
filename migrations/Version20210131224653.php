<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210131224653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE poste_langage_poste DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE poste_langage_poste ADD PRIMARY KEY (poste_id, poste_langage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25A76ED395');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25A0905086');
        $this->addSql('ALTER TABLE poste_langage_poste DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE poste_langage_poste ADD PRIMARY KEY (poste_langage_id, poste_id)');
    }
}
