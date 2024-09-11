<?php

namespace Import\Controller;

use Unicaen\Console\ColorInterface;
use Unicaen\Console\Controller\AbstractConsoleController;

class ConsoleController extends AbstractConsoleController
{
    private function bonjour(array $imports)
    {
        $this->getConsole()->writeLine("Hello World", ColorInterface::NORMAL);
    }

}