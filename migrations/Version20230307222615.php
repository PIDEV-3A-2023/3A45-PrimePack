<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307222615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, date_n DATE NOT NULL, numero INT NOT NULL, adresse VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_549281976A99F74A');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F6A99F74A');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB4B1C397');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA2843073');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6A99F74A');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E6A99F74A');
        $this->addSql('ALTER TABLE maladie DROP FOREIGN KEY FK_ADC4024B8E962C16');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB293345E0A3');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29F347EFB');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29FD02F13');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D8E962C16');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DB4B1C397');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C3345E0A3');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC276A99F74A');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A8E962C16');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3FD02F13');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE maladie');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE ordonnance');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE ticket');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, theme VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, contenu LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nbr_vue INT NOT NULL, date_creation DATE NOT NULL, INDEX IDX_549281976A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, maladie_id INT DEFAULT NULL, membre_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, race VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, genre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, age VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6AAB231F6A99F74A (membre_id), INDEX IDX_6AAB231FB4B1C397 (maladie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, icone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, note DOUBLE PRECISION NOT NULL, marque VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sous_categorie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, actualite_id INT DEFAULT NULL, membre_id INT DEFAULT NULL, text LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, INDEX IDX_67F068BCA2843073 (actualite_id), INDEX IDX_67F068BC6A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, sponsor LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_B26681E6A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE maladie (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type_aniaml VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_creation DATE NOT NULL, date_maj DATE NOT NULL, INDEX IDX_ADC4024B8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, evenement_id INT DEFAULT NULL, rendezvous_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_naiss DATE NOT NULL, telephone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, adress VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_F6B4FB293345E0A3 (rendezvous_id), INDEX IDX_F6B4FB29F347EFB (produit_id), INDEX IDX_F6B4FB29FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, maladie_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, date_operation DATE NOT NULL, type_operation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom_medecin VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cout_operation INT NOT NULL, note_operation LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1981A66DB4B1C397 (maladie_id), INDEX IDX_1981A66D8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, rendezvous_id INT DEFAULT NULL, date DATE NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, traitement VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_924B326C3345E0A3 (rendezvous_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, membre_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix DOUBLE PRECISION NOT NULL, stock INT NOT NULL, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, disponibilite TINYINT(1) NOT NULL, INDEX IDX_29A5EC27BCF5E72D (categorie_id), INDEX IDX_29A5EC276A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, date DATE NOT NULL, duree TIME NOT NULL, INDEX IDX_65E8AA0A8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix DOUBLE PRECISION NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_97A0ADA3FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_549281976A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB4B1C397 FOREIGN KEY (maladie_id) REFERENCES maladie (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA2843073 FOREIGN KEY (actualite_id) REFERENCES actualite (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE maladie ADD CONSTRAINT FK_ADC4024B8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB293345E0A3 FOREIGN KEY (rendezvous_id) REFERENCES rendez_vous (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DB4B1C397 FOREIGN KEY (maladie_id) REFERENCES maladie (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C3345E0A3 FOREIGN KEY (rendezvous_id) REFERENCES rendez_vous (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC276A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('DROP TABLE user');
    }
}
