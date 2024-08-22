<?php

declare(strict_types=1);

namespace App\Developer\Command\Create;

use App\Developer\Entity\Developer;
use App\Developer\Entity\DeveloperRepository;
use App\Developer\Entity\ValueObject\Email;
use App\Developer\Entity\ValueObject\Name;
use App\Developer\Entity\ValueObject\Phone;
use App\Developer\Entity\ValueObject\Position;
use Exception;
use Symfony\Component\Uid\UuidV7;

final readonly class CreateDeveloper
{
    public function __construct(
        private DeveloperRepository $repository,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(CreateDeveloperCommand $command): void
    {
        if ($this->repository->hasByEmail($command->email)) {
            throw new Exception('Разработчик с такой почтой "'.$command->email.'" уже существует.');
        }

        $developer = new Developer(
            new UuidV7(),
            new Name(
                $command->name,
                $command->surname,
                $command->patronymic,
            ),
            new Email($command->email),
            new Phone($command->phone),
            Position::from($command->position),
        );

        $this->repository->add($developer);
    }
}
