<?php

declare(strict_types=1);

namespace App\Project\Query\AverageAgeOfDevelopersByProject;

use Doctrine\DBAL\Connection;

final readonly class GetAverageAgeOfDevelopersByProject
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function __invoke(GetAverageAgeOfDevelopersByProjectQuery $query): ?float
    {
        $age = $this->connection->createQueryBuilder()
            ->from('project', 'p')
            ->select('AVG(d.age) AS age')
            ->join('p', 'developers_projects', 'dp', 'dp.project_id = p.id')
            ->join('dp', 'developer', 'd', 'dp.developer_id = d.id')
            ->where('p.id = :id')
            ->setParameter('id', $query->projectId)
            ->executeQuery()
            ->fetchAssociative();

        return \is_array($age) && $age['age'] ? json_decode($age['age'], true) : null;
    }
}
