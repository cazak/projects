<?php

declare(strict_types=1);

namespace App\Api\Statistics;

use App\Api\ParameterBag;
use App\Project\Query\AverageAgeOfDevelopersByProject\GetAverageAgeOfDevelopersByProject;
use App\Project\Query\AverageAgeOfDevelopersByProject\GetAverageAgeOfDevelopersByProjectQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistics/developers-age-in-project/{projectId}', methods: ['GET'])]
#[AsController]
final readonly class AverageDevelopersAgeByProject
{
    public function __construct(private GetAverageAgeOfDevelopersByProject $ageOfDevelopersByProject) {}

    public function __invoke(Request $request): JsonResponse
    {
        $payload = new ParameterBag($request->attributes->all());

        $query = new GetAverageAgeOfDevelopersByProjectQuery($payload->getString('projectId'));

        return new JsonResponse(($this->ageOfDevelopersByProject)($query), Response::HTTP_OK);
    }
}
