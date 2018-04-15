<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180415135917 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AB9CF4E62');
        $this->addSql('DROP INDEX IDX_5387574AB9CF4E62 ON events');
        $this->addSql('ALTER TABLE events CHANGE event_category_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A12469DE2 FOREIGN KEY (category_id) REFERENCES event_categories (id)');
        $this->addSql('CREATE INDEX IDX_5387574A12469DE2 ON events (category_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A12469DE2');
        $this->addSql('DROP INDEX IDX_5387574A12469DE2 ON events');
        $this->addSql('ALTER TABLE events CHANGE category_id event_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AB9CF4E62 FOREIGN KEY (event_category_id) REFERENCES event_categories (id)');
        $this->addSql('CREATE INDEX IDX_5387574AB9CF4E62 ON events (event_category_id)');
    }
}
