<?php

declare(strict_types=1);

namespace App\Api\Developer;

use App\Api\ParameterBag;
use App\Developer\Command\TransferToProject\TransferToProject;
use App\Developer\Command\TransferToProject\TransferToProjectCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/developers/transfer-to-project/{developerId}', methods: ['PUT'])]
#[AsController]
final readonly class TransferToProjectAction
{
    public function __construct(
        private TransferToProject $transferToProject,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $attribute = new ParameterBag($request->attributes->all());
        $payload = new ParameterBag($request->getPayload()->all());

        $command = new TransferToProjectCommand(
            $attribute->getString('developerId'),
            $payload->getString('project_name'),
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');

            return new JsonResponse($json, 400, [], true);
        }

        ($this->transferToProject)($command);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
