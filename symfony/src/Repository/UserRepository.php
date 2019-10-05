<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $passwordEncoder;

    public function __construct(
        ManagerRegistry $registry,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        parent::__construct($registry, User::class);
        $this->passwordEncoder = $passwordEncoder;
    }

    public function register(User $user): User
    {
        $em = $this->getEntityManager();
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $em->persist($user);
        $em->flush();

        return $user;
    }
}
