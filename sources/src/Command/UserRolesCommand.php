<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserRolesCommand extends Command
{
    /**
     * ContainerInterface.
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:user:roles';

    protected function configure(): void
    {
        $this
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'user email'
            )
            ->addOption(
                'addRoles',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'role to add'
            )
            ->addOption(
                'removeRoles',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'role to remove'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('User roles managment');

        $userRepository = $this->container->get('doctrine')->getRepository(User::class);
        $userEmail = $input->getArgument('email');

        $user = $userRepository->findOneByEmail($userEmail);

        if (null == $user) {
            $io->error('User not found');

            return Command::FAILURE;
        }
        $saveUser = false;
        $userRoles = $user->getRoles();

        $io->section('Current User roles for '.$userEmail);
        $table = new Table($output);
        $table
            ->setHeaders(['role']);
        foreach ($userRoles as $role) {
            $table->addRow([$role]);
        }
        $table->render();

        if (!empty($input->getOption('removeRoles'))) {
            $table = new Table($output);
            $io->section('Removes Roles');
            $table
                ->setHeaders(['role', 'status']);
            foreach ($input->getOption('removeRoles') as $role) {
                $status = 'Not found';
                if (($key = array_search($role, $userRoles)) !== false) {
                    unset($userRoles[$key]);
                    $status = 'Removed';
                    $saveUser = true;
                }
                $table->addRow([$role, $status]);
            }
            $table->render();
        }

        if (!empty($input->getOption('addRoles'))) {
            $table = new Table($output);
            $io->section('Add Roles');
            $table
                ->setHeaders(['role', 'status']);
            foreach ($input->getOption('addRoles') as $role) {
                $status = 'Exist';
                if (!in_array($role, $userRoles)) {
                    $userRoles[] = $role;
                    $status = 'Added';
                    $saveUser = true;
                }
                $table->addRow([$role, $status]);
            }
            $table->render();
        }

        $io->section('Result roles for '.$userEmail);

        $table = new Table($output);
        $table
            ->setHeaders(['role']);
        foreach ($userRoles as $role) {
            $table->addRow([$role]);
        }
        $table->render();

        $io->section('Save all roles for '.$userEmail);
        if ($saveUser) {
            $user->setRoles($userRoles);
            $this->container->get('doctrine')->getManager()->persist($user);
            $this->container->get('doctrine')->getManager()->flush();
            $io->text('Saved');
        } else {
            $io->text('No change, not saved');
        }

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
