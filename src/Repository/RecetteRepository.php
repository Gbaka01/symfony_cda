<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recette>
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

    //    /**
    //     * @return Recette[] Returns an array of Recette objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recette
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

// À COPIER dans votre classe App\Repository\RecetteRepository existante.
// La relation Recette::notes est confirmée.
// SEUL POINT À VÉRIFIER : 'n.note' doit être le nom du champ de l'entité Note
// qui contient la valeur de 1 à 5 (remplacez-le s'il s'appelle autrement, ex. 'n.valeur').

    /**
     * Les N dernières recettes publiées.
     * Si vous avez un champ createdAt, triez plutôt dessus.
     */
    public function findDernieres(int $limite = 6): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'DESC')
            ->setMaxResults($limite)
            ->getQuery()
            ->getResult();
    }

    /**
     * Les N recettes les mieux notées, avec leur note moyenne et leur nombre d'avis.
     * Retourne un tableau de lignes : ['recette' => Recette, 'moyenne' => float, 'nbAvis' => int]
     */
    public function findMieuxNotees(int $limite = 6): array
    {
        $lignes = $this->createQueryBuilder('r')
            ->select('r AS recette, AVG(n.note) AS moyenne, COUNT(n.id) AS nbAvis')
            ->innerJoin('r.notes', 'n')
            ->groupBy('r.id')
            ->orderBy('moyenne', 'DESC')
            ->addOrderBy('nbAvis', 'DESC')
            ->setMaxResults($limite)
            ->getQuery()
            ->getResult();

        return array_map(fn (array $l) => [
            'recette' => $l['recette'],
            'moyenne' => round((float) $l['moyenne'], 1),
            'nbAvis'  => (int) $l['nbAvis'],
        ], $lignes);
    }

public function searchOneRecette(string $mot): ?Recette
{
    return $this->createQueryBuilder('r')
        ->andWhere('r.fiche LIKE :mot')
        ->setParameter('mot', '%' . $mot . '%')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

}
}
