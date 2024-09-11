<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Application\Controller\Interfaces;

use Application\Application\Controller\Traits\ActionEntityControlerToolsTrait;
use Application\Application\Controller\Traits\AfficherEntityActionTrait;
use Application\Application\Controller\Traits\AjouterEntityActionTrait;
use Application\Application\Controller\Traits\ArchiverEntityActionTrait;
use Application\Application\Controller\Traits\GetActionsMenuActionTrait;
use Application\Application\Controller\Traits\ListerEntityActionTrait;
use Application\Application\Controller\Traits\ModifierEntityActionTrait;
use Application\Application\Controller\Traits\RestaurerEntityActionTrait;
use Application\Application\Controller\Traits\SupprimerEntityActionTrait;
use Application\Application\Form\AbstractEntityForm;
use Application\Application\Form\Misc\ConfirmationForm;
use Application\Application\Form\Misc\ConfirmationFormAwareTrait;
use Application\Application\Service\API\CommonEntityService;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\View\Model\ViewModel;

abstract class AbstractEntityController
    extends AbstractActionController
    implements EntityControllerInterface
{
    /** ROUTES a surchargé nécessairement */
    const ROUTE_INDEX = null;
    const ROUTE_LISTER = null;
    const ROUTE_AFFICHER = null;
    const ROUTE_AJOUTER = null;
    const ROUTE_MODIFIER = null;
    const ROUTE_ARCHIVER = null;
    const ROUTE_RESTAURER = null;
    const ROUTE_SUPPRIMER = null;
    const ROUTE_GET_ACTIONS_MENU = null;

    /** ACTION a surchargé éventuellement */
    const ACTION_INDEX = "index";
    const ACTION_LISTER = "lister";
    const ACTION_AFFICHER = "afficher";
    const ACTION_AJOUTER = "ajouter";
    const ACTION_MODIFIER = "modifier";
    const ACTION_SUPPRIMER = "supprimer";
    const ACTION_ARCHIVER = "archiver";
    const ACTION_RESTAURER = "restaurer";
    const ACTION_GET_ACTIONS_MENU = "get-actions-menu";

    /** EVENT A surchargé éventuellement */
    const EVENT_AJOUTER = 'event-ajouter';
    const EVENT_MODIFIER = 'event-modifier';
    const EVENT_SUPPRIMER = 'event-supprimer';
    const EVENT_ARCHIVER = 'event-archiver';
    const EVENT_RESTAURER = 'event-restaurer';

    use ActionEntityControlerToolsTrait;
    use ConfirmationFormAwareTrait;
}
