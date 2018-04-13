<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180328184236 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events ADD location_id INT DEFAULT NULL, ADD inspiration_id INT DEFAULT NULL, ADD location_fee NUMERIC(6, 2) NOT NULL, ADD planned_date DATETIME NOT NULL, ADD duration INT NOT NULL, ADD fee NUMERIC(5, 2) NOT NULL, ADD comments VARCHAR(255) DEFAULT NULL, ADD tags VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_879CA6A064D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_879CA6A02B726C5F FOREIGN KEY (inspiration_id) REFERENCES inspirations (id)');
        $this->addSql('CREATE INDEX IDX_879CA6A064D218E ON events (location_id)');
        $this->addSql('CREATE INDEX IDX_879CA6A02B726C5F ON events (inspiration_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_879CA6A064D218E');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_879CA6A02B726C5F');
        $this->addSql('DROP INDEX IDX_879CA6A064D218E ON events');
        $this->addSql('DROP INDEX IDX_879CA6A02B726C5F ON events');
        $this->addSql('ALTER TABLE events DROP location_id, DROP inspiration_id, DROP location_fee, DROP planned_date, DROP duration, DROP fee, DROP comments, DROP tags');
    }
}
