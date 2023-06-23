<?php

namespace Application\Application\Validator\Actions;

use Application\Application\Entity\Traits\Entities\TypeDiplomeAwareTrait;use Application\Application\Validator\Actions\Traits\HistoriqueActionsAssertionsTrait;
use Application\Application\Validator\Actions\Traits\SourcesActionsAssertionsTrait;
use Application\Controller\Formation\TypeDiplomeController;
use Application\Provider\Privilege\FormationPrivileges;
use Exception;

class TypeDiplomeActionsValidator extends AbstractActionsValidator
{
    /**
     * Validation
     * @param string $action
     * @param array $context
     * @return bool
     * @throws Exception
     */
    public function isValid($action, array $context = []): bool
    {
        $this->setAction($action);
        $this->setData($context);
        switch ($action) {
            case TypeDiplomeController::ACTION_INDEX:
                $this->actionAllowed = $this->assertIndex();
                break;
            case TypeDiplomeController::ACTION_LISTER:
                $this->actionAllowed = $this->assertLister();
                break;
            case TypeDiplomeController::ACTION_AFFICHER:
                $this->actionAllowed = $this->assertAfficher();
                break;
            case TypeDiplomeController::ACTION_AJOUTER:
                $this->actionAllowed = $this->assertAjouter();
                break;
            case TypeDiplomeController::ACTION_MODIFIER:
                $this->actionAllowed = $this->assertModifier();
                break;
            case TypeDiplomeController::ACTION_SUPPRIMER:
                $this->actionAllowed = $this->assertSupprimer();
                break;
            case TypeDiplomeController::ACTION_GET_ACTIONS_MENU:
                $this->actionAllowed = $this->assertGetActionsMenu();
                break;
            default :
                $this->error(self::ACTION_NOT_FOUND_ERROR);
                $this->actionAllowed = false;
        }
        return $this->actionAllowed;
    }


    /** Fonction d'assertion par actions */
    public function assertIndex()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_PARAMETRE_AFFICHER);
    }

    public function assertLister()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_PARAMETRE_AFFICHER);
    }

    public function assertAfficher()
    {
        throw new Exception("Les fiches des types de diplômes ne sont pas implémentées");
    }

    public function assertAjouter()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_PARAMETRE_MODIFIER);
    }

    public function assertModifier()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_PARAMETRE_MODIFIER)
            && $this->assertHasTypeDiplome();
    }

    public function assertSupprimer()
    {

        $allowed = $this->assertHasPrivilege(FormationPrivileges::FORMATION_PARAMETRE_MODIFIER)
            && $this->assertHasTypeDiplome();
        if (!$allowed) {
            return false;
        }
        $typeDiplome = $this->getTypeDiplome();

        if ($typeDiplome->getFormations()->count() > 0) {
            $this->error(self::ENTITY_USED_BY_FORMATION_ERROR);
            $this->canSeeAction = true;
            return false;
        }
        return true;
    }

    public function assertGetActionsMenu()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_PARAMETRE_MODIFIER)
            && $this->assertHasTypeDiplome();
    }

    /*******************************
     ** Sous-fonctions d'assertion **
     *******************************/

    /**
     * @return boolean
     */
    public function assertHasTypeDiplome()
    {
        if (!$this->hasTypeDiplome()) {
            $this->error(self::ENTITY_NOT_FOUND_ERROR);
            return false;
        }
        return true;
    }

    /**
     * Gestion des messages d'erreur
     */
    use TypeDiplomeAwareTrait;

    public function setData(array $data = [])
    {
        $this->setTypeDiplome($data['typeDiplome'] ?? null);
    }

    /**************************
     ** Gestion des messages **
     **************************/
    const ENTITY_NOT_FOUND_ERROR = 'ENTITY_NOT_FOUND_ERROR';
    const ENTITY_ARCHIVEE_ERROR = 'ENTITY_ARCHIVEE_ERROR';
    const ENTITY_USED_BY_FORMATION_ERROR = 'ENTITY_USED_BY_FORMATION_ERROR';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::ACTION_NOT_FOUND_ERROR => "L'action demandé n'est pas correctement définie",
        self::ACTION_NOT_ALLOWED_ERROR => "%errorMessage%",
        self::ENTITY_NOT_FOUND_ERROR => "Le type de diplome demandé n'as pas été trouvé",
        self::ENTITY_USED_BY_FORMATION_ERROR => "Le type de diplome demandé est utilisé par au moins une formation",
    ];
}