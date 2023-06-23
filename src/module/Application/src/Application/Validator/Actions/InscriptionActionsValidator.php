<?php

namespace Application\Application\Validator\Actions;

use Application\Application\Entity\Traits\Entities\InscriptionAwareTrait;
use Application\Application\Validator\Actions\Traits\HistoriqueActionsAssertionsTrait;
use Application\Application\Validator\Actions\Traits\SourcesActionsAssertionsTrait;
use Application\Controller\Inscription\InscriptionController;
use Application\Provider\Privilege\InscriptionPrivileges;
use Exception;

class InscriptionActionsValidator extends AbstractActionsValidator
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
            case InscriptionController::ACTION_INDEX:
                $this->actionAllowed = $this->assertIndex();
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
        return $this->assertHasPrivilege(InscriptionPrivileges::FORMATION_AFFICHER);
    }

    public function assertLister()
    {
        return $this->assertHasPrivilege(InscriptionPrivileges::FORMATION_AFFICHER);
    }

    public function assertAfficher()
    {
        return $this->assertHasPrivilege(InscriptionPrivileges::FORMATION_AFFICHER)
            && $this->assertHasInscription();
    }

    public function assertAjouter()
    {
        return $this->assertHasPrivilege(InscriptionPrivileges::FORMATION_AFFICHER);
    }

    public function assertModifier()
    {
        $allowed = $this->assertHasPrivilege(InscriptionPrivileges::FORMATION_MODIFIER)
            && $this->assertHasInscription();
        if (!$allowed) {
            return false;
        }
        $inscription = $this->getInscription();

        return $this->assertEntitySourceIsLocal($inscription)
            && $this->assertEntityEstNonArchivee($inscription);
    }

    public function assertSupprimer()
    {

        $allowed = $this->assertHasPrivilege(InscriptionPrivileges::FORMATION_SUPPRIMER)
            && $this->assertHasInscription();
        if (!$allowed) {
            return false;
        }
        $inscription = $this->getInscription();

        return $this->assertEntitySourceIsLocal($inscription)
            && $this->assertEntityEstArchivee($inscription);

    }

    public function assertArchiver()
    {

        $allowed = $this->assertHasPrivilege(InscriptionPrivileges::FORMATION_SUPPRIMER)
            && $this->assertHasInscription();
        if (!$allowed) {
            return false;
        }
        $inscription = $this->getInscription();

        return $this->assertEntitySourceIsLocal($inscription)
            && $this->assertEntityEstNonArchivee($inscription);
    }

    public function assertRestaurer()
    {
        $allowed = $this->assertHasPrivilege(InscriptionPrivileges::FORMATION_AJOUTER)
            && $this->assertHasInscription();
        if (!$allowed) {
            return false;
        }

        $inscription = $this->getInscription();
        $allowed = $this->assertEntitySourceIsLocal($inscription)
            && $this->assertEntityEstArchivee($inscription);
        if (!$allowed) {
            return false;
        }

        $typeInscription = $inscription->getTypeInscription();
        if ($typeInscription->estArchivee()) {
            $this->error(self::TYPE_FORMATION_ARCHIVEE_ERROR);
            return false;
        }
        $composante = $inscription->getComposante();
        if ($composante->estArchivee()) {
            $this->error(self::COMPOSANTE_FORMATION_ARCHIVEE_ERROR);
            return false;
        }

        return true;
    }

    public function assertGetActionsMenu()
    {
        return $this->assertHasPrivilege(InscriptionPrivileges::FORMATION_AFFICHER)
            && $this->assertHasInscription();
    }

    /*******************************
     ** Sous-fonctions d'assertion **
     *******************************/
    use SourcesActionsAssertionsTrait;
    use HistoriqueActionsAssertionsTrait;

    /**
     * @return boolean
     */
    public function assertHasInscription()
    {
        if (!$this->hasInscription()) {
            $this->error(self::ENTITY_NOT_FOUND_ERROR);
            return false;
        }
        return true;
    }

    /**
     * Gestion des messages d'erreur
     */
    use InscriptionAwareTrait;

    public function setData(array $data = [])
    {
        $this->setInscription($data['inscription'] ?? null);
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
        self::ENTITY_NOT_FOUND_ERROR => "La inscription demandée n'as pas été trouvée",

        self::ENTITY_ARCHIVEE_ERROR => "La inscription demandée est archivée",
        self::ENTITY_NON_ARCHIVEE_ERROR => "La inscription demandée n'est pas archivée",
        self::TYPE_FORMATION_ARCHIVEE_ERROR => "Le type de la inscription demandée est archivé",
        self::COMPOSANTE_FORMATION_ARCHIVEE_ERROR => "La composante de la inscription demandée est archivée",

        self::ENTITY_SOURCE_EXTERNE_ERROR => "Impossible de modifier les données issues d'une source externe.",
        self::ENTITY_SOURCE_NOT_FOUND_ERROR => "La source de donnée n'as pas été trouvée",
    ];

}