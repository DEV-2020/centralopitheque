<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpectacleRepository")
 */
class Spectacle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"default"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"default"})
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Groups({"default"})
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"default"})
     */
    private $places;

    /**
     * @ORM\Column(type="date")
     * @Groups({"default"})
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"default"})
     */
    private $hours;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"default"})
     */
    private $minutes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Shop", mappedBy="spectacles")
     */
    private $shops;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="spectacle")
     */
    private $tickets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SpectaclePlace", mappedBy="spectacle", orphanRemoval=true)
     */
    private $spectaclePlaces;

    public function __construct()
    {
        $this->shops = new ArrayCollection();
        $this->tickets = new ArrayCollection();
        $this->spectaclePlaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHours(): ?int
    {
        return $this->hours;
    }

    public function setHours(int $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getMinutes(): ?int
    {
        return $this->minutes;
    }

    public function setMinutes(int $minutes): self
    {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getShops(): Collection
    {
        return $this->shops;
    }

    public function addShop(Shop $shop): self
    {
        if (!$this->shops->contains($shop)) {
            $this->shops[] = $shop;
            $shop->addSpectacle($this);
        }

        return $this;
    }

    public function removeShop(Shop $shop): self
    {
        if ($this->shops->contains($shop)) {
            $this->shops->removeElement($shop);
            $shop->removeSpectacle($this);
        }

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setSpectacle($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getSpectacle() === $this) {
                $ticket->setSpectacle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SpectaclePlace[]
     */
    public function getSpectaclePlaces(): Collection
    {
        return $this->spectaclePlaces;
    }

    public function addSpectaclePlace(SpectaclePlace $spectaclePlace): self
    {
        if (!$this->spectaclePlaces->contains($spectaclePlace)) {
            $this->spectaclePlaces[] = $spectaclePlace;
            $spectaclePlace->setSpectacle($this);
        }

        return $this;
    }

    public function removeSpectaclePlace(SpectaclePlace $spectaclePlace): self
    {
        if ($this->spectaclePlaces->contains($spectaclePlace)) {
            $this->spectaclePlaces->removeElement($spectaclePlace);
            // set the owning side to null (unless already changed)
            if ($spectaclePlace->getSpectacle() === $this) {
                $spectaclePlace->setSpectacle(null);
            }
        }

        return $this;
    }
}
