<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201122170855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reponses');
        $this->addSql('DROP TABLE review_postes');
        $this->addSql('DROP TABLE review_reponses');
        $this->addSql('ALTER TABLE poste ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7C890FABA76ED395 ON poste (user_id)');
        $this->addSql('ALTER TABLE user ADD creation_date DATETIME NOT NULL, CHANGE pseudo pseudo VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reponses (id INT AUTO_INCREMENT NOT NULL, contenu TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, foreign_key INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE review_postes (id INT AUTO_INCREMENT NOT NULL, likes INT NOT NULL, dislikes INT NOT NULL, foreign_key INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE review_reponses (id INT AUTO_INCREMENT NOT NULL, likes INT NOT NULL, dislikes INT NOT NULL, foreign_key INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FABA76ED395');
        $this->addSql('DROP INDEX IDX_7C890FABA76ED395 ON poste');
        $this->addSql('ALTER TABLE poste DROP user_id');
        $this->addSql('ALTER TABLE user DROP creation_date, CHANGE pseudo pseudo VARCHAR(16) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, CHANGE email email VARCHAR(500) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, CHANGE password password VARCHAR(18) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, CHANGE picture picture VARCHAR(535) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`');
    }
}
