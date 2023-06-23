<?php

namespace Application\Application\View\Helper\Formation;

use Application\Application\Entity\Traits\Entities\TypeDiplomeAwareTrait;
use Application\Application\Validator\Actions\Traits\ActionsValidatorAwareTrait;
use Application\Application\View\Helper\Interfaces\EntityActionViewHelperInterface;
use Application\Controller\Formation\TypeDiplomeController;
use Application\Entity\TypeDiplome;
use Exception;
use Laminas\Form\Form;
use Laminas\View\Helper\AbstractHelper;

class TypeDiplomeViewHelper extends AbstractHelper
    implements EntityActionViewHelperInterface
{
    use TypeDiplomeAwareTrait;
    use ActionsValidatorAwareTrait;

    /**
     * @param TypeDiplome $typeDiplome
     * @return self
     */
    public function __invoke(?TypeDiplome $typeDiplome = null): TypeDiplomeViewHelper
    {
        $this->setTypeDiplome($typeDiplome);
        return $this;
    }

    public function setTypeDiplome(?TypeDiplome $typeDiplome): void
    {
        $this->typeDiplome = $typeDiplome;
    }

    /**
     * @return string
     */
    public function renderListe(?array $typesDiplomes = []): string
    {
        return $this->view->render('application/formation/type-diplome/template/liste-types-diplomes', ['typesDiplomes' => $typesDiplomes]);
    }

    public function renderForm(Form $form): string
    {
        return $this->view->render('application/formation/type-diplome/template/form-type-diplome', ['form' => $form]);
    }

    /**
     * @return string
     */
    public function renderActionsMenu(): string
    {
        $data = ['typeDiplome' => $this->typeDiplome];
        if(!$this->getActionsValidator()->isValid(TypeDiplomeController::ACTION_GET_ACTIONS_MENU, $data)){
            $html = sprintf("<span data-bs-toggle='tooltip' data-bs-html='true' 
                data-bs-placement='bottom' title=\"%s\">%s</span>",
                "Aucune action autorisée",
                self::MENU_ICONE);
            return $html;
        }
        $data = ['typeDiplome' => $this->typeDiplome->getId()];
        $url = $this->view->url(TypeDiplomeController::ROUTE_GET_ACTIONS_MENU, $data, [], true);
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
        throw new Exception("La fiche des types de diplômes n'est pas implémenté");
    }

    function renderLienAjouter(): string
    {
        if(!$this->getActionsValidator()->isValid(TypeDiplomeController::ACTION_AJOUTER, [])){return "";}
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::AJOUTER_LINK_CLASS,
            TypeDiplomeController::EVENT_AJOUTER,
            "Ajouter un type diplome",
            $this->view->url(TypeDiplomeController::ROUTE_AJOUTER, [], [], true),
            self::AJOUTER_LINK_ICONE,
            self::AJOUTER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienModifier(): string
    {
        $data = ['typeDiplome' => $this->typeDiplome];
        if(!$this->getActionsValidator()->isValid(TypeDiplomeController::ACTION_MODIFIER, $data)){return "";}

        $data = ['typeDiplome' => $this->typeDiplome->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::MODIFIER_LINK_CLASS,
            TypeDiplomeController::EVENT_MODIFIER,
            "Modifier le type de diplome ".$this->typeDiplome->getAcronyme(),
            $this->view->url(TypeDiplomeController::ROUTE_MODIFIER, $data, [], true),
            self::MODIFIER_LINK_ICONE,
            self::MODIFIER_LINK_LABEL,
        );
        return $html;
    }

    function renderLienSupprimer(): string
    {
        $data = ['typeDiplome' => $this->typeDiplome];
        if(!$this->getActionsValidator()->isValid(TypeDiplomeController::ACTION_SUPPRIMER, $data)){return "";}

        $data = ['typeDiplome' => $this->typeDiplome->getId()];
        $html = sprintf("<a class='%s ajax-modal' data-event='%s' title='%s' href='%s'>%s %s</a>",
            self::SUPPRIMER_LINK_CLASS,
            TypeDiplomeController::EVENT_SUPPRIMER,
            "Supprimer le type de diplome ".$this->typeDiplome->getAcronyme(),
            $this->view->url(TypeDiplomeController::ROUTE_SUPPRIMER, $data, [], true),
            self::SUPPRIMER_LINK_ICONE,
            self::SUPPRIMER_LINK_LABEL,
        );
        return $html;
    }

}