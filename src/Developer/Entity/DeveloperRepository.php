<?php

declare(strict_types=1);

namespace App\Developer\Entity;

use Doctrine\ORM\EntityManagerInterface;
use DomainException;

final readonly class DeveloperRepository
{
    public function __construct(private EntityManagerInterface $em) {}

    public function add(Developer $developer): void
    {
        $this->em->persist($developer);
        $this->em->flush();
    }

    public function remove(Developer $developer): void
    {
        $this->em->remove($developer);
        $this->em->flush();
    }

    public function get(string $id): Developer
    {
        $developer = $this->em->getRepository(Developer::class)->find($id);

        if ($developer === null) {
            throw new DomainException('Разработчик не найден.');
        }

        return $developer;
    }

    public function hasByEmail(string $email): bool
    {
        return $this->em->getRepository(Developer::class)->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->andWhere('d.email.value = :email')
            ->setParameter(':email', $email)
            ->getQuery()->getSingleScalarResult() > 0;
    }
}
