<?php

namespace Application\Application\Form\Misc\CodeValidator;

use Application\Application\Service\API\CommonEntityService;
use RuntimeException;
use Laminas\Validator\AbstractValidator;

class CodeValidator extends AbstractValidator
{

    const CODE_EMPTY_ERROR = "CODE_EMPTY_ERROR";
    const CODE_ALREADY_USED_ERROR = "CODE_ALREADY_USED_ERROR";
    const MODIFICATION_NOT_ALLOWED_ERROR = "MODIFICATION_NOT_ALLOWED_ERROR";
    //TODO : revoir la vérification pour l'édition afin d'interdire une modification

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::CODE_EMPTY_ERROR => "Le champ code ne peut être vide.",
        self::CODE_ALREADY_USED_ERROR => "Ce code est déjà utilisé.",
        self::MODIFICATION_NOT_ALLOWED_ERROR => "La modification du code n'est pas autorisée.",
    ];

    public function setMessageTemplate($key, $value)
    {
        $this->messageTemplates[$key] = $value;
        $this->abstractOptions["messageTemplates"][$key] = $value;
    }

    /**
     * @var array
     */
    protected $messageVariables = [
    ];

    /** @var CommonEntityService $entityService */
    protected $entityService;

    public function setEntityService(CommonEntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    /** @var mixed|null $entity */
    protected $entity;

    public function setEntity($entity)
    {
        if ($entity === null) {
            $this->entity = null;
            return;
        }
        if (method_exists($entity, "getCode()")) {
            throw new RuntimeException("L'entité fournise doit implémenté la fonction getCode().");
        }
        $this->entity = $entity;
    }

    /**
     * Validation
     *
     * @param mixed $value
     * @param mixed $context Additional context to provide to the callback
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        $value=trim($value);
        if ($value == null || $value == "") {
            $this->error(self::CODE_EMPTY_ERROR);
            return false;
        }

        //Cas d'un ajout
        if(!$this->modeEdition){
            if ($this->entityService === null) {
                throw new RuntimeException("Aucun service n'as été fournis pour déterminer si le code est valide.");
            }
            $entityCorrespondante = $this->entityService->findByAttribute($value, "code", false);
            if(isset($entityCorrespondante)){
                $this->error(self::CODE_ALREADY_USED_ERROR);
                return false;
            }
            return true;
        }
        $currentCode =  $this->entity->getCode();
        //pas de modification du code
        if(strcmp($value,$currentCode) == 0){return true;}
        //Modification interdite
        if(!$this->modificationAutoriee){
            $this->error(self::MODIFICATION_NOT_ALLOWED_ERROR);
            return false;
        }
        //Modification autorisée : on regarde s'il existe une autre entité ayant le nouveau code
        $entityCorrespondante = $this->entityService->findByAttribute($value, "code", false);
        if(isset($entityCorrespondante)){
            $this->error(self::CODE_ALREADY_USED_ERROR);
            return false;
        }
        return true;


    }

    /** @var bool $modeEdition */
    protected $modeEdition = false;
    /**
     * @return bool
     */
    public function isModeEdition(): bool
    {
        return $this->modeEdition;
    }
    /**
     * @param bool $modeEdition
     */
    public function setModeEdition(bool $modeEdition): void
    {
        $this->modeEdition = $modeEdition;
    }


    /** @var bool $modificationAutoriee */
    protected $modificationAutoriee = false;
    /**
     * @return bool
     */
    public function isModificationAutoriee(): bool
    {
        return $this->modificationAutoriee;
    }

    /**
     * @param bool $modificationAutoriee
     */
    public function setModificationAutoriee(bool $modificationAutoriee): void
    {
        $this->modificationAutoriee = $modificationAutoriee;
    }
}
