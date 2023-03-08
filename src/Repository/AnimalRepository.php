<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Animal>
 *
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function save(Animal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Animal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function searchByNameAndBreed(string $nom, string $race)
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->where('a.nom = :nom')
            ->andWhere('a.race = :race')
            ->setParameter('nom', $nom)
            ->setParameter('race', $race);
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
    public function chartRepository()
    {
        $qb = $this->createQueryBuilder('r');

        $qb->select('r.race, COUNT(r.id) as count')
            ->groupBy('r.race');

        return $qb->getQuery()->getResult();
    }

    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT r
                FROM App\Entity\Animal r
                WHERE (r.race LIKE :str) OR (r.nom LIKE :str)'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

//    /**
//     * @return Animal[] Returns an array of Animal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Animal
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }








}
