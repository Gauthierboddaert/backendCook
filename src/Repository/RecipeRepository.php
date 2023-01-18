<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Service\Helper\CriteriaHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository implements RepositoryInterface, RecipeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function save(Recipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Recipe $entity, bool $flush = false): void
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
                    ->setMaxResults($recette)
                    ->orderBy('recette.id','DESC')
                    ->getQuery()
                    ->getResult();
    }


    public function UpdateLike(Recipe $recette, bool $isLiked)
    {
        return $this->createQueryBuilder('recette')
            ->innerJoin('recette.like', 'like')
            ->update()
            ->where('like.recette = :recette')
            ->setParameter(':recette', $recette)
            ->set('like.isLike', $isLiked)
            ->getQuery()
            ->execute();
    }

    public function findTopThreeBestLikedRecipe() : ?array
    {
        return $this->createQueryBuilder('recette')
                ->select('recette, COUNT(l.isLike)')
                ->innerJoin('recette.likes', 'l')
                ->andWhere('l.isLike = true')
                ->groupBy('recette.id')
                ->orderBy('COUNT(l.isLike)', 'DESC')
                ->setMaxResults(3)
                ->getQuery()
                ->getResult();
    }
}
