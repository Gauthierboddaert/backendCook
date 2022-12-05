<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221204112708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette_category (recette_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B658F93989312FE9 (recette_id), INDEX IDX_B658F93912469DE2 (category_id), PRIMARY KEY(recette_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recette_category ADD CONSTRAINT FK_B658F93989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_category ADD CONSTRAINT FK_B658F93912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C189312FE9');
        $this->addSql('DROP INDEX IDX_64C19C189312FE9 ON category');
        $this->addSql('ALTER TABLE category DROP recette_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette_category DROP FOREIGN KEY FK_B658F93989312FE9');
        $this->addSql('ALTER TABLE recette_category DROP FOREIGN KEY FK_B658F93912469DE2');
        $this->addSql('DROP TABLE recette_category');
        $this->addSql('ALTER TABLE category ADD recette_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C189312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('CREATE INDEX IDX_64C19C189312FE9 ON category (recette_id)');
    }
}
