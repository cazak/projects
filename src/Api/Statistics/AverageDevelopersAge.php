<?php

declare(strict_types=1);

namespace App\Api\Statistics;

use App\Developer\Query\AverageAgeOfDevelopers\GetAverageAgeOfDevelopers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistics/developers-age', methods: ['GET'])]
#[AsController]
final readonly class AverageDevelopersAge
{
    public function __construct(private GetAverageAgeOfDevelopers $ageOfDevelopers) {}

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(($this->ageOfDevelopers)(), Response::HTTP_OK);
    }
}
