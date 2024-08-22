<?php

declare(strict_types=1);

namespace App\Project\Command\Create;

use App\Project\Entity\Project;
use App\Project\Entity\ProjectRepository;
use Exception;
use Symfony\Component\Uid\UuidV7;

final readonly class CreateProject
{
    public function __construct(
        private ProjectRepository $repository,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(CreateProjectCommand $command): void
    {
        if ($this->repository->hasByName($command->name)) {
            throw new Exception('Проект с таким именем "'.$command->name.'" уже существует.');
        }

        $project = new Project(
            new UuidV7(),
            $command->name,
            $command->clientName,
        );

        $this->repository->add($project);
    }
}
