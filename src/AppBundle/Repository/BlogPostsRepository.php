<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BlogPosts;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class BlogPostsRepository extends EntityRepository
{
    public function getPostsOnPage($page)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb->select('p')
            ->from(BlogPosts::class, 'p')
            ->where('p.postdraft = 0')
            ->orderBy('p.posttimestamp', 'DESC')
            ->setFirstResult($page * 5)
            ->setMaxResults(5);

        $paginator = new Paginator($query, $fetchJoinCollection = true);

        return $paginator;
    }
}
