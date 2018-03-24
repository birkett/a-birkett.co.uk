<?php

namespace WebsiteBundle\Repository;

use WebsiteBundle\Entity\BlogPosts;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class BlogPostsRepository extends EntityRepository
{
    public function getPostsOnPage($page, $postsPerPage)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $query = $queryBuilder->select('p')
            ->from(BlogPosts::class, 'p')
            ->where('p.postdraft = 0')
            ->orderBy('p.posttimestamp', 'DESC')
            ->setFirstResult(($page - 1) * $postsPerPage)
            ->setMaxResults($postsPerPage);

        $paginator = new Paginator($query);

        return $paginator;
    }

    public function getNumberOfPosts()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $query = $queryBuilder->select('count(p.postid)')->from(BlogPosts::class, 'p');

        $count = $query->getQuery()->getSingleScalarResult();

        return $count;
    }
}
