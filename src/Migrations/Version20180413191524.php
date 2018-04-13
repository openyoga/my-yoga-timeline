<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180413191524 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE workshops_participants DROP FOREIGN KEY FK_78391CCA1FDCE57C');
        $this->addSql('CREATE TABLE events_participants (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, participant_id INT NOT NULL, special_fee NUMERIC(5, 2) DEFAULT NULL, fee_payed_yn VARCHAR(1) NOT NULL, attending_yn VARCHAR(1) NOT NULL, INDEX IDX_E8FA4B6271F7E88B (event_id), INDEX IDX_E8FA4B629D1C3019 (participant_id), UNIQUE INDEX unique_event_participant (event_id, participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, yoga_style_id INT NOT NULL, location_id INT NOT NULL, inspiration_id INT DEFAULT NULL, location_fee NUMERIC(6, 2) NOT NULL, planned_date DATETIME NOT NULL, duration INT NOT NULL, fee NUMERIC(5, 2) NOT NULL, comments VARCHAR(500) DEFAULT NULL, INDEX IDX_5387574A5D1D1ED8 (yoga_style_id), INDEX IDX_5387574A64D218E (location_id), INDEX IDX_5387574A2B726C5F (inspiration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events_participants ADD CONSTRAINT FK_E8FA4B6271F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE events_participants ADD CONSTRAINT FK_E8FA4B629D1C3019 FOREIGN KEY (participant_id) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A5D1D1ED8 FOREIGN KEY (yoga_style_id) REFERENCES yoga_styles (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A2B726C5F FOREIGN KEY (inspiration_id) REFERENCES inspirations (id)');
        $this->addSql('DROP TABLE workshops');
        $this->addSql('DROP TABLE workshops_participants');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events_participants DROP FOREIGN KEY FK_E8FA4B6271F7E88B');
        $this->addSql('CREATE TABLE workshops (id INT AUTO_INCREMENT NOT NULL, yoga_style_id INT NOT NULL, location_id INT NOT NULL, inspiration_id INT DEFAULT NULL, location_fee NUMERIC(6, 2) NOT NULL, planned_date DATETIME NOT NULL, duration INT NOT NULL, fee NUMERIC(5, 2) NOT NULL, comments VARCHAR(500) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_879CA6A05D1D1ED8 (yoga_style_id), INDEX IDX_879CA6A064D218E (location_id), INDEX IDX_879CA6A02B726C5F (inspiration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshops_participants (id INT AUTO_INCREMENT NOT NULL, workshop_id INT NOT NULL, participant_id INT NOT NULL, special_fee NUMERIC(5, 2) DEFAULT NULL, fee_payed_yn VARCHAR(1) NOT NULL COLLATE utf8mb4_unicode_ci, attending_yn VARCHAR(1) NOT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX unique_workshop_participant (workshop_id, participant_id), INDEX IDX_78391CCA1FDCE57C (workshop_id), INDEX IDX_78391CCA9D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workshops ADD CONSTRAINT FK_879CA6A02B726C5F FOREIGN KEY (inspiration_id) REFERENCES inspirations (id)');
        $this->addSql('ALTER TABLE workshops ADD CONSTRAINT FK_879CA6A05D1D1ED8 FOREIGN KEY (yoga_style_id) REFERENCES yoga_styles (id)');
        $this->addSql('ALTER TABLE workshops ADD CONSTRAINT FK_879CA6A064D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE workshops_participants ADD CONSTRAINT FK_78391CCA1FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshops (id)');
        $this->addSql('ALTER TABLE workshops_participants ADD CONSTRAINT FK_78391CCA9D1C3019 FOREIGN KEY (participant_id) REFERENCES participants (id)');
        $this->addSql('DROP TABLE events_participants');
        $this->addSql('DROP TABLE events');
    }
}
