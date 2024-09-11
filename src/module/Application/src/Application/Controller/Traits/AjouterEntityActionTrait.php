<?php

namespace Application\Application\Controller\Traits;

use Application\Application\Controller\Interfaces\EntityControllerInterface;
use Application\Application\Form\AbstractEntityForm;
use Exception;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\ViewModel;

/**
 * @method FlashMessenger flashMessenger();
 */
trait AjouterEntityActionTrait
{
    public function ajouterAction(): ViewModel
    {
        try {
            $title = $this->getAjouterActionTitle();
            $form = $this->getAjouterForm();
            if(!$this->assertAction(self::ACTION_AJOUTER)){
                return $this->renderNotAllowedAction($title);
            }

            if ($data = $this->params()->fromPost()) {
                $form->setData($data);
                if ($form->isValid()) {
                    $entity = $form->getObject();
                    $this->getEntityService()->add($entity);
                    $msg = $this->getAjouterSuccessMessage();
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

    /**
     * @return string
     */
    public function getAjouterActionTitle(): string {return "Ajouter";}

    /**
     * @return string
     */
    public function getAjouterSuccessMessage(): string {return "Ajout effecuté";}

    /**
     * @return AbstractEntityForm
     */
    public abstract function getAjouterForm(): AbstractEntityForm;
}