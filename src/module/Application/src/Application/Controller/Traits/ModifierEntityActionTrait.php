<?php

namespace Application\Application\Controller\Traits;

use Application\Application\Form\AbstractEntityForm;
use Exception;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\ViewModel;

/**
 * @method FlashMessenger flashMessenger();
 */
trait ModifierEntityActionTrait
{
    public function modifierAction(): ViewModel
    {
        try {
            $title = $this->getModifierActionTitle();
            $entity = $this->getEntityFromRoute();

            if(!$this->assertAction(self::ACTION_MODIFIER, [$this->getEntityParam() => $entity])){
                return $this->renderNotAllowedAction($title);
            }

            $form = $this->getModifierForm();
            $form->bind($entity);
            if ($data = $this->params()->fromPost()) {
                $form->setData($data);
                if ($form->isValid()) {
                    $entity = $form->getObject();
                    $this->getEntityService()->update($entity);
                    $msg = $this->getModifierSuccessMessage();
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
    public function getModifierActionTitle(): string {return "Modifier";}

    /**
     * @return string
     */
    public function getModifierSuccessMessage(): string  {return "Modification effecutée";}

    /**
     * @return AbstractEntityForm
     */
    public abstract function getModifierForm(): AbstractEntityForm;

}