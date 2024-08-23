<?php

declare(strict_types=1);

namespace App\Api\Statistics;

use App\Api\ParameterBag;
use App\Project\Query\DevelopersCountByProject\GetDevelopersCountByProject;
use App\Project\Query\DevelopersCountByProject\GetDevelopersCountByProjectQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistics/developers-in-project/{projectId}', methods: ['GET'])]
#[AsController]
final readonly class DevelopersCountByProject
{
    public function __construct(private GetDevelopersCountByProject $developersCountByProject) {}

    public function __invoke(Request $request): JsonResponse
    {
        $payload = new ParameterBag($request->attributes->all());

        $query = new GetDevelopersCountByProjectQuery($payload->getString('projectId'));

        return new JsonResponse(($this->developersCountByProject)($query), Response::HTTP_OK);
    }
}
