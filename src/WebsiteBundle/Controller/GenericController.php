<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Anthony Birkett
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * PHP Version 7.1
 *
 * @category  Entities
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015-2018 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace WebsiteBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use WebsiteBundle\Entity\SitePages;

class GenericController extends Controller
{
    /**
     * @Route("/about/", name="about", defaults={"pageName" = "about"})
     * @Method({"GET"})
     *
     * @Route("/contact/", name="contact", defaults={"pageName" = "contact"})
     * @Method({"GET"})
     *
     * @Route("/photos/", name="photos", defaults={"pageName" = "photos"})
     * @Method({"GET"})
     *
     * @Route("/projects/", name="projects", defaults={"pageName" = "projects"})
     * @Method({"GET"})
     *
     * @Route("/videos/", name="videos", defaults={"pageName" = "videos"})
     * @Method({"GET"})
     *
     * @param string $pageName
     *
     * @throws EntityNotFoundException
     *
     * @return Response
     */
    public function indexAction(string $pageName): Response
    {
        $page = $this->getDoctrine()
            ->getManager()
            ->getRepository(SitePages::class)
            ->findOneBy(['pageName' => $pageName]);

        if ($page === null) {
            throw new EntityNotFoundException('Page (' . $pageName . ') not found.');
        }

        return $this->render('@Website/default/generic.html.twig', [
            'page' => $page,
        ]);
    }
}
