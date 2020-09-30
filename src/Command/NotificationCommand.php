<?php
namespace App\Command;

use App\Entity\User;
use App\Exception\UserNotExistException;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NotificationCommand extends Command
{
    protected static $defaultName = 'app:send-notification';
    private $entityManager;
    private $notificationService;

    public function __construct(EntityManagerInterface $entityManager, NotificationService $notificationService)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->notificationService = $notificationService;
    }

    protected function configure()
    {
        $this
            ->addOption('message','-m',InputOption::VALUE_REQUIRED,
                'Message that will be sent to user')
            ->addOption('logins','-u',InputOption::VALUE_REQUIRED,
                'user login which on has to receive message')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $input->getOption('message');
        $logins = $input->getOption('logins');

        try {
            $this->notificationService->sendNotifications($message, $logins);
        } catch (\Error $error) {
            $output->writeln('ERROR! Something went wrong. Notifications cannot be send. Aborting!');
            return Command::FAILURE;
        } catch (UserNotExistException $exception) {
            $output->writeln($exception->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }


}