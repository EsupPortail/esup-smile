<?php

namespace Application\Application\Service\Options;

interface ModuleOptionsAwareInterface
{
    /**
     * @param ModuleOptions $moduleOptions
     */
    public function setAppOptions(ModuleOptions $moduleOptions);

    /**
     * @return ModuleOptions
     */
    public function getAppOptions();
}