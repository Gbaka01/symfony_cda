<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261013210428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY `ingredient_ibfk_1`');
        $this->addSql('ALTER TABLE ingredient CHANGE description description VARCHAR(255) NOT NULL, CHANGE recette_id recette_id INT NOT NULL');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787089312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY `note_ibfk_1`');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY `note_ibfk_2`');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1489312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY `recette_ibfk_1`');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY `recette_ibfk_2`');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63908EDA19B0 FOREIGN KEY (moderated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE recette_categorie DROP FOREIGN KEY `recette_categorie_ibfk_1`');
        $this->addSql('ALTER TABLE recette_categorie DROP FOREIGN KEY `recette_categorie_ibfk_2`');
        $this->addSql('ALTER TABLE recette_categorie ADD CONSTRAINT FK_FAABB8FA89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_categorie ADD CONSTRAINT FK_FAABB8FABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787089312FE9');
        $this->addSql('ALTER TABLE ingredient CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE recette_id recette_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT `ingredient_ibfk_1` FOREIGN KEY (recette_id) REFERENCES recette (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1489312FE9');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A76ED395');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (recette_id) REFERENCES recette (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63908EDA19B0');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390A76ED395');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT `recette_ibfk_1` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT `recette_ibfk_2` FOREIGN KEY (moderated_by_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_categorie DROP FOREIGN KEY FK_FAABB8FA89312FE9');
        $this->addSql('ALTER TABLE recette_categorie DROP FOREIGN KEY FK_FAABB8FABCF5E72D');
        $this->addSql('ALTER TABLE recette_categorie ADD CONSTRAINT `recette_categorie_ibfk_1` FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_categorie ADD CONSTRAINT `recette_categorie_ibfk_2` FOREIGN KEY (recette_id) REFERENCES recette (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
