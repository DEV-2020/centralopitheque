<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spectacle", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spectacle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Shop", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shop;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\SpectaclePlace", mappedBy="ticket", cascade={"persist", "remove"})
     */
    private $place;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getSpectacle(): ?Spectacle
    {
        return $this->spectacle;
    }

    public function setSpectacle(?Spectacle $spectacle): self
    {
        $this->spectacle = $spectacle;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getPlace(): ?SpectaclePlace
    {
        return $this->place;
    }

    public function setPlace(?SpectaclePlace $place): self
    {
        $this->place = $place;

        // set (or unset) the owning side of the relation if necessary
        $newTicket = $place === null ? null : $this;
        if ($newTicket !== $place->getTicket()) {
            $place->setTicket($newTicket);
        }

        return $this;
    }
}
