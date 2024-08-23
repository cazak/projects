<?php

declare(strict_types=1);

namespace App\Api\Developer;

use App\Api\ParameterBag;
use App\Developer\Command\Create\CreateDeveloper;
use App\Developer\Command\Create\CreateDeveloperCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/developers/create', methods: ['POST'])]
#[AsController]
final readonly class CreateDeveloperAction
{
    public function __construct(
        private CreateDeveloper $createDeveloper,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $payload = ParameterBag::createFromJson($request->getContent());

        $command = new CreateDeveloperCommand(
            $payload->getStringWithoutSpaces('name'),
            $payload->getStringWithoutSpaces('surname'),
            $payload->getStringWithoutSpaces('patronymic'),
            $payload->getStringWithoutSpaces('email'),
            $payload->getStringWithoutSpaces('phone'),
            $payload->getStringWithoutSpaces('position'),
            $payload->getInt('age'),
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');

            return new JsonResponse($json, 400, [], true);
        }

        ($this->createDeveloper)($command);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
