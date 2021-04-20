<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420214437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, poste_id INT DEFAULT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_DADD4A25A76ED395 (user_id), INDEX IDX_DADD4A25A0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_7C890FABA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_langage_poste (poste_id INT NOT NULL, poste_langage_id INT NOT NULL, INDEX IDX_96C1166DA0905086 (poste_id), INDEX IDX_96C1166DE46E110E (poste_langage_id), PRIMARY KEY(poste_id, poste_langage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_dislike (id INT AUTO_INCREMENT NOT NULL, poste_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_8E81CE3AA0905086 (poste_id), INDEX IDX_8E81CE3AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_langage (id INT AUTO_INCREMENT NOT NULL, langage VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_like (id INT AUTO_INCREMENT NOT NULL, poste_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_C3BC988CA0905086 (poste_id), INDEX IDX_C3BC988CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_50159CA9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, grade INT NOT NULL, creation_date DATETIME NOT NULL, is_banished TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE poste_langage_poste ADD CONSTRAINT FK_96C1166DA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poste_langage_poste ADD CONSTRAINT FK_96C1166DE46E110E FOREIGN KEY (poste_langage_id) REFERENCES poste_langage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poste_dislike ADD CONSTRAINT FK_8E81CE3AA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE poste_dislike ADD CONSTRAINT FK_8E81CE3AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE poste_like ADD CONSTRAINT FK_C3BC988CA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE poste_like ADD CONSTRAINT FK_C3BC988CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25A0905086');
        $this->addSql('ALTER TABLE poste_langage_poste DROP FOREIGN KEY FK_96C1166DA0905086');
        $this->addSql('ALTER TABLE poste_dislike DROP FOREIGN KEY FK_8E81CE3AA0905086');
        $this->addSql('ALTER TABLE poste_like DROP FOREIGN KEY FK_C3BC988CA0905086');
        $this->addSql('ALTER TABLE poste_langage_poste DROP FOREIGN KEY FK_96C1166DE46E110E');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25A76ED395');
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FABA76ED395');
        $this->addSql('ALTER TABLE poste_dislike DROP FOREIGN KEY FK_8E81CE3AA76ED395');
        $this->addSql('ALTER TABLE poste_like DROP FOREIGN KEY FK_C3BC988CA76ED395');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9A76ED395');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE poste_langage_poste');
        $this->addSql('DROP TABLE poste_dislike');
        $this->addSql('DROP TABLE poste_langage');
        $this->addSql('DROP TABLE poste_like');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE user');
    }
}
