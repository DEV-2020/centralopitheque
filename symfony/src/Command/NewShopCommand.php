<?php

namespace App\Command;

use App\Entity\Shop;
use App\Repository\ShopRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NewShopCommand extends Command
{
    protected static $defaultName = 'new:shop';
    private $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        parent::__construct();
        $this->shopRepository = $shopRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $shopName = $io->ask('Shop display name');
        $shopUsername = $io->ask('Shop username');
        $shopEmail = $io->ask('Shop email');

        $password = $io->askHidden('Shop password');

        $passwordConfirm = $io->askHidden('Confirm password');

        if ($password !== $passwordConfirm) {
            return $io->error('Passwords do not match');
        }

        $shop = (new Shop)
            ->setUsername($shopUsername)
            ->setDisplayName($shopName)
            ->setEmail($shopEmail)
            ->setPassword($password);

        $shop = $this->shopRepository->register($shop);

        $io->success(sprintf('The user "%s" was created.', $shop->getUsername()));
    }
}
