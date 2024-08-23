<?php

declare(strict_types=1);

namespace App\Developer\Query\AverageAgeOfDevelopers;

use Doctrine\DBAL\Connection;

final readonly class GetAverageAgeOfDevelopers
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function __invoke(): ?float
    {
        $age = $this->connection->createQueryBuilder()
            ->from('developer', 'd')
            ->select('AVG(d.age) AS age')
            ->executeQuery()
            ->fetchAssociative();

        return \is_array($age) && $age['age'] ? json_decode($age['age'], true) : null;
    }
}
