<?php

declare(strict_types=1);

namespace App\Developer\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final readonly class Name
{
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $surname;

    #[ORM\Column(type: 'string', length: 255)]
    private string $patronymic;

    public function __construct(string $name, string $surname, string $patronymic)
    {
        Assert::notEmpty($name);
        Assert::notEmpty($surname);
        Assert::notEmpty($patronymic);

        $this->name = $name;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
    }

    public function isEqual(self $other): bool
    {
        return $this->getName() === $other->getName()
            && $this->getSurname() === $other->getSurname()
            && $this->getPatronymic() === $other->getPatronymic();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    public function getFullName(): string
    {
        return $this->name.' '.$this->surname.' '.$this->patronymic;
    }
}
