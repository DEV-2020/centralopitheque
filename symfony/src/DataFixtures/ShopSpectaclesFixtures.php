<?php

namespace App\DataFixtures;

use App\Repository\ShopRepository;
use App\Repository\SpectacleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ShopSpectaclesFixtures extends Fixture implements DependentFixtureInterface
{
    private $shopRepository;
    private $spectacleRepository;

    public function __construct(
        ShopRepository $shopRepository,
        SpectacleRepository $spectacleRepository
    )
    {
        
        $this->shopRepository = $shopRepository;
        $this->spectacleRepository = $spectacleRepository;
    }

    public function load(ObjectManager $manager)
    {
        $shop = $this->shopRepository->findOneBy(['name' => 'Fnac']);
        $spectacles = $this->spectacleRepository->findAll();
        shuffle($spectacles);
        $spectacles = array_slice($spectacles, 0, random_int(1, 3));

        foreach ($spectacles as $spectacle) {
            $shop->addSpectacle($spectacle);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            SpectacleFixtures::class,
        ];
    }
}
