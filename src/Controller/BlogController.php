<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Anthony Birkett
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
 * PHP Version 7.2
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2014-2018 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PostRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;

class BlogController extends AbstractController
{
    /**
     * Load and handle the blog.
     *
     * @param int $postId     Unique post ID.
     * @param int $pageNumber Page number to load.
     *
     * @throws EntityNotFoundException If the requested post is not found.
     *
     * @return Response
     */
    public function indexAction(int $postId = null, int $pageNumber = 1): Response
    {
        /** @var PostRepository $repository */
        $repository = $this->getDoctrine()->getManager()->getRepository(Post::class);

        $postsPerPage = 5;

        $postId === null
            ? $blogPosts = $repository->getPostsOnPage($pageNumber, $postsPerPage)
            : $blogPosts[] = $repository->findOneBy(['postId' => $postId]);

        if ($blogPosts === null) {
            throw new EntityNotFoundException('Requested blog post not found.');
        }

        $numberOfPosts = $repository->getNumberOfPosts();

        return $this->render(
            'pages/blog.html.twig',
            [
                'posts'        => $blogPosts,
                'totalposts'   => $numberOfPosts,
                'page'         => $pageNumber,
                'postsperpage' => $postsPerPage,
            ]
        );
    }//end indexAction()
}//end class
