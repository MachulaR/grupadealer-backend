<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\UserNotExistException;
use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    private $emailNotificationService;
    private $smsNotificationService;
    private $userService;

    public function __construct(UserService $userService,
                                EmailNotificationService $emailNotificationService, SMSNotificationService $smsNotificationService)
    {
        $this->emailNotificationService = $emailNotificationService;
        $this->smsNotificationService = $smsNotificationService;
        $this->userService = $userService;
    }

    public function sendNotifications(string $message, string $logins)
    {
        $logins = array_map('trim', explode(',', $logins));

        /** @var User[] $users */
        $users = $this->userService->getUsersByLogins($logins);

        foreach ($users as $user){
            $contactChannels = $user->getContactChannelsAsArray();
            if (!$contactChannels) {
                $this->emailNotificationService->sendNotification($message, $user);
            }
            if (key_exists('email', $contactChannels) && $contactChannels['email']) {
                $this->emailNotificationService->sendNotification($message, $user);
            }
            if (key_exists('sms', $contactChannels) && $contactChannels['sms']) {
                $this->smsNotificationService->sendNotification($message, $user);
            }
        }
    }
}
