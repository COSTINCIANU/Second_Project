<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210111557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bijoux ADD CONSTRAINT FK_7B5AF509F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE couture ADD CONSTRAINT FK_791448E5F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image_bijoux ADD CONSTRAINT FK_D447ABC18BE553D6 FOREIGN KEY (bijoux_id) REFERENCES bijoux (id)');
        $this->addSql('ALTER TABLE image_couture ADD CONSTRAINT FK_EC041F39EB12C672 FOREIGN KEY (couture_id) REFERENCES couture (id)');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bijoux DROP FOREIGN KEY FK_7B5AF509F675F31B');
        $this->addSql('ALTER TABLE couture DROP FOREIGN KEY FK_791448E5F675F31B');
        $this->addSql('ALTER TABLE image_bijoux DROP FOREIGN KEY FK_D447ABC18BE553D6');
        $this->addSql('ALTER TABLE image_couture DROP FOREIGN KEY FK_EC041F39EB12C672');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
    }
}
