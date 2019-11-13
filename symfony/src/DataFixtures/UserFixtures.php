<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    const USER = [
        'username' => 'admin',
        'password' => 'password',
        'email' => 'user@centrale.local',
    ];

    const SHOP = [
        'username' => 'fnac',
        'password' => 'fnac',
        'email' => 'fnac@fnac.com',
        'shop' => 'Fnac',
    ];

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {
        $admin = (new User())
            ->setUsername(self::USER['username'])
            ->setPassword(self::USER['password'])
            ->setEmail(self::USER['email'])
            ->setRoles(['ROLE_ADMIN']);

        $this->userRepository->register($admin);

        $shop = (new User())
            ->setUsername(self::SHOP['username'])
            ->setPassword(self::SHOP['password'])
            ->setEmail(self::SHOP['email'])
            ->setShop((new Shop())->setName(self::SHOP['shop']));

        $this->userRepository->register($shop);
    }
}
