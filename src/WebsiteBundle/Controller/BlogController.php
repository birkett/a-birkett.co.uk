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
    public function indexAction(int $postId = null, int $pageNumber = 1): Response
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(BlogPosts::class);

        $postsPerPage = 5;

        if ($postId === null) {
            $blogPosts = $repository->getPostsOnPage($pageNumber, $postsPerPage);
        } else {
            $blogPosts[] = $repository->findOneBy(['postId' => $postId]);
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
