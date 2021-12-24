<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213202153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_c DROP FOREIGN KEY FK_E46CE38191D79BD3');
        $this->addSql('DROP INDEX IDX_E46CE38191D79BD3 ON comment_c');
        $this->addSql('ALTER TABLE comment_c CHANGE c_id couture_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment_c ADD CONSTRAINT FK_E46CE381EB12C672 FOREIGN KEY (couture_id) REFERENCES couture (id)');
        $this->addSql('CREATE INDEX IDX_E46CE381EB12C672 ON comment_c (couture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_c DROP FOREIGN KEY FK_E46CE381EB12C672');
        $this->addSql('DROP INDEX IDX_E46CE381EB12C672 ON comment_c');
        $this->addSql('ALTER TABLE comment_c CHANGE couture_id c_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment_c ADD CONSTRAINT FK_E46CE38191D79BD3 FOREIGN KEY (c_id) REFERENCES couture (id)');
        $this->addSql('CREATE INDEX IDX_E46CE38191D79BD3 ON comment_c (c_id)');
    }
}
