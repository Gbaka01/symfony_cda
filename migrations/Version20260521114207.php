<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260521114207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, description2 VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, description1 VARCHAR(255) NOT NULL, note INT NOT NULL, recette_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_CFBDFA1489312FE9 (recette_id), INDEX IDX_CFBDFA14A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, description3 LONGTEXT NOT NULL, fiche VARCHAR(255) NOT NULL, avatar2 VARCHAR(255) NOT NULL, moderated_by_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_49BB63908EDA19B0 (moderated_by_id), INDEX IDX_49BB6390A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE recette_categorie (recette_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_FAABB8FA89312FE9 (recette_id), INDEX IDX_FAABB8FABCF5E72D (categorie_id), PRIMARY KEY (recette_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE recette_ingredient (recette_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_17C041A989312FE9 (recette_id), INDEX IDX_17C041A9933FE08C (ingredient_id), PRIMARY KEY (recette_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1489312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63908EDA19B0 FOREIGN KEY (moderated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE recette_categorie ADD CONSTRAINT FK_FAABB8FA89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_categorie ADD CONSTRAINT FK_FAABB8FABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A9933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1489312FE9');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A76ED395');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63908EDA19B0');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390A76ED395');
        $this->addSql('ALTER TABLE recette_categorie DROP FOREIGN KEY FK_FAABB8FA89312FE9');
        $this->addSql('ALTER TABLE recette_categorie DROP FOREIGN KEY FK_FAABB8FABCF5E72D');
        $this->addSql('ALTER TABLE recette_ingredient DROP FOREIGN KEY FK_17C041A989312FE9');
        $this->addSql('ALTER TABLE recette_ingredient DROP FOREIGN KEY FK_17C041A9933FE08C');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE recette_categorie');
        $this->addSql('DROP TABLE recette_ingredient');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
