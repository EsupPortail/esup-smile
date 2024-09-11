<?php

namespace Application\Entity;

/**
 * ImportLog
 */
class ImportLog
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $success;

    /**
     * @var string
     */
    private $log;

    /**
     * @var \DateTime
     */
    private $startedOn;

    /**
     * @var \DateTime
     */
    private $endedOn;

    /**
     * @var string|null
     */
    private $importHash;

    /**
     * @var bool
     */
    private $hasProblems = '';

    /**
     * @var int
     */
    private $id;


    /**
     * Set type.
     *
     * @param string $type
     *
     * @return ImportLog
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ImportLog
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set success.
     *
     * @param bool $success
     *
     * @return ImportLog
     */
    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * Get success.
     *
     * @return bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Set log.
     *
     * @param string $log
     *
     * @return ImportLog
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get log.
     *
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set startedOn.
     *
     * @param \DateTime $startedOn
     *
     * @return ImportLog
     */
    public function setStartedOn($startedOn)
    {
        $this->startedOn = $startedOn;

        return $this;
    }

    /**
     * Get startedOn.
     *
     * @return \DateTime
     */
    public function getStartedOn()
    {
        return $this->startedOn;
    }

    /**
     * Set endedOn.
     *
     * @param \DateTime $endedOn
     *
     * @return ImportLog
     */
    public function setEndedOn($endedOn)
    {
        $this->endedOn = $endedOn;

        return $this;
    }

    /**
     * Get endedOn.
     *
     * @return \DateTime
     */
    public function getEndedOn()
    {
        return $this->endedOn;
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
}
