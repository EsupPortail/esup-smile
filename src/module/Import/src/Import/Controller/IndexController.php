<?php

namespace Import\Controller;

use Import\Service\Import\ImportServiceAwareTrait;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use UnicaenApp\Service\EntityManagerAwareTrait;

class IndexController extends  AbstractActionController {
    use EntityManagerAwareTrait;
    use ImportServiceAwareTrait;

    public function indexAction()
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
        $res = null;
        if($fileInfo) {
            $res = $this->getImportService()->importCsv($fileInfo, $type);
        }
        $result = base64_encode(serialize($res));
        return $this->redirect()->toRoute('import', ['action' => 'index'], ['query' => ['resultCsv' => $result]]);
    }
}