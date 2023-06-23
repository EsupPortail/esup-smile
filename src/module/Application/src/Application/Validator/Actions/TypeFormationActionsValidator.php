<?php

namespace Application\Application\Validator\Actions;

use Application\Application\Entity\Traits\Entities\TypeFormationAwareTrait;
use Application\Application\Validator\Actions\Traits\HistoriqueActionsAssertionsTrait;
use Application\Application\Validator\Actions\Traits\SourcesActionsAssertionsTrait;
use Application\Controller\Formation\TypeFormationController;
use Application\Entity\Formation;
use Application\Provider\Privilege\FormationPrivileges;
use Exception;

class TypeFormationActionsValidator extends AbstractActionsValidator
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
            case TypeFormationController::ACTION_INDEX:
                $this->actionAllowed = $this->assertIndex();
                break;
            case TypeFormationController::ACTION_LISTER:
                $this->actionAllowed = $this->assertLister();
                break;
            case TypeFormationController::ACTION_AFFICHER:
                $this->actionAllowed = $this->assertAfficher();
                break;
            case TypeFormationController::ACTION_AJOUTER:
                $this->actionAllowed = $this->assertAjouter();
                break;
            case TypeFormationController::ACTION_MODIFIER:
                $this->actionAllowed = $this->assertModifier();
                break;
            case TypeFormationController::ACTION_SUPPRIMER:
                $this->actionAllowed = $this->assertSupprimer();
                break;
            case TypeFormationController::ACTION_GET_ACTIONS_MENU:
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
        throw new Exception("Les fiches des types de formations ne sont pas implémentées");
    }

    public function assertAjouter()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_PARAMETRE_MODIFIER);
    }

    public function assertModifier()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_PARAMETRE_MODIFIER)
            && $this->assertHasTypeFormation();
    }

    public function assertSupprimer()
    {

        $allowed = $this->assertHasPrivilege(FormationPrivileges::FORMATION_PARAMETRE_MODIFIER)
            && $this->assertHasTypeFormation();
        if (!$allowed) {
            return false;
        }
        $typeFormation = $this->getTypeFormation();

        if ($typeFormation->getFormations()->count() > 0) {
            $this->error(self::ENTITY_USED_BY_FORMATION_ERROR);
            $this->canSeeAction = true;
            return false;
        }
        return true;
    }

    public function assertGetActionsMenu()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_PARAMETRE_MODIFIER)
            && $this->assertHasTypeFormation();
    }

    /*******************************
     ** Sous-fonctions d'assertion **
     *******************************/

    /**
     * @return boolean
     */
    public function assertHasTypeFormation()
    {
        if (!$this->hasTypeFormation()) {
            $this->error(self::ENTITY_NOT_FOUND_ERROR);
            return false;
        }
        return true;
    }

    /**
     * Gestion des messages d'erreur
     */
    use TypeFormationAwareTrait;

    public function setData(array $data = [])
    {
        $this->setTypeFormation($data['typeFormation'] ?? null);
    }

    /**************************
     ** Gestion des messages **
     **************************/
    const ENTITY_NOT_FOUND_ERROR = 'ENTITY_NOT_FOUND_ERROR';
    const ENTITY_USED_BY_FORMATION_ERROR = 'ENTITY_USED_BY_FORMATION_ERROR';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::ACTION_NOT_FOUND_ERROR => "L'action demandé n'est pas correctement définie",
        self::ACTION_NOT_ALLOWED_ERROR => "%errorMessage%",
        self::ENTITY_NOT_FOUND_ERROR => "Le type de formation demandé n'as pas été trouvé",
        self::ENTITY_USED_BY_FORMATION_ERROR => "Le type de formation demandé est utilisé par au moins une formation",
    ];
}