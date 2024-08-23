<?php

declare(strict_types=1);

namespace App\Api\Statistics;

use App\Project\Query\ProjectsCount\GetProjectsCount;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistics/projects-count', methods: ['GET'])]
#[AsController]
final readonly class ProjectsCountAction
{
    public function __construct(private GetProjectsCount $projectsCount) {}

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(($this->projectsCount)(), Response::HTTP_OK);
    }
}
