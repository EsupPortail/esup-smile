<?php

namespace Application\Service\Mobilite;

use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Application\Service\Cours\CoursServiceAwareTrait;
use Application\Entity\Cours;
use Application\Entity\Mobilite;
use Laminas\Form\Element\DateTime;
use Laminas\Mvc\Application;
use UnicaenAuthentification\Service\UserContext;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;

class MobiliteService extends CommonEntityService
{
    use HistoEntityServiceTrait;
    use CoursServiceAwareTrait;

    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return Mobilite::class;
    }

    public function create(string $libelle, bool $active, bool $activeAllCourses)
    {
        $mobilite = new \Application\Entity\Mobilite();
        $mobilite->setLibelle($libelle);
        $mobilite->setActive($active);

        $isExist = $this->findOneBy(['libelle' => $libelle]);
        if(!$isExist) {
            $mobilite = $this->add($mobilite);

            if($activeAllCourses) {
                $this->activeAllCourses($mobilite);
            }
        }
    }

    public function activeAllCourses(Mobilite $mobilite)
    {
        $cours = $this->getCoursService()->findAll();

        $sql = 'INSERT INTO mobilite_cours_linker (mobilite_id, cours_id, active) VALUES ';
        foreach($cours as $c) {
            $sql.= '('.$mobilite->getId().','.$c->getId().', true)';
            if($c === end($cours)) {
                $sql.= ';';
            }else {
                $sql.= ',';
            }
        }

        $conn = $this->getCoursService()->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->executeQuery();
    }

    public function getMobiliteTypeDocArray()
    {
        $mobilite = $this->findAllBy(['active' => true]);
        $mobiliteArray = [];
        /** @var Mobilite $m */
        foreach ($mobilite as $m) {
            $mobiliteArray[] = $m->toArray();
        }
        return $mobiliteArray;
    }
}