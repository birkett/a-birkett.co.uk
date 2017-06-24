<?php

namespace WebsiteBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use WebsiteBundle\Entity\SitePages;

class GenericController extends Controller
{
    /**
     * @Route("/about/", name="about", defaults={"pageName" = "about"})
     * @Route("/contact/", name="contact", defaults={"pageName" = "contact"})
     * @Route("/photos/", name="photos", defaults={"pageName" = "photos"})
     * @Route("/projects/", name="projects", defaults={"pageName" = "projects"})
     * @Route("/videos/", name="videos", defaults={"pageName" = "videos"})
     */
    public function indexAction(Request $request, $pageName)
    {
        $page = $this->getDoctrine()
            ->getManager()
            ->getRepository(SitePages::class)
            ->findOneBy(['pagename' => $pageName]);

        if ($page === null) {
            throw new EntityNotFoundException('Page (' . $pageName . ') not found.');
        }

        // replace this example code with whatever you need
        return $this->render('WebsiteBundle:default:generic.html.twig', [
            'page' => $page,
        ]);
    }
}
