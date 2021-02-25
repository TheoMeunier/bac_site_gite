<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity=ImageBlog::class, mappedBy="image", cascade={"persist"})
     */
    private $imageBlogs;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->imageBlogs = new ArrayCollection();
    }

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

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Collection|ImageBlog[]
     */
    public function getImageBlogs(): Collection
    {
        return $this->imageBlogs;
    }

    public function getImageBlog(): ?ImageBlog
    {
        if ($this->imageBlogs->isEmpty()) {
            return null;
        }
        return $this->imageBlogs->first();
    }

    public function addImageBlog(ImageBlog $imageBlog): self
    {
        if (!$this->imageBlogs->contains($imageBlog)) {
            $this->imageBlogs[] = $imageBlog;
            $imageBlog->setImage($this);
        }

        return $this;
    }

    public function removeImageBlog(ImageBlog $imageBlog): self
    {
        if ($this->imageBlogs->removeElement($imageBlog)) {
            // set the owning side to null (unless already changed)
            if ($imageBlog->getImage() === $this) {
                $imageBlog->setImage(null);
            }
        }

        return $this;
    }
}
