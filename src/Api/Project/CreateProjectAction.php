<?php

declare(strict_types=1);

namespace App\Api\Project;

use App\Api\ParameterBag;
use App\Project\Command\Create\CreateProject;
use App\Project\Command\Create\CreateProjectCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/projects/create', methods: ['POST'])]
#[AsController]
final readonly class CreateProjectAction
{
    public function __construct(
        private CreateProject $createProject,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $payload = ParameterBag::createFromJson($request->getContent());

        $command = new CreateProjectCommand(
            $payload->getString('name'),
            $payload->getString('client_name'),
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');

            return new JsonResponse($json, 400, [], true);
        }

        ($this->createProject)($command);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
