<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NewUserCommand extends Command
{
    protected static $defaultName = 'new:user';
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a user from CLI')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('Username');
        $email = $io->ask('Email');

        $password = $io->askHidden('Password');

        $passwordConfirm = $io->askHidden('Confirm password');

        if ($password !== $passwordConfirm) {
            return $io->error('Passwords do not match');
        }

        $user = (new User)
            ->setUsername($username)
            ->setEmail($email)
            ->setPassword($password);

        $user = $this->userRepository->register($user);

        $io->success(sprintf('The user "%s" was created.', $user->getUsername()));
    }
}
