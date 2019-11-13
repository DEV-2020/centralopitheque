<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpectaclePlaceRepository")
 */
class SpectaclePlace
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spectacle", inversedBy="spectaclePlaces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spectacle;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ticket", inversedBy="place", cascade={"persist", "remove"})
     */
    private $ticket;

    /**
     * @ORM\Column(type="integer")
     */
    private $seat;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getSeat(): ?int
    {
        return $this->seat;
    }

    public function setSeat(int $seat): self
    {
        $this->seat = $seat;

        return $this;
    }
}
