<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210418123958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE regime_aliment (id INT AUTO_INCREMENT NOT NULL, id_aliment INT NOT NULL, id_regime INT NOT NULL, INDEX fk_aliment (id_aliment), INDEX fk_regime (id_regime), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_like (id INT AUTO_INCREMENT NOT NULL, video_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_ABF41D6F29C1004E (video_id), INDEX IDX_ABF41D6FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE video_like ADD CONSTRAINT FK_ABF41D6F29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE video_like ADD CONSTRAINT FK_ABF41D6FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE aliment DROP FOREIGN KEY aliment_ibfk_1');
        $this->addSql('ALTER TABLE aliment CHANGE id_regime id_regime INT DEFAULT NULL, CHANGE recette recette TEXT NOT NULL');
        $this->addSql('ALTER TABLE aliment ADD CONSTRAINT FK_70FF972B8CB1FF91 FOREIGN KEY (id_regime) REFERENCES regime (id_regime)');
        $this->addSql('ALTER TABLE e_books CHANGE id_c id_c INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY fk_idmusic');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY fk_iduser');
        $this->addSql('ALTER TABLE favoris CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_music id_music INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43223D7637A FOREIGN KEY (id_music) REFERENCES musique (nombre)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4326B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE health DROP FOREIGN KEY fk_health');
        $this->addSql('ALTER TABLE health CHANGE id_User id_User INT DEFAULT NULL');
        $this->addSql('ALTER TABLE health ADD CONSTRAINT FK_CEDA2313A6816575 FOREIGN KEY (id_User) REFERENCES user (id)');
        $this->addSql('ALTER TABLE liste_taches DROP FOREIGN KEY liste_taches_ibfk_1');
        $this->addSql('ALTER TABLE liste_taches CHANGE id_p id_p INT DEFAULT NULL, CHANGE etat_du_tache etat_du_tache INT NOT NULL');
        $this->addSql('ALTER TABLE liste_taches ADD CONSTRAINT FK_A83B8A3459234CE FOREIGN KEY (id_p) REFERENCES planning (id)');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY planning_ibfk_1');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY planning_ibfk_2');
        $this->addSql('ALTER TABLE planning CHANGE id_U id_U INT DEFAULT NULL, CHANGE liker liker INT DEFAULT NULL, CHANGE disliker disliker INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6E96E089 FOREIGN KEY (id_U) REFERENCES user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6FA4255D8 FOREIGN KEY (id_C) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE planning_user CHANGE id_p id_p INT DEFAULT NULL, CHANGE id_u id_u INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE id_client id_client INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regime CHANGE id_User id_User INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY fk_idcoach');
        $this->addSql('ALTER TABLE review CHANGE id_coach id_coach INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6D1DC2CFC FOREIGN KEY (id_coach) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE tache CHANGE `like` `like` INT DEFAULT NULL, CHANGE dislike dislike INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video CHANGE mailSent mailSent INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE regime_aliment');
        $this->addSql('DROP TABLE video_like');
        $this->addSql('ALTER TABLE aliment DROP FOREIGN KEY FK_70FF972B8CB1FF91');
        $this->addSql('ALTER TABLE aliment CHANGE id_regime id_regime INT NOT NULL, CHANGE recette recette VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE aliment ADD CONSTRAINT aliment_ibfk_1 FOREIGN KEY (id_regime) REFERENCES regime (id_regime) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE e_books CHANGE id_c id_c INT NOT NULL');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43223D7637A');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4326B3CA4B');
        $this->addSql('ALTER TABLE favoris CHANGE id_music id_music INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT fk_idmusic FOREIGN KEY (id_music) REFERENCES musique (nombre) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT fk_iduser FOREIGN KEY (id_user) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE health DROP FOREIGN KEY FK_CEDA2313A6816575');
        $this->addSql('ALTER TABLE health CHANGE id_User id_User INT NOT NULL');
        $this->addSql('ALTER TABLE health ADD CONSTRAINT fk_health FOREIGN KEY (id_User) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_taches DROP FOREIGN KEY FK_A83B8A3459234CE');
        $this->addSql('ALTER TABLE liste_taches CHANGE id_p id_p INT NOT NULL, CHANGE etat_du_tache etat_du_tache INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE liste_taches ADD CONSTRAINT liste_taches_ibfk_1 FOREIGN KEY (id_p) REFERENCES planning (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6E96E089');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6FA4255D8');
        $this->addSql('ALTER TABLE planning CHANGE liker liker INT DEFAULT 0, CHANGE disliker disliker INT DEFAULT 0, CHANGE id_U id_U INT NOT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT planning_ibfk_1 FOREIGN KEY (id_U) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT planning_ibfk_2 FOREIGN KEY (id_C) REFERENCES coach (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning_user CHANGE id_p id_p INT NOT NULL, CHANGE id_u id_u INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE id_client id_client INT NOT NULL');
        $this->addSql('ALTER TABLE regime CHANGE id_User id_User INT NOT NULL');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6D1DC2CFC');
        $this->addSql('ALTER TABLE review CHANGE id_coach id_coach INT NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT fk_idcoach FOREIGN KEY (id_coach) REFERENCES coach (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache CHANGE `like` `like` INT DEFAULT 0, CHANGE dislike dislike INT DEFAULT 0');
        $this->addSql('ALTER TABLE video CHANGE mailSent mailSent INT DEFAULT 0 NOT NULL');
    }
}
