<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="qa_content")
 * @Vich\Uploadable
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
     * @ORM\Column(type="bool")
     */
    protected $isSignOff;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $type;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $user;

    /**
     * @ORM\Column(type="integer")
     */
    protected $views;

    /**
     * @ORM\Column(type="datetime", length=100)
     *
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * @Vich\UploadableField(mapping="media_entry", fileNameProperty="mediaName")
     * 
     * @var File
     */
    protected $mediaFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $mediaName;

    /**
     * @ORM\Column(type="string", length=45)
     *
     * @var string
     */
    protected $mimeType;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return MediaObject
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MediaObject
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return MediaObject
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set team
     *
     * @param string $team
     *
     * @return MediaObject
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return string
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set environment
     *
     * @param string $environment
     *
     * @return MediaObject
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Get environment
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Set story
     *
     * @param string $story
     *
     * @return MediaObject
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story
     *
     * @return string
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return MediaObject
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return MediaObject
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set views
     *
     * @param int $views
     *
     * @return MediaObject
     */
    public function setViews($views)
    {

        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return MediaObject
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param File|null $file
     *
     * @return $this
     */
    public function setMediaFile(File $file = null)
    {
        $this->mediaFile = $file;

        if ($file) {
            $this->timestamp = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Get mediaFile
     *
     * @return File
     */
    public function getMediaFile()
    {
        return $this->mediaFile;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setMediaName($name)
    {
        $this->mediaName = $name;

        return $this;
    }

    /**
     * @return File
     */
    public function getMediaName()
    {
        return $this->mediaName;
    }

    /**
     * @param $mineType
     *
     * @return $this
     */
    public function setMimeType($mineType)
    {
        $this->mimeType = $mineType;

        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return bool
     */
    public function getIsSignOff()
    {
        return $this->isSignOff;
    }

    /**
     * @param bool $isSignOff
     */
    public function setIsSignOff($isSignOff)
    {
        $this->isSignOff = $isSignOff;
    }
}
