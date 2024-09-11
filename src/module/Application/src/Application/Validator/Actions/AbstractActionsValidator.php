<?php

namespace Application\Application\Validator\Actions;

use Exception;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Validator\AbstractValidator;
use UnicaenApp\Service\EntityManagerAwareTrait;
use UnicaenAuthentification\Service\Traits\AuthorizeServiceAwareTrait;
use UnicaenPrivilege\Provider\Privilege\Privileges;

abstract class AbstractActionsValidator extends AbstractValidator
{
    /**
     * Validation
     * @param string $action
     * @param array $context
     * @return bool
     */
    public abstract function isValid($action, array $context=[]) : bool;

    use AuthorizeServiceAwareTrait;
    /**
     * Est-ce que l'on a le/les priviléges requis pour effectuer l'action
     * @param string $privilege
     * @return boolean
     */
    function assertHasPrivilege($privilege){
        return $this->getServiceAuthorize()->isAllowed(Privileges::getResourceId($privilege));
    }


    protected $action;

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
        $this->abstractOptions['messages'] = [];
        $this->actionAllowed= null;
        $this->canSeeAction= null;
    }

    /**
     * @desc détermine si l'action courante est autorisée
     * @var bool $actionAllowed
     */
    protected $actionAllowed;
    /**
     * @desc Mécanisme permettant de décider si le fait de ne pas pouvoir effectuer une action permet cependant de l'afficher
     * (nottament pour les liens)
     * Choix fait de ne jamais afficher le bouton pour les actions qui ne sont pas autorisé. On garde cependant le code pour une réutilisation futur éventuelle
     * Penser si on le réintégre pour chaque assertions à dire si l'action permet de voir les liens
     * @var bool $canSeeAction
     */
    protected $canSeeAction;

    /**
     * @desc génére une exception si l'action n'as pas définie
     * @return bool
     */
    public function actionAllowed(): bool
    {
        if($this->action === null){
            throw new Exception("L'action courante n'as pas été été définie");
        }
        if($this->actionAllowed===null){
            $this->actionAllowed = false;
        }
        return $this->actionAllowed;
    }

    /**
     * @desc génére une exception si l'action n'as pas définie
     * @return bool
     */
    public function canSeeAction(): bool
    {
        return $this->actionAllowed();
//        if($this->action === null){
//            throw new Exception("L'action courante n'as pas été été définie");
//        }
//        if($this->canSeeAction===null){
//            $this->canSeeAction = false;
//        }
//        return $this->canSeeAction;

    }


    /**
     * @desc Permet de fournir les services aux sous-classe sans avoir besoins de définir un constructeur spécifique
     * @var ServiceManager $serviceManager
     */
    private $serviceManager;

    /** @return ServiceManager|null */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /** @param ServiceManager $serviceManager */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    use EntityManagerAwareTrait;
    public function setData(array $data = []){}

    const ACTION_NOT_FOUND_ERROR = 'ACTION_NOT_FOUND_ERROR';
    const ACTION_NOT_ALLOWED_ERROR = 'ACTION_NOT_ALLOWED_ERROR';
    const ENTITY_SOURCE_EXTERNE_ERROR = 'ENTITY_SOURCE_EXTERNE_ERROR';
    const ENTITY_SOURCE_NOT_FOUND_ERROR = 'ENTITY_SOURCE_NOT_FOUND_ERROR';
    const ENTITY_ARCHIVEE_ERROR = 'ENTITY_ARCHIVEE_ERROR';
    const ENTITY_NON_ARCHIVEE_ERROR = 'ENTITY_NON_ARCHIVEE_ERROR';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::ACTION_NOT_FOUND_ERROR => "L'action demandé n'est pas correctement définie",
        self::ACTION_NOT_ALLOWED_ERROR => "%errorMessage%",
        self::ENTITY_SOURCE_EXTERNE_ERROR => "Impossible de modifier les données issues d'une source externe.",
        self::ENTITY_SOURCE_NOT_FOUND_ERROR => "La source de donnée n'as pas été trouvée",
        self::ENTITY_ARCHIVEE_ERROR => "L'entité demandée est archivée",
        self::ENTITY_NON_ARCHIVEE_ERROR => "L'entité demandée n'est pas archivée",
    ];

    /**
     * @var array
     */
    protected $messageVariables = [
        "errorMessage" => "errorMessage",
    ];

    //permet d'afficher un message spécifique sans vraiment passer par un template
    protected $errorMessage;

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param mixed $errorMessage
     */
    public function setErrorMessage($errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }
}