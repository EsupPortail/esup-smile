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
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Join;
use Exception;
use Laminas\Http\Response;
use Laminas\Http\Request;
use Laminas\Json\Json;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use UnicaenDbImport\Entity\Db\Service\Source\SourceServiceAwareTrait;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;
use UnicaenVue\View\Model\AxiosModel;
use UnicaenVue\View\Model\VueModel;

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
    const ACTION_ACTIVE_ALL_BY_MOBILITE = "activeAllByMobilite";
    const ACTION_DESCRIPTIF = "descriptif";
    const ACTION_TEST = "test";
    const ACTION_TEST_DATA = "testData";

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

    // Action qui va charger le composant MonTest
    // route exemple/test à ajouter à votre config
    public function testAction()
    {
        $data = [
            'monId' => 50,
        ];

        // On crée un VueModel et on lui transmet des données par défaut
        $vm = new VueModel($data);

        // On lui donne un template, c'est-à-dire le chemin et le nom du composant à utiliser
        // Le composant s'appelle MonTest se trouvera dans le fichier front/Exemple/MonTest.vue
        // Notez qu'on utilise par convention une syntaxe kebab-case pour le template et CamelCase pour les répertoires, & noms de composants Vue.
        $vm->setTemplate('exemple/mon-test');

        // On retourne le VueModel
        return $vm;
    }

    // Action qui envoie des données au composant
    // route exemple/test-data/:monId à ajouter à votre config
    public function testDataAction(): AxiosModel
    {
        $monId = $this->params()->fromRoute('monId');

//        $courses = $this->getCoursService()->getEntityRepository()->findBy([], [], 100);
        $er = $this->getCoursService()->getEntityRepository();
        $emC = $this->getCoursService()->getEntityManager();
        $emM = $this->getMobiliteService()->getEntityManager();
        $qb = $er->createQueryBuilder('c');
//        $qb->setMaxResults(50000);
//        $qb->select('c.codeElp, c.libelle, c.ects, c.langueEnseignement, c.s1, c.s2');
//        $qb->addSelect('com.libelle as composanteLibelle, com.id as composanteId');
//        $qb->setMaxResults(100);
//        $qb->join('c.formation', 'f');
//        $qb->join('f.composante', 'com');
//        $qb->join('c.mobilite', 'm')
//            ->where(
//                $qb->expr()->in(
//                    'm',
//                    $emM->createQueryBuilder()
//                    ->select('m2')
//                    ->from('Application\Entity\Mobilite', 'm2')
//                    ->join('Application\Entity\Cours',
//                        'c2',
//                            Expr\Join::WITH,
//                        $qb->expr()->andX(
//                            $qb->expr()->eq('c2.mobilite', 'm2')
//                        )
//                    )
//                    ->getDQL()
//                )
//            );

        $qb = $er->createQueryBuilder('c')
            ->select('c. langueEnseignement, c.libelle', 'm.libelle AS mobilite_libelle', 'com.id AS composanteId', 'com.libelle AS composanteLibelle')
            ->join('c.mobilite', 'm', Join::WITH)
            ->join('c.formation', 'f', )
            ->join('f.composante', 'com', );

        $query = $qb->getQuery();

        try {
            $arrayRes["courses"] = $query->getArrayResult();
        } catch (Exception $e) {
            return new AxiosModel([
                "error" => [
                    "message" => $e->getMessage(),
                    "DQL" => $query->getDQL()
                    ]
            ]);
        }

        $arrayRes["composantes"] = [];
        foreach ($arrayRes["courses"] as $course) {
            $arrayRes["composantes"][$course["composanteId"]] = [
                "id" => $course["composanteId"],
                "libelle" => $course["composanteLibelle"]
            ];
        }

        $arrayRes["langues"] = [];
        foreach ($arrayRes["courses"] as $course) {
            $arrayRes["langues"][$course["langueEnseignement"]] = $course["langueEnseignement"];
        }

        $qb = $this->getMobiliteService()->getEntityRepository()->createQueryBuilder('m');
        $qb->select('m');
        $qb->where('m.active = true');
        $query = $qb->getQuery();

        try {
            $arrayRes["mobilites"] = $query->getArrayResult();
        } catch (Exception $e) {
            $arrayRes = [$e->getMessage()];
        }

        // Petit msg d'info
        $this->flashMessenger()->addSuccessMessage('Tout va bien!');

        // Et on retourne un AxiosModel qui présente le tout au client
        return new AxiosModel($arrayRes);
    }


    public function mobiliteAction()
    {
        /**
         * @var Cours[] $cours
         */
//        $formations = $this->formationService->findAll();
        $cours = $this->coursService->getEntityRepository()->findBy(array(), array('codeElp' => 'ASC'), 5000);
//        $cours = $this->coursService->findAllOpenMobilite();
        $mobilites = $this->mobiliteService->findAllBy(['active' => true, 'histoDestruction' => null]);
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
                    'S1' => [$checkedS1, $c->getCodeElp()],
                    'S2' => [$checkedS2, $c->getCodeElp()],
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
                $langueE = $request->getPost('langueE') || '';
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
                $cours->setLangueEnseignement($langueE);
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
                    $langueE = $request->getPost('langueE') || '';
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
                    $cours->setLangueEnseignement($langueE);
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

    public function activeAllByMobiliteAction() {

        $mobiliteId = $this->params('id');
        if(!$mobiliteId) {
            return $this->redirect()->toRoute('formations/mobilite');
        }

        $mobilite = $this->getMobiliteService()->find($mobiliteId);
        if(!$mobilite) {
            return $this->redirect()->toRoute('formations/mobilite');
        }

        /** @var Cours $cours */
        $cours = $this->getCoursService()->findAll();
        $sql = 'INSERT INTO mobilite_cours_linker (mobilite_id, cours_id, active) VALUES ';
        foreach($cours as $c) {
            $cMobilites = $c->getMobilite();
            if($cMobilites->contains($mobilite)) {
                continue;
            }
            $sql.= '('.$mobilite->getId().','.$c->getId().', true)';
            if($c === end($cours)) {
                $sql.= ';';
            }else {
                $sql.= ',';
            }
        }

        if($sql === 'INSERT INTO mobilite_cours_linker (mobilite_id, cours_id, active) VALUES ') {
            return $this->redirect()->toRoute('formations/mobilite');
        }
        $conn = $this->getCoursService()->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->executeQuery();

        return $this->redirect()->toRoute('formations/mobilite');
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
            try {
                $cours = $this->coursService->findOneBy(['codeElp' => $data->codeCours]);
                if(isset($data->mobiliteId)) {
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
                }else if(isset($data->S1)) {
                    if($data->active) {
                        $cours->setS1('1');
                    }else {
                        $cours->setS1('');
                    }
                    $this->coursService->update($cours);
                }else if(isset($data->S2)) {
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
            }catch (Exception $e) {
                $response = new Response();
                $response->setStatusCode(500);
                $response->setContent($e);
                return $response;
            }

        }

        return $this->redirect()->toRoute('home');
    }
}