<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220105130915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stage_formation (stage_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_734BDB9E2298D193 (stage_id), INDEX IDX_734BDB9E5200282E (formation_id), PRIMARY KEY(stage_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stage_formation ADD CONSTRAINT FK_734BDB9E2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage_formation ADD CONSTRAINT FK_734BDB9E5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise DROP a');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C93695200282E');
        $this->addSql('DROP INDEX IDX_C27C93695200282E ON stage');
        $this->addSql('ALTER TABLE stage DROP formation_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stage_formation');
        $this->addSql('ALTER TABLE entreprise ADD a VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stage ADD formation_id INT NOT NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93695200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_C27C93695200282E ON stage (formation_id)');
    }
}
