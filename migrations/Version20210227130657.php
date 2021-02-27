<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227130657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_blog ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment_blog ADD CONSTRAINT FK_E623F3AFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E623F3AFA76ED395 ON comment_blog (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_blog DROP FOREIGN KEY FK_E623F3AFA76ED395');
        $this->addSql('DROP INDEX IDX_E623F3AFA76ED395 ON comment_blog');
        $this->addSql('ALTER TABLE comment_blog DROP user_id');
    }
}
