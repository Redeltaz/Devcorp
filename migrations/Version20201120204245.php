<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201120204245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_langage (id INT AUTO_INCREMENT NOT NULL, langage VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_langage_poste (poste_langage_id INT NOT NULL, poste_id INT NOT NULL, INDEX IDX_96C1166DE46E110E (poste_langage_id), INDEX IDX_96C1166DA0905086 (poste_id), PRIMARY KEY(poste_langage_id, poste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_postes (id INT AUTO_INCREMENT NOT NULL, likes INT NOT NULL, dislikes INT NOT NULL, foreign_key INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_reponses (id INT AUTO_INCREMENT NOT NULL, likes INT NOT NULL, dislikes INT NOT NULL, foreign_key INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poste_langage_poste ADD CONSTRAINT FK_96C1166DE46E110E FOREIGN KEY (poste_langage_id) REFERENCES poste_langage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poste_langage_poste ADD CONSTRAINT FK_96C1166DA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE postes');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poste_langage_poste DROP FOREIGN KEY FK_96C1166DA0905086');
        $this->addSql('ALTER TABLE poste_langage_poste DROP FOREIGN KEY FK_96C1166DE46E110E');
        $this->addSql('CREATE TABLE postes (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(535) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, contenu TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, foreign_key INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE poste_langage');
        $this->addSql('DROP TABLE poste_langage_poste');
        $this->addSql('DROP TABLE review_postes');
        $this->addSql('DROP TABLE review_reponses');
    }
}
