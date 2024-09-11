<?php

namespace Api\Controller;

use Laminas\Form\Element\Select;
use Laminas\Http\Request;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class ApiController extends AbstractActionController {

    const INDEX_ACTION = 'index';
    const TEST_ACTION = 'test';

    public function indexAction(): JsonModel
    {
        return new JsonModel([
            'message' => 'INDEX'
        ]);
    }

    public function testAction(): JsonModel
    {
        return new JsonModel([
            'message' => 'TEST'
        ]);
    }
}