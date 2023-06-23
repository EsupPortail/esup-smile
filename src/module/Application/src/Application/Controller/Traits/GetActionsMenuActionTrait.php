<?php

namespace Application\Application\Controller\Traits;

use Exception;
use Laminas\Http\Response;
use Laminas\Stdlib\RequestInterface as Request;
use Laminas\View\Model\ViewModel;

/**
 * @method Request getRequest();
 */
trait GetActionsMenuActionTrait
{
    use ActionEntityControlerToolsTrait;
    public function getActionsMenuAction()
    {
        try {
            $entity = $this->getEntityFromRoute();
            if (!$this->assertAction(self::ACTION_GET_ACTIONS_MENU, [$this->getEntityParam() => $entity])) {
                throw new Exception("Action non autorisée");
            }
            $vm = new ViewModel([$this->getEntityParam() => $entity]);
            $templatePath = $this->getActionsMenuTemplatePath();
            if (isset($templatePath)) {
                $vm->setTemplate($templatePath);
            }
            return $vm;
        }
        catch (Exception $e){
            $response = new Response();
            $response->setStatusCode(Response::STATUS_CODE_303);
            $response->setContent($e->getMessage());
            return $response;
        }
    }

    /**
     * @return string
     */
    public function getActionsMenuTemplatePath(): ?string { return null;}
}