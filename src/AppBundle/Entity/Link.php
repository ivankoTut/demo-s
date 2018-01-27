<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Link
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="links", indexes={@ORM\Index(name="short_link", columns={"short_link"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LinkRepository")
 * @UniqueEntity(fields={"shortLink"}, entityClass="AppBundle\Entity\Link")
 */
class Link
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Url(
     *    protocols = {"http", "https"},
     *    checkDNS = true
     * )
     * @ORM\Column(name="full_link", type="text")
     */
    private $fullLink;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="short_link", type="string", length=255, unique=true)
     */
    private $shortLink;

    /**
     * @var int
     * @Assert\Type("integer")
     * @ORM\Column(name="count_visit", type="integer")
     */
    private $countVisit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    public function __construct()
    {
        $this->updatedTimestamps();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fullLink
     *
     * @param string $fullLink
     *
     * @return Link
     */
    public function setFullLink($fullLink)
    {
        $this->fullLink = $fullLink;

        return $this;
    }

    /**
     * Get fullLink
     *
     * @return string
     */
    public function getFullLink()
    {
        return $this->fullLink;
    }

    /**
     * Set shortLink
     *
     * @param string $shortLink
     *
     * @return Link
     */
    public function setShortLink($shortLink)
    {
        $this->shortLink = $shortLink;

        return $this;
    }

    /**
     * Get shortLink
     *
     * @return string
     */
    public function getShortLink()
    {
        return $this->shortLink;
    }

    /**
     * Set countVisit
     *
     * @param integer $countVisit
     *
     * @return Link
     */
    public function setCountVisit($countVisit)
    {
        $this->countVisit = $countVisit;

        return $this;
    }

    /**
     * Get countVisit
     *
     * @return int
     */
    public function getCountVisit()
    {
        return $this->countVisit;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Link
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Link
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        if($this->getCreatedAt() == null)
        {
            $this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        }
    }


    /**
     * The number of passed days from the day of creation links
     */
    public function getDifferenceDays()
    {
        return date_diff(new \DateTime(), new \DateTime($this->getCreatedAt()->format('Y-m-d H:i:s')))->days;
    }
}

