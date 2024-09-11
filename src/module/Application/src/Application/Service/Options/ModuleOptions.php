<?php

namespace Application\Application\Service\Options;

use Laminas\Stdlib\AbstractOptions;
use Laminas\Stdlib\ArrayUtils;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $encryption = [];

    /**
     * @var array
     */
    protected $http_client = [];


    /**
     * Getter for encryption params
     *
     * @return array
     */
    public function getEncryption()
    {
        return $this->encryption;
    }

    /**
     * Setter for encryption params
     *
     * @param array $encryption
     * @return self
     */
    public function setEncryption(array $encryption)
    {
        $this->encryption = ArrayUtils::merge($this->encryption, $encryption);

        return $this;
    }

    /**
     * Getter for sgc params
     *
     * @return array
     */
    public function getHttpclient()
    {
        return $this->http_client;
    }

    /**
     * Setter for sgc params
     *
     * @param array $http_client
     * @return self
     */
    public function setHttpclient(array $http_client)
    {
        $this->http_client = ArrayUtils::merge($this->http_client, $http_client);

        return $this;
    }

}
