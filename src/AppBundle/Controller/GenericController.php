<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\SitePages;

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
        return $this->render('default/generic.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'RAND1' => rand(0, 255),
            'RAND2' => rand(0, 255),
            'RAND3' => rand(0, 255),
            'THISYEAR' => date('Y'),
            'PAGETITLE' => $page->getPagetitle(),
            'PAGECONTENT' => $page->getPagecontent(),
        ]);
    }
}
