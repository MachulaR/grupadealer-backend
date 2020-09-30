<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class EmailNotificationService implements NotificationInterface
{
    private $mailer;
    private $em;

    public function __construct(\Swift_Mailer $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->em = $entityManager;
    }


    public function sendNotification($message, User $user)
    {
        $from = '';
        $to = $user->getEmail();
        $subject = 'Zadanie Rekrutacyjne Grupa Dealer';

        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                $message,
                'text/html'
            );
        $this->mailer->send($message);
    }
}
