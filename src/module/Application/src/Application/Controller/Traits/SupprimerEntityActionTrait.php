<?php

namespace Application\Application\Controller\Traits;

use Application\Application\Form\AbstractEntityForm;
use Application\Application\Form\Misc\ConfirmationFormAwareTrait;
use Exception;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\Stdlib\RequestInterface as Request;
use Laminas\View\Model\ViewModel;

/**
 * @method FlashMessenger flashMessenger();
 * @method Request getRequest();
 */
trait SupprimerEntityActionTrait
{
    function supprimerAction(): ViewModel
    {
        try {
            $title = $this->getSupprimerActionTitle();
            $entity = $this->getEntityFromRoute();

            if(!$this->assertAction(self::ACTION_SUPPRIMER, [$this->getEntityParam() => $entity])){
                return $this->renderNotAllowedAction($title);
            }

            $form = $this->getConfirmationForm();
            $question = $this->getSupprimerConfirmationMessage();
            $form->setQuestion($question);
            $request = $this->getRequest();
            if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->hasBeenConfirm()) {
                    $this->getEntityService()->delete($entity);
                    $msg = $this->getSupprimerSuccessMessage();
                    if(isset($msg) && $msg != ""){
                        $this->flashMessenger()->addSuccessMessage($msg);
                    }
                }
            }
            return new ViewModel(['title' => $title, 'form' => $form]);
        }
        catch (Exception $e) {
            return $this->renderError($title, $e->getMessage());
        }
    }

    use ActionEntityControlerToolsTrait;
    use ConfirmationFormAwareTrait;

    /**
     * @return string
     */
    public function getSupprimerActionTitle(): string {return "Supprimer";}
    /**
     * @return string
     */
    public function getSupprimerSuccessMessage(): string {return "Suppression effecutée";}
    /**
     * @return string
     */
    public function getSupprimerConfirmationMessage(): string
    {
        return "La suppression est définitive. Etes-vous sûr&middot;e de vouloir continuer ?";
    }

}