<?php

namespace App\Entity;


class Notification
{
    protected $message;
    protected $logins;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getLogins()
    {
        return $this->logins;
    }

    /**
     * @param mixed $logins
     */
    public function setLogins($logins): void
    {
        $this->logins = $logins;
    }
}
