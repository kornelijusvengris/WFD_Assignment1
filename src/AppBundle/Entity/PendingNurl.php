<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PendingNurl
 *
 * @ORM\Table(name="pending_nurl")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PendingNurlRepository")
 */
class PendingNurl
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
     * @var bool
     *
     * @ORM\Column(name="approved", type="boolean")
     */
    private $approved;

    //-----------------------------------------------------------

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Nurl")
     * @ORM\JoinColumn(name="nurl", referencedColumnName="id")
     */
    private $nurl;

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
     * Set approved
     *
     * @param boolean $approved
     *
     * @return PendingNurl
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     *
     * @return PendingNurl
     */
    public function setNurl(\AppBundle\Entity\Nurl $nurl = null)
    {
        $this->nurl = $nurl;

        return $this;
    }

    /**
     * Get nurl
     *
     * @return \AppBundle\Entity\Nurl
     */
    public function getNurl()
    {
        return $this->nurl;
    }
}
