<?php

namespace Application\Application\Validator\Actions\Traits;
use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Validator\Actions\AbstractActionsValidator;

/**
 * @method error();
 */
trait HistoriqueActionsAssertionsTrait
{

    //Vérifie que la source de données de l'entité est bien Smile
    public function assertEntityEstArchivee(HistoriqueAwareInterface $entity){
        if(!$entity->estArchivee()){
            $this->error(AbstractActionsValidator::ENTITY_NON_ARCHIVEE_ERROR);
            return false;
        }
        return true;
    }
    public function assertEntityEstNonArchivee(HistoriqueAwareInterface $entity){
        if($entity->estArchivee()){
            $this->error(AbstractActionsValidator::ENTITY_ARCHIVEE_ERROR);
            return false;
        }
        return true;
    }

}