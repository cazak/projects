<?php

declare(strict_types=1);

namespace App\Developer\Entity;

use App\Developer\Entity\ValueObject\Email;
use App\Developer\Entity\ValueObject\Name;
use App\Developer\Entity\ValueObject\Phone;
use App\Developer\Entity\ValueObject\Position;
use App\Project\Entity\Project;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
/** @final */
class Developer
{
    #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
    private readonly Uuid $id;

    #[ORM\Embedded]
    private Name $name;

    #[ORM\Embedded]
    private Email $email;

    #[ORM\Embedded]
    private Phone $phone;

    #[ORM\Column]
    private Position $position;

    #[ORM\Column]
    private int $age;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'developers')]
    #[ORM\JoinTable(name: 'developers_projects')]
    private Collection $projects;

    #[ORM\Column(type: 'datetime_immutable')]
    private readonly DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    public function __construct(
        Uuid $id,
        Name $name,
        Email $email,
        Phone $phone,
        Position $position,
        int $age,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->position = $position;
        $this->age = $age;
        $this->projects = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function hireToProject(Project $project): void
    {
        if ($this->projects->contains($project)) {
            throw new DomainException('Разработчик уже нанят на проект.');
        }

        $this->projects->add($project);
    }

    public function fireFromProject(Project $project): void
    {
        if (!$this->projects->contains($project)) {
            throw new DomainException('Разработчик не работает на проекте.');
        }

        $this->projects->removeElement($project);
    }

    public function transferToProject(Project $project): void
    {
        $this->projects->clear();
        $this->projects->add($project);
    }

    public function changePosition(Position $position): void
    {
        if ($this->position === $position) {
            throw new DomainException('Разработчик уже занимает данную позицию.');
        }

        $this->position = $position;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
