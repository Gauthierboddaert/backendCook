<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221222135335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE like_recette (like_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_1A3629B3859BFA32 (like_id), INDEX IDX_1A3629B389312FE9 (recette_id), PRIMARY KEY(like_id, recette_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE like_user (like_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_54E60A37859BFA32 (like_id), INDEX IDX_54E60A37A76ED395 (user_id), PRIMARY KEY(like_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE like_recette ADD CONSTRAINT FK_1A3629B3859BFA32 FOREIGN KEY (like_id) REFERENCES `like` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE like_recette ADD CONSTRAINT FK_1A3629B389312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE like_user ADD CONSTRAINT FK_54E60A37859BFA32 FOREIGN KEY (like_id) REFERENCES `like` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE like_user ADD CONSTRAINT FK_54E60A37A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE like_recette DROP FOREIGN KEY FK_1A3629B3859BFA32');
        $this->addSql('ALTER TABLE like_recette DROP FOREIGN KEY FK_1A3629B389312FE9');
        $this->addSql('ALTER TABLE like_user DROP FOREIGN KEY FK_54E60A37859BFA32');
        $this->addSql('ALTER TABLE like_user DROP FOREIGN KEY FK_54E60A37A76ED395');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE like_recette');
        $this->addSql('DROP TABLE like_user');
    }
}
