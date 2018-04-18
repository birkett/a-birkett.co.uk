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

declare(strict_types=1);

namespace App\Repository;

use App\Entity\BlogPosts;
use Doctrine\ORM\EntityRepository;

class BlogPostsRepository extends EntityRepository
{
    /**
     * @param $page
     * @param $postsPerPage
     *
     * @return BlogPosts[]|array
     */
    public function getPostsOnPage($page, $postsPerPage): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        return $queryBuilder->select('p')
            ->from(BlogPosts::class, 'p')
            ->where($queryBuilder->expr()->eq('p.postDraft', ':draft'))
            ->orderBy('p.postTimestamp', 'DESC')
            ->setParameter('draft', false)
            ->setFirstResult(($page - 1) * $postsPerPage)
            ->setMaxResults($postsPerPage)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNumberOfPosts(): int
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $query = $queryBuilder->select('COUNT(p.postId)')->from(BlogPosts::class, 'p');

        return (int) $query->getQuery()->getSingleScalarResult();
    }
}
