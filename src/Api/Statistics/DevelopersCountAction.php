<?php

declare(strict_types=1);

namespace App\Api\Statistics;

use App\Api\ParameterBag;
use App\Developer\Query\DevelopersCount\GetDevelopersCount;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistics/developers-count', methods: ['GET'])]
#[AsController]
final readonly class DevelopersCountAction
{
    public function __construct(private GetDevelopersCount $developersCount) {}

    public function __invoke(Request $request): JsonResponse
    {
        $payload = new ParameterBag($request->attributes->all());

        return new JsonResponse(($this->developersCount)(), Response::HTTP_OK);
    }
}
