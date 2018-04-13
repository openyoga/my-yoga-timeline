<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180408190641 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE events_participants (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, participant_id INT NOT NULL, special_fee NUMERIC(5, 2) DEFAULT NULL, fee_payed_yn VARCHAR(1) NOT NULL, INDEX IDX_78391CCA1FDCE57C (event_id), INDEX IDX_78391CCA9D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events_participants ADD CONSTRAINT FK_78391CCA1FDCE57C FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE events_participants ADD CONSTRAINT FK_78391CCA9D1C3019 FOREIGN KEY (participant_id) REFERENCES participants (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE events_participants');
    }
}
