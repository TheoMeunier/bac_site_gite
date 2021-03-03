<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303214723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar ADD user_id INT DEFAULT NULL, ADD gite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146652CAE9B FOREIGN KEY (gite_id) REFERENCES gite (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EA9A146A76ED395 ON calendar (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EA9A146652CAE9B ON calendar (gite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146A76ED395');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146652CAE9B');
        $this->addSql('DROP INDEX UNIQ_6EA9A146A76ED395 ON calendar');
        $this->addSql('DROP INDEX UNIQ_6EA9A146652CAE9B ON calendar');
        $this->addSql('ALTER TABLE calendar DROP user_id, DROP gite_id');
    }
}
