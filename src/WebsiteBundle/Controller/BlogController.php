<?php

namespace WebsiteBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WebsiteBundle\Entity\BlogPosts;

class BlogController extends Controller
{
    /**
     * @Route("/blog/", name="blog")
     * @Route("/blog/{postId}", name="blog_single")
     * @Route("/blog/page/{pageNumber}", name="blog_page")
     *
     * @param Request $request
     * @param int     $postId
     * @param int     $pageNumber
     *
     * @throws EntityNotFoundException
     *
     * @return Response
     */
    public function indexAction(Request $request, $postId = null, $pageNumber = 1)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(BlogPosts::class);

        $postsPerPage = 5;

        if ($postId === null) {
            $blogPosts = $repository->getPostsOnPage($pageNumber, $postsPerPage);
        } else {
            $blogPosts[] = $repository->findOneBy(['postid' => $postId]);
        }

        if ($blogPosts === null) {
            throw new EntityNotFoundException('Requested blog post not found.');
        }

        $numberOfPosts = $repository->getNumberOfPosts();

        return $this->render(
            '@Website/default/blog.html.twig',
            [
                'posts' => $blogPosts,
                'totalposts' => $numberOfPosts,
                'page' => $pageNumber,
                'postsperpage' => $postsPerPage,
            ]
        );
    }
}
