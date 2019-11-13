<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191113142730 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates the Ticket and SpectaclePlace tables';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE spectacle_place (id INT AUTO_INCREMENT NOT NULL, spectacle_id INT NOT NULL, ticket_id INT DEFAULT NULL, INDEX IDX_6290ECD8C682915D (spectacle_id), UNIQUE INDEX UNIQ_6290ECD8700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, spectacle_id INT NOT NULL, shop_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, uid VARCHAR(255) NOT NULL, INDEX IDX_97A0ADA3C682915D (spectacle_id), INDEX IDX_97A0ADA34D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE spectacle_place ADD CONSTRAINT FK_6290ECD8C682915D FOREIGN KEY (spectacle_id) REFERENCES spectacle (id)');
        $this->addSql('ALTER TABLE spectacle_place ADD CONSTRAINT FK_6290ECD8700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C682915D FOREIGN KEY (spectacle_id) REFERENCES spectacle (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA34D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE shop CHANGE url url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE shop_id shop_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE spectacle_place DROP FOREIGN KEY FK_6290ECD8700047D2');
        $this->addSql('DROP TABLE spectacle_place');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('ALTER TABLE shop CHANGE url url VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE shop_id shop_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
