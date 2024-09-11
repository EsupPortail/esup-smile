<?php

namespace Application\Application\View\Helper\Composante;

use Application\Application\Entity\Traits\Entities\ComposanteAwareTrait;
use Application\Application\Validator\Actions\Traits\ActionsValidatorAwareTrait;
use Application\Application\View\Helper\Interfaces\EntityActionViewHelperInterface;
use Application\Application\View\Helper\Interfaces\HistoriqueActionViewHelperInterface;
use Application\Controller\Composante\ComposanteController;
use Application\Entity\Composante;
use Laminas\Form\Form;
use Laminas\View\Helper\AbstractHelper;

class ComposanteViewHelper extends AbstractHelper
    implements EntityActionViewHelperInterface,
    HistoriqueActionViewHelperInterface
{
    use ComposanteAwareTrait;
    use ActionsValidatorAwareTrait;

    /**
     * @param Composante $composante
     * @return self
     */
    public function __invoke(?Composante $composante = null) : ComposanteViewHelper
    {
        $this->setComposante($composante);
        return $this;
    }

    public function setComposante(?Composante $composante): void
    {
        $this->composante = $composante;
    }

    /**
     * @return string
     */
    public function renderListe(?array $composantes = []) : string
    {
        return $this->view->render('application/composante/composante/template/liste-composantes', ['composantes' => $composantes]);
    }

    public function renderForm(Form $form) : string
    {
        return $this->view->render('application/composante/composante/template/form-composante', ['form' => $form]);
    }

    /**
     * @return string
     */
    public function renderActionsMenu(): string
    {
        $data = ['composante' => $this->composante];
        if(!$this->getActionsValidator()->isValid(ComposanteController::ACTION_GET_ACTIONS_MENU, $data)){
            $html = sprintf("<span data-bs-toggle='tooltip' data-bs-html='true' 
                data-bs-placement='bottom' title=\"%s\">%s</span>",
                "Aucune action autorisée",
                self::MENU_ICONE);
            return $html;
        }
        $data = ['composante' => $this->composante->getId()];
        $url = $this->view->url(ComposanteController::ROUTE_GET_ACTIONS_MENU, $data, [], true);
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
        $data = ['composante' => $this->composante];
        if(!$this->getActionsValidator()->isValid(ComposanteController::ACTION_AFFICHER, $data)){return "";}

        $data = ['composante' => $this->composante->getId()];
        $html = sprintf("<a class='%s' title='%s' href='%s'>%s %s</a>",
            self::AFFICHER_LINK_CLASS,
            "Afficher la composante ".$this->composante->getAcronyme(),
            $this->view->url(ComposanteController::ROUTE_AFFICHER, $data, [], true),
            self::AFFICHER_LINK_ICONE,
            self::AFFICHER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienAjouter(): string
    {
        if(!$this->getActionsValidator()->isValid(ComposanteController::ACTION_AJOUTER, [])){return "";}
        $html = sprintf("<a class='%s ajax-modal' data-event='%s'  title='%s' href='%s'>%s %s</a>",
            self::AJOUTER_LINK_CLASS,
            ComposanteController::EVENT_AJOUTER,
            "Ajouter une composante",
            $this->view->url(ComposanteController::ROUTE_AJOUTER, [], [], true),
            self::AJOUTER_LINK_ICONE,
            self::AJOUTER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienModifier(): string
    {
        $data = ['composante' => $this->composante];
        if(!$this->getActionsValidator()->isValid(ComposanteController::ACTION_MODIFIER, $data)){return "";}

        $data = ['composante' => $this->composante->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::MODIFIER_LINK_CLASS,
            ComposanteController::EVENT_MODIFIER,
            "Modifier la composante ".$this->composante->getAcronyme(),
            $this->view->url(ComposanteController::ROUTE_MODIFIER, $data, [], true),
            self::MODIFIER_LINK_ICONE,
            self::MODIFIER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienSupprimer(): string
    {
        $data = ['composante' => $this->composante];
        if(!$this->getActionsValidator()->isValid(ComposanteController::ACTION_SUPPRIMER, $data)){return "";}

        $data = ['composante' => $this->composante->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s'  title='%s' href='%s'>%s %s</a>",
            self::SUPPRIMER_LINK_CLASS,
            ComposanteController::EVENT_SUPPRIMER,
            "Supprimer la composante ".$this->composante->getAcronyme(),
            $this->view->url(ComposanteController::ROUTE_SUPPRIMER, $data, [], true),
            self::SUPPRIMER_LINK_ICONE,
            self::SUPPRIMER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienArchiver(): string
    {
        $data = ['composante' => $this->composante];
        if(!$this->getActionsValidator()->isValid(ComposanteController::ACTION_ARCHIVER, $data)){return "";}

        $data = ['composante' => $this->composante->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s'  title='%s' href='%s'>%s %s</a>",
            self::ARCHIVER_LINK_CLASS,
            ComposanteController::EVENT_ARCHIVER,
            "Archiver la composante ".$this->composante->getAcronyme(),
            $this->view->url(ComposanteController::ROUTE_ARCHIVER, $data, [], true),
            self::ARCHIVER_LINK_ICONE,
            self::ARCHIVER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienRestaurer(): string
    {
        $data = ['composante' => $this->composante];
        if(!$this->getActionsValidator()->isValid(ComposanteController::ACTION_RESTAURER, $data)){return "";}

        $data = ['composante' => $this->composante->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s'  title='%s' href='%s'>%s %s</a>",
            self::RESTAURER_LINK_CLASS,
            ComposanteController::EVENT_RESTAURER,
            "Restaurer la composante ".$this->composante->getAcronyme(),
            $this->view->url(ComposanteController::ROUTE_RESTAURER, $data, [], true),
            self::RESTAURER_LINK_ICONE,
            self::RESTAURER_LINK_LABEL,
        );
        return $html;
    }
}