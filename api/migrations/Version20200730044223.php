<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200730044223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE surveys (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, duration INT DEFAULT NULL, next_submission_after INT DEFAULT NULL, ttl INT DEFAULT NULL, use_pagination TINYINT(1) NOT NULL, questions_per_page INT DEFAULT NULL, shuffle_questions TINYINT(1) DEFAULT NULL, immediate_answers TINYINT(1) DEFAULT NULL, restrict_submissions TINYINT(1) DEFAULT NULL, allowed_submissions TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE survey');
        $this->addSql('ALTER TABLE questions ADD shuffle_answers TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE survey (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, summary LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, duration INT DEFAULT NULL, next_submission_after INT DEFAULT NULL, ttl INT DEFAULT NULL, use_pagination TINYINT(1) NOT NULL, questions_per_page INT DEFAULT NULL, shuffle_questions TINYINT(1) DEFAULT NULL, immediate_answers TINYINT(1) DEFAULT NULL, restrict_submissions TINYINT(1) DEFAULT NULL, allowed_submissions TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE surveys');
        $this->addSql('ALTER TABLE questions DROP shuffle_answers');
    }
}
