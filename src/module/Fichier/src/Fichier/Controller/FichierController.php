<?php

namespace Fichier\Controller;

use Fichier\Entity\Db\Fichier;
use Fichier\Form\Upload\UploadFormAwareTrait;
use Fichier\Service\Fichier\FichierServiceAwareTrait;
use Fichier\Service\Nature\NatureServiceAwareTrait;
use Laminas\Form\Element\Select;
use Laminas\Http\Request;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class FichierController extends AbstractActionController {
    use FichierServiceAwareTrait;
    use NatureServiceAwareTrait;
    use UploadFormAwareTrait;

    public function uploadAction()
    {
        $natureCode = $this->params()->fromRoute('nature');
        $nature = $this->getNatureService()->getNatureByCode($natureCode);

        $fichier = new Fichier();
        $form = $this->getUploadForm();
        $form->setAttribute('action', $this->url()->fromRoute('upload-fichier',[] , [], true));
        $form->bind($fichier);

        if ($nature) {
            /** @var Select $select */
            $select = $form->get('nature');
            $select->setValueOptions([ $nature->getId() => $nature->getLibelle()]);
        }

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $file = current($request->getFiles());

            if ($file['name'] != '') {

                $nature = $this->getNatureService()->getNature($data['nature']);
                $fichier = $this->getFichierService()->createFichierFromUpload($file, $nature);
            }

            exit();
        }

        $vm =  new ViewModel();
        //$vm->setTemplate('fichier\default\default-form');
        $vm->setVariables([
            'title' => 'Téléversement d\'un fichier',
            'form' => $form,
        ]);
        return $vm;
    }

    public function downloadAction()
    {
        $fichier = $this->getFichierService()->getRequestedFichier($this, 'fichier');

        $contentType = $fichier->getTypeMime() ?: 'application/octet-stream';
        $contenuFichier = $this->getFichierService()->fetchContenuFichier($fichier);

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: attachment; filename=' . $fichier->getNomOriginal());
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . $fichier->getTaille());
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        header('Pragma: public');

        echo $contenuFichier;
        exit;
    }

    public function deleteAction() {
        $retour  = $this->params()->fromQuery('retour');
        $fichier = $this->getFichierService()->getRequestedFichier($this, 'fichier');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            if ($data["reponse"] === "oui") {
                if ($fichier) $this->getFichierService()->removeFichier($fichier);
            }

            if ($retour) {
                return $this->redirect()->toUrl($retour);
            }
            exit();
        }

        $vm = new ViewModel();
        if ($fichier !== null) {
            $vm->setTemplate('fichier/default/confirmation');
            $vm->setVariables([
                'title' => "Suppression du fichier " . $fichier->getNomOriginal(),
                'text' => "La suppression est définitive êtes-vous sûr&middot;e de vouloir continuer ?",
                'action' => $this->url()->fromRoute('delete-fichier', ["fichier" => $fichier->getId()], [], true),
            ]);
        }
        return $vm;
    }

    public function historiserAction() {
        $fichier = $this->getFichierService()->getRequestedFichier($this, 'fichier');
        $this->getFichierService()->historise($fichier);

        $retour = $this->params()->fromQuery('retour');
        if ($retour) return $this->redirect()->toUrl($retour);
        exit();
    }

    public function restaurerAction() {
        $fichier = $this->getFichierService()->getRequestedFichier($this, 'fichier');
        $this->getFichierService()->restore($fichier);

        $retour = $this->params()->fromQuery('retour');
        if ($retour) return $this->redirect()->toUrl($retour);
        exit();
    }
}