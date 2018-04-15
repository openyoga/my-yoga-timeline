<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180415105606 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(500) NOT NULL, UNIQUE INDEX UNIQ_621D9F475E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, event_category_id INT NOT NULL, location_id INT NOT NULL, inspiration_id INT DEFAULT NULL, location_fee NUMERIC(6, 2) NOT NULL, planned_date DATETIME NOT NULL, duration INT NOT NULL, fee NUMERIC(5, 2) NOT NULL, external_event_yn VARCHAR(1) DEFAULT \'N\' NOT NULL, comment VARCHAR(500) DEFAULT NULL, INDEX IDX_5387574AB9CF4E62 (event_category_id), INDEX IDX_5387574A64D218E (location_id), INDEX IDX_5387574A2B726C5F (inspiration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expenses (id INT AUTO_INCREMENT NOT NULL, date_spent DATETIME NOT NULL, amount NUMERIC(10, 2) NOT NULL, description VARCHAR(250) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inspirations (id INT AUTO_INCREMENT NOT NULL, author VARCHAR(100) NOT NULL, title VARCHAR(100) NOT NULL, reference VARCHAR(500) DEFAULT NULL, UNIQUE INDEX UNIQ_6D2F62DFBDAFD8C8 (author), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, street VARCHAR(100) DEFAULT NULL, zip_code VARCHAR(20) DEFAULT NULL, city VARCHAR(100) NOT NULL, comment VARCHAR(250) DEFAULT NULL, UNIQUE INDEX UNIQ_17E64ABA5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants (id INT AUTO_INCREMENT NOT NULL, academic_title VARCHAR(20) DEFAULT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) DEFAULT NULL, email VARCHAR(100) NOT NULL, info_mails_yn VARCHAR(1) DEFAULT \'N\' NOT NULL, active_yn VARCHAR(1) DEFAULT \'Y\' NOT NULL, comment VARCHAR(250) DEFAULT NULL, UNIQUE INDEX UNIQ_71697092E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payments (id INT AUTO_INCREMENT NOT NULL, participant_id INT NOT NULL, receipt_date DATETIME NOT NULL, amount NUMERIC(6, 2) NOT NULL, comment VARCHAR(100) DEFAULT NULL, INDEX IDX_65D29B329D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events_participants (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, participant_id INT NOT NULL, special_fee NUMERIC(5, 2) DEFAULT NULL, attending_yn VARCHAR(1) DEFAULT \'Y\' NOT NULL, comment VARCHAR(100) DEFAULT NULL, INDEX IDX_E8FA4B6271F7E88B (event_id), INDEX IDX_E8FA4B629D1C3019 (participant_id), UNIQUE INDEX unique_event_participant (event_id, participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AB9CF4E62 FOREIGN KEY (event_category_id) REFERENCES event_categories (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A2B726C5F FOREIGN KEY (inspiration_id) REFERENCES inspirations (id)');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B329D1C3019 FOREIGN KEY (participant_id) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE events_participants ADD CONSTRAINT FK_E8FA4B6271F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE events_participants ADD CONSTRAINT FK_E8FA4B629D1C3019 FOREIGN KEY (participant_id) REFERENCES participants (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AB9CF4E62');
        $this->addSql('ALTER TABLE events_participants DROP FOREIGN KEY FK_E8FA4B6271F7E88B');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A2B726C5F');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A64D218E');
        $this->addSql('ALTER TABLE payments DROP FOREIGN KEY FK_65D29B329D1C3019');
        $this->addSql('ALTER TABLE events_participants DROP FOREIGN KEY FK_E8FA4B629D1C3019');
        $this->addSql('DROP TABLE event_categories');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE expenses');
        $this->addSql('DROP TABLE inspirations');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE payments');
        $this->addSql('DROP TABLE events_participants');
    }
}
