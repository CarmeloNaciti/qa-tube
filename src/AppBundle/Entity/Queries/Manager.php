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
    public function getLatestResult()
    {
        $query = $this->repository->createQueryBuilder('p')
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
     * @param $sort
     * @param $direction
     *
     * @return \Doctrine\ORM\Query
     */
    public function getSearchResults($searchTerm, $sort, $direction)
    {
        $query = $this->repository->createQueryBuilder('p')
            ->where('LOWER(p.title) LIKE :search_term')
            ->orWhere('LOWER(p.description) LIKE :search_term')
            ->orWhere('LOWER(p.story) LIKE :search_term')
            ->setParameter('search_term', '%'.$searchTerm.'%')
            ->orderBy($sort, $direction)
            ->getQuery();

        return $query;
    }

    /**
     * @param $user
     * @param string $sort
     * @param string $direction
     *
     * @return \Doctrine\ORM\Query
     */
    public function getUserObjectSearchQuery($user, $sort, $direction)
    {
        $query = $this->repository->createQueryBuilder('p')
            ->where('LOWER(p.user) LIKE :user')
            ->setParameter('user', '%'.$user.'%')
            ->orderBy($sort, $direction)
            ->getQuery();

        return $query;
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

    /**
     * @param $columnName
     * @param $value
     *
     * @return \AppBundle\Entity\MediaObject
     */
    public function getEntityByColumn($columnName, $value)
    {
        return $this->repository->findOneBy([$columnName => $value]);
    }

    /**
     * @param $entity
     */
    public function saveEntity($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param $entity
     */
    public function deleteEntity($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}