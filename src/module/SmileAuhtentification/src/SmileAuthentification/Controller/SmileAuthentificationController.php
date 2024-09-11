<?php

namespace SmileAuthentification\Controller;


use SmileAuthentification\Service\SmileAuthentification\SmileAuthentificationServiceAwareTrait;
use Laminas\Mvc\Controller\AbstractActionController;

class SmileAuthentificationController extends AbstractActionController {
    use SmileAuthentificationServiceAwareTrait;

}