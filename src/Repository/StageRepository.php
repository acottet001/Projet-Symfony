<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    public function findByEntrepriseQB($nomEntreprise)
    {
        return $this->createQueryBuilder('s')
                    ->join('s.entreprise','e')
                    ->where('e.nom = :nomEntreprise')
                    ->setParameter('nomEntreprise',$nomEntreprise)
                    ->getQuery()
                    ->getResult();
    }

    public function findByFormationDQL($nomCourtFormation)
    {
        $gestionnaireEntite = $this->getEntityManager();

        $requete = $gestionnaireEntite->createQuery(
                                "SELECT s,f 
                                FROM App\Entity\Stage s 
                                JOIN s.formation f
                                WHERE f.nomCourt = :nomCourt");

        $requete->setParameter('nomCourt',$nomCourtFormation);

        return $requete->execute();
    }


    public function recupererStageAvecSonEntrepriseQB()
    {
        $gestionnaireEntite = $this->getEntityManager();

        return $this->createQueryBuilder('s')
                    ->join('s.entreprise','e')
                    ->select('s,e')
                    ->getQuery()
                    ->getResult();
        return $requete->execute();
    }
    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
