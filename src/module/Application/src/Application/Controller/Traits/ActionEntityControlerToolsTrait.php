<?php

namespace Application\Application\Controller\Traits;

use Application\Application\Form\AbstractEntityForm;
use Application\Application\Form\Misc\ConfirmationFormAwareTrait;
use Application\Application\Misc\RouterToolsTrait;
use Application\Application\Service\API\CommonEntityService;
use Application\Application\Validator\Actions\Traits\ActionsValidatorAwareTrait;
use Exception;
use Laminas\Permissions\Acl\Resource\ResourceInterface;

/** Trait permettant de fournir diverses fonctions au ActionEntityTrait */
trait ActionEntityControlerToolsTrait
{
    use RouterToolsTrait;

    /*****
     * Accés à l'entité manipulé
     *****/
    public function getEntityFromRoute(): ResourceInterface
    {
        $id = $this->getParamFromRoute($this->getEntityParam(), 0);
        $entity = $this->getEntityService()->find($id);
        if (!isset($entity)) {
            $msg = $this->getEntityNotFoundMessage();
            throw new Exception($msg);
        }
        return $entity;
    }

    /**
     * @return string
     */
    public abstract function getEntityParam(): string;
    /**
     * @return string
     */
    public abstract function getEntitiesParam(): string;
    /**
     * @return CommonEntityService
     */
    public abstract function getEntityService(): CommonEntityService;
    /**
     * @return string|null
     */
    public function getEntityNotFoundMessage(): ?string
    {
        return "L'entité demandée n'as pas été trouvée";
    }

    use ActionsValidatorAwareTrait;

    /**
     * @param string $action
     * @param array $data
     * @return bool
     */
    protected function assertAction(string $action, array $data=[]) : bool
    {
        if(!$this->getActionsValidator()){return true;}
        return $this->getActionsValidator()->isValid($action, $data);
    }

    protected function formatValidatorErrorMessage($title="Action non autorisée", $msg=null)
    {
        if ($msg === null) {
            $messages = $this->getActionsValidator()->getMessages();
            if (sizeof($messages) == 0) {
                $msg = "Vous n'êtes pas autorisé a effectué l'action demandée.";
            } else if (sizeof($messages) == 1) {
                $msg = current($messages);
            } else {
                $msg = "<ul>";
                foreach ($messages as $message) {
                    $msg .= sprintf("<li>%s</li>", $message);
                }
                $msg .= "</ul>";
            }
        }
        return $msg;
    }
    protected function renderNotAllowedAction($title="Action non autorisée", $msg=null){
        $msg = $this->formatValidatorErrorMessage($title, $msg);
        return $this->renderError($title, $msg);
    }

}