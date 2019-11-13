<?php

namespace App\DataFixtures;

use App\Entity\Spectacle;
use App\Service\SpectacleManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SpectacleFixtures extends Fixture implements DependentFixtureInterface
{
    const PLACES = 30;
    const SPECTACLES = [
        [
            'name' => 'Flume',
            'price' => 46,
            'date' => '2020-02-23',
            'hours' => 20,
            'minutes' => 0,
        ],
        [
            'name' => 'DROELOE',
            'price' => 31.5,
            'date' => '2020-04-12',
            'hours' => 22,
            'minutes' => 15,
        ],
        [
            'name' => 'Nekfeu',
            'price' => 95,
            'date' => '2020-05-16',
            'hours' => 21,
            'minutes' => 30,
        ],
        [
            'name' => 'Orelsan',
            'price' => 70,
            'date' => '2020-03-20',
            'hours' => 21,
            'minutes' => 0,
        ],
        [
            'name' => 'Bakermat',
            'price' => 38.80,
            'date' => '2020-05-02',
            'hours' => 20,
            'minutes' => 0,
        ],
    ];

    private $spectacleManager;

    public function __construct(SpectacleManager $spectacleManager)
    {
        $this->spectacleManager = $spectacleManager;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::SPECTACLES as $entry) {
            $spectacle = (new Spectacle())
                ->setName($entry['name'])
                ->setPrice($entry['price'])
                ->setDate(new \DateTime($entry['date']))
                ->setHours($entry['hours'])
                ->setMinutes($entry['minutes'])
                ->setPlaces(self::PLACES);

            $this->spectacleManager->createSpectacle($spectacle);
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
