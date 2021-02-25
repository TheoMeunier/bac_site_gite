<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(BlogRepository $repository): Response
    {
        return $this->render('blog/index.html.twig', [
            'blog' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function show(BlogRepository $repository): Response
    {
        return $this->render('blog/index.html.twig', [
            'blog' => $repository->findAll(),
        ]);
    }
}
