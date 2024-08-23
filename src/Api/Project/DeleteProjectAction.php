<?php

declare(strict_types=1);

namespace App\Api\Project;

use App\Api\ParameterBag;
use App\Project\Command\Delete\DeleteProject;
use App\Project\Command\Delete\DeleteProjectCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/projects/delete/{projectId}', methods: ['DELETE'])]
#[AsController]
final readonly class DeleteProjectAction
{
    public function __construct(
        private DeleteProject $deleteProject,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $attribute = new ParameterBag($request->attributes->all());

        $command = new DeleteProjectCommand(
            $attribute->getString('projectId'),
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');

            return new JsonResponse($json, 400, [], true);
        }

        ($this->deleteProject)($command);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
