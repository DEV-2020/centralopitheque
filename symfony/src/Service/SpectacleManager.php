<?php

namespace App\Service;

use App\Entity\Spectacle;
use App\Entity\SpectaclePlace;
use Doctrine\Common\Persistence\ObjectManager;

class SpectacleManager
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function createSpectacle(Spectacle $spectacle): Spectacle
    {
        for ($i = 1; $i <= $spectacle->getPlaces(); $i += 1) {
            $place = (new SpectaclePlace())
                ->setSpectacle($spectacle)
                ->setSeat($i);
            $spectacle->addSpectaclePlace($place);
            $this->em->persist($place);
        }
        $this->em->persist($spectacle);
        $this->em->flush();

        return $spectacle;
    }
}
