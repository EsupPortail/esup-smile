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
use Application\Application\Controller\Traits\AfficherEntityActionTrait;
use Application\Application\Controller\Traits\AjouterEntityActionTrait;
use Application\Application\Controller\Traits\ArchiverEntityActionTrait;
use Application\Application\Controller\Traits\GetActionsMenuActionTrait;
use Application\Application\Controller\Traits\ListerEntityActionTrait;
use Application\Application\Controller\Traits\ModifierEntityActionTrait;
use Application\Application\Controller\Traits\RestaurerEntityActionTrait;
use Application\Application\Controller\Traits\SupprimerEntityActionTrait;
use Application\Application\Entity\Traits\Entities\TypeDiplomeAwareTrait;

use Application\Application\Form\AbstractEntityForm;
use Application\Application\Form\Formation\Traits\TypeDiplomeFormAwareTrait;
use Application\Application\Form\Misc\ConfirmationFormAwareTrait;
use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\Formation\TypeDiplomeServiceAwareTrait;
use Application\Entity\Formation;
use Laminas\View\Model\ViewModel;
use UnicaenLdap\Exception;

class TypeDiplomeController extends AbstractEntityController
    implements EntityControllerInterface
{
    const ROUTE_INDEX = "types-diplomes";
    const ROUTE_LISTER = "types-diplomes/lister";
    const ROUTE_AJOUTER = "type-diplome/ajouter";
    const ROUTE_MODIFIER = "type-diplome/modifier";
    const ROUTE_SUPPRIMER = "type-diplome/supprimer";
    const ROUTE_GET_ACTIONS_MENU = "type-diplome/actions";

    const EVENT_AJOUTER = 'event-ajouter-type-diplome';
    const EVENT_MODIFIER = 'event-modifier-type-diplome';
    const EVENT_SUPPRIMER = 'event-supprimer-type-diplome';

    use TypeDiplomeAwareTrait;
    use TypeDiplomeFormAwareTrait;
    use TypeDiplomeServiceAwareTrait;
    use ConfirmationFormAwareTrait;

    use ListerEntityActionTrait;
    use AjouterEntityActionTrait;
    use ModifierEntityActionTrait;
    use SupprimerEntityActionTrait;
    use GetActionsMenuActionTrait;

    public function indexAction(){return $this->redirect()->toRoute(FormationController::ROUTE_INDEX, [], [], true);}

    public function getEntityParam(): string {return "typeDiplome";}
    public function getEntitiesParam(): string {return "typesDiplomes";}
    public function getEntityService(): CommonEntityService
    {
        return $this->getTypeDiplomeService();
    }
    public function getAjouterForm(): AbstractEntityForm
    {
        return $this->getAddTypeDiplomeForm();
    }
    public function getModifierForm(): AbstractEntityForm
    {
        return $this->getEditTypeDiplomeForm();
    }

    public function getEntityNotFoundMessage(): ?string
    {
        return "Le type de diplome demandé n'as pas été trouvé";
    }

    public function getAjouterActionTitle(): string
    {
        return "Ajouter un type de diplome";
    }
    public function getModifierActionTitle(): string
    {
        $typeDiplome = $this->getTypeDiplomeFromRoute();
        return sprintf("Modifier le type de diplome %s", $typeDiplome->getCode());
    }
    public function getSupprimerActionTitle(): string
    {
        $typeDiplome = $this->getTypeDiplomeFromRoute();
        return sprintf("Supprimer le type de diplome %s", $typeDiplome->getCode());
    }
    public function getArchiverActionTitle(): string
    {
        $typeDiplome = $this->getTypeDiplomeFromRoute();
        return sprintf("Archiver le type de diplome %s", $typeDiplome->getCode());
    }
    /**
     * @return string
     */
    public function getArchiverConfirmationMessage(): string
    {
        $typeDiplome = $this->getTypeDiplomeFromRoute();
        $formations = $typeDiplome->getFormations()->toArray();
        $formations = array_filter($formations, function(Formation $f){
            return $f->estNonHistorise();
        });
        if(sizeof($formations)>0){
            $msg = sprintf("Archiver le type de diplome \"%s\" archivera également les %s formations associés <br/>"
                ,$typeDiplome->getLibelle(), sizeof($formations)
            );
        }
        $msg = "Etes-vous sûr&middot;e de vouloir continuer ?";
        return $msg;
    }

    public function getRestaurerActionTitle(): string
    {
        $typeDiplome = $this->getTypeDiplomeFromRoute();
        return sprintf("Restaurer le type de diplôme %s", $typeDiplome->getCode());
    }
    public function getActionsMenuTemplatePath(): ?string
    {
        return 'application/formation/type-diplome/fragment/actions-menu';
    }

    public function afficherAction(): ViewModel
    {
       throw new Exception("Les fiches des types de diplomes ne sont pas implémentés.");
    }

    function archiverAction(): ViewModel
    {
        throw new Exception("Les types de diplomes ne peuvent pas être archivés.");
    }

    function restaurerAction(): ViewModel
    {
        throw new Exception("Les types de diplomes ne peuvent pas être restaurés.");
    }
}
