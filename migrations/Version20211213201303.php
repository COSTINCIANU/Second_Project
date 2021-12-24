<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213201303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_b DROP FOREIGN KEY FK_936BD317296BFCB6');
        $this->addSql('DROP INDEX IDX_936BD317296BFCB6 ON comment_b');
        $this->addSql('ALTER TABLE comment_b CHANGE b_id bijoux_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment_b ADD CONSTRAINT FK_936BD3178BE553D6 FOREIGN KEY (bijoux_id) REFERENCES bijoux (id)');
        $this->addSql('CREATE INDEX IDX_936BD3178BE553D6 ON comment_b (bijoux_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_b DROP FOREIGN KEY FK_936BD3178BE553D6');
        $this->addSql('DROP INDEX IDX_936BD3178BE553D6 ON comment_b');
        $this->addSql('ALTER TABLE comment_b CHANGE bijoux_id b_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment_b ADD CONSTRAINT FK_936BD317296BFCB6 FOREIGN KEY (b_id) REFERENCES bijoux (id)');
        $this->addSql('CREATE INDEX IDX_936BD317296BFCB6 ON comment_b (b_id)');
    }
}
