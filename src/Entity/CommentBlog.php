<?php

namespace App\Entity;

use App\Repository\CommentBlogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentBlogRepository::class)
 */
class CommentBlog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Blog::class, inversedBy="commentBlogs")
     */
    private $commentBlog;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentBlogs")
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getCommentBlog(): ?Blog
    {
        return $this->commentBlog;
    }

    public function setCommentBlog(?Blog $commentBlog): self
    {
        $this->commentBlog = $commentBlog;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
