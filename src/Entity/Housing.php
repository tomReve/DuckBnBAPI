<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HousingRepository")
 */
class Housing
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbTravelerMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbRoom;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbBed;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getNbTravelerMax(): ?int
    {
        return $this->nbTravelerMax;
    }

    public function setNbTravelerMax(int $nbTravelerMax): self
    {
        $this->nbTravelerMax = $nbTravelerMax;

        return $this;
    }

    public function getNbRoom(): ?int
    {
        return $this->nbRoom;
    }

    public function setNbRoom(int $nbRoom): self
    {
        $this->nbRoom = $nbRoom;

        return $this;
    }

    public function getNbBed(): ?int
    {
        return $this->nbBed;
    }

    public function setNbBed(int $nbBed): self
    {
        $this->nbBed = $nbBed;

        return $this;
    }

    public function getCreationAt(): ?\DateTimeInterface
    {
        return $this->creationAt;
    }

    public function setCreationAt(\DateTimeInterface $creationAt): self
    {
        $this->creationAt = $creationAt;

        return $this;
    }
}
