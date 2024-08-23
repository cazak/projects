<?php

declare(strict_types=1);

namespace App\Project\Query\DevelopersCountByProject;

use App\Project\Entity\ProjectRepository;

final readonly class GetDevelopersCountByProject
{
    public function __construct(private ProjectRepository $repository) {}

    public function __invoke(GetDevelopersCountByProjectQuery $query): int
    {
        $project = $this->repository->get($query->projectId);

        return $project->getDevelopers()->count();
    }
}
