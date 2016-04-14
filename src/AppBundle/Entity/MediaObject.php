<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="qa_content")
 */
class MediaObject
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $tags;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $team;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $environment;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $story;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $type;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $user;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $views;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $timestamp;
}