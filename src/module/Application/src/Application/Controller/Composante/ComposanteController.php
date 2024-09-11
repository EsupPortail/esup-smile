<?php

namespace Application\Controller\Composante;

use Application\Application\Controller\Interfaces\AbstractEntityController;
use Application\Application\Controller\Traits\AfficherEntityActionTrait;
use Application\Application\Controller\Traits\AjouterEntityActionTrait;
use Application\Application\Controller\Traits\ArchiverEntityActionTrait;
use Application\Application\Controller\Traits\GetActionsMenuActionTrait;
use Application\Application\Controller\Traits\ListerEntityActionTrait;
use Application\Application\Controller\Traits\ModifierEntityActionTrait;
use Application\Application\Controller\Traits\RestaurerEntityActionTrait;
use Application\Application\Controller\Traits\SourceEntityActionTrait;
use Application\Application\Controller\Traits\SupprimerEntityActionTrait;
use Application\Application\Entity\Interfaces\SourceAwareInterface;
use Application\Application\Entity\Traits\Entities\ComposanteAwareTrait;
use Application\Application\Form\AbstractEntityForm;
use Application\Application\Form\Composante\Traits\ComposanteFormAwareTrait;
use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\SourceAwareEntityServiceInterface;
use Application\Application\Service\API\SourceEntityServiceTrait;
use Application\Application\Service\Composante\ComposanteServiceAwareTrait;
use Exception;
use Laminas\Http\Response;
use Laminas\View\Model\ViewModel;

class ComposanteController extends AbstractEntityController
{
    /** ROUTES */
    const ROUTE_INDEX = "composantes";
    const ROUTE_LISTER = "composantes/lister";
    const ROUTE_AFFICHER = "composante/afficher";
    const ROUTE_AJOUTER = "composante/ajouter";
    const ROUTE_MODIFIER = "composante/modifier";
    const ROUTE_ARCHIVER = "composante/archiver";
    const ROUTE_RESTAURER = "composante/restaurer";
    const ROUTE_SUPPRIMER = "composante/supprimer";
    const ROUTE_GET_ACTIONS_MENU = "composante/actions";

    const EVENT_AJOUTER = 'event-ajouter-composante';
    const EVENT_MODIFIER = 'event-modifier-composante';
    const EVENT_SUPPRIMER = 'event-supprimer-composante';
    const EVENT_ARCHIVER = 'event-archiver-composante';
    const EVENT_RESTAURER = 'event-restaurer-composante';


    use ComposanteAwareTrait;
    use ComposanteServiceAwareTrait;
    use ComposanteFormAwareTrait;

    use ListerEntityActionTrait;
    use AfficherEntityActionTrait;
    use AjouterEntityActionTrait;
    use ModifierEntityActionTrait;
    use SupprimerEntityActionTrait;
    use ArchiverEntityActionTrait;
    use RestaurerEntityActionTrait;
    use GetActionsMenuActionTrait;

    public function getEntityParam(): string {return "composante";}
    public function getEntitiesParam(): string {return "composantes";}
    public function getEntityService(): CommonEntityService
    {
        return $this->getComposanteService();
    }
    public function getAjouterForm(): AbstractEntityForm
    {
        return $this->getAddComposanteForm();
    }
    public function getModifierForm(): AbstractEntityForm
    {
        return $this->getEditComposanteForm();
    }

    public function getEntityNotFoundMessage(): ?string
    {
        return "La composante demandée n'as pas été trouvée";
    }

    public function getAfficherActionTitle(): string
    {
        $composante = $this->getComposanteFromRoute();
        return sprintf("Fiche de la composante %s", $composante->getAcronyme());
    }
    public function getAjouterActionTitle(): string
    {
        return "Ajouter une composante";
    }
    public function getModifierActionTitle(): string
    {
        $composante = $this->getComposanteFromRoute();
        return sprintf("Modifier la composante %s", $composante->getCode());
    }
    public function getSupprimerActionTitle(): string
    {
        $composante = $this->getComposanteFromRoute();
        return sprintf("Supprimer la composante %s", $composante->getCode());
    }
    public function getArchiverActionTitle(): string
    {
        $composante = $this->getComposanteFromRoute();
        return sprintf("Archiver la composante %s", $composante->getCode());
    }
    public function getRestaurerActionTitle(): string
    {
        $composante = $this->getComposanteFromRoute();
        return sprintf("Restaurer la composante %s", $composante->getCode());
    }
    public function getActionsMenuTemplatePath(): ?string
    {
        return 'application/composante/composante/fragment/actions-menu';
    }
}