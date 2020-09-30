<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact_channels;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContactChannels(): ?string
    {
        return $this->contact_channels;
    }

    public function getContactChannelsAsArray(): ?array
    {
        $contactForm = [];
        if($this->contact_channels) {
            $contactChannels = explode(',', $this->contact_channels);
            foreach ($contactChannels as $key => $contact) {
                $contactForm[trim($contact)] = true;
            }
        }

        return $contactForm;
    }

    public function setContactChannels(?string $contact_channels): self
    {
        $this->contact_channels = $contact_channels;

        return $this;
    }
}
