<?php

namespace Application\Application\Validator\Actions;

use Application\Application\Entity\Traits\Entities\ComposanteAwareTrait;
use Application\Application\Validator\Actions\Traits\HistoriqueActionsAssertionsTrait;
use Application\Application\Validator\Actions\Traits\SourcesActionsAssertionsTrait;
use Application\Controller\Composante\ComposanteController;
use Application\Provider\Privilege\SmilePrivileges;
use Application\Provider\Privilege\FormationPrivileges;
use Exception;

class ComposanteActionsValidator extends AbstractActionsValidator
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
        switch ($action){
            case ComposanteController::ACTION_INDEX:
                $this->actionAllowed = $this->assertIndex();
            break;
            case ComposanteController::ACTION_LISTER:
                $this->actionAllowed = $this->assertLister();
            break;
            case ComposanteController::ACTION_AFFICHER:
                $this->actionAllowed = $this->assertAfficher();
            break;
            case ComposanteController::ACTION_AJOUTER:
                $this->actionAllowed = $this->assertAjouter();
            break;
            case ComposanteController::ACTION_MODIFIER:
                $this->actionAllowed = $this->assertModifier();
            break;
            case ComposanteController::ACTION_SUPPRIMER:
                $this->actionAllowed = $this->assertSupprimer();
            break;
            case ComposanteController::ACTION_ARCHIVER:
                $this->actionAllowed = $this->assertArchiver();
            break;
            case ComposanteController::ACTION_RESTAURER:
                $this->actionAllowed = $this->assertRestaurer();
            break;
            case ComposanteController::ACTION_GET_ACTIONS_MENU:
                $this->actionAllowed = $this->assertGetActionsMenu();
            break;
            default :
                $this->error(self::ACTION_NOT_FOUND_ERROR);
                $this->actionAllowed = false;
        }
        return $this->actionAllowed;
    }


    /** Fonction d'assertion par actions */
    public function assertIndex(){
        return $this->assertHasPrivilege(FormationPrivileges::COMPOSANTE_AFFICHER);
    }

    public function assertLister(){
        return $this->assertHasPrivilege(FormationPrivileges::COMPOSANTE_AFFICHER);
    }

    public function assertAfficher(){
        return $this->assertHasPrivilege(FormationPrivileges::COMPOSANTE_AFFICHER)
            && $this->assertHasComposante();
    }

    public function assertAjouter(){
        return $this->assertHasPrivilege(FormationPrivileges::COMPOSANTE_AJOUTER);
    }

    public function assertModifier(){
        $allowed = $this->assertHasPrivilege(FormationPrivileges::COMPOSANTE_MODIFIER)
                && $this->assertHasComposante();
        if(!$allowed) return false;
        $composante = $this->getComposante();
        return $this->assertEntitySourceIsLocal($composante);
    }

    public function assertSupprimer(){
        $allowed = $this->assertHasPrivilege(FormationPrivileges::COMPOSANTE_SUPPRIMER)
            && $this->assertHasComposante();
        if(!$allowed) return false;

        $composante = $this->getComposante();
        return  $this->assertEntitySourceIsLocal($composante)
            && $this->assertEntityEstArchivee($composante);
    }

    public function assertArchiver(){
        $allowed = $this->assertHasPrivilege(FormationPrivileges::COMPOSANTE_MODIFIER)
            && $this->assertHasComposante();
        if(!$allowed) return false;

        $composante = $this->getComposante();
        return  $this->assertEntitySourceIsLocal($composante)
            && $this->assertEntityEstNonArchivee($composante);
    }

    public function assertRestaurer(){
        $allowed = $this->assertHasPrivilege(FormationPrivileges::COMPOSANTE_MODIFIER)
            && $this->assertHasComposante();
        if(!$allowed) return false;

        $composante = $this->getComposante();
        return  $this->assertEntitySourceIsLocal($composante)
            && $this->assertEntityEstArchivee($composante);
    }

    public function assertGetActionsMenu()
    {
        return $this->assertHasPrivilege(FormationPrivileges::COMPOSANTE_AFFICHER)
            && $this->assertHasComposante();
    }

    /*******************************
     ** Sous-fonctions d'assertion **
     *******************************/
    use SourcesActionsAssertionsTrait;
    use HistoriqueActionsAssertionsTrait;
    /**
     * @return boolean
     */
    public function assertHasComposante()
    {
        if (!$this->hasComposante()) {
            $this->error(self::ENTITY_NOT_FOUND_ERROR);
            return false;
        }
        return true;
    }


    /**
     * Gestion des messages d'erreur
     */
    use ComposanteAwareTrait;
    public function setData(array $data = [])
    {
        $this->setComposante($data['composante'] ?? null);
    }

    /**************************
     ** Gestion des messages **
     **************************/
    const ENTITY_NOT_FOUND_ERROR = 'ENTITY_NOT_FOUND_ERROR';
    /**
     * @var array
     */
    protected $messageTemplates = [
        self::ACTION_NOT_FOUND_ERROR => "L'action demandé n'est pas correctement définie",
        self::ACTION_NOT_ALLOWED_ERROR => "%errorMessage%",
        self::ENTITY_NOT_FOUND_ERROR => "La composante demandée n'as pas été trouvée",

        self::ENTITY_ARCHIVEE_ERROR => "La composante demandée est archivée",
        self::ENTITY_NON_ARCHIVEE_ERROR => "La composante demandée n'est pas archivée",

        self::ENTITY_SOURCE_EXTERNE_ERROR => "Impossible de modifier les données issues d'une source externe.",
        self::ENTITY_SOURCE_NOT_FOUND_ERROR => "La source de donnée n'as pas été trouvée",
    ];

}