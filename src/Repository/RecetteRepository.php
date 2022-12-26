<?php

namespace App\Repository;

use App\Entity\Recette;
use App\Service\Helper\CriteriaHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recette>
 *
 * @method Recette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recette[]    findAll()
 * @method Recette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

    public function save(Recette $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Recette $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findThreeLastRecette() :  ?array
    {
        return $this->createQueryBuilder('recette')
                    ->orderBy('recette.id', 'DESC')
                    ->setMaxResults(3)
                    ->getQuery()
                    ->getResult();
    }

    public function findFavoriesByUser() : ?array
    {
        return $this->createQueryBuilder('recette')
                    ->getQuery()
                    ->getResult();
    }

    public function filterByRecette(string $name) : ?array
    {
        return $this->createQueryBuilder('recette')
                    ->addCriteria(CriteriaHelper::createFilterByRecetteName($name))
                    ->getQuery()
                    ->getResult();
    }

    public function findTenLastObject(int $recette = 10) : ? array
    {
        return $this->createQueryBuilder('recette')
                    ->setMaxResults(':max')
                    ->setParameter('max', $recette)
                    ->orderBy('recette.id','DESC')
                    ->getQuery()
                    ->getResult();
    }

}
