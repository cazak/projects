<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240822075432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add `developer`, `developers_projects` and `project` tables';
    }

    public function up(Schema $schema): void
    {
        // developer
        $this->addSql(
            '
            CREATE TABLE developer (
                id UUID NOT NULL,
                position VARCHAR(255) NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                name_name VARCHAR(255) NOT NULL,
                name_surname VARCHAR(255) NOT NULL,
                name_patronymic VARCHAR(255) NOT NULL,
                email_value VARCHAR(255) NOT NULL,
                phone_value VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
           )'
        );
        $this->addSql('COMMENT ON COLUMN developer.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN developer.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN developer.updated_at IS \'(DC2Type:datetime_immutable)\'');

        // developers_projects
        $this->addSql(
            '
            CREATE TABLE developers_projects (
                developer_id UUID NOT NULL,
                project_id UUID NOT NULL,
                PRIMARY KEY(developer_id, project_id)
            )'
        );
        $this->addSql('CREATE INDEX IDX_23A8596B64DD9267 ON developers_projects (developer_id)');
        $this->addSql('CREATE INDEX IDX_23A8596B166D1F9C ON developers_projects (project_id)');
        $this->addSql('COMMENT ON COLUMN developers_projects.developer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN developers_projects.project_id IS \'(DC2Type:uuid)\'');

        // project
        $this->addSql(
            '
            CREATE TABLE project (
                id UUID NOT NULL,
                name VARCHAR(255) NOT NULL,
                client_name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id)
            )'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2FB3D0EE5E237E06 ON project (name)');
        $this->addSql('COMMENT ON COLUMN project.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN project.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN project.updated_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE developers_projects ADD CONSTRAINT FK_23A8596B64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE developers_projects ADD CONSTRAINT FK_23A8596B166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE developers_projects DROP CONSTRAINT FK_23A8596B64DD9267');
        $this->addSql('ALTER TABLE developers_projects DROP CONSTRAINT FK_23A8596B166D1F9C');

        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE developers_projects');
        $this->addSql('DROP TABLE project');
    }
}
