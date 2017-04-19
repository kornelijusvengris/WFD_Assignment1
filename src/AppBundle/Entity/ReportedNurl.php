<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportedNurl
 *
 * @ORM\Table(name="reported_nurls")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReportedNurlRepository")
 */
class ReportedNurl
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
     *
     * @ORM\Column(name="reason", type="string", length=255)
     */
    private $reason;

    /**
     * @var bool
     *
     * @ORM\Column(name="frozen", type="boolean", nullable=true)
     */
    private $frozen;

    //-----------------------------------------------------------------

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
     * Set reason
     *
     * @param string $reason
     *
     * @return ReportedNurl
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set frozen
     *
     * @param boolean $frozen
     *
     * @return ReportedNurl
     */
    public function setFrozen($frozen)
    {
        $this->frozen = $frozen;

        return $this;
    }

    /**
     * Get frozen
     *
     * @return boolean
     */
    public function getFrozen()
    {
        return $this->frozen;
    }

    /**
     * Set nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     *
     * @return ReportedNurl
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
