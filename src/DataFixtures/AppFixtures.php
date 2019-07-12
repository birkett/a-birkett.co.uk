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
 * @category  Fixtures
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2014-2018 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Page;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class AppFixtures extends Fixture
{
    /**
     * Pages to generate by default.
     */
    private const PAGES_TO_CREATE = [
        'About',
        'Contact',
        'Photos',
        'Videos',
        'Projects',
    ];

    /**
     * Doctrine manager.
     *
     * @var ObjectManager
     */
    private $manager;


    /**
     * Load the fixtures.
     *
     * @param ObjectManager $manager Doctrine manager.
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->createPages();
        $this->createPosts();
        $this->createUsers();

        $manager->flush();
    }//end load()


    /**
     * Create pages.
     *
     * @return void
     */
    private function createPages(): void
    {
        foreach (self::PAGES_TO_CREATE as $pageTitle) {
            $page = new Page();
            $page->setPageTitle($pageTitle);
            $page->setPageName(strtolower($pageTitle));
            $page->setPageContent('<p>Test page.</p>');

            $this->manager->persist($page);
        }
    }//end createPages()


    /**
     * Create posts.
     *
     * @return void
     */
    private function createPosts(): void
    {
        $post = new Post();
        $post->setPostTitle('Test Post');
        $post->setPostContent('<p>Test post.</p>');

        $this->manager->persist($post);

        $this->createComments($post);
    }//end createPosts()


    /**
     * @param Post $post Post to link this comment to.
     *
     * @return void
     */
    private function createComments(Post $post): void
    {
        $comment = new Comment();
        $comment->setPost($post);
        $comment->setClientIp('0.0.0.0');
        $comment->setCommentUsername('testUser');
        $comment->setCommentText('Test comment');

        $this->manager->persist($comment);
    }//end createComments()


    /**
     * Create users.
     *
     * @return void
     */
    private function createUsers(): void
    {
        $user            = new User();
        $passwordEncoder = new NativePasswordEncoder(10);

        $user->setUsername('test');
        $user->setPassword($passwordEncoder->encodePassword('test', 'test'));

        $this->manager->persist($user);
    }//end createUsers()
}//end class
