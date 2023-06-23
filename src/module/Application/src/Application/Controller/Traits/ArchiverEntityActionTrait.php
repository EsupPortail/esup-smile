<?php

namespace Application\Application\Controller\Traits;

use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Form\AbstractEntityForm;
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
trait ArchiverEntityActionTrait
{
    function archiverAction(): ViewModel
    {
        try {
            $title = $this->getArchiverActionTitle();
            $entity = $this->getEntityFromRoute();
            /** @var HistoServiceInterface $service */
            $service = $this->getEntityService();
            if(!$entity instanceof HistoriqueAwareInterface || !$service instanceof HistoServiceInterface){
                throw new Exception("L'entité demandée ne peux pas être restaurée");
            }

            if(!$this->assertAction(self::ACTION_ARCHIVER, [$this->getEntityParam() => $entity])){
                return $this->renderNotAllowedAction($title);
            }

            $form = $this->getConfirmationForm();
            $question = $this->getArchiverConfirmationMessage();
            $form->setQuestion($question);

            $request = $this->getRequest();
            if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->hasBeenConfirm()) {
                    $service->archiverEntity($entity);
                    $msg = $this->getArchiverSuccessMessage();
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
    public function getArchiverActionTitle(): string { return "Archiver";}
    /**
     * @return string
     */
    public function getArchiverSuccessMessage(): string { return "Donnée archivée"; }

    /**
     * @return string
     */
    public function getArchiverConfirmationMessage(): string
    {
        return "Etes-vous sûr&middot;e de vouloir continuer ?";
    }

}