<?php

namespace Import\Controller;

use Fichier\Service\S3\S3ServiceAwareTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Import\Service\Import\ImportServiceAwareTrait;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use UnicaenApp\Service\EntityManagerAwareTrait;
use UnicaenVue\View\Model\VueModel;
use Aws\S3\S3Client;

class IndexController extends  AbstractActionController {
    use EntityManagerAwareTrait;
    use ImportServiceAwareTrait;
    use S3ServiceAwareTrait;

    public function indexVueAction()
    {
        $resultCsv = null;
        $nCourses = $this->getEntityManager()->getRepository('Application\Entity\Cours')->count([]);
        $nComposantes = $this->getEntityManager()->getRepository('Application\Entity\Composante')->count([]);
        $nFormations = $this->getEntityManager()->getRepository('Application\Entity\Formation')->count([]);

        $vm = new VueModel(
            [
                'nCourses' => $nCourses,
                'nComposantes' => $nComposantes,
                'nFormations' => $nFormations,
                'resultCsv' => $resultCsv,
            ]
        );
        $vm->setTemplate('import/index');
        return $vm;
    }

    public function parseCatalogueAction()
    {
        if($this->request->isPost()) {

            $contentPost = $this->getRequest()->getContent();
            $urlApi = json_decode($contentPost)->urlApi;
            $data = [
                [
                    'name' => 'John',
                    'age' => 30,
                    'city' => 'New York'
                ],
                [
                    'name' => 'Doe',
                    'age' => 25,
                    'city' => 'Paris'
                ],
                [
                    'name' => 'Param',
                    'age' => 25,
                    'city' => $urlApi ?? 'Paris'
                ]
            ];
//            $nData = $this->getImportService()->smileConnect();
            return new JsonModel([
                'success' => true,
                'message' => 'Catalogue parsé avec succès',
                'data' => $nData ?? $data
            ]);
        }
    }

    public function IndexAction()
    {
        $resultCsv = null;
        $queryCsv = $this->params()->fromQuery('resultCsv');
        if($queryCsv) {
            $queryDecoded = base64_decode($queryCsv);
            $resultCsv = unserialize($queryDecoded);
        }

        $nCourses = $this->getEntityManager()->getRepository('Application\Entity\Cours')->count([]);
        $nComposantes = $this->getEntityManager()->getRepository('Application\Entity\Composante')->count([]);
        $nFormations = $this->getEntityManager()->getRepository('Application\Entity\Formation')->count([]);

        return new ViewModel([
            'nCourses' => $nCourses,
            'nComposantes' => $nComposantes,
            'nFormations' => $nFormations,
            'importLogs' => $this->getImportService()->getImportLogs(),
            'resultCsv' => $resultCsv,
        ]);
    }

    /**
     * @return \Laminas\Http\Response
     * Get a csv file and import it in the database
     */
    public function importAction()
    {
        if(!$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('import');
        }
        $type = $this->params()->fromRoute('type');
        $fileInfo = $this->getRequest()->getFiles()->toArray()['fileImportCsv'];
        $result = null;
        if($fileInfo) {
            $result = $this->getImportService()->importCsv($fileInfo, $type);
        }

        return $this->redirect()->toRoute('import', ['action' => 'index'], ['query' => ['resultCsv' => $result]]);
    }

    /**
     * @throws GuzzleException
     */
    public function smileConnectAction()
    {
        $res = $this->getImportService()->importODF();
        return new JsonModel($res);
    }
}