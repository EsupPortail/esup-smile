<?php

namespace Application\Entity;

/**
 * ImportObservResult
 */
class ImportObservResult
{
    /**
     * @var \DateTime
     */
    private $dateCreation = 'now()';

    /**
     * @var string
     */
    private $sourceCode;

    /**
     * @var string
     */
    private $resultat;

    /**
     * @var int
     */
    private $id;

    /**
     * @var \Application\Entity\ImportObserv
     */
    private $importObserv;


    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return ImportObservResult
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set sourceCode.
     *
     * @param string $sourceCode
     *
     * @return ImportObservResult
     */
    public function setSourceCode($sourceCode)
    {
        $this->sourceCode = $sourceCode;

        return $this;
    }

    /**
     * Get sourceCode.
     *
     * @return string
     */
    public function getSourceCode()
    {
        return $this->sourceCode;
    }

    /**
     * Set resultat.
     *
     * @param string $resultat
     *
     * @return ImportObservResult
     */
    public function setResultat($resultat)
    {
        $this->resultat = $resultat;

        return $this;
    }

    /**
     * Get resultat.
     *
     * @return string
     */
    public function getResultat()
    {
        return $this->resultat;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set importObserv.
     *
     * @param \Application\Entity\ImportObserv|null $importObserv
     *
     * @return ImportObservResult
     */
    public function setImportObserv(\Application\Entity\ImportObserv $importObserv = null)
    {
        $this->importObserv = $importObserv;

        return $this;
    }

    /**
     * Get importObserv.
     *
     * @return \Application\Entity\ImportObserv|null
     */
    public function getImportObserv()
    {
        return $this->importObserv;
    }
}
