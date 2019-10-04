<?php

namespace App\Command;

use App\Entity\Shop;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NewShopCommand extends Command
{
    protected static $defaultName = 'new:shop';

    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, ObjectManager $em)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a shop and links it to a user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('Account username the shop will be attached to');

        $user = $this->userRepository->findOneBy(['username' => $username]);

        if (null === $user) {
            return $io->error('User not found.');
        }

        $shopName = $io->ask('Shop name');
        $user->setShop((new Shop())->setName($shopName));

        $this->em->flush();
    }
}
