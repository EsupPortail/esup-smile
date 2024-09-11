<?php

namespace Application\Application\View\Helper\Interfaces;

use Laminas\Form\Form;

interface HistoriqueActionViewHelperInterface
{
    const ARCHIVER_LINK_CLASS = "btn btn-secondary";
    const ARCHIVER_LINK_ICONE = "<span class='icon icon-historiser'></span>";
    const ARCHIVER_LINK_LABEL = "Archiver";

    const RESTAURER_LINK_CLASS = "btn btn-primary";
    const RESTAURER_LINK_ICONE = "<span class='icon icon-restaurer'></span>";
    const RESTAURER_LINK_LABEL = "Restaurer";

    /** @return string */
    function renderLienArchiver() : string;

    /** @return string */
    function renderLienRestaurer() : string;
}