<?php

namespace AppBundle\Entity\Queries;

use Doctrine\ORM\EntityManager;

/**
 * Class Manager
 * @package AppBundle\Entity\Queries
 */
class Manager
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * Manager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('AppBundle:MediaObject');
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return array
     */
    public function getFeaturedResult()
    {
        $query = $this->repository->createQueryBuilder('p')
            ->where('p.type = :views')
            ->setParameter('views', 'New Feature')
            ->orderBy('p.timestamp', 'DESC')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @return array
     */
    public function getPopularResults()
    {
        $query = $this->repository->createQueryBuilder('p')
            ->orderBy('p.views', 'DESC')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param $type
     *
     * @return \AppBundle\Entity\MediaObject[]|array
     */
    public function getResultByType($type)
    {
        return $this->repository->findBy(['type' => $type]);
    }

    /**
     * @param $searchTerm
     *
     * @return array
     */
    public function getSearchResults($searchTerm)
    {
        $query = $this->repository->createQueryBuilder('p')
            ->where('LOWER(p.title) LIKE :searchterm')
            ->setParameter('searchterm', '%'.$searchTerm.'%')
            ->orderBy('p.title', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param $id
     * 
     * @return \AppBundle\Entity\MediaObject
     */
    public function getEntityById($id)
    {
        return $this->repository->find($id);
    }
}