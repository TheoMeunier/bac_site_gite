<?php

namespace App\Entity;

use App\Repository\ImageBlogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageBlogRepository::class)
 */
class ImageBlog
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
     * @ORM\ManyToOne(targetEntity=Blog::class, inversedBy="imageBlogs")
     */
    private $image;

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

    public function getImage(): ?Blog
    {
        return $this->image;
    }

    public function setImage(?Blog $image): self
    {
        $this->image = $image;

        return $this;
    }
}
