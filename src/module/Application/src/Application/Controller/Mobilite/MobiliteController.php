<?php

namespace Application\Controller\Mobilite;


use Application\Application\Entity\Traits\Entities\ComposanteAwareTrait;
use Application\Application\Service\Composante\ComposanteServiceAwareTrait;
use Application\Application\Service\Cours\CoursServiceAwareTrait;
use Application\Application\Service\Dashboard\DashboardServiceAwareTrait;
use Application\Application\Service\Formation\FormationServiceAwareTrait;
use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Application\Service\Mobilite\MobiliteServiceAwareTrait;
use Application\Application\Service\Step\StepServiceAwareTrait;
use Application\Entity\Composante;
use Application\Entity\Cours;
use Application\Entity\Formation;
use Application\Entity\Inscription;
use Application\Entity\Mobilite;
use Application\Entity\Step;
use Application\Entity\Typedocument;
use Application\Service\Document\DocumentServiceAwareTrait;
use Interop\Container\Containerinterface;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;
use Mpdf\MpdfException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Ramsey\Uuid\Uuid;
use UnicaenPdf\Exporter\PdfExporter;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class MobiliteController extends AbstractActionController
{
    use UserServiceAwareTrait;
    use FormationServiceAwareTrait;
    use CoursServiceAwareTrait;
    use ComposanteServiceAwareTrait;
    use InscriptionServiceAwareTrait;
    use MobiliteServiceAwareTrait;
    use DocumentServiceAwareTrait;

    /** ACTION */
    const ACTION_INDEX = "index";
    const ACTION_ADD = "add_mobilite";
    const ACTION_ADD_TYPE_DOCUMENT = "add_type_document";
    const ACTION_REMOVE_TYPE_DOCUMENT = "remove_type_document";
    const ACTION_UPDATE = "update_mobilite";
    const ACTION_SHOW = "show";
    const ACTION_DELETE = "delete_mobilite";
    const ACTION_ACTIVE = "active_mobilite";

    public function __construct()
    {
    }

    public function indexAction()
    {
        if (!$this->authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('/');
        }

        $mobilite = $this->mobiliteService->findAll();

        return new ViewModel(['mobilite' => $mobilite]);
    }

    public function showAction()
    {
        if (!$this->authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('/');
        }
        $id = $this->params('id');

        $mobilite = $this->getMobiliteService()->find($id);

        return new ViewModel(['mobilite' => $mobilite]);
    }

    public function addMobiliteAction() {
        if(!$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('mobilite');
        }else {

            $post = $this->getRequest()->getPost();
            $str = $post;
            $mobiliteLibelle = $post['mobiliteLibelle'];
            $mobiliteActive = $post['mobiliteActive'] === 'active';
            $mobiliteActiveAllCourses = $post['mobiliteActiveAllCourses'] === 'active';

            $this->getMobiliteService()->create($mobiliteLibelle, $mobiliteActive, $mobiliteActiveAllCourses);

            return $this->redirect()->toRoute('mobilite');
        }
    }

    public function addTypeDocumentAction() {
        if(!$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('mobilite');
        }else {
            $post = $this->getRequest()->getPost();
            $typeDocumentLibelle = $post['typeDocumentLibelle'];
            $mobiliteId = $post['typeDocumentId'];

            if($mobiliteId) {
                $mobilite = $this->getMobiliteService()->find($mobiliteId);
                if($mobilite) {
                    $typeDocument = $this->getDocumentService()->getTypeDocumentsByLibelle($typeDocumentLibelle);
                    if(!$typeDocument) {
                        $typeDocument = new Typedocument();
                        $typeDocument->setLibelle($typeDocumentLibelle);
                        $this->getDocumentService()->addTypeDocument($typeDocument);
                        $typeDocument = $this->getDocumentService()->getTypeDocumentsByLibelle($typeDocumentLibelle);
                    }
                    $mobilite->addTypeDocument($typeDocument);
                    $this->getMobiliteService()->update($mobilite);
                }
            }

            return $this->redirect()->toUrl('/mobilite/'.$mobiliteId);
        }
    }

    public function removeTypeDocumentAction() {
        if(!$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('mobilite');
        }else {
            $post = $this->getRequest()->getPost();
            $typeDocumentId = $post['typeDocumentId'];
            $mobiliteId = $post['mobiliteId'];
            $typeDocument = $this->getDocumentService()->getTypeDocumentById($typeDocumentId);

            $this->getDocumentService()->removeTypeDocument($typeDocument);
            return $this->redirect()->toUrl('/mobilite/'.$mobiliteId);
        }
    }

    public function updateMobiliteAction() {
        if(!$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('mobilite');
        }else {

            $post = $this->getRequest()->getPost();
            $mobiliteLibelle = $post['mobiliteLibelle'];
            $mobiliteActive = $post['mobiliteActive'] === 'on';
            $mobiliteId = $post['mobiliteId'];

            $mobilite = $this->getMobiliteService()->find($mobiliteId);
            $mobilite->setActive($mobiliteActive);
            $mobilite->setLibelle($mobiliteLibelle);
            $this->getMobiliteService()->update($mobilite);

            return $this->redirect()->toUrl('/mobilite/'.$mobiliteId);
        }
    }

    public function deleteMobiliteAction() {
        $id = $this->params('id');

        $mToDlete = $this->mobiliteService->findOneBy(['id' => $id]);
        if ($mToDlete) {
            $this->mobiliteService->delete($mToDlete);
        }

        return $this->redirect()->toRoute('mobilite');
    }

    public function activeMobiliteAction() {
        if($this->getRequest()->isPost()) {
            $content = $this->getRequest()->getContent();
            $data = json_decode($content);

            $mobilite = $this->mobiliteService->find($data->mobiliteId);
            if($mobilite) {
                $mobilite->setActive($data->active);
                $this->mobiliteService->update($mobilite);
            }

            $response = new Response();
            $response->setContent('[]');
            return $response;
        }

        return $this->redirect()->toRoute('home');
    }
}