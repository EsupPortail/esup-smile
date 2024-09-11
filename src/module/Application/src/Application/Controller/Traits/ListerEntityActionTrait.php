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
trait ListerEntityActionTrait
{
    public function listerAction(): ViewModel
    {
        try {
            if(!$this->assertAction(self::ACTION_LISTER)){
                return $this->renderNotAllowedAction();
            }
            $entities = $this->getEntityService()->findAll();
            return new ViewModel([$this->getEntitiesParam() => $entities]);
        }
        catch (Exception $e) {
            return $this->renderError(null, $e->getMessage());
        }
    }
    use ActionEntityControlerToolsTrait;

}