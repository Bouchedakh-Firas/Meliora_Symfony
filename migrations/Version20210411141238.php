<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411141238 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aliment (id_aliment INT AUTO_INCREMENT NOT NULL, id_regime INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, recette TEXT NOT NULL, calorie DOUBLE PRECISION NOT NULL, gras DOUBLE PRECISION NOT NULL, carbs DOUBLE PRECISION NOT NULL, INDEX id_regime (id_regime), PRIMARY KEY(id_aliment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE citations (id INT AUTO_INCREMENT NOT NULL, auteur VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coach (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, tel INT NOT NULL, adresse VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, rating DOUBLE PRECISION NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE e_books (id INT AUTO_INCREMENT NOT NULL, id_c INT DEFAULT NULL, auteur VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, favoris INT NOT NULL, titre VARCHAR(255) NOT NULL, evaluation DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, INDEX id_c (id_c), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, id_music INT DEFAULT NULL, id_user INT DEFAULT NULL, INDEX id_music (id_music), INDEX id_user (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE health (id_health INT AUTO_INCREMENT NOT NULL, total_calories INT NOT NULL, total_carbs INT NOT NULL, total_gras INT NOT NULL, moy_tension INT NOT NULL, poids INT NOT NULL, hauteur INT NOT NULL, id_User INT DEFAULT NULL, INDEX fk_health (id_User), PRIMARY KEY(id_health)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_taches (id INT AUTO_INCREMENT NOT NULL, id_p INT DEFAULT NULL, id_t INT DEFAULT NULL, date DATETIME NOT NULL, nom_tache VARCHAR(255) DEFAULT NULL, type_tache VARCHAR(255) DEFAULT NULL, etat_du_tache INT NOT NULL, INDEX id_t (id_t), INDEX id_p (id_p), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE musique (nombre INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, genre VARCHAR(20) NOT NULL, Artiste VARCHAR(50) NOT NULL, MusicPath VARCHAR(250) NOT NULL, image VARCHAR(250) DEFAULT \'noImage\', PRIMARY KEY(nombre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, liker INT DEFAULT NULL, disliker INT DEFAULT NULL, date_creation DATE DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, nom_p VARCHAR(255) DEFAULT NULL, id_U INT DEFAULT NULL, id_C INT DEFAULT NULL, INDEX id_C (id_C), INDEX id_U (id_U), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning_user (id INT AUTO_INCREMENT NOT NULL, id_p INT DEFAULT NULL, id_u INT DEFAULT NULL, date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP, date_suppr DATE DEFAULT NULL, nom_planning VARCHAR(255) DEFAULT NULL, nb_tache INT DEFAULT NULL, INDEX id_u (id_u), INDEX id_p (id_p), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, id_client INT DEFAULT NULL, sujetReclamation VARCHAR(255) NOT NULL, statu VARCHAR(255) NOT NULL, descriptionReclamation VARCHAR(255) NOT NULL, dateReclamation DATE NOT NULL, INDEX id_client (id_client), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regime2 (id_regime INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, duration INT NOT NULL, id_User INT DEFAULT NULL, INDEX id_User (id_User), PRIMARY KEY(id_regime)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regime_aliment (id INT AUTO_INCREMENT NOT NULL, id_aliment INT NOT NULL, id_regime INT NOT NULL, INDEX fk_aliment (id_aliment), INDEX fk_regime (id_regime), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, id_coach INT DEFAULT NULL, etat VARCHAR(20) NOT NULL, rating DOUBLE PRECISION NOT NULL, comment TEXT NOT NULL, INDEX fk_idcoach (id_coach), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, id_c INT DEFAULT NULL, id_e INT DEFAULT NULL, type_tache VARCHAR(255) NOT NULL, nom_tache VARCHAR(255) NOT NULL, id_v INT DEFAULT NULL, id_m INT DEFAULT NULL, idnonnull INT NOT NULL, `like` INT DEFAULT NULL, dislike INT DEFAULT NULL, INDEX tache_ebook (id_e), INDEX tache_citation (id_c), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', prenom VARCHAR(200) DEFAULT NULL, dateNai DATE DEFAULT NULL, adresse VARCHAR(200) DEFAULT NULL, tel VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id_v INT AUTO_INCREMENT NOT NULL, titre VARCHAR(20) NOT NULL, genre VARCHAR(20) NOT NULL, VideoPath VARCHAR(500) NOT NULL, nb_likes INT NOT NULL, nb_dislikes INT NOT NULL, mailSent INT NOT NULL, PRIMARY KEY(id_v)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aliment ADD CONSTRAINT FK_70FF972B8CB1FF91 FOREIGN KEY (id_regime) REFERENCES regime2 (id_regime)');
        $this->addSql('ALTER TABLE e_books ADD CONSTRAINT FK_3503DB91C12C7510 FOREIGN KEY (id_c) REFERENCES citations (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43223D7637A FOREIGN KEY (id_music) REFERENCES musique (nombre)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4326B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE health ADD CONSTRAINT FK_CEDA2313A6816575 FOREIGN KEY (id_User) REFERENCES user (id)');
        $this->addSql('ALTER TABLE liste_taches ADD CONSTRAINT FK_A83B8A3459234CE FOREIGN KEY (id_p) REFERENCES planning (id)');
        $this->addSql('ALTER TABLE liste_taches ADD CONSTRAINT FK_A83B8A342FFF0D7 FOREIGN KEY (id_t) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6E96E089 FOREIGN KEY (id_U) REFERENCES user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6FA4255D8 FOREIGN KEY (id_C) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE planning_user ADD CONSTRAINT FK_4545DE07459234CE FOREIGN KEY (id_p) REFERENCES planning (id)');
        $this->addSql('ALTER TABLE planning_user ADD CONSTRAINT FK_4545DE0735F8C041 FOREIGN KEY (id_u) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404E173B1B8 FOREIGN KEY (id_client) REFERENCES user (id)');
        $this->addSql('ALTER TABLE regime2 ADD CONSTRAINT FK_43CC0550A6816575 FOREIGN KEY (id_User) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6D1DC2CFC FOREIGN KEY (id_coach) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075C12C7510 FOREIGN KEY (id_c) REFERENCES citations (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075284FD025 FOREIGN KEY (id_e) REFERENCES e_books (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE e_books DROP FOREIGN KEY FK_3503DB91C12C7510');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075C12C7510');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6FA4255D8');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6D1DC2CFC');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075284FD025');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43223D7637A');
        $this->addSql('ALTER TABLE liste_taches DROP FOREIGN KEY FK_A83B8A3459234CE');
        $this->addSql('ALTER TABLE planning_user DROP FOREIGN KEY FK_4545DE07459234CE');
        $this->addSql('ALTER TABLE aliment DROP FOREIGN KEY FK_70FF972B8CB1FF91');
        $this->addSql('ALTER TABLE liste_taches DROP FOREIGN KEY FK_A83B8A342FFF0D7');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4326B3CA4B');
        $this->addSql('ALTER TABLE health DROP FOREIGN KEY FK_CEDA2313A6816575');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6E96E089');
        $this->addSql('ALTER TABLE planning_user DROP FOREIGN KEY FK_4545DE0735F8C041');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404E173B1B8');
        $this->addSql('ALTER TABLE regime2 DROP FOREIGN KEY FK_43CC0550A6816575');
        $this->addSql('DROP TABLE aliment');
        $this->addSql('DROP TABLE citations');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE e_books');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE health');
        $this->addSql('DROP TABLE liste_taches');
        $this->addSql('DROP TABLE musique');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE planning_user');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE regime2');
        $this->addSql('DROP TABLE regime_aliment');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
    }
}
