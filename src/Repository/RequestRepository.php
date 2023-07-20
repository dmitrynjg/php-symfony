<?php

namespace App\Repository;

use App\Entity\Request;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @extends ServiceEntityRepository<Request>
 *
 * @method Request|null find($id, $lockMode = null, $lockVersion = null)
 * @method Request|null findOneBy(array $criteria, array $orderBy = null)
 * @method Request[]    findAll()
 * @method Request[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class RequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Request::class);
    }

    public function search($page = 1)
    {
        $queryBuilder = $this->createQueryBuilder('r')->Select('r.id, r.text, u.id userId, u.name, u.surname, u.fatherName, u.login, u.email')->join('r.user', 'u')->orderBy('r.id', 'DESC');
        $paginator = new Paginator($queryBuilder, 3);
        return $paginator->paginate($page ?? 1);
    }

    public function create(User $user, $text, EntityManagerInterface $entityManager): void
    {
        $request = new Request();
        $request->setUser($user);
        $request->setText($text);
        $entityManager->persist($request);
        $entityManager->flush();
    }
}
