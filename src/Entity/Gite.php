<?php

namespace App\Entity;

use App\Repository\GiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @ORM\Entity(repositoryClass=GiteRepository::class)
 */
class Gite
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surface;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chambres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $personnes;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity=ImageGite::class, mappedBy="gite", orphanRemoval=true, cascade={"persist"})
     */
    private $imageGites;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->imageGites = new ArrayCollection();
    }

    public function getSlug(): \Symfony\Component\String\AbstractUnicodeString
    {
        return (new AsciiSlugger())->slug($this->getName());

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getChambres(): ?string
    {
        return $this->chambres;
    }

    public function setChambres(string $chambres): self
    {
        $this->chambres = $chambres;

        return $this;
    }

    public function getPersonnes(): ?string
    {
        return $this->personnes;
    }

    public function setPersonnes(string $personnes): self
    {
        $this->personnes = $personnes;

        return $this;
    }

    /**
     * @return Collection|ImageGite[]
     */
    public function getImageGites(): Collection
    {
        return $this->imageGites;
    }

    public function getImageGite(): ?ImageGite
    {
        if ($this->imageGites->isEmpty()) {
            return null;
        }
        return $this->imageGites->first();
    }

    public function addImageGite(ImageGite $imageGite): self
    {
        if (!$this->imageGites->contains($imageGite)) {
            $this->imageGites[] = $imageGite;
            $imageGite->setGite($this);
        }

        return $this;
    }

    public function removeImageGite(ImageGite $imageGite): self
    {
        if ($this->imageGites->removeElement($imageGite)) {
            // set the owning side to null (unless already changed)
            if ($imageGite->getGite() === $this) {
                $imageGite->setGite(null);
            }
        }

        return $this;
    }
}
