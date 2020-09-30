<?php

namespace App\Service;

use App\Entity\User;

Interface NotificationInterface
{
    public function sendNotification($message, User $user);
}
