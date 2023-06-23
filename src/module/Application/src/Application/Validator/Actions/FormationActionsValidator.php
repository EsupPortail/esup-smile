<?php

namespace Application\Application\Validator\Actions;

use Application\Application\Entity\Traits\Entities\FormationAwareTrait;
use Application\Application\Validator\Actions\Traits\HistoriqueActionsAssertionsTrait;
use Application\Application\Validator\Actions\Traits\SourcesActionsAssertionsTrait;
use Application\Controller\Formation\FormationController;
use Application\Provider\Privilege\FormationPrivileges;
use Exception;

class FormationActionsValidator extends AbstractActionsValidator
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
            case FormationController::ACTION_INDEX:
                $this->actionAllowed = $this->assertIndex();
                break;
            case FormationController::ACTION_LISTER:
                $this->actionAllowed = $this->assertLister();
                break;
            case FormationController::ACTION_AFFICHER:
                $this->actionAllowed = $this->assertAfficher();
                break;
            case FormationController::ACTION_AJOUTER:
                $this->actionAllowed = $this->assertAjouter();
                break;
            case FormationController::ACTION_MODIFIER:
                $this->actionAllowed = $this->assertModifier();
                break;
            case FormationController::ACTION_SUPPRIMER:
                $this->actionAllowed = $this->assertSupprimer();
                break;
            case FormationController::ACTION_ARCHIVER:
                $this->actionAllowed = $this->assertArchiver();
                break;
            case FormationController::ACTION_RESTAURER:
                $this->actionAllowed = $this->assertRestaurer();
                break;
            case FormationController::ACTION_GET_ACTIONS_MENU:
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
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_AFFICHER);
    }

    public function assertLister()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_AFFICHER);
    }

    public function assertAfficher()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_AFFICHER)
            && $this->assertHasFormation();
    }

    public function assertAjouter()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_AFFICHER);
    }

    public function assertModifier()
    {
        $allowed = $this->assertHasPrivilege(FormationPrivileges::FORMATION_MODIFIER)
            && $this->assertHasFormation();
        if (!$allowed) {
            return false;
        }
        $formation = $this->getFormation();

        return $this->assertEntitySourceIsLocal($formation)
            && $this->assertEntityEstNonArchivee($formation);
    }

    public function assertSupprimer()
    {

        $allowed = $this->assertHasPrivilege(FormationPrivileges::FORMATION_SUPPRIMER)
            && $this->assertHasFormation();
        if (!$allowed) {
            return false;
        }
        $formation = $this->getFormation();

        return $this->assertEntitySourceIsLocal($formation)
            && $this->assertEntityEstArchivee($formation);

    }

    public function assertArchiver()
    {

        $allowed = $this->assertHasPrivilege(FormationPrivileges::FORMATION_MODIFIER)
            && $this->assertHasFormation();
        if (!$allowed) {
            return false;
        }
        $formation = $this->getFormation();

        return $this->assertEntitySourceIsLocal($formation)
            && $this->assertEntityEstNonArchivee($formation);
    }

    public function assertRestaurer()
    {
        $allowed = $this->assertHasPrivilege(FormationPrivileges::FORMATION_SUPPRIMER)
            && $this->assertHasFormation();
        if (!$allowed) {
            return false;
        }

        $formation = $this->getFormation();
        $allowed = $this->assertEntitySourceIsLocal($formation)
            && $this->assertEntityEstArchivee($formation);
        if (!$allowed) {
            return false;
        }

        $typeFormation = $formation->getTypeFormation();
        if ($typeFormation->estArchivee()) {
            $this->error(self::TYPE_FORMATION_ARCHIVEE_ERROR);
            return false;
        }
        $composante = $formation->getComposante();
        if ($composante->estArchivee()) {
            $this->error(self::COMPOSANTE_FORMATION_ARCHIVEE_ERROR);
            return false;
        }

        return true;
    }

    public function assertGetActionsMenu()
    {
        return $this->assertHasPrivilege(FormationPrivileges::FORMATION_AFFICHER)
            && $this->assertHasFormation();
    }

    /*******************************
     ** Sous-fonctions d'assertion **
     *******************************/
    use SourcesActionsAssertionsTrait;
    use HistoriqueActionsAssertionsTrait;

    /**
     * @return boolean
     */
    public function assertHasFormation()
    {
        if (!$this->hasFormation()) {
            $this->error(self::ENTITY_NOT_FOUND_ERROR);
            return false;
        }
        return true;
    }

    /**
     * Gestion des messages d'erreur
     */
    use FormationAwareTrait;

    public function setData(array $data = [])
    {
        $this->setFormation($data['formation'] ?? null);
    }

    /**************************
     ** Gestion des messages **
     **************************/
    const ENTITY_NOT_FOUND_ERROR = 'ENTITY_NOT_FOUND_ERROR';
    const ENTITY_ARCHIVEE_ERROR = 'ENTITY_ARCHIVEE_ERROR';
    const TYPE_FORMATION_ARCHIVEE_ERROR = 'TYPE_FORMATION_ARCHIVEE_ERROR';
    const COMPOSANTE_FORMATION_ARCHIVEE_ERROR = 'COMPOSANTE_FORMATION_ARCHIVEE_ERROR';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::ACTION_NOT_FOUND_ERROR => "L'action demandé n'est pas correctement définie",
        self::ACTION_NOT_ALLOWED_ERROR => "%errorMessage%",
        self::ENTITY_NOT_FOUND_ERROR => "La formation demandée n'as pas été trouvée",

        self::ENTITY_ARCHIVEE_ERROR => "La formation demandée est archivée",
        self::ENTITY_NON_ARCHIVEE_ERROR => "La formation demandée n'est pas archivée",
        self::TYPE_FORMATION_ARCHIVEE_ERROR => "Le type de la formation demandée est archivé",
        self::COMPOSANTE_FORMATION_ARCHIVEE_ERROR => "La composante de la formation demandée est archivée",

        self::ENTITY_SOURCE_EXTERNE_ERROR => "Impossible de modifier les données issues d'une source externe.",
        self::ENTITY_SOURCE_NOT_FOUND_ERROR => "La source de donnée n'as pas été trouvée",
    ];

}