<?php

namespace Application\Application\View\Helper\Formation;

use Application\Application\Entity\Traits\Entities\TypeFormationAwareTrait;
use Application\Application\Validator\Actions\Traits\ActionsValidatorAwareTrait;
use Application\Application\View\Helper\Interfaces\EntityActionViewHelperInterface;
use Application\Application\View\Helper\Interfaces\HistoriqueActionViewHelperInterface;
use Application\Controller\Formation\TypeFormationController;
use Application\Entity\TypeFormation;
use Exception;
use Laminas\Form\Form;
use Laminas\View\Helper\AbstractHelper;

class TypeFormationViewHelper extends AbstractHelper
    implements EntityActionViewHelperInterface
{
    use TypeFormationAwareTrait;
    use ActionsValidatorAwareTrait;

    /**
     * @param TypeFormation $typeFormation
     * @return self
     */
    public function __invoke(?TypeFormation $typeFormation = null): TypeFormationViewHelper
    {
        $this->setTypeFormation($typeFormation);
        return $this;
    }

    public function setTypeFormation(?TypeFormation $typeFormation): void
    {
        $this->typeFormation = $typeFormation;
    }

    /**
     * @return string
     */
    public function renderListe(?array $typesFormations = []): string
    {
        return $this->view->render('application/formation/type-formation/template/liste-types-formations', ['typesFormations' => $typesFormations]);
    }

    public function renderForm(Form $form): string
    {
        return $this->view->render('application/formation/type-formation/template/form-type-formation', ['form' => $form]);
    }

    /**
     * @return string
     */
    public function renderActionsMenu(): string
    {
        $data = ['typeFormation' => $this->typeFormation];
        if(!$this->getActionsValidator()->isValid(TypeFormationController::ACTION_GET_ACTIONS_MENU, $data)){
            $html = sprintf("<span data-bs-toggle='tooltip' data-bs-html='true' 
                data-bs-placement='bottom' title=\"%s\">%s</span>",
                "Aucune action autorisée",
                self::MENU_ICONE);
            return $html;
        }
        $data = ['typeFormation' => $this->typeFormation->getId()];
        $url = $this->view->url(TypeFormationController::ROUTE_GET_ACTIONS_MENU, $data, [], true);
        $uid = uniqid();
        $actionsProviderId = 'actions-provider_' . $uid;
        $actionsBtnId = 'actions-btn_' . $uid;
        $html = sprintf("<span id='%s' data-url='%s'>", $actionsProviderId, $url);
        $html .= sprintf("<span id='%s' class='%s text-red'>",
            $actionsBtnId, self::MENU_LINK_CLASS,
        );
        $html .= sprintf("%s", self::MENU_ICONE);
        $html .= "</span>";
        //Permet de s'assurer que la fonction sera appelé, même si le liens est paginé par data-table. PB : le init est appelé trés souvent, pas forcément mieux
        $js = '$("#' . $actionsBtnId . '").on("click", function(){$("#' . $actionsProviderId . '").refresh()});';
        $html .= PHP_EOL . "<script>" . $js . "</script>" . PHP_EOL;
        $html .= "</span>";
        return $html;
    }

    function renderLienAfficher(): string
    {
        throw new Exception("Les fiches des types de diplomes ne sont pas implémentés.");
    }

    function renderLienAjouter(): string
    {
        if(!$this->getActionsValidator()->isValid(TypeFormationController::ACTION_AJOUTER, [])){return "";}
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::AJOUTER_LINK_CLASS,
            TypeFormationController::EVENT_AJOUTER,
            "Ajouter une formation",
            $this->view->url(TypeFormationController::ROUTE_AJOUTER, [], [], true),
            self::AJOUTER_LINK_ICONE,
            self::AJOUTER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienModifier(): string
    {
        $data = ['typeFormation' => $this->typeFormation];
        if(!$this->getActionsValidator()->isValid(TypeFormationController::ACTION_MODIFIER, $data)){return "";}

        $data = ['typeFormation' => $this->typeFormation->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::MODIFIER_LINK_CLASS,
            TypeFormationController::EVENT_MODIFIER,
            "Modifier le type de formation ".$this->typeFormation->getAcronyme(),
            $this->view->url(TypeFormationController::ROUTE_MODIFIER, $data, [], true),
            self::MODIFIER_LINK_ICONE,
            self::MODIFIER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienSupprimer(): string
    {
        $data = ['typeFormation' => $this->typeFormation];
        if(!$this->getActionsValidator()->isValid(TypeFormationController::ACTION_SUPPRIMER, $data)){return "";}

        $data = ['typeFormation' => $this->typeFormation->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::SUPPRIMER_LINK_CLASS,
            TypeFormationController::EVENT_SUPPRIMER,
            "Supprimer le type de formation ".$this->typeFormation->getAcronyme(),
            $this->view->url(TypeFormationController::ROUTE_SUPPRIMER, $data, [], true),
            self::SUPPRIMER_LINK_ICONE,
            self::SUPPRIMER_LINK_LABEL,
        );
        return $html;
    }

}