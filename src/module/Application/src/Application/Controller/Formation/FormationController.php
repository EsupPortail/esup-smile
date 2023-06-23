<?php

namespace Application\Controller\Formation;

use Application\Application\Controller\Interfaces\AbstractEntityController;
use Application\Application\Controller\Interfaces\EntityControllerInterface;
use Application\Application\Controller\Traits\AfficherEntityActionTrait;
use Application\Application\Controller\Traits\AjouterEntityActionTrait;
use Application\Application\Controller\Traits\ArchiverEntityActionTrait;
use Application\Application\Controller\Traits\GetActionsMenuActionTrait;
use Application\Application\Controller\Traits\ListerEntityActionTrait;
use Application\Application\Controller\Traits\ModifierEntityActionTrait;
use Application\Application\Controller\Traits\RestaurerEntityActionTrait;
use Application\Application\Controller\Traits\SupprimerEntityActionTrait;
use Application\Application\Entity\Traits\Entities\ComposanteAwareTrait;
use Application\Application\Entity\Traits\Entities\FormationAwareTrait;
use Application\Application\Form\AbstractEntityForm;
use Application\Application\Form\Formation\Traits\FormationFormAwareTrait;
use Application\Application\Form\Misc\ConfirmationFormAwareTrait;
use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\SourceEntityServiceTrait;
use Application\Application\Service\Cours\CoursServiceAwareTrait;
use Application\Application\Service\Formation\FormationServiceAwareTrait;
use Application\Application\Service\Langue\LangueServiceAwareTrait;
use Application\Application\Service\Mobilite\MobiliteServiceAwareTrait;
use Application\Entity\Cours;
use Application\Entity\Mobilite;
use Application\Entity\Source;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Laminas\Http\Response;
use Laminas\Http\Request;
use Laminas\Json\Json;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use UnicaenDbImport\Entity\Db\Service\Source\SourceServiceAwareTrait;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class FormationController extends AbstractEntityController
{
    /** ROUTES */
    const ROUTE_INDEX = "formations";
    const ROUTE_LISTER = "formations/lister";
    const ROUTE_AFFICHER = "formation/afficher";
    const ROUTE_AJOUTER = "formation/ajouter";
    const ROUTE_MODIFIER = "formation/modifier";
    const ROUTE_ARCHIVER = "formation/archiver";
    const ROUTE_RESTAURER = "formation/restaurer";
    const ROUTE_SUPPRIMER = "formation/supprimer";
    const ROUTE_GET_ACTIONS_MENU = "formation/actions";

    const EVENT_AJOUTER = 'event-ajouter-formation';
    const EVENT_MODIFIER = 'event-modifier-formation';
    const EVENT_SUPPRIMER = 'event-supprimer-formation';
    const EVENT_ARCHIVER = 'event-archiver-formation';
    const EVENT_RESTAURER = 'event-restaurer-formation';

    const ACTION_MOBILITE = "mobilite";
    const ACTION_SAVE_MOBILITE = "saveMobilite";
    const ACTION_ACTIVE_ALLMOBILITY = "activeAllMobility";
    const ACTION_DESCRIPTIF = "descriptif";

    use FormationAwareTrait;
    use ComposanteAwareTrait;
    use MobiliteServiceAwareTrait;
    use FormationServiceAwareTrait;
    use CoursServiceAwareTrait;
    use FormationFormAwareTrait;
    use ConfirmationFormAwareTrait;
    use LangueServiceAwareTrait;
    use UserServiceAwareTrait;
    use SourceEntityServiceTrait;

    use ListerEntityActionTrait;
    use AfficherEntityActionTrait;
    use AjouterEntityActionTrait;
    use ModifierEntityActionTrait;
    use SupprimerEntityActionTrait;
    use ArchiverEntityActionTrait;
    use RestaurerEntityActionTrait;
    use GetActionsMenuActionTrait;

    public function getEntityParam(): string {return "formation";}
    public function getEntitiesParam(): string {return "formations";}
    public function getEntityService(): CommonEntityService
    {
        return $this->getFormationService();
    }
    public function getAjouterForm(): AbstractEntityForm
    {
        return $this->getAddFormationForm();
    }
    public function getModifierForm(): AbstractEntityForm
    {
        return $this->getEditFormationForm();
    }

    public function getEntityNotFoundMessage(): ?string
    {
        return "La formation demandée n'as pas été trouvée";
    }

    public function getAfficherActionTitle(): string
    {
        $formation = $this->getFormationFromRoute();
        return sprintf("Fiche de la formation %s", (isset($formation)) ? $formation->getAcronyme() : "");
    }
    public function getAjouterActionTitle(): string
    {
        return "Ajouter une formation";
    }
    public function getModifierActionTitle(): string
    {
        $formation = $this->getFormationFromRoute();
        return sprintf("Modifier la formation %s", (isset($formation)) ? $formation->getCode() : "");
    }
    public function getSupprimerActionTitle(): string
    {
        $formation = $this->getFormationFromRoute();
        return sprintf("Supprimer la formation %s", (isset($formation)) ? $formation->getCode() : "");
    }
    public function getArchiverActionTitle(): string
    {
        $formation = $this->getFormationFromRoute();
        return sprintf("Archiver la formation %s", (isset($formation)) ? $formation->getCode() : "");
    }
    public function getRestaurerActionTitle(): string
    {
        $formation = $this->getFormationFromRoute();
        return sprintf("Restaurer la formation %s", (isset($formation)) ? $formation->getCode() : "");
    }
    public function getActionsMenuTemplatePath(): ?string
    {
        return 'application/formation/formation/fragment/actions-menu';
    }

    public function mobiliteAction()
    {
        /**
         * @var Cours[] $cours
         */
//        $formations = $this->formationService->findAll();
        $cours = $this->coursService->getEntityRepository()->findBy(array(), array('codeElp' => 'ASC'), 5000);
//        $cours = $this->coursService->findAllOpenMobilite();
        $mobilites = $this->mobiliteService->findAllBy(['active' => true]);
        $composantes = $this->composanteService->findAll();
        $langues = $this->langueService->findAll();
//        $cours = $this->formationService->;
//        $composantes = $this->getFormation();

        if($this->getRequest()->isPost()) {
            $request = $this->getRequest();
            $array = [];



            foreach($cours as $c) {

                $checkedS1 = ($c->getS1()) ? 'checked' : '';
                $checkedS2 = ($c->getS2()) ? 'checked' : '';
                $newLine = [
                    'component' => htmlspecialchars($c->getFormation()->getComposante()->getLibelle(), ENT_QUOTES),
                    'code' => $c->getCodeElp(),
                    'title' => htmlspecialchars($c->getLibelle(), ENT_QUOTES),
                    'ects' => floatval($c->getEcts()),
                    'langage' => $c->getLangueEnseignement(),
                    'S1' => '<div class="form-check form-switch"><input class="form-check-input checkS1" data-codeCours="'. $c->getCodeElp() .'" type="checkbox" role="switch" id="flexSwitchCheckChecked" '. $checkedS1 .'>
                            <label class="form-check-label" for="flexSwitchCheckChecked"></label></div>',
                    'S2' => '<div class="form-check form-switch"><input class="form-check-input checkS2" data-codeCours="'. $c->getCodeElp() .'" type="checkbox" role="switch" id="flexSwitchCheckChecked" '. $checkedS2 .'>
                            <label class="form-check-label" for="flexSwitchCheckChecked"></label></div>',
                    'action' => '<a href="mobilite/'.$c->getCodeElp().'"><i class="fa-solid fa-pen"></i></a>'
                ];
                foreach ($mobilites as $mobilite) {
                    $mTitle = htmlspecialchars($mobilite->getLibelle(), ENT_QUOTES);
                    $checked = ($c->isMobiliteActive($mobilite)) ? 'checked' : '';
                    $newLine['mobilite'.$mobilite->getId()] = '<div class="form-check form-switch">
                                <input class="form-check-input checkMobilite" data-id="'. $mobilite->getId() .'" data-codeCours="'. $c->getCodeElp() .'" type="checkbox" role="switch" id="flexSwitchCheckChecked" '. $checked .'><label class="form-check-label" for="flexSwitchCheckChecked"></label></div>';
                }
                $array[] = $newLine;
            }

            $json = json_encode($array);

            $res = new Response();
            $res->setContent($json);
            return $res;
        }

        return new ViewModel([
//            'formations' => $formations,
            'cours' => $cours,
            'mobilites' => $mobilites,
            'composantes' => $composantes,
            'langues' => $langues
        ]);
    }

    public function descriptifAction() {

        $codeC = $this->params('uuid');
        $message = null;

        $composantes = $this->getComposanteService()->findAllWithFormations();
        $formations = $this->getFormationService()->findAll();
        $cours = $this->getCoursService()->findOneBy(['codeElp' => $codeC]);

        if($codeC === 'ADD' ) {
            $request = $this->getRequest();

            if($request->isPost()) {
                $typeCours = $request->getPost('typeCours');
                $description = $request->getPost('description');
                $objectif = $request->getPost('objectif');
                $formationCode = $request->getPost('formation');
                $code = $request->getPost('code');
                $libelle = $request->getPost('libelle');
                $ects = $request->getPost('ects');
                $semester = $request->getPost('semester');
                $vH = $request->getPost('vH');
                $s1 = ($semester === '1' || $semester === '3') ? '1' : '';
                $s2 = ($semester === '2' || $semester === '3') ? '1' : '';

                $formation = $this->getFormationService()->findOneBy(['code' => $formationCode]);

                $cours = new Cours();

                $source = $this->getSmileSource();
                $cours->setSource($source);
                $cours->setSourceCode($code);
                $cours->setHistoCreateur($this->getUserService()->getConnectedUser());
                $cours->setLibelle($libelle);
                $cours->setLangueEnseignement('Français');
                $cours->setEcts($ects);
                $cours->setVolElp($vH);
                $cours->setCodeElp($code);
                $cours->setS1($s1);
                $cours->setS2($s2);
                $cours->setFormation($formation);
                $cours->setTypeCours($typeCours);
                $cours->setDescription($description);
                $cours->setObjectif($objectif);

                $this->getCoursService()->add($cours);
                $message = 'Course has been updated';

                return $this->redirect()->toRoute('formations/mobilite',array(
                    'controller' => FormationController::class,
                    'action' =>  'descriptif',
                    'uuid' => $code
                ));
            }

            if(!$cours) {
                $cours = new Cours();
            }

            return new ViewModel([
                'cours' => $cours,
                'composantes' => $composantes,
                'formations' => $formations,
                'message' => $message,
                'editable' => true
            ]);
        }else if($cours) {

            $message = null;
            /**
             * @var Cours $cours
             */

            $editable = $cours->getSource()->getCode() === 'smile';
            if(!$cours) {
                $message = 'Course not found';
            }

            $request = $this->getRequest();
            if($request->isPost()) {
                if($editable) {
                    $typeCours = $request->getPost('typeCours');
                    $description = $request->getPost('description');
                    $objectif = $request->getPost('objectif');
                    $formationCode = $request->getPost('formation');
                    $code = $request->getPost('code');
                    $libelle = $request->getPost('libelle');
                    $ects = $request->getPost('ects');
                    $semester = $request->getPost('semester');
                    $vH = $request->getPost('vH');
                    $s1 = ($semester === '1' || $semester === '3') ? '1' : '';
                    $s2 = ($semester === '2' || $semester === '3') ? '1' : '';

                    $formation = $this->getFormationService()->findOneBy(['code' => $formationCode]);

//                $cours->setHistoCreateur($this->getUserService()->getConnectedUser());
                    $cours->setLibelle($libelle);
                    $cours->setLangueEnseignement('Français');
                    $cours->setEcts($ects);
                    $cours->setVolElp($vH);
                    $cours->setCodeElp($code);
                    $cours->setS1($s1);
                    $cours->setS2($s2);
                    $cours->setFormation($formation);
                    $cours->setTypeCours($typeCours);
                    $cours->setDescription($description);
                    $cours->setObjectif($objectif);

                    $this->getCoursService()->update($cours);
                }else {
                    $typeCours = $request->getPost('typeCours');
                    $description = $request->getPost('description');
                    $objectif = $request->getPost('objectif');

                    $cours->setTypeCours($typeCours);
                    $cours->setDescription($description);
                    $cours->setObjectif($objectif);
                    $this->getCoursService()->update($cours);
                }
                $message = 'Course has been updated';
            }

            return new ViewModel([
                'cours' => $cours,
                'composantes' => $composantes,
                'formations' => $formations,
                'message' => $message,
                'editable' => $editable
            ]);
        }else {
            return '';
        }
    }

    public function activeAllMobilityAction() {

        $cours = $this->getCoursService()->findAll();
        $mobility = $this->getMobiliteService()->findAll();

        $sql = 'INSERT INTO mobilite_cours_linker (mobilite_id, cours_id, active) VALUES ';
        foreach($cours as $c) {
            foreach($mobility as $m) {
                $sql.= '('.$m->getId().','.$c->getId().', true)';
                if($m === end($mobility) AND $c === end($cours)) {
                    $sql.= ';';
                }else {
                    $sql.= ',';
                }
            }
        }

        $conn = $this->getCoursService()->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->executeQuery();

        return $this->redirect()->toRoute('formations/mobilite');
    }

    /**
     * @return Response
     */
    public function saveMobiliteAction() {

        if($this->getRequest()->isPost()) {
            $content = $this->getRequest()->getContent();
            $data = json_decode($content);
            $error = null;
            /**
             * @var Mobilite $mobilite
             * @var Cours $cours
             */

            $cours = $this->coursService->findOneBy(['codeElp' => $data->codeCours]);
            if($data->mobiliteId) {
                $mobilite = $this->mobiliteService->find($data->mobiliteId);

                if($data->active) {
                    $mobilite->addCours($cours);
                }else {
                    $mobilite->removeCours($cours);
                }
                try {
                    $this->mobiliteService->update($mobilite);
                } catch (OptimisticLockException|ORMException $e) {
                    $error = $e->getMessage();
                }
            }else if($data->S1) {
                if($data->active) {
                    $cours->setS1('1');
                }else {
                    $cours->setS1('');
                }
                $this->coursService->update($cours);
            }else if($data->S2) {
                if($data->active) {
                    $cours->setS2('1');
                }else {
                    $cours->setS2('');
                }
                $this->coursService->update($cours);
            }




            $res = array(['error' => $error]);
            $coursTable = json_encode(array_values($res));

            $response = new Response();
            $response->setContent($coursTable);
            return $response;
        }

        return $this->redirect()->toRoute('home');
    }
}