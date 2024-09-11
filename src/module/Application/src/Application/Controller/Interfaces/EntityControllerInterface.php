<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Application\Controller\Interfaces;

use Application\Application\Form\AbstractEntityForm;
use Application\Application\Form\Misc\ConfirmationForm;
use Application\Application\Service\API\CommonEntityService;
use Laminas\Http\Response;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\View\Model\ViewModel;

/**
 * @desc Controlleur permettant de gérer de maniére générique les actions liées à l'ajout, la suppression ... d'une entité
 */
interface EntityControllerInterface
{
    function listerAction() : ViewModel;
    function afficherAction() : ViewModel;
    function ajouterAction() : ViewModel;
    function modifierAction() : ViewModel;
    function supprimerAction() : ViewModel;
    function archiverAction() : ViewModel;
    function restaurerAction() : ViewModel;
    function getActionsMenuAction() ; // : ViewModel|Response;
}
