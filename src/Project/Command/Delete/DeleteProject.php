<?php

declare(strict_types=1);

namespace App\Project\Command\Delete;

use App\Project\Entity\ProjectRepository;
use Exception;

final readonly class DeleteProject
{
    public function __construct(
        private ProjectRepository $repository,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(DeleteProjectCommand $command): void
    {
        $project = $this->repository->get($command->projectId);

        $this->repository->remove($project);
    }
}
