<?php

namespace Application\Application\Service\Options;

trait ModuleOptionsAwareTrait
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;


    /**
     * @param ModuleOptions $moduleOptions
     */
    public function setAppOptions(ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return ModuleOptions
     */
    public function getAppOptions()
    {
        return $this->moduleOptions;
    }
}