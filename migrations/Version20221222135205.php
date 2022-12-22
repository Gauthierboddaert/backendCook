<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221222135205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris_recette (favoris_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_FC51CA9551E8871B (favoris_id), INDEX IDX_FC51CA9589312FE9 (recette_id), PRIMARY KEY(favoris_id, recette_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris_user (favoris_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3E144C2E51E8871B (favoris_id), INDEX IDX_3E144C2EA76ED395 (user_id), PRIMARY KEY(favoris_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favoris_recette ADD CONSTRAINT FK_FC51CA9551E8871B FOREIGN KEY (favoris_id) REFERENCES favoris (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favoris_recette ADD CONSTRAINT FK_FC51CA9589312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favoris_user ADD CONSTRAINT FK_3E144C2E51E8871B FOREIGN KEY (favoris_id) REFERENCES favoris (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favoris_user ADD CONSTRAINT FK_3E144C2EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris_recette DROP FOREIGN KEY FK_FC51CA9551E8871B');
        $this->addSql('ALTER TABLE favoris_recette DROP FOREIGN KEY FK_FC51CA9589312FE9');
        $this->addSql('ALTER TABLE favoris_user DROP FOREIGN KEY FK_3E144C2E51E8871B');
        $this->addSql('ALTER TABLE favoris_user DROP FOREIGN KEY FK_3E144C2EA76ED395');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE favoris_recette');
        $this->addSql('DROP TABLE favoris_user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
