<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class SMSNotification
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function sendMessage(string $message): void
    {
        file_put_contents('sms.txt', $message);
    }
}