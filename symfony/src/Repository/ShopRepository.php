<?php

namespace App\Repository;

use App\Entity\Shop;
use App\Entity\Spectacle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Shop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shop[]    findAll()
 * @method Shop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shop::class);
    }

    /**
     * @param Spectacle[] $spectacles
     * @return Spectacle[]
     */
    public function updateSpectacles(Shop $shop, array $spectacles): Shop {
        foreach ($spectacles as $spectacle) {
            $shop->addSpectacle($spectacle);
        }

        $ids = array_map(function (Spectacle $spectacle) {
            return $spectacle->getId();
        }, $spectacles);

        foreach ($shop->getSpectacles()->toArray() as $spectacle) {
            if (!in_array($spectacle->getId(), $ids)) {
                $shop->removeSpectacle($spectacle);
            }
        }

        $this->_em->flush($shop);

        return $shop;
    }
}
