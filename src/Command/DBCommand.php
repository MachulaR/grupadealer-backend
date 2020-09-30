<?php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DBCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:fill-database';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addOption('path','-p',InputOption::VALUE_OPTIONAL,
                'Path to file with data',
                dirname(__FILE__).'/../../db.json')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = file_get_contents($input->getOption('path'), 'r');
        $data = json_decode($data);

        foreach ($data as $element) {
            if ($this->in_array_all(['login','email','contact_channels'], array_keys((array)$element))) {
                $user = new User();
                $user->setLogin($element->login);
                $user->setEmail($element->email);
                $user->setContactChannels($element->contact_channels);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
        }
        return 0;
    }

    private function in_array_all($needles, $haystack) {
        return empty(array_diff($needles, $haystack));
    }
}