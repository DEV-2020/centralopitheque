<?php

namespace App\Repository;

use App\Entity\SpectaclePlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpectaclePlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpectaclePlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpectaclePlace[]    findAll()
 * @method SpectaclePlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpectaclePlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpectaclePlace::class);
    }
}
