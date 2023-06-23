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
use Application\Entity\Step;
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

    /** ACTION */
    const ACTION_INDEX = "index";
    const ACTION_ADD = "add_mobilite";
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

    public function addMobiliteAction() {
        if(!$this->getRequest()->isPost()) {
           $str = 'not post';
        }else {

            $post = $this->getRequest()->getPost();
            $str = $post;
            $mobiliteLibelle = $post['mobiliteLibelle'];
            $mobiliteActive = $post['mobiliteActive'] === 'active';

            $this->mobiliteService->create($mobiliteLibelle, $mobiliteActive);

            return $this->redirect()->toRoute('mobilite');
        }
        var_dump($str);
        die();
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