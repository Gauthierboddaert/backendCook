<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227121523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F89312FE9');
        $this->addSql('DROP INDEX IDX_C53D045F89312FE9 ON image');
        $this->addSql('ALTER TABLE image DROP recette_id');
        $this->addSql('ALTER TABLE recette ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63903DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49BB63903DA5256D ON recette (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD recette_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F89312FE9 ON image (recette_id)');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63903DA5256D');
        $this->addSql('DROP INDEX UNIQ_49BB63903DA5256D ON recette');
        $this->addSql('ALTER TABLE recette DROP image_id');
    }
}
