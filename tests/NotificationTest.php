<?php

namespace Tests;

use App\Entity\User;
use App\Service\EmailNotificationService;
use App\Service\NotificationService;
use App\Service\SMSNotificationService;
use App\Service\UserService;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    public function testSendNotificationToUserWithDefinedNotificationChannelViaEmail()
    {
        $user = $this->createUser('jan', 'email');

        $userService = $this->createMock(UserService::class);
        $emailNotificationService = $this->createMock(EmailNotificationService::class);
        $smsNotificationService = $this->createMock(SMSNotificationService::class);

        $userService->expects($this->any())
            ->method('getUsersByLogins')
            ->willReturn([
                0 => $user,
            ]);

        $emailNotificationService->expects($this->once())
            ->method('sendNotification');

        $smsNotificationService->expects($this->never())
            ->method('sendNotification');


        $notificationService = new NotificationService($userService, $emailNotificationService, $smsNotificationService);
        $notificationService->sendNotifications('test message', 'jan');
    }

    public function testSendNotificationToUserWithDefinedNotificationChannelviaSMSandEmail()
    {
        $user = $this->createUser('jan', 'sms, email');
        $user2 = $this->createUser('jan2', 'email, sms');
        $user3 = $this->createUser('jan3', 'email,sms');

        $userService = $this->createMock(UserService::class);
        $emailNotificationService = $this->createMock(EmailNotificationService::class);
        $smsNotificationService = $this->createMock(SMSNotificationService::class);

        $userService->expects($this->any())
            ->method('getUsersByLogins')
            ->willReturn([
                0 => $user,
                1 => $user2,
                2 => $user3,
                ]);

        $emailNotificationService->expects($this->exactly(3))
            ->method('sendNotification');

        $smsNotificationService->expects($this->exactly(3))
            ->method('sendNotification');


        $notificationService = new NotificationService($userService, $emailNotificationService, $smsNotificationService);
        $notificationService->sendNotifications('test message', 'jan, jan2, jan3');
    }

    public function testSendNotificationToUserWithNotDefinedNotificationChannel()
    {
        $user = $this->createUser('jan', null);

        $userService = $this->createMock(UserService::class);
        $userService->expects($this->any())
            ->method('getUsersByLogins')
            ->willReturn([
                0 => $user,
                ]);

        $emailNotificationService = $this->createMock(EmailNotificationService::class);
        $emailNotificationService->expects($this->once())
            ->method('sendNotification');

        $smsNotificationService = $this->createMock(SMSNotificationService::class);
        $smsNotificationService->expects($this->never())
            ->method('sendNotification');

        $notificationService = new NotificationService($userService, $emailNotificationService, $smsNotificationService);
        $notificationService->sendNotifications('test message', 'jan');
    }

    public function testSendNotificationToUsersWithDefinedButDifferentNotificationChannel()
    {
        $user1 = $this->createUser('jan', 'sms');
        $user2 = $this->createUser('pablo', 'email');

        $userService = $this->createMock(UserService::class);
        $emailNotificationService = $this->createMock(EmailNotificationService::class);
        $smsNotificationService = $this->createMock(SMSNotificationService::class);

        $userService->expects($this->any())
            ->method('getUsersByLogins')
            ->willReturn([
                0 => $user1,
                1 => $user2,
                ]);

        $emailNotificationService->expects($this->once())
            ->method('sendNotification');

        $smsNotificationService->expects($this->once())
            ->method('sendNotification');

        $notificationService = new NotificationService($userService, $emailNotificationService, $smsNotificationService);
        $notificationService->sendNotifications('test message', 'jan, pablo');
    }

    private function createUser($login, $contactChannels)
    {
        $user = new User();
        $user->setLogin($login);
        $user->setContactChannels($contactChannels);

        return $user;
    }

}
