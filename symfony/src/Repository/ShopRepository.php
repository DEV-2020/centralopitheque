<?php

namespace App\Repository;

use App\Entity\Shop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method Shop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shop[]    findAll()
 * @method Shop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopRepository extends ServiceEntityRepository
{
    private $passwordEncoder;

    public function __construct(
        ManagerRegistry $registry,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        parent::__construct($registry, Shop::class);
        $this->passwordEncoder = $passwordEncoder;
    }

    public function register(Shop $shop): Shop
    {
        $em = $this->getEntityManager();
        $shop->setPassword($this->passwordEncoder->encodePassword($shop, $shop->getPassword()));
        $em->persist($shop);
        $em->flush();
        return $shop;
    }

    // public function authenticate(User $user): User
    // {
    //     $opts = [
    //         'http' => [
    //             'method' => 'POST',
    //             'header' => 'Content-type: application/json',
    //             'content' => \json_encode([
    //                 'username' => $user->getEmail(),
    //                 'password' => $user->getPassword(),
    //             ]),
    //         ],
    //     ];
    //     $context = stream_context_create($opts);
    //     $host = $this->parameterBag->get('env_host').'/api/login_check';
    //     $response = file_get_contents($host, false, $context);
    //     $data = \json_decode($response, true);
    //     $user = $this->userRepository->findOneBy(['email' => $user->getEmail()]);
    //     $user
    //         ->setRefreshToken($data['refresh_token'])
    //         ->setToken($data['token']);
    //     return $user;
    // }
}
