<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210423002018 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, id_client INT DEFAULT NULL, sujetReclamation VARCHAR(255) NOT NULL, statu VARCHAR(255) NOT NULL, descriptionReclamation VARCHAR(255) NOT NULL, dateReclamation DATE NOT NULL, INDEX id_client (id_client), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(180) NOT NULL, adresse VARCHAR(180) NOT NULL, prenom VARCHAR(180) NOT NULL, date_nai DATE NOT NULL, tel INT NOT NULL, is_active TINYINT(1) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404E173B1B8 FOREIGN KEY (id_client) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4326B3CA4B');
        $this->addSql('ALTER TABLE health DROP FOREIGN KEY FK_CEDA2313A6816575');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6E96E089');
        $this->addSql('ALTER TABLE planning_user DROP FOREIGN KEY FK_4545DE0735F8C041');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404E173B1B8');
        $this->addSql('ALTER TABLE regime DROP FOREIGN KEY FK_AA864A7CA6816575');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE user');
    }
}
