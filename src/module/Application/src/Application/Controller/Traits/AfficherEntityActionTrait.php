<?php

namespace Application\Application\Controller\Traits;

use Exception;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\ViewModel;

/**
 * @method FlashMessenger flashMessenger();
 */
trait AfficherEntityActionTrait
{
    public function afficherAction(): ViewModel
    {
        try {
            $entity = $this->getEntityFromRoute();
            $title = $this->getAfficherActionTitle();
            if(!$this->assertAction(self::ACTION_AFFICHER, [$this->getEntityParam() => $entity])){
                return $this->renderNotAllowedAction($title);
            }
            return new ViewModel(['title' => $title, $this->getEntityParam() => $entity]);
        }
        catch (Exception $e) {
            return $this->renderError($title, $e->getMessage());
        }
    }

    use ActionEntityControlerToolsTrait;

    /**
     * @param mixed $entity
     * @return string
     */
    public function getAfficherActionTitle(): string {return "Fiche";}

}