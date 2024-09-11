<?php

namespace Application\Application\Controller\Traits;

use  Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Form\Misc\ConfirmationFormAwareTrait;
use Application\Application\Service\API\HistoServiceInterface;
use Exception;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\Stdlib\RequestInterface as Request;
use Laminas\View\Model\ViewModel;

/**
 * @method FlashMessenger flashMessenger();
 * @method Request getRequest();
 */
trait RestaurerEntityActionTrait
{
    function restaurerAction(): ViewModel
    {
        try {
            $title = $this->getRestaurerActionTitle();
            $entity = $this->getEntityFromRoute();

            if(!$this->assertAction(self::ACTION_RESTAURER, [$this->getEntityParam() => $entity])){
                return $this->renderNotAllowedAction($title);
            }

            /** @var HistoServiceInterface $service */
            $service = $this->getEntityService();
            if(!$entity instanceof HistoriqueAwareInterface || !$service instanceof HistoServiceInterface){
                throw new Exception("L'entité demandé ne peux pas être archivée");
            }

            $form = $this->getConfirmationForm();
            $question = $this->getRestaurerConfirmationMessage();
            $form->setQuestion($question);


            $request = $this->getRequest();
            if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->hasBeenConfirm()) {
                    $service->restaurerEntity($entity);
                    $msg = $this->getRestaurerSuccessMessage();
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
    public function getRestaurerActionTitle(): string {return "Restaurer";}
    /**
     * @return string
     */
    public function getRestaurerSuccessMessage(): string {return "Restauration effectuée";}
     /**
     * @return string
     */
    public function getRestaurerConfirmationMessage(): string {return "Etes-vous sûr&middot;e de vouloir continuer ?";}

}