<?php

namespace App\Command;

use App\Constants\UserRoles;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserRolesCommand extends Command
{
    protected static $defaultName = 'user:roles';
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Setup roles for a user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('Enter the username');
        $user = $this->userRepository->findOneBy(['username' => $username]);
        if (null === $user) {
            return $io->error('User not found.');
        }

        $action = strtolower($io->choice('Would you like to add or remove roles ?', ['Add', 'Remove']));

        $choices = array_filter(UserRoles::ROLES, function(string $role) use ($user, $action) {
            return !in_array($role, $user->getRoles()) === ($action === 'add');
        });

        if (empty($choices)) {
            return $io->text("No roles to $action for this user");
        }

        $question = new ChoiceQuestion("Roles to $action (Enter comma separated values)", array_values($choices));
        $question->setMultiselect(true);

        $roles = $io->askQuestion($question);

        if ($action === 'add') {
            $roles = array_merge($user->getRoles(), $roles);
        } else {
            $roles = array_filter($user->getRoles(), function(string $role) use ($roles) {
                return !in_array($role, $roles);
            });
        }

        $user->setRoles($roles);

        $this->userRepository->saveUser();
        
        return $io->success("Successfully updated roles for user $username");
    }
}
