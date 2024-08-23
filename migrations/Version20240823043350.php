<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240823043350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add `age` field to `developer\'s` table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE developer ADD age INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE developer DROP age');
    }
}
