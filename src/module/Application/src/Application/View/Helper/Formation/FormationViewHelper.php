<?php

namespace Application\Application\View\Helper\Formation;

use Application\Application\Entity\Traits\Entities\FormationAwareTrait;
use Application\Application\Validator\Actions\Traits\ActionsValidatorAwareTrait;
use Application\Application\View\Helper\Interfaces\EntityActionViewHelperInterface;
use Application\Application\View\Helper\Interfaces\HistoriqueActionViewHelperInterface;
use Application\Controller\Formation\FormationController;
use Application\Entity\Formation;
use Laminas\Form\Form;
use Laminas\View\Helper\AbstractHelper;

class FormationViewHelper extends AbstractHelper
    implements EntityActionViewHelperInterface, HistoriqueActionViewHelperInterface
{
    use FormationAwareTrait;
    use ActionsValidatorAwareTrait;

    /**
     * @param Formation $formation
     * @return self
     */
    public function __invoke(?Formation $formation = null) : FormationViewHelper
    {
        $this->setFormation($formation);
        return $this;
    }

    public function setFormation(?Formation $formation): void
    {
        $this->formation = $formation;
    }

    /**
     * @return string
     */
    public function renderListe(?array $formations = []) : string
    {
        return $this->view->render('application/formation/formation/template/liste-formations', ['formations' => $formations]);
    }

    public function renderForm(Form $form) : string
    {
        return $this->view->render('application/formation/formation/template/form-formation', ['form' => $form]);
    }

    /**
     * @return string
     */
    public function renderActionsMenu(): string
    {
        $data = ['formation' => $this->formation];
        if(!$this->getActionsValidator()->isValid(FormationController::ACTION_GET_ACTIONS_MENU, $data)){
            $html = sprintf("<span data-bs-toggle='tooltip' data-bs-html='true' 
                data-bs-placement='bottom' title=\"%s\">%s</span>",
                "Aucune action autorisée",
                self::MENU_ICONE);
            return $html;
        }
        $data = ['formation' => $this->formation->getId()];
        $url = $this->view->url(FormationController::ROUTE_GET_ACTIONS_MENU, $data, [], true);
        $uid = uniqid();
        $actionsProviderId = 'actions-provider_' . $uid;
        $actionsBtnId = 'actions-btn_' . $uid;
        $html = sprintf("<span id='%s' data-url='%s'>", $actionsProviderId, $url);
        $html .= sprintf("<span id='%s' class='%s'>",
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
        $data = ['formation' => $this->formation];
        if(!$this->getActionsValidator()->isValid(FormationController::ACTION_AFFICHER, $data)){return "";}

        $data = ['formation' => $this->formation->getId()];
        $html = sprintf("<a class='%s' title='%s' href='%s'>%s %s</a>",
            self::AFFICHER_LINK_CLASS,
            "Afficher la formation ".$this->formation->getAcronyme(),
            $this->view->url(FormationController::ROUTE_AFFICHER, $data, [], true),
            self::AFFICHER_LINK_ICONE,
            self::AFFICHER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienAjouter(): string
    {
        if(!$this->getActionsValidator()->isValid(FormationController::ACTION_AJOUTER, [])){return "";}
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::AJOUTER_LINK_CLASS,
            FormationController::EVENT_AJOUTER,
            "Ajouter une formation",
            $this->view->url(FormationController::ROUTE_AJOUTER, [], [], true),
            self::AJOUTER_LINK_ICONE,
            self::AJOUTER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienModifier(): string
    {
        $data = ['formation' => $this->formation];
        if(!$this->getActionsValidator()->isValid(FormationController::ACTION_MODIFIER, $data)){return "";}

        $data = ['formation' => $this->formation->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::MODIFIER_LINK_CLASS,
            FormationController::EVENT_MODIFIER,
            "Modifier la formation ".$this->formation->getAcronyme(),
            $this->view->url(FormationController::ROUTE_MODIFIER, $data, [], true),
            self::MODIFIER_LINK_ICONE,
            self::MODIFIER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienSupprimer(): string
    {
        $data = ['formation' => $this->formation];
        if(!$this->getActionsValidator()->isValid(FormationController::ACTION_SUPPRIMER, $data)){return "";}

        $data = ['formation' => $this->formation->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::SUPPRIMER_LINK_CLASS,
            FormationController::EVENT_SUPPRIMER,
            "Supprimer la formation ".$this->formation->getAcronyme(),
            $this->view->url(FormationController::ROUTE_SUPPRIMER, $data, [], true),
            self::SUPPRIMER_LINK_ICONE,
            self::SUPPRIMER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienArchiver(): string
    {
        $data = ['formation' => $this->formation];
        if(!$this->getActionsValidator()->isValid(FormationController::ACTION_ARCHIVER, $data)){return "";}

        $data = ['formation' => $this->formation->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::ARCHIVER_LINK_CLASS,
            FormationController::EVENT_ARCHIVER,
            "Archiver la formation ".$this->formation->getAcronyme(),
            $this->view->url(FormationController::ROUTE_ARCHIVER, $data, [], true),
            self::ARCHIVER_LINK_ICONE,
            self::ARCHIVER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienRestaurer(): string
    {
        $data = ['formation' => $this->formation];
        if(!$this->getActionsValidator()->isValid(FormationController::ACTION_RESTAURER, $data)){return "";}

        $data = ['formation' => $this->formation->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::RESTAURER_LINK_CLASS,
            FormationController::EVENT_RESTAURER,
            "Restaurer la formation ".$this->formation->getAcronyme(),
            $this->view->url(FormationController::ROUTE_RESTAURER, $data, [], true),
            self::RESTAURER_LINK_ICONE,
            self::RESTAURER_LINK_LABEL,
        );
        return $html;
    }
}