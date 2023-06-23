<?php

namespace Application\Application\Validator\Actions\Traits;


use Application\Application\Entity\Interfaces\SourceAwareInterface;
use Application\Application\Provider\Entities\CodeSourceProvider;
use Application\Application\Validator\Actions\AbstractActionsValidator;

/**
 * @method error();
 */
trait SourcesActionsAssertionsTrait
{
    //Vérifie que la source de données de l'entité est bien Smile
    public function assertEntitySourceIsLocal(SourceAwareInterface $entity){
        $source = $entity->getSource();
        if(!$source){
            $this->error(AbstractActionsValidator::ENTITY_SOURCE_NOT_FOUND_ERROR);
            return false;
        }
        if($source->getCode() != CodeSourceProvider::SMILE_SOURCE_CODE){
            $this->error(AbstractActionsValidator::ENTITY_SOURCE_EXTERNE_ERROR);
            return false;
        }
        return true;
    }

}