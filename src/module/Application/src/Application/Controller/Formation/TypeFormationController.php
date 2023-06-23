<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\Formation;

use Application\Application\Controller\Interfaces\AbstractEntityController;
use Application\Application\Controller\Interfaces\EntityControllerInterface;
use Application\Application\Controller\Traits\AjouterEntityActionTrait;
use Application\Application\Controller\Traits\ArchiverEntityActionTrait;
use Application\Application\Controller\Traits\GetActionsMenuActionTrait;
use Application\Application\Controller\Traits\ListerEntityActionTrait;
use Application\Application\Controller\Traits\ModifierEntityActionTrait;
use Application\Application\Controller\Traits\RestaurerEntityActionTrait;
use Application\Application\Controller\Traits\SupprimerEntityActionTrait;
use Application\Application\Entity\Traits\Entities\TypeFormationAwareTrait;
use Application\Application\Form\AbstractEntityForm;
use Application\Application\Form\Formation\Traits\TypeFormationFormAwareTrait;
use Application\Application\Form\Misc\ConfirmationFormAwareTrait;
use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\Formation\TypeFormationServiceAwareTrait;
use Exception;
use Laminas\View\Model\ViewModel;

class TypeFormationController extends AbstractEntityController
    implements EntityControllerInterface
{
    const ROUTE_INDEX = "types-formations";
    const ROUTE_LISTER = "types-formations/lister";
    const ROUTE_AJOUTER = "type-formation/ajouter";
    const ROUTE_MODIFIER = "type-formation/modifier";
    const ROUTE_SUPPRIMER = "type-formation/supprimer";
    const ROUTE_GET_ACTIONS_MENU = "type-formation/actions";

    const EVENT_AJOUTER = 'event-ajouter-type-formation';
    const EVENT_MODIFIER = 'event-modifier-type-formation';
    const EVENT_SUPPRIMER = 'event-supprimer-type-formation';

    use TypeFormationAwareTrait;
    use TypeFormationFormAwareTrait;
    use TypeFormationServiceAwareTrait;
    use ConfirmationFormAwareTrait;

    use ListerEntityActionTrait;
    use AjouterEntityActionTrait;
    use ModifierEntityActionTrait;
    use SupprimerEntityActionTrait;
    use ArchiverEntityActionTrait;
    use RestaurerEntityActionTrait;
    use GetActionsMenuActionTrait;

    public function indexAction(){return $this->redirect()->toRoute(FormationController::ROUTE_INDEX, [], [], true);}

    public function getEntityParam(): string {return "typeFormation";}
    public function getEntitiesParam(): string {return "typesFormations";}
    public function getEntityService(): CommonEntityService
    {
        return $this->getTypeFormationService();
    }
    public function getAjouterForm(): AbstractEntityForm
    {
        return $this->getAddTypeFormationForm();
    }
    public function getModifierForm(): AbstractEntityForm
    {
        return $this->getEditTypeFormationForm();
    }

    public function getEntityNotFoundMessage(): ?string
    {
        return "Le type de formation demandé n'as pas été trouvé";
    }

    public function getAfficherActionTitle(): string
    {
        $typeFormation = $this->getTypeFormationFromRoute();
        return sprintf("Fiche du type de formation %s", $typeFormation->getAcronyme());
    }
    public function getAjouterActionTitle(): string
    {
        return "Ajouter un type de formation";
    }
    public function getModifierActionTitle(): string
    {
        $typeFormation = $this->getTypeFormationFromRoute();
        return sprintf("Modifier le type de formation %s", $typeFormation->getCode());
    }
    public function getSupprimerActionTitle(): string
    {
        $typeFormation = $this->getTypeFormationFromRoute();
        return sprintf("Supprimer le type de formation %s", $typeFormation->getCode());
    }
    public function getArchiverActionTitle(): string
    {
        $typeFormation = $this->getTypeFormationFromRoute();
        return sprintf("Archiver le type de formation %s", $typeFormation->getCode());
    }

    public function getRestaurerActionTitle(): string
    {
        $typeFormation = $this->getTypeFormationFromRoute();
        return sprintf("Restaurer le type de formation %s", $typeFormation->getCode());
    }
    public function getActionsMenuTemplatePath(): ?string
    {
        return 'application/formation/type-formation/fragment/actions-menu';
    }

    function afficherAction(): ViewModel
    {
        throw new Exception("Les fiches des types de formations ne sont pas implémentées");
    }

    function archiverAction(): ViewModel
    {
        throw new Exception("Les types de formations ne peuvent pas être archivés.");
    }

    function restaurerAction(): ViewModel
    {
        throw new Exception("Les types de formations ne peuvent pas être restaurés.");
    }
}
