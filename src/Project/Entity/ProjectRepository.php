<?php

declare(strict_types=1);

namespace App\Project\Entity;

use Doctrine\ORM\EntityManagerInterface;
use DomainException;

final readonly class ProjectRepository
{
    public function __construct(private EntityManagerInterface $em) {}

    public function add(Project $project): void
    {
        $this->em->persist($project);
        $this->em->flush();
    }

    public function remove(Project $project): void
    {
        $this->em->remove($project);
        $this->em->flush();
    }

    public function get(string $id): Project
    {
        $project = $this->em->getRepository(Project::class)->find($id);

        if ($project === null) {
            throw new DomainException('Проект не найден.');
        }

        return $project;
    }

    public function getByName(string $name): Project
    {
        $project = $this->em->getRepository(Project::class)->findOneBy([
            'name' => $name,
        ]);

        if ($project === null) {
            throw new DomainException('Проект не найден.');
        }

        return $project;
    }

    public function hasByName(string $name): bool
    {
        return $this->em->getRepository(Project::class)->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->andWhere('p.name = :name')
            ->setParameter(':name', $name)
            ->getQuery()->getSingleScalarResult() > 0;
    }
}
