<?php

namespace WebsiteBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use WebsiteBundle\Entity\BlogPosts;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class FeedController extends Controller
{
    /**
     * @Route("/feed/", defaults={"_format"="xml"}, name="feed")
     */
    public function indexAction(Request $request)
    {
        $blogPosts = $this->getDoctrine()
            ->getManager()
            ->getRepository(BlogPosts::class)
            ->getPostsOnPage(1, 5);

        if ($blogPosts === null) {
            throw new EntityNotFoundException('Failed to retrieve latest posts.');
        }
$request->setFormat('xml', 'text/xml');
        return $this->render('WebsiteBundle::feed.xml.twig', [
            'posts' => $blogPosts,
        ]);
    }
}
