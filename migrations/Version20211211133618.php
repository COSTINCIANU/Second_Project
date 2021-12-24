<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211211133618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment_b (id INT AUTO_INCREMENT NOT NULL, bijoux_id INT NOT NULL, author_id INT NOT NULL, created_at DATETIME NOT NULL, rating INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_936BD3178BE553D6 (bijoux_id), INDEX IDX_936BD317F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_c (id INT AUTO_INCREMENT NOT NULL, couture_id INT NOT NULL, author_id INT NOT NULL, created_at DATETIME NOT NULL, rating INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_E46CE381EB12C672 (couture_id), INDEX IDX_E46CE381F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment_b ADD CONSTRAINT FK_936BD3178BE553D6 FOREIGN KEY (bijoux_id) REFERENCES bijoux (id)');
        $this->addSql('ALTER TABLE comment_b ADD CONSTRAINT FK_936BD317F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment_c ADD CONSTRAINT FK_E46CE381EB12C672 FOREIGN KEY (couture_id) REFERENCES couture (id)');
        $this->addSql('ALTER TABLE comment_c ADD CONSTRAINT FK_E46CE381F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comment_b');
        $this->addSql('DROP TABLE comment_c');
    }
}
