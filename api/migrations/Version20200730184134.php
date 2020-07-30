<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200730184134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions ADD survey_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5B3FE509D FOREIGN KEY (survey_id) REFERENCES surveys (id)');
        $this->addSql('CREATE INDEX IDX_8ADC54D5B3FE509D ON questions (survey_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5B3FE509D');
        $this->addSql('DROP INDEX IDX_8ADC54D5B3FE509D ON questions');
        $this->addSql('ALTER TABLE questions DROP survey_id');
    }
}
