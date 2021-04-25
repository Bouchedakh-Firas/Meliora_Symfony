<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210418224316 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_taches DROP FOREIGN KEY FK_A83B8A3459234CE');
        $this->addSql('ALTER TABLE planning_user DROP FOREIGN KEY FK_4545DE07459234CE');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, id_music INT DEFAULT NULL, id_user INT DEFAULT NULL, INDEX id_user (id_user), INDEX id_music (id_music), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vlike (id INT AUTO_INCREMENT NOT NULL, video_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_3D977DDD29C1004E (video_id), INDEX IDX_3D977DDDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43223D7637A FOREIGN KEY (id_music) REFERENCES musique (nombre)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4326B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vlike ADD CONSTRAINT FK_3D977DDD29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE vlike ADD CONSTRAINT FK_3D977DDDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE liste_taches');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE planning_user');
        $this->addSql('DROP TABLE video_like');
        $this->addSql('ALTER TABLE aliment CHANGE recette recette VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE video CHANGE mailSent mailSent INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liste_taches (id INT AUTO_INCREMENT NOT NULL, id_p INT DEFAULT NULL, id_t INT DEFAULT NULL, date DATETIME NOT NULL, nom_tache VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, type_tache VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, etat_du_tache INT NOT NULL, INDEX id_p (id_p), INDEX id_t (id_t), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, liker INT DEFAULT NULL, disliker INT DEFAULT NULL, date_creation DATE DEFAULT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, nom_p VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, id_U INT DEFAULT NULL, id_C INT DEFAULT NULL, INDEX id_U (id_U), INDEX id_C (id_C), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE planning_user (id INT AUTO_INCREMENT NOT NULL, id_p INT DEFAULT NULL, id_u INT DEFAULT NULL, date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP, date_suppr DATE DEFAULT NULL, nom_planning VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, nb_tache INT DEFAULT NULL, INDEX id_p (id_p), INDEX id_u (id_u), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE video_like (id INT AUTO_INCREMENT NOT NULL, video_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_ABF41D6FA76ED395 (user_id), INDEX IDX_ABF41D6F29C1004E (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE liste_taches ADD CONSTRAINT FK_A83B8A342FFF0D7 FOREIGN KEY (id_t) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE liste_taches ADD CONSTRAINT FK_A83B8A3459234CE FOREIGN KEY (id_p) REFERENCES planning (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6E96E089 FOREIGN KEY (id_U) REFERENCES user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6FA4255D8 FOREIGN KEY (id_C) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE planning_user ADD CONSTRAINT FK_4545DE0735F8C041 FOREIGN KEY (id_u) REFERENCES user (id)');
        $this->addSql('ALTER TABLE planning_user ADD CONSTRAINT FK_4545DE07459234CE FOREIGN KEY (id_p) REFERENCES planning (id)');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE vlike');
        $this->addSql('ALTER TABLE aliment CHANGE recette recette TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE video CHANGE mailSent mailSent INT DEFAULT 0 NOT NULL');
    }
}
