<?php

namespace Import\Controller;

use Import\Service\Import\ImportServiceAwareTrait;
use Laminas\Form\Element\Select;
use Laminas\Http\Request;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ImportController extends AbstractActionController {
    use ImportServiceAwareTrait;

    public function indexAction()
    {
        return "hey";
    }
}