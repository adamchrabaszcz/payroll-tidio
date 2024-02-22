<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222002718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE department (id UUID NOT NULL, name VARCHAR(255) NOT NULL, department_bonus_bonus_type VARCHAR(255) NOT NULL, department_bonus_amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN department.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE employee (id UUID NOT NULL, department_id UUID NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, base_salary INT NOT NULL, started_work_at VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5D9F75A1AE80F5DF ON employee (department_id)');
        $this->addSql('COMMENT ON COLUMN employee.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN employee.department_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE employee DROP CONSTRAINT FK_5D9F75A1AE80F5DF');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE employee');
    }
}
