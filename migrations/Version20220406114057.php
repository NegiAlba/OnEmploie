<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220406114057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidate_category (candidate_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_A7125B1291BD8781 (candidate_id), INDEX IDX_A7125B1212469DE2 (category_id), PRIMARY KEY(candidate_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate_contract_type (candidate_id INT NOT NULL, contract_type_id INT NOT NULL, INDEX IDX_CADD026C91BD8781 (candidate_id), INDEX IDX_CADD026CCD1DF15B (contract_type_id), PRIMARY KEY(candidate_id, contract_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidate_category ADD CONSTRAINT FK_A7125B1291BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_category ADD CONSTRAINT FK_A7125B1212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_contract_type ADD CONSTRAINT FK_CADD026C91BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_contract_type ADD CONSTRAINT FK_CADD026CCD1DF15B FOREIGN KEY (contract_type_id) REFERENCES contract_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873ECD1DF15B FOREIGN KEY (contract_type_id) REFERENCES contract_type (id)');
        $this->addSql('CREATE INDEX IDX_29D6873ECD1DF15B ON offer (contract_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE candidate_category');
        $this->addSql('DROP TABLE candidate_contract_type');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873ECD1DF15B');
        $this->addSql('DROP INDEX IDX_29D6873ECD1DF15B ON offer');
    }
}
