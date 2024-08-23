<?php

declare(strict_types=1);

namespace App\Project\Query\ProjectsCount;

use Doctrine\DBAL\Connection;

final readonly class GetProjectsCount
{
    public function __construct(private Connection $connection) {}

    public function __invoke(): int
    {
        return $this->connection->createQueryBuilder()
            ->from('project', 'p')
            ->select('COUNT(p.id)')
            ->fetchOne();
    }
}
