<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210601213543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` CHANGE id id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398B2AA22EE ON `order` (num_order)');
        $this->addSql('ALTER TABLE purchase CHANGE error error LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F5299398B2AA22EE ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE purchase CHANGE error error LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
