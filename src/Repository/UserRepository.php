<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function search($page = 1, $limit = 10, $value = null)
    {
        $queryBuilder = $this->createQueryBuilder('u');

        if (isset($value) && $value !== '') {
            $queryBuilder = $queryBuilder->andWhere('u.login LIKE :user')->setParameter('user', '%' . $value . '%');
        }

        $paginator = new Paginator($queryBuilder, $limit ?? 10);
        return $paginator->paginate($page ?? 1);
    }
}
