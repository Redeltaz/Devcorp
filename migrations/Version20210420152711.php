<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420152711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA99D86650F');
        $this->addSql('DROP INDEX IDX_50159CA99D86650F ON projet');
        $this->addSql('ALTER TABLE projet ADD user_id INT DEFAULT NULL, ADD link VARCHAR(255) NOT NULL, DROP user_id_id');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9A76ED395 ON projet (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9A76ED395');
        $this->addSql('DROP INDEX IDX_50159CA9A76ED395 ON projet');
        $this->addSql('ALTER TABLE projet ADD user_id_id INT NOT NULL, DROP user_id, DROP link');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA99D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_50159CA99D86650F ON projet (user_id_id)');
    }
}
