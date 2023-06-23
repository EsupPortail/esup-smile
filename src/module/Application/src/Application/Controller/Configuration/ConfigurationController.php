<?php

namespace Application\Controller\Configuration;


use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Application\Service\Step\StepServiceAwareTrait;
use Application\Entity\Step;
use Doctrine\ORM\EntityManager;
use Laminas\Http\Headers;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class ConfigurationController extends AbstractActionController
{
    use UserServiceAwareTrait;
    use InscriptionServiceAwareTrait;
    use StepServiceAwareTrait;

    /** ACTION */
    const ACTION_INDEX = "index";
    const ACTION_GET_DATA = "get_data";
    const ACTION_CHANGE_ORDER = "change_order";
    const ACTION_SAVE = "save";

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction() {
        $steps = $this->stepService->findAll();

        return new ViewModel(['steps' => $steps]);
    }

    public function saveAction() {
        if ($this->getRequest()->isPost()) {
            $response = new Response();

            $data = $this->getRequest()->getContent();
            $array = json_decode($data);
            $type = $array->type;
            $code = $array->code;
            $step = $this->stepService->findOneBy(['code' => $code]);

            if ($type === 'checkValidation') {
                try {
                    $step->setNeedValidation(!$step->getNeedValidation());
                    $this->stepService->update($step);
                }catch (\Exception $e) {
                    $response->setStatusCode(501);
                    $response->setContent($e->getMessage());
                    return $response;
                }

            }

            $response->setContent(json_encode($array));
            return $response;
        }else {
            return '';
        }
    }

    public function getDataAction(): Response
    {
        if($this->getRequest()->isPost()) {
            $steps = $this->stepService->findAll();
            $roles = $this->roleService->findAll();

            $jsonTxt = "[";
            /**
             * @var Step $step
             */
            foreach ($steps as $step)
            {
                $jsonTxt.="{";

                $jsonTxt.='"code": "'.htmlentities($step->getCode()).'",';
                $jsonTxt.='"name": "'.htmlentities($step->getLibelle()).'",';
                $jsonTxt.='"needValidation": ["'.$step->getNeedValidation().'", "'.$step->getCode().'"],';
                $jsonTxt.='"validator": "<select class=\'form-select\'>';
                foreach ($roles as $r) {
                    $jsonTxt.= '<option class=\'\' ';
                    $jsonTxt.= 'value=\''.$r->getRoleId().'\'';
                    $jsonTxt.= ($step->getRole()->getRoleId() === $r->getRoleId()) ? 'selected>' : '>';
                    $jsonTxt.= $r->getLibelle();
                    $jsonTxt.= '</option>';
                }
                $jsonTxt.= '</select>",';
                $jsonTxt.='"order": ["'.htmlentities($step->getOrder()).'", "'.htmlentities($step->getCode()).'"]';
//                $jsonTxt.='"order": "'.htmlentities($step->getOrder()).' <i data-id=\''.$step->getCode().'\' class=\'fa-solid fa-arrow-up changeOrder\'></i> <i data-id=\''.$step->getCode().'\' class=\'fa-solid fa-arrow-down changeOrder\'></i>"';

                if ($step === end($steps)) {
                    $jsonTxt.="}";
                } else {
                    $jsonTxt.="},";
                }
            }
            $jsonTxt .= "]";

            $stepsJson = json_encode($jsonTxt);

            $response = new Response();
            $response->setContent($stepsJson);
            return $response;
        }else {
            return $this->redirect()->toRoute('home');
        }
    }

    public function changeOrderAction() {
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getContent();
            $response = new Response();
            $headers = new Headers();
            $headers->addHeaders(['Content-Type' => 'application/json']);
            $response->setHeaders($headers);
            $response->setContent(json_encode($data));
//            $response->setContent('[{"yoh": "ouais"}]');
            return $response;
        }else {
            $response = new Response();
            $response->setStatusCode(400);
            return $response;
        }
    }

}