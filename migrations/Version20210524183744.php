<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524183744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bid (id INT AUTO_INCREMENT NOT NULL, _user_id INT NOT NULL, product_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_4AF2B3F3D32632E8 (_user_id), INDEX IDX_4AF2B3F34584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, _user_id INT NOT NULL, comment LONGTEXT NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_9474526C4584665A (product_id), INDEX IDX_9474526CD32632E8 (_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dispute (id INT AUTO_INCREMENT NOT NULL, purchase_id INT NOT NULL, _user_id INT NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3C925007558FBEB9 (purchase_id), INDEX IDX_3C925007D32632E8 (_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, _user_id INT NOT NULL, UNIQUE INDEX UNIQ_68C58ED9D32632E8 (_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, num_order VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(10) NOT NULL, INDEX IDX_F52993988DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, favorite_id INT DEFAULT NULL, genre_id INT NOT NULL, name VARCHAR(255) NOT NULL, short_description VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, video VARCHAR(255) DEFAULT NULL, start_price DOUBLE PRECISION NOT NULL, min_bid_price DOUBLE PRECISION NOT NULL, max_bid_price DOUBLE PRECISION NOT NULL, started_at DATETIME NOT NULL, ended_at DATETIME NOT NULL, verified TINYINT(1) NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_D34A04ADAA17481D (favorite_id), INDEX IDX_D34A04AD4296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, _order_id INT DEFAULT NULL, bid_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, state VARCHAR(15) NOT NULL, error LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_6117D13BA35F2858 (_order_id), UNIQUE INDEX UNIQ_6117D13B4D9866B8 (bid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate_seller (id INT AUTO_INCREMENT NOT NULL, _user_id INT NOT NULL, seller_id INT NOT NULL, number_stars INT NOT NULL, INDEX IDX_59EDE297D32632E8 (_user_id), INDEX IDX_59EDE2978DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, first_name VARCHAR(25) DEFAULT NULL, last_name VARCHAR(30) NOT NULL, date_birth DATE DEFAULT NULL, email VARCHAR(50) NOT NULL, phone VARCHAR(20) DEFAULT NULL, password VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F3D32632E8 FOREIGN KEY (_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F34584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD32632E8 FOREIGN KEY (_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE dispute ADD CONSTRAINT FK_3C925007558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('ALTER TABLE dispute ADD CONSTRAINT FK_3C925007D32632E8 FOREIGN KEY (_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9D32632E8 FOREIGN KEY (_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988DE820D9 FOREIGN KEY (seller_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADAA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BA35F2858 FOREIGN KEY (_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B4D9866B8 FOREIGN KEY (bid_id) REFERENCES bid (id)');
        $this->addSql('ALTER TABLE rate_seller ADD CONSTRAINT FK_59EDE297D32632E8 FOREIGN KEY (_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rate_seller ADD CONSTRAINT FK_59EDE2978DE820D9 FOREIGN KEY (seller_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B4D9866B8');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADAA17481D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4296D31F');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BA35F2858');
        $this->addSql('ALTER TABLE bid DROP FOREIGN KEY FK_4AF2B3F34584665A');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4584665A');
        $this->addSql('ALTER TABLE dispute DROP FOREIGN KEY FK_3C925007558FBEB9');
        $this->addSql('ALTER TABLE bid DROP FOREIGN KEY FK_4AF2B3F3D32632E8');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD32632E8');
        $this->addSql('ALTER TABLE dispute DROP FOREIGN KEY FK_3C925007D32632E8');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9D32632E8');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988DE820D9');
        $this->addSql('ALTER TABLE rate_seller DROP FOREIGN KEY FK_59EDE297D32632E8');
        $this->addSql('ALTER TABLE rate_seller DROP FOREIGN KEY FK_59EDE2978DE820D9');
        $this->addSql('DROP TABLE bid');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE dispute');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE rate_seller');
        $this->addSql('DROP TABLE `user`');
    }
}
