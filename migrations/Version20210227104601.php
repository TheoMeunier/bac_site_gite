<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227104601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_blog DROP FOREIGN KEY FK_E623F3AFBA9CD190');
        $this->addSql('DROP INDEX IDX_E623F3AFBA9CD190 ON comment_blog');
        $this->addSql('ALTER TABLE comment_blog ADD commentaire LONGTEXT NOT NULL, CHANGE commentaire_id comment_blog_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment_blog ADD CONSTRAINT FK_E623F3AF29931C87 FOREIGN KEY (comment_blog_id) REFERENCES blog (id)');
        $this->addSql('CREATE INDEX IDX_E623F3AF29931C87 ON comment_blog (comment_blog_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_blog DROP FOREIGN KEY FK_E623F3AF29931C87');
        $this->addSql('DROP INDEX IDX_E623F3AF29931C87 ON comment_blog');
        $this->addSql('ALTER TABLE comment_blog DROP commentaire, CHANGE comment_blog_id commentaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment_blog ADD CONSTRAINT FK_E623F3AFBA9CD190 FOREIGN KEY (commentaire_id) REFERENCES blog (id)');
        $this->addSql('CREATE INDEX IDX_E623F3AFBA9CD190 ON comment_blog (commentaire_id)');
    }
}
