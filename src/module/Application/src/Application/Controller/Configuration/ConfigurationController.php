<?php

namespace Application\Controller\Configuration;


use Application\Application\Service\Composante\ComposanteServiceAwareTrait;
use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Application\Service\Step\StepMessageServiceAwareTrait;
use Application\Application\Service\Step\StepServiceAwareTrait;
use Application\Entity\ComposanteGroupe;
use Application\Entity\Step;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Laminas\Http\Headers;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use UnicaenUtilisateur\Entity\Db\Role;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;
use UnicaenVue\View\Model\AxiosModel;
use UnicaenVue\View\Model\VueModel;

class ConfigurationController extends AbstractActionController
{
    use UserServiceAwareTrait;
    use InscriptionServiceAwareTrait;
    use StepServiceAwareTrait;
    use StepMessageServiceAwareTrait;
    use ComposanteServiceAwareTrait;

    /** ACTION */
    const ACTION_INDEX = "index";
    const ACTION_CALENDAR = "calendar";
    const ACTION_GET_DATA = "get_data";
    const ACTION_CHANGE_ORDER_API = "change_order_api";
    const ACTION_CHANGE_ORDER = "change_order";
    const ACTION_SAVE = "save";

    const ACTION_DELETE = "delete";

    const ACTION_ADD = "add";
    const ACTION_ADD_ATTRIBUTION = "add_attribution";
    const ACTION_REMOVE_ATTRIBUTION = "remove_attribution";
    const ACTION_ADD_COMPOSANTE_TO_GROUP = "add_composante_to_group";
    const ACTION_REMOVE_COMPOSANTE_TO_GROUP = "remove_composante_to_group";
    const ACTION_ADD_GROUP = "add_group";
    const ACTION_DELETE_GROUP = "delete_group";
    const ACTION_GET_DATA_COMPOSANTE_GROUP = "get_data_composante_group";
    const ACTION_GESTIONNAIRE_COMPOSANTE = "gestionnaire_composante";

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

    public function calendarAction() {

        $vm = new VueModel(
            [
            ]
        );
        $vm->setTemplate('configuration/calendar');
        return $vm;
    }

    public function gestionnaireComposanteAction () {
        $composanteGroupes = $this->getComposanteService()->getComposanteGroupes();

        $role = $this->getRoleService()->findByRoleId('gestionnaire');
        $users = $this->getUserService()->findByRole($role);
        $gestionnaires = [];
        $composanteGroupesArray = [];
        $composantes = $this->getComposanteService()->findAll();
        $composantesArray = [];
        foreach ($composantes as $c) {
            $composantesArray[$c->getId()] = $c->toArray();
        }

        foreach ($users as $u) {
            $gestionnaires[$u->getId()] = [
                'id' => $u->getId(),
                'displayName' => $u->getDisplayName(),
                'email' => $u->getEmail(),
                'username' => $u->getUsername(),
                'composanteGroupes' => []
            ];
            foreach ($composanteGroupes as $cg) {
                $composanteGroupesArray[$cg->getId()] = $cg->toArray();
                $composanteGroupesArray[$cg->getId()]['composantes'] = [];
                $users = $cg->getUsers();
                if(!$users) {
                    continue;
                }
                if ($users->contains($u)){
                    $gestionnaires[$u->getId()]['composanteGroupe'][] = $cg;
                }
            }
        }

        $vm = new VueModel(
            [
                'gestionnaires' => $gestionnaires,
                'composanteGroupesDefault' => $composanteGroupesArray,
                'composantesDefault' => $composantesArray
            ]
        );
        $vm->setTemplate('configuration/gestionnaire-composante');
        return $vm;
    }

    public function addAttributionAction(): AxiosModel
    {
        if($this->getRequest()->isPost()) {
            $jsonData = $this->getRequest()->getContent();
            $data = json_decode($jsonData, true);
            $user = $data['user'];
            $user = $this->getUserService()->findByUsername($user['username']);
            $cg = $data['cg'];
            $cg = $this->getComposanteService()->getComposanteGroupe($cg['id']);
            $cg->addUser($user);
            $this->getComposanteService()->updateGroup($cg);
            return new AxiosModel($data);
        }
        return new AxiosModel;
    }

