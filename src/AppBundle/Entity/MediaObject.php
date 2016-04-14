<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping;

/**
 * Class MediaObject
 *
 * @package AppBundle\Entity
 */
class MediaObject
{
    protected $id;

    protected $title;

    protected $description;

    protected $tags;

    protected $team;

    protected $environment;

    protected $story;

    protected $type;

    protected $user;

    protected $views;

    protected $timestamp;
}