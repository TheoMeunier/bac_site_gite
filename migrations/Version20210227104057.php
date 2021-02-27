<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227104057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment_blog (id INT AUTO_INCREMENT NOT NULL, commentaire_id INT DEFAULT NULL, INDEX IDX_E623F3AFBA9CD190 (commentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment_blog ADD CONSTRAINT FK_E623F3AFBA9CD190 FOREIGN KEY (commentaire_id) REFERENCES blog (id)');
        $this->addSql('DROP TABLE commentaires_blog');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaires_blog (id INT AUTO_INCREMENT NOT NULL, commentaires_id INT DEFAULT NULL, INDEX IDX_68D22C0917C4B2B0 (commentaires_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaires_blog ADD CONSTRAINT FK_68D22C0917C4B2B0 FOREIGN KEY (commentaires_id) REFERENCES blog (id)');
        $this->addSql('DROP TABLE comment_blog');
    }
}
