<?php

namespace Application\Controller\Configuration;


use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Application\Service\Step\StepMessageServiceAwareTrait;
use Application\Application\Service\Step\StepServiceAwareTrait;
use Application\Entity\Step;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Laminas\Http\Headers;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use UnicaenUtilisateur\Entity\Db\Role;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class ConfigurationController extends AbstractActionController
{
    use UserServiceAwareTrait;
    use InscriptionServiceAwareTrait;
    use StepServiceAwareTrait;
    use StepMessageServiceAwareTrait;

    /** ACTION */
    const ACTION_INDEX = "index";
    const ACTION_GET_DATA = "get_data";
    const ACTION_CHANGE_ORDER_API = "change_order_api";
    const ACTION_CHANGE_ORDER = "change_order";
    const ACTION_SAVE = "save";

    const ACTION_DELETE = "delete";

    const ACTION_ADD = "add";

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction() {
        $steps = $this->getStepService()->findAll();
        $roles = $this->getRoleService()->findAll();

        return new ViewModel(
            [
                'steps' => $steps,
                'roles' => $roles
            ]
        );
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function addAction() {
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $code = $data['stepCode'];
            $libelle = $data['stepName'];
            $validator = $data['stepValidator'];
            $role = $this->getRoleService()->find($validator);

            $step = new Step();
            $step->setCode($code);
            $step->setLibelle($libelle);
            $step->setMovable(true);
            $step->setFixed(false);
            $step->setDeletable(true);
            $step->setNeedValidation(true);
            $step->setRole($role);
            $step->setStatus(true);

            // set order to the last step beside the fixed steps, also change the order of the step ahead
            $lastStep = $this->getStepService()->findOneBy(['order' => $this->getStepService()->getMaxOrder()]);
            $stepsToUp = [];
            $order = null;
            while($order === null) {
                $stepsToUp[] = $lastStep;
                if($lastStep === null) {
                    return $this->redirect()->toRoute('Configuration');
                }else if($lastStep->getFixed()) {
                    $order = $lastStep->getOrder();
                }
                $lastStep = $this->getStepService()->getPreviousStep($lastStep);
            }
            $step->setOrder($order);
            foreach ($stepsToUp as $stepToUp) {
                $stepToUp->setOrder($stepToUp->getOrder() + 1);
                $this->getStepService()->update($stepToUp);
            }

            $this->getStepService()->add($step);
        }

        return $this->redirect()->toRoute('Configuration');
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteAction() {
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $code = $data['code'];
            $step = $this->getStepService()->findOneBy(['code' => $code]);
            if($step === null) {
                return $this->redirect()->toRoute('Configuration');
            }
            if(!$step->getDeletable()) {
                return $this->redirect()->toRoute('Configuration');
            }

            $previousStep = $this->getStepService()->getPreviousStep($step);
            $inscriptions = $this->getInscriptionService()->findAllBy(['step' => $step]);
            $inscriptionsToUpdate = [];
            foreach ($inscriptions as $inscription) {
                if($previousStep !== null) {
                    $inscription->setStep($previousStep);
                    $inscriptionsToUpdate[] = $inscription;
                }else {
                    return $this->redirect()->toRoute('Configuration');
                }
            }
            foreach ($inscriptionsToUpdate as $inscription) {
                $this->getInscriptionService()->update($inscription);
            }

            $stepMessages = $this->getStepMessageService()->findAllBy(['step' => $step]);
            foreach ($stepMessages as $stepMessage) {
                $this->getStepMessageService()->delete($stepMessage);
            }

            $newOrder = $step->getOrder();
            $nextStep = $this->getStepService()->getNextStep($step);
            while($nextStep !== null) {
                $nextStep->setOrder($newOrder);
                $this->getStepService()->update($nextStep);
                $newOrder++;
                $nextStep = $this->getStepService()->findOneBy(['order' => ($newOrder+1)]);
            }

            $this->getStepService()->delete($step);
        }

        return $this->redirect()->toRoute('Configuration');
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public  function saveAction() {
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            // transform JSON into array
            $array = json_decode($data['data']);
            foreach ($array as $key => $validator) {
                $step = $this->getStepService()->findOneBy(['code' => $key]);
                $role = $this->getRoleService()->findByRoleId($validator);
                if($role === null) {
                    return $this->redirect()->toRoute('Configuration');
                }
                $step->setRole($role);
                $this->getStepService()->update($step);
            }
        }

        return $this->redirect()->toRoute('Configuration');
    }

    public function saveOldAction() {
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
            $steps = $this->stepService->findAllBy([], ['order' => 'ASC']);
            $roles = $this->roleService->findAll();

            $jsonTxt = "[";
            /**
             * @var Step $step
             */
            foreach ($steps as $step)
            {
                $previousStep = $this->getStepService()->getPreviousStep($step);
                $nextStep = $this->getStepService()->getNextStep($step);
                if($previousStep === null) {
                    $previousStepFixed = false;
                }else {
                    $previousStepFixed = $previousStep->getFixed();
                }
                if($nextStep === null) {
                    $nextStepFixed = false;
                }else {
                    $nextStepFixed = $nextStep->getFixed();
                }

                $jsonTxt.="{";

                $jsonTxt.='"code": "'.htmlentities($step->getCode()).'",';
                $jsonTxt.='"name": "'.htmlentities($step->getLibelle()).'",';
//                $jsonTxt.='"needValidation": ["'.$step->getNeedValidation().'", "'.$step->getCode().'"],';
                if($step->getCode() === "course") {
                    $jsonTxt.='"validator": "<select disabled data-code=\''.$step->getCode().'\' class=\'form-select selectValidator\'>';
                    $jsonTxt.= '<option class=\'\' ';
                    $jsonTxt.= 'value=\'course\'>';
                    $jsonTxt.= 'Etudiant';
                    $jsonTxt.= '</option>';
                }else {
                    $jsonTxt.='"validator": "<select data-code=\''.$step->getCode().'\' class=\'form-select selectValidator\'>';
                    foreach ($roles as $r) {
                        $jsonTxt.= '<option class=\'\' ';
                        $jsonTxt.= 'value=\''.$r->getRoleId().'\'';
                        $jsonTxt.= ($step->getRole()->getRoleId() === $r->getRoleId()) ? 'selected>' : '>';
                        $jsonTxt.= $r->getLibelle();
                        $jsonTxt.= '</option>';
                    }
                }
                $jsonTxt.= '</select>",';
                $jsonTxt.='"order": "'.htmlentities($step->getOrder()).'",';
                $jsonTxt.='"move": ["'.htmlentities($step->getOrder()).'", "'.htmlentities($step->getCode()).'", "'.htmlentities($step->getMovable()).'", "'.htmlentities($step->getFixed()).'", "'.htmlentities($nextStepFixed).'", "'.htmlentities($previousStepFixed).'", "'.htmlentities($this->getStepService()->getMaxOrder()).'"],';
                $jsonTxt.='"action": ["'.htmlentities($step->getCode()).'", "'.htmlentities($step->getDeletable()).'"]';
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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function changeOrderAction(): Response
    {
        // check if there is a POST request, get the POST parameters and check if they are valid
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $direction = $data['direction'];
            $code = $data['code'];
            $step = $this->getStepService()->findOneBy(['code' => $code]);
            if($step === null) {
                return $this->redirect()->toRoute('Configuration');
            }
            $order = $step->getOrder();

            $stepToUpdate = null;
            if ($direction === 'up') {
                // get previous step and set its order to the current step's order and check if the previous step is not the first step and is not fixed
                if($order === 1 || $step->getFixed()) {
                    return $this->redirect()->toRoute('Configuration');
                }else {
                    $stepToUpdate = $this->getStepService()->getPreviousStep($step);
                    if(!$stepToUpdate->getFixed()){
                        $stepToUpdate->setOrder($order);
                        $step->setOrder($order - 1);
                    }else {
                        return $this->redirect()->toRoute('Configuration');
                    }
                }

            }else if ($direction === 'down') {
                // get next step and set its order to the current step's order
                if($order === $this->getStepService()->getMaxOrder() || $step->getFixed()) {
                    return $this->redirect()->toRoute('Configuration');
                }else {
                    $stepToUpdate = $this->getStepService()->getNextStep($step);
                    if(!$stepToUpdate->getFixed()){
                        $stepToUpdate->setOrder($order);
                        $step->setOrder($order + 1);
                    }else {
                        return $this->redirect()->toRoute('Configuration');
                    }
                }
            }

            try {
                $this->getStepService()->update($step);
                $this->getStepService()->update($stepToUpdate);
            } catch (\Exception $e) {
                var_dump($e);
                die();
            }

            return $this->redirect()->toRoute('Configuration');
        }else {
            return $this->redirect()->toRoute('home');
        }
    }

    public function changeOrderAPIAction() {
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