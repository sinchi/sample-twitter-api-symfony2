<?php

namespace Twitter\DomainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function getTimeline(User $user)
    {
        return $this->_em->createQuery('
                SELECT
                    tweet
                FROM
                    TwitterDomainBundle:Tweet tweet
                JOIN tweet.user author
                WHERE author.id IN (
                    SELECT
                        follower.id
                    FROM
                        TwitterDomainBundle:User me
                    JOIN me.following follower
                    WHERE
                        me.id = :id
                )
                ORDER BY
                    tweet.id DESC')
            ->setParameter('id', $user->getId())
            ->getResult();
    }
}
