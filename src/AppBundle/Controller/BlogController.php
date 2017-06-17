<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\BlogPosts;
use AppBundle\Repository\BlogPostsRepository;

class BlogController extends Controller
{
    /**
     * @Route("/blog/", name="blog")
     * @Route("/blog/{postId}", name="blog_single")
     * @Route("/blog/page/{pageNumber}", name="blog_page")
     */
    public function indexAction(Request $request, $postId = null, $pageNumber = 1)
    {
        if ($postId === null) {
            $blogPosts = $this->getDoctrine()
                ->getManager()
                ->getRepository(BlogPosts::class)
                ->getPostsOnPage($pageNumber);
        } else {
            $blogPosts[] = $this->getDoctrine()
                ->getManager()
                ->getRepository(BlogPosts::class)
                ->findOneBy(['postid' => $postId]);
        }

        if ($blogPosts === null) {
            throw new EntityNotFoundException('Requested blog post not found.');
        }

        return $this->render('default/blog.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'RAND1' => rand(0, 255),
            'RAND2' => rand(0, 255),
            'RAND3' => rand(0, 255),
            'THISYEAR' => date('Y'),
            'posts' => $blogPosts,
        ]);
    }
}