    public function removeAttributionAction(): AxiosModel
    {
        if($this->getRequest()->isPost()) {
            $jsonData = $this->getRequest()->getContent();
            $data = json_decode($jsonData, true);
            $user = $data['user'];
            $user = $this->getUserService()->findByUsername($user['username']);
            $cg = $data['cg'];
            $cg = $this->getComposanteService()->getComposanteGroupe($cg['id']);
            $cg->getUsers()->removeElement($user);
            $this->getComposanteService()->updateGroup($cg);
            return new AxiosModel($data);
        }
        return new AxiosModel;
    }

    public function addGroupAction(): AxiosModel
    {
        if($this->getRequest()->isPost()) {
            $jsonData = $this->getRequest()->getContent();
            $data = json_decode($jsonData, true);
            $groupName = $data['name'];
            $group = new ComposanteGroupe();
            $group->setLibelle($groupName);
            $this->getComposanteService()->addGroup($group);
            return new AxiosModel();
        }
        return new AxiosModel;
    }

    public function deleteGroupAction(): AxiosModel
    {
        if($this->getRequest()->isDelete()) {
            $id = $this->params()->fromRoute('id');
            if($id) {
                $this->getComposanteService()->deleteGroup($id);
            }
            return new AxiosModel();
        }
        return new AxiosModel;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function addComposanteToGroupAction(): AxiosModel
    {
        if($this->getRequest()->isPost()) {
            $jsonData = $this->getRequest()->getContent();
            $data = json_decode($jsonData, true);
            $composanteGroup = $data['composanteGroup'];
            $composanteGroup = $this->getComposanteService()->getComposanteGroupe($composanteGroup['id']);
            $composante = $data['composante'];
            $composante = $this->getComposanteService()->find($composante['id']);

            $composante->setGroupe($composanteGroup);
            $test = $this->getComposanteService()->update($composante);
            $cg = $this->getComposanteService()->getComposanteGroupe($data['composanteGroup']['id']);
            return new AxiosModel();
        }
        return new AxiosModel;
    }

    public function removeComposanteToGroupAction(): AxiosModel
    {
        if($this->getRequest()->isPost()) {
            $jsonData = $this->getRequest()->getContent();
            $data = json_decode($jsonData, true);
            $composanteGroup = $data['composanteGroup'];
            $composanteGroup = $this->getComposanteService()->getComposanteGroupe($composanteGroup['id']);
            $composante = $data['composante'];
            $composante = $this->getComposanteService()->find($composante['id']);

            $composante->setGroupe(null);
            $test = $this->getComposanteService()->update($composante);
            $cg = $this->getComposanteService()->getComposanteGroupe($data['composanteGroup']['id']);
            return new AxiosModel();
        }
        return new AxiosModel;
    }

    public function getDataComposanteGroupAction(): AxiosModel
    {
        if($this->getRequest()->isGet()) {
            $composanteGroupes = $this->getComposanteService()->getComposanteGroupes();

            $role = $this->getRoleService()->findByRoleId('gestionnaire');
            $users = $this->getUserService()->findByRole($role);
            $gestionnaires = [];
            $composanteGroupesArray = [];
            $composantes = $this->getComposanteService()->findAll();
            $composantesArray = [];
            foreach ($composantes as $c) {
                $composantesArray[$c->getId()] = $c->toArray();
            }

            foreach ($users as $u) {
                $gestionnaires[$u->getId()] = [
                    'id' => $u->getId(),
                    'displayName' => $u->getDisplayName(),
                    'email' => $u->getEmail(),
                    'username' => $u->getUsername(),
                    'composanteGroupes' => []
                ];
                foreach ($composanteGroupes as $cg) {
                    $composanteGroupesArray[$cg->getId()] = $cg->toArray();
//                    $composanteGroupesArray[$cg->getId()]['composantes'] = ;
                    $users = $cg->getUsers();
                    if(!$users) {
                        continue;
                    }
                    if ($users->contains($u)){
                        $gestionnaires[$u->getId()]['composanteGroupes'][] = $cg->toArray();
                    }
                }
            }

            return new AxiosModel(
                [
                    'gestionnaires' => $gestionnaires,
                    'composanteGroupesDefault' => $composanteGroupesArray,
                    'composantesDefault' => $composantesArray
                ]
            );
        }
        return new AxiosModel;
    }

//    public function etablissementsAction() {
//
//        $etablissements = $this->getEtablissementService()->findAll();
//
//        return new AxiosModel($etablissements);
//    }
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