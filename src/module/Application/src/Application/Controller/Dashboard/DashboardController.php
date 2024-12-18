<?php

namespace Application\Controller\Dashboard;


use Application\Application\Entity\Traits\Entities\ComposanteAwareTrait;
use Application\Application\Service\Calendar\CalendarServiceAwareTrait;
use Application\Application\Service\Composante\ComposanteServiceAwareTrait;
use Application\Application\Service\Cours\CoursServiceAwareTrait;
use Application\Application\Service\Dashboard\DashboardServiceAwareTrait;
use Application\Application\Service\Formation\FormationServiceAwareTrait;
use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Application\Service\Langue\LangueServiceAwareTrait;
use Application\Application\Service\Step\StepServiceAwareTrait;
use Application\Entity\Composante;
use Application\Entity\Cours;
use Application\Entity\Document;
use Application\Entity\Formation;
use Application\Entity\Inscription;
use Application\Entity\Mobilite;
use Application\Entity\Step;
use Application\Entity\Typedocument;
use Application\Provider\Template\PdfTemplate;
use Application\Service\Document\DocumentServiceAwareTrait;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\PersistentCollection;
use Fichier\Entity\Db\Fichier;
use Fichier\Form\Upload\UploadFormAwareTrait;
use Fichier\Service\Fichier\FichierServiceAwareTrait;
use Fichier\Service\Nature\NatureServiceAwareTrait;
use Fichier\Service\S3\S3ServiceAwareTrait;
use http\Client\Request;
use Interop\Container\Containerinterface;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;
use Message\Service\Message\MessageServiceAwareTrait;
use Mpdf\MpdfException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use UnicaenMail\Service\Mail\MailServiceAwareTrait;
use UnicaenParametre\Service\Parametre\ParametreServiceAwareTrait;
use UnicaenPdf\Exporter\PdfExporter;
use UnicaenRenderer\Service\Rendu\RenduServiceAwareTrait;
use UnicaenUtilisateur\Service\Role\RoleServiceAwareTrait;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class DashboardController extends AbstractActionController
{
    use DashboardServiceAwareTrait;
    use InscriptionServiceAwareTrait;
    use UserServiceAwareTrait;
    use FormationServiceAwareTrait;
    use CoursServiceAwareTrait;
    use ComposanteServiceAwareTrait;
    use StepServiceAwareTrait;
    use UploadFormAwareTrait;
    use NatureServiceAwareTrait;
    use FichierServiceAwareTrait;
    use DocumentServiceAwareTrait;
    use LangueServiceAwareTrait;
    use RenduServiceAwareTrait;
    use ParametreServiceAwareTrait;
    use MessageServiceAwareTrait;
    use MailServiceAwareTrait;
    use CalendarServiceAwareTrait;
    use S3ServiceAwareTrait;


    /** ACTION */
    const ACTION_INDEX = "index";
    const ACTION_COURSES = "courses";
    const ACTION_SAVECOURSES = "saveCourses";
    const ACTION_VALIDATEOLA = "validateOla";
    const ACTION_GENERATE_PDF = "generatePdf";
    const ACTION_UPLOAD_FICHIER = "uploadFichier";
    const ACTION_VALIDATECOURSES = "validateCourses";
    const ACTION_COURSES_VIEW = "coursesView";
    const ACTION_REMOVE_DOCUMENT = "removeDocument";
    const ACTION_ABANDON = "abandon";

    protected Containerinterface $container;
    private PhpRenderer $renderer;

    public function __construct()
    {
    }

    public function indexAction()
    {
        $user = $this->userService->getConnectedUser();
        $period = $this->getCalendarService()->getCurrentPeriod();

        if (!$this->authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('/');
        }

        $inscription = $this->inscriptionService->findByUser($user);
        $stepCourses = $this->stepService->findOneBy(['code' => 'course']);
        $stepRegistration = $this->stepService->findOneBy(['code' => 'registered']);
        $stepApprovalStudent = $this->stepService->findOneBy(['code' => 'approval_student']);
        $steps = $this->stepService->findAllBy(['status' => 1], ['order' => 'ASC']);

        if (!$inscription) {

            // TODO: Fiabiliser l'année en cours
            $inscription = $this->getInscriptionService()->isNomine($user, 2023);

            if (!$inscription) {
                $inscription = new Inscription();
                $inscription->setFirstname(explode(' ', $user->getDisplayName())[0]);
                $inscription->setLastname(explode(' ', $user->getDisplayName())[1]);
                $inscription->setEmail($user->getEmail());
                $inscription->setCreatedAt(new \DateTime());
                $inscription->setUser($user);
                $inscription->setUuid(Uuid::uuid4()->toString());
            }
            $inscription->setStep($this->stepService->getFirstStep());
            $inscription->setStatus(Inscription::STATUS_INSCRIT[0]);
            $inscription->setStatuslibelle(Inscription::STATUS_INSCRIT[1]);
            $inscription->setUser($user);


            $this->inscriptionService->update($inscription);
        }

        $courses = $inscription->getCours();
        $mainComponent = $inscription->getComposante();

        $redirectToStep = $this->stepService->getRedirect($inscription->getStep());
        if($redirectToStep) {
            return $this->redirect()->toRoute($redirectToStep);
        }
        $stepMsg = $this->stepService->getLastStepMsg($inscription);
        $messages = $this->messageService->findAllBy(['inscription' => $inscription], ['createdAt' => 'DESC']);
//        $documents = $this->getDocumentService()->findAll();
        $documents = $this->getDocumentService()->findAllBy(['user' => $user]);

        return new ViewModel(['inscription' => $inscription,
                              'user' => $user,
                              'role' => $this->getUserService()->getConnectedRole(),
                              'courses' => $courses,
                              'mainComponent' => $mainComponent,
                              'stepCourses' => $stepCourses,
                              'stepRegistration' => $stepRegistration,
                              'stepApprovalStudent' => $stepApprovalStudent,
                              'stepMsg' => $stepMsg,
                              'steps' => $steps,
                              'documents' => $documents,
                              'messages' => $messages,
                              'period' => $period
        ]);
    }

    public function uploadFichierAction(): ViewModel
    {
        $user = $this->userService->getConnectedUser();

        /** @var ?Inscription $inscription */
        $inscription = $this->getInscriptionService()->findByUser($user);
        $typeDocuments = $inscription->getMobilite()->getTypedocuments();

        $document = new Document();
        $fichier = new Fichier();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $file = $request->getFiles()['fileToUpload'];
            $typeId = $request->getPost('fileType');
            $natureId = 1;
            $nature = $this->getNatureService()->getNature($natureId);
            if($typeId === null || $typeId === '0') {
                $typeDocument = new Typedocument();
                $typeDocument->setLibelle('Autre');
                $this->getDocumentService()->getEntityManager()->persist($typeDocument);
                $this->getDocumentService()->getEntityManager()->flush();
            }else {
                $typeDocument = $this->getDocumentService()->getTypeDocumentById($typeId);
            }


            if ($file['name'] != '') {
                $this->getFichierService()->setPath('public/upload');
                $fichier = $this->getFichierService()->createFichierFromUpload($file, $nature);
            }

            $this->getDocumentService()->removeDocumentWithTypeDocument($user, $typeDocument);
            $document = new Document();
            $document->setUser($user);
            $document->setFichier($fichier);
            $document->setTypedocument($typeDocument);
            $this->getDocumentService()->create($document);


        }

        $vm = new ViewModel();
        $vm->setTemplate('fichier/default/typedocument-form');
        $vm->setVariables([
            'title' => 'Téléversement d\'un fichier',
            'warning' => "<p class='lead'><span class='icon icon-attention'></span> La taille des fichiers est limitée à 2 Mo.</p>",
            'typeDocuments' => $typeDocuments,
        ]);
        return $vm;
    }

    public function abandonAction()
    {
        if($this->getRequest()->isPost()) {
            $user = $this->userService->getConnectedUser();
            $inscription = $this->inscriptionService->findByUser($user);
            $inscription->setStatus(Inscription::STATUS_ABANDON[0]);
            $inscription->setStatusLibelle(Inscription::STATUS_ABANDON[1]);
            $this->getInscriptionService()->update($inscription);

            $rendu = $this->getRenduService()->generateRenduByTemplateCode("Gestionnaire_abandon", [
                'inscription' => $inscription,
                'user' => $user,
                'etablissement' => $inscription->getEtablissement(),
                'step' => $inscription->getStep()
            ]);

            // TODO : Send mail to gestionnaire
            $users = $this->getUserService()->getUtilisateursByRoleIdAsOptions('gestionnaire');
            foreach ($users as $gestionnaire) {
                $mail = $this->getMailService()->sendMail($gestionnaire['email'], $rendu->getSujet(), $rendu->getCorps());
                $this->getMailService()->update($mail);
            }
        }
        return $this->redirect()->toRoute('dashboard');
    }

    public function coursesAction()
    {
        /**
         * @var Mobilite $mobilite;
         */
        if ($this->getRequest()->isPost()) {
            $listCours = [];

            $user = $this->userService->getConnectedUser();
            $coursSelected = [];


            if($user) {
                $inscription = $this->inscriptionService->findByUser($user);
                $roleGestionnaire = $this->getUserService()->getRoleService()->findByLibelle('Gestionnaire');
                if($user->hasRole($roleGestionnaire)) {
                    $listCours = $this->coursService->findAllOpenMobilite();
                }else if($inscription && $inscription->getMobilite()) {
                    $coursSelected = $inscription->getCours();
                    $mobilite = $inscription->getMobilite();
                    $listCours = $mobilite->getCours()->toArray();
//                    $listCours = $this->coursService->findAllOpenMobilite();
                }else {
                    $listCours = $this->coursService->findAllOpenMobilite();
                }
            }else {
                $listCours = $this->coursService->findAllOpenMobilite();
            }



            $coursTable = array();
            $jsonTxt = "[";
            /**
             * @var Cours $cours
             * @var Formation $formation
             */
            foreach ($listCours as $cours)
            {
                $isSelected = $this->coursService->isCoursSelected($coursSelected, $cours);
                $formation = $cours->getFormation();
                $coursTable[] = [
                    "name" => $cours->getLibelle(),
                    "truc" => $cours->getCodeElp()
                ];
                $jsonTxt.="{";
                $nameGroup = ($cours->getFormation()->getComposante()->getGroupe()) ? $cours->getFormation()->getComposante()->getGroupe()->getLibelle() : '';
                $jsonTxt.='"group": "'.htmlentities($nameGroup, ENT_QUOTES).'",';;
                $nameComponent = $cours->getFormation()->getComposante()->getLibelle();
                $jsonTxt.='"component": "'.htmlentities($nameComponent, ENT_QUOTES).'",';
                $jsonTxt.='"name": "'.htmlentities($cours->getLibelle(), ENT_QUOTES).'",';
                $jsonTxt.='"level": "'.htmlentities($formation->getNiveauEtude()).'",';
                $semester = ($cours->getS1()) ? 'S1' : '';
                $semester = ($cours->getS2()) ? 'S2' : $semester;
                $semester = ($cours->getS1() && $cours->getS2()) ? 'S1/S2' : $semester;
                $jsonTxt.='"semester": "'.$semester.'",';
//                $jsonTxt.='"semester": "'.htmlentities($formation->getBibliographie()).'",';
                $langue = $cours->getLangueEnseignement();
                $jsonTxt.='"language": "'.htmlentities($langue).'",';
                $ects = floatval($cours->getEcts());
                $jsonTxt.='"ects": "'.$ects.'",';
                $jsonTxt.='"view": "<a href=\'/dashboard/courses/'.$cours->getCodeElp().'\' target=\'_blank\'><i class=\'fa-solid fa-eye\'></i></a>",';
                $jsonTxt.='"select": "<input type=\'checkbox\' class=\'checkCourses checkCourse-'.$cours->getCodeElp().'\' ';
                $jsonTxt.='data-formationLibelle=\''.htmlentities($cours->getLibelle(), ENT_QUOTES).'\' ';
                $jsonTxt.='data-ects=\''.$ects.'\' ';
                $jsonTxt.='data-composanteId=\''.htmlentities($formation->getComposante()->getCode()).'\' ';
                $jsonTxt.='data-id=\''.$cours->getCodeElp().'\' ';
                $jsonTxt.=$isSelected ? 'checked' : '';
                $jsonTxt.='>",';
                $jsonTxt.='"selected": "';
                $jsonTxt.= $isSelected ? "true" : "false";
                $jsonTxt.= '",';
                $jsonTxt.= '"composanteId": "'.htmlentities($formation->getComposante()->getCode()).'",';
                $jsonTxt.= '"formationId": "'.$cours->getCodeElp().'",';
                $jsonTxt.= '"formationLibelle": "'.htmlentities($cours->getLibelle()).'"';

                if ($cours === end($listCours)) {
                    $jsonTxt.="}";
                } else {
                    $jsonTxt.="},";
                }
            }
            $jsonTxt .= "]";
//            $formationsTable = json_decode($jsonTxt);
            $coursTable = json_encode($jsonTxt);
//            $formationsTable = json_encode(array_values($formationsTable));

            $response = new Response();
            $response->setContent($coursTable);
//            $response->setContent(json_encode('[{"name": "Michel","truc": "machin"},{"name": "bonjour", "truc": "chose"}]'));
            return $response;
        }else{
            $composantes = $this->getComposanteService()->findAllWithFormations();
            $groupeComposantes = $this->getComposanteService()->findAllComposanteGroupeWithFormations();
            $ratioAlloc = $this->getParametreService()->getValeurForParametre('ects','ratio');
            $minAlloc = $this->getParametreService()->getValeurForParametre('ects','min');
            $maxAlloc = $this->getParametreService()->getValeurForParametre('ects','max');

            $renduCoursAide = $this->getRenduService()->generateRenduByTemplateCode("cours_aide");
//            $composantes = $this->composanteService->findAllBy(['formations']);
            if (!$this->userService->getConnectedUser()) {
                $langues = $this->getLangueService()->findAll();

                return new ViewModel(
                    [
                        'composantes' => $composantes,
                        'groupeComposantes' => $groupeComposantes,
                        'role' => $this->userService->getConnectedRole(),
                        'langues' => $langues,
                        'ratioAlloc' => $ratioAlloc,
                        'minAlloc' => $minAlloc,
                        'maxAlloc' => $maxAlloc,
                        'renduCoursAide' => $renduCoursAide,
                    ]
                );
            }

            $user = $this->userService->getConnectedUser();
            $inscription = $this->inscriptionService->findByUser($user);
            $langues = $this->getLangueService()->findAll();

            $stepMsg = $this->stepService->getLastStepMsg($inscription);

            $groupeComposantes = $this->getComposanteService()->getComposanteGroupes();

            $vm = new ViewModel(
                [
                    'composantes' => $composantes,
                    'groupeComposantes' => $groupeComposantes,
                    'role' => $this->userService->getConnectedRole(),
                    'stepMsg' => $stepMsg,
                    'inscription' => $inscription,
                    'langues' => $langues,
                    'ratioAlloc' => $ratioAlloc,
                    'minAlloc' => $minAlloc,
                    'maxAlloc' => $maxAlloc,
                    'renduCoursAide' => $renduCoursAide,
                ]
            );
            $vm->setTemplate('application/dashboard/dashboard/courses');
            return $vm;
        }
    }

    public function saveCoursesAction() {
        $role = $this->userService->getConnectedRole()->getLibelle();
        if ($role === 'Administrateur technique' || 'Etudiant') {
            if ($this->getRequest()->isPost()) {
                $post = $this->getRequest()->getPost();
                $coursesString = $post['courses'];
                $mainComponentCode = $post['mainComponent'];

                $userConnected = $this->userService->getConnectedUser();

                $inscription = $this->inscriptionService->findByUser($userConnected);
                if($inscription !== null) {
                    /**
                     * @var Inscription $inscription
                     */
                    $this->inscriptionService->removeAllCours($inscription);

                    $coursesId = explode('-', $coursesString);
                    foreach ($coursesId as $id) {
                        $coursToAdd = $this->coursService->findOneBy(['codeElp' => $id]);
                        if($id !== '') {
                            $inscription->addCours($coursToAdd);
                        }
                    }
                    $composante = $this->composanteService->findOneBy(['code' => $mainComponentCode]);
                    $inscription->setComposante($composante);

                    $this->inscriptionService->update($inscription);

                }else {
                    echo 'Error: No registration found';
                    die();
                }

                $this->redirect()->toRoute('dashboard');
            }
        }else {
            $this->redirect()->toRoute('dashboard');
        }
    }

    public function validateCoursesAction() {

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            //STEP
            $user = $this->getUserService()->getConnectedUser();
            $inscription = $this->getInscriptionService()->findByUser($user);

            $step = $inscription->getStep();
            if ($step->getCode() === 'course') {
                $this->stepService->validateStep($inscription, $user, 'Validé', true);
            }
        }

        return $this->redirect()->toRoute('dashboard');
    }

    public function coursesViewAction() {
        $uuid = $this->params('uuid');
        $cours = $this->getCoursService()->findOneBy(['codeElp' => $uuid]);
        if($cours) {
            return new ViewModel(
                [
                    'cours' => $cours
                ]
            );
        }
        return 'Not found';
    }

    public function validateOlaAction(): Response {
        /**
         * @var Inscription $inscription
         */
        $userConnected = $this->userService->getConnectedUser();
        $inscription = $this->inscriptionService->findByUser($userConnected);

        $msg = 'Generated OLA';


        $this->stepService->validateStep($inscription, $userConnected, $msg, true);


        return $this->redirect()->toRoute('dashboard');
    }

    public function removeDocumentAction() {
        $fileName = $this->params('fileName');
        /**
         * @var Fichier $file
         */
        $file = $this->getFichierService()->getEntityManager()->getRepository(Fichier::class)->findOneBy(['nomOriginal' => $fileName]);
        $doc = $this->getDocumentService()->findOneBy(['fichier' => $file]);

        try {
            $this->getFichierService()->removeFichier($file);
            $this->getDocumentService()->delete($doc);
        }catch (ORMException $e) {
            return new RuntimeException($e->getMessage());
        }

        return $this->returnPreviousPage($this->getRequest());
    }

    private function returnPreviousPage(\Laminas\Http\Request $request): Response{
        $request = $this->getRequest();
        $uri = $request->getUri();
        $path = $uri->getPath();
        $baseRouteExploded = explode('/', $path);
        $baseRoute = $baseRouteExploded[1].'/'.$baseRouteExploded[2];
        return $this->redirect()->toRoute($baseRoute);
    }

    public function generatePdfAction(): Response
    {
        /**
         * @var Inscription $inscription
         */
        $user = $this->userService->getConnectedUser();
        $inscription = $this->inscriptionService->findByUser($user);
        $etablissement = $inscription->getEtablissement();
        $etablissementOrigine = $inscription->getEtablissement();

        $vars = [
            'inscription' => $inscription,
            'etablissement' => $etablissement,
            'etablissementOrigine' => $etablissementOrigine
        ];
        $rendu = $this->getRenduService()->generateRenduByTemplateCode(PdfTemplate::OLA, $vars);

        try {
            $relativePathToPdf = $_SERVER['DOCUMENT_ROOT'].'/upload/pdf';
            $filename = 'contrat_pedagogique_'.$inscription->getFirstname().'_'.$inscription->getLastname().'.pdf';
            $exporter = new PdfExporter();
            $exporter->setExportDirectoryPath($relativePathToPdf);
            $exporter->getMpdf()->SetTitle($rendu->getSujet());
            $exporter->setHeaderScript('');
            $exporter->setFooterScript('');
            $exporter->addBodyHtml($rendu->getCorps());
            $exporter->export($filename, PdfExporter::DESTINATION_FILE);
            $size = filesize($relativePathToPdf.'/'.$filename);

            $file = new Fichier();
            $nature = $this->getNatureService()->getNatureByCode('ola');
            $file->setId(uniqid());
            $file->setNature($nature);
            $file->setNomOriginal($filename);
            $file->setNomStockage('pdf/'.$filename);
            $file->setTypeMime('application/pdf');
            $file->setTaille($size);
            $this->getFichierService()->create($file);

            $document = new Document();
            $document->setUser($user);
            $document->setFichier($file);
            $this->getDocumentService()->create($document);

            return $this->validateOlaAction();
        } catch(MpdfException $e) {
            throw new RuntimeException("Un problème lié à MPDF est survenue",0,$e);
        }
    }

    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
    }
}