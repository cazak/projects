<?php

declare(strict_types=1);

namespace App\Developer\Query\DevelopersCount;

use Doctrine\DBAL\Connection;

final readonly class GetDevelopersCount
{
    public function __construct(private Connection $connection) {}

    public function __invoke(): int
    {
        return $this->connection->createQueryBuilder()
            ->from('developer', 'd')
            ->select('COUNT(d.id)')
            ->fetchOne();
    }
}
