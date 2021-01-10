<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210109183343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE poste_dislike (id INT AUTO_INCREMENT NOT NULL, poste_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_8E81CE3AA0905086 (poste_id), INDEX IDX_8E81CE3AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_like (id INT AUTO_INCREMENT NOT NULL, poste_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_C3BC988CA0905086 (poste_id), INDEX IDX_C3BC988CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poste_dislike ADD CONSTRAINT FK_8E81CE3AA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE poste_dislike ADD CONSTRAINT FK_8E81CE3AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE poste_like ADD CONSTRAINT FK_C3BC988CA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE poste_like ADD CONSTRAINT FK_C3BC988CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE poste_dislike');
        $this->addSql('DROP TABLE poste_like');
    }
}
