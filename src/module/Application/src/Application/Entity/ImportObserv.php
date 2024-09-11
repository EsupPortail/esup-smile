<?php

namespace Application\Entity;

/**
 * ImportObserv
 */
class ImportObserv
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var string
     */
    private $columnName;

    /**
     * @var string
     */
    private $operation = 'UPDATE';

    /**
     * @var string|null
     */
    private $toValue;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var bool
     */
    private $enabled = '';

    /**
     * @var string|null
     */
    private $filter;

    /**
     * @var int
     */
    private $id;


    /**
     * Set code.
     *
     * @param string $code
     *
     * @return ImportObserv
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set tableName.
     *
     * @param string $tableName
     *
     * @return ImportObserv
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * Get tableName.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Set columnName.
     *
     * @param string $columnName
     *
     * @return ImportObserv
     */
    public function setColumnName($columnName)
    {
        $this->columnName = $columnName;

        return $this;
    }

    /**
     * Get columnName.
     *
     * @return string
     */
    public function getColumnName()
    {
        return $this->columnName;
    }

    /**
     * Set operation.
     *
     * @param string $operation
     *
     * @return ImportObserv
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation.
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set toValue.
     *
     * @param string|null $toValue
     *
     * @return ImportObserv
     */
    public function setToValue($toValue = null)
    {
        $this->toValue = $toValue;

        return $this;
    }

    /**
     * Get toValue.
     *
     * @return string|null
     */
    public function getToValue()
    {
        return $this->toValue;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return ImportObserv
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return ImportObserv
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set filter.
     *
     * @param string|null $filter
     *
     * @return ImportObserv
     */
    public function setFilter($filter = null)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Get filter.
     *
     * @return string|null
     */
    public function getFilter()
    {
        return $this->filter;
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
