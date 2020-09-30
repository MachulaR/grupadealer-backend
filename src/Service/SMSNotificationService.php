<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class SMSNotificationService implements NotificationInterface
{
    private $em;
    private $smsNotification;

    public function __construct(EntityManagerInterface $entityManager, SMSNotification $smsNotification)
    {
        $this->em = $entityManager;
        $this->smsNotification = $smsNotification;
    }

    public function sendNotification($message, User $user)
    {
        $this->smsNotification->sendMessage($message);
    }
}
