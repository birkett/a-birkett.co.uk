<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\BlogPosts;

class BlogController extends Controller
{
    /**
     * @Route("/blog/", name="blog")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/blog.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'RAND1' => rand(0, 255),
            'RAND2' => rand(0, 255),
            'RAND3' => rand(0, 255),
            'THISYEAR' => date('Y'),
            'POSTID' => 0,
        ]);
    }

    /**
     * @Route("/blog/{postId}", name="blog_single")
     */
    public function singlePostAction($postId)
    {
        $blogPost = $this->getDoctrine()
            ->getManager()
            ->getRepository(BlogPosts::class)
            ->findOneBy(['postid' => $postId]);

        if ($blogPost === null) {
            throw new EntityNotFoundException('Requested blog post not found.');
        }

        return $this->render('default/blog.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'RAND1' => rand(0, 255),
            'RAND2' => rand(0, 255),
            'RAND3' => rand(0, 255),
            'THISYEAR' => date('Y'),
            'POSTID' => $blogPost->getPostid(),
            'POSTTITLE' => $blogPost->getPosttitle(),
            'POSTCONTENT' => $blogPost->getPostcontent(),
        ]);
    }
}
