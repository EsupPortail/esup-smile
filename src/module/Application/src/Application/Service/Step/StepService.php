<?php

namespace Application\Service\Step;

use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\Step\StepMessageServiceAwareTrait;
use Application\Entity\Document;
use Application\Entity\Inscription;
use Application\Entity\Step;
use Application\Entity\Stepmessage;
use Application\Service\Document\DocumentServiceAwareTrait;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Fichier\Service\Fichier\FichierServiceAwareTrait;
use UnicaenMail\Service\Mail\MailServiceAwareTrait;
use UnicaenRenderer\Service\Rendu\RenduServiceAwareTrait;
use UnicaenUtilisateur\Entity\Db\User;

class StepService extends CommonEntityService
{
//    use HistoEntityServiceTrait;
    use StepMessageServiceAwareTrait;
    use FichierServiceAwareTrait;
    use DocumentServiceAwareTrait;
    use MailServiceAwareTrait;
    use RenduServiceAwareTrait;

    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return Step::class;
    }

    public function getFirstStep() {
        // TODO Must be correlated with configuration
        return $this->findOneBy(['order' => 1]);
    }

    public function getNextStep(Step $step): ?Step {
        $order = $step->getOrder();
        $nextOrder = $order+1;
        return $this->findOneBy(['order' => $nextOrder]);
    }

    public function getPreviousStep(Step $step): ?Step {
        $order = $step->getOrder();
        $previousOrder = $order-1;
        return $this->findOneBy(['order' => $previousOrder]);
    }

    public function getMaxOrder(): int {
        $maxOrder = $this->findOneBy([], ['order' => 'DESC']);
        return $maxOrder->getOrder();
    }

    public function findAllOrdered(): array {
        return $this->findAllBy(array(), array('order' => 'ASC'));
    }

    public function findAllOrderedByValidator(User $user): array {
        return $this->findAllBy([
            'role' => $user->getRoles()->toArray()
        ],
            array('order' => 'ASC'));
    }

    public function validateStep(Inscription $inscription, User $user, string $msg, bool $isValid): Inscription {
        $step = $inscription->getStep();
        $nextStep = $this->getNextStep($step);
        if ($nextStep) {
            $inscription->setStep($nextStep);
            $status = $this->getStatusByStep($nextStep, $inscription);
            $inscription->setStatus($status[0]);
            $inscription->setStatusLibelle($status[1]);
            $etablissement = $inscription->getEtablissement();
            $stepMsg = new Stepmessage();
            $stepMsg->setInscription($inscription);
            $stepMsg->setStep($step);
            $stepMsg->setCurrentstatus($isValid);
            $stepMsg->setDate(new \DateTime());
            $stepMsg->setLibelle($msg);
            $stepMsg->setValidator($user);
            $this->getEntityManager()->persist($inscription);
            $this->getEntityManager()->persist($stepMsg);
            $this->getEntityManager()->flush();
            $this->mailStep($stepMsg);
//            $this->mailStudent($inscription, $user, $etablissement);
        }

        return $inscription;
    }

    private function getStatusByStep(Step $step, Inscription $inscription) {
        $status = $step->getStatus();
        if($step->getCode() === 'registered') {
            return Inscription::STATUS_INSCRIT;
        }elseif ($step->getCode() === 'contract') {
            return Inscription::STATUS_TERMINE;
        }

        return [$inscription->getStatus(), $inscription->getStatusLibelle()];
    }

    protected function mailStudent($inscription, $user, $etablissement) {
        $rendu = $this->getRenduService()->generateRenduByTemplateCode('Etudiant_etape_suivante', [
            'inscription' => $inscription,
            'user' => $user,
            'etablissement' => $etablissement
        ]);
        $mail = $this->getMailService()->sendMail($user->getEmail(), $rendu->getSujet(), $rendu->getCorps());
        $this->getMailService()->update($mail);
//        $this->getMailService()->sendMail('anthony.gautreau@unicaen.fr', 'SMILE - Etape validé', 'Bonjour, Votre dossier SMILE a avancé, cliquez ici pour voir votre dossier.');
    }

    public function mailStep(Stepmessage $stepmessage) {
        $template = $this->getTemplateFromStepMessage($stepmessage);
        $inscription = $stepmessage->getInscription();
        $user = $inscription->getUser();
        $renduEtudiant = $this->getRenduService()->generateRenduByTemplateCode($template, [
            'inscription' => $inscription,
            'user' => $user,
            'etablissement' => $inscription->getEtablissement(),
            'step' => $stepmessage->getStep()
        ]);
        $renduGestionnaire = $this->getRenduService()->generateRenduByTemplateCode("Gestionnaire_etape_suivante", [
            'inscription' => $inscription,
            'user' => $user,
            'etablissement' => $inscription->getEtablissement(),
            'step' => $stepmessage->getStep()
        ]);

        $mail = $this->getMailService()->sendMail($user->getEmail(), $renduEtudiant->getSujet(), $renduEtudiant->getCorps());
        $this->getMailService()->update($mail);
        $mail = $this->getMailService()->sendMail($user->getEmail(), $renduGestionnaire->getSujet(), $renduGestionnaire->getCorps());
        $this->getMailService()->update($mail);
    }

    public function getTemplateFromStepMessage(Stepmessage $stepmessage) {
        $stepCode = $stepmessage->getStep()->getCode();
        switch ($stepCode) {
//            case "pre-registration":
//                break;
//            case "registered":
//                break;
//            case "course":
//                break;
//            case "approval_educational":
//                break;
//            case "approval_host":
//                break;
//            case "approval_base":
//                break;
//            case "approval_student":
//                break;
//            case "contract":
//                break;
            default:
                return "Etudiant_etape_suivante";
        }
    }

    public function deniedStep(Inscription $inscription, User $user, string $msg, bool $isValid): Inscription {
        $step = $inscription->getStep();
        $previousStep = $this->getPreviousStep($step);

        if($this->isCoursesDone($inscription)) {
            $inscription->setStep($this->findOneBy(['code' => 'course']));
//            $this->clearCourses($inscription);
            $this->clearContract($user);
        }else {
            $inscription->setStep($previousStep);
        }

        $stepMsg = new Stepmessage();
        $stepMsg->setInscription($inscription);
        $stepMsg->setStep($step);
        $stepMsg->setCurrentstatus($isValid);
        $stepMsg->setDate(new \DateTime());
        $stepMsg->setLibelle($msg);
        $stepMsg->setValidator($user);
        $stepMsg->setType('denied');
        $stepMsg->setShowed(false);
        $this->getEntityManager()->persist($inscription);
        $this->getEntityManager()->persist($stepMsg);
        $this->getEntityManager()->flush();

        $rendu = $this->getRenduService()->generateRenduByTemplateCode("Etudiant_refus", [
            'inscription' => $inscription,
            'user' => $user,
            'etablissement' => $inscription->getEtablissement(),
            'step' => $step
        ]);

        $mail = $this->getMailService()->sendMail($user->getEmail(), $rendu->getSujet(), $rendu->getCorps());
        $this->getMailService()->update($mail);

        return $inscription;
    }

    public function clearContract(User $user): bool
    {
        /**
         * @var Document[] $documents
         */
        $documents = $this->getDocumentService()->findAllBy(['user' => $user]);
        foreach ($documents as $doc) {
            if($doc->getFichier()->getNature()->getCode() === 'ola') {
                try {
                    $this->getFichierService()->removeFichier($doc->getFichier());
                    $this->getDocumentService()->delete($doc);
                } catch (ORMException $e) {
                    return new \RuntimeException($e->getMessage());
                }
            }
        }
        return true;
    }

    public function clearCourses(Inscription $inscription): Inscription
    {
        return $inscription->removeAllCours();
    }

    public function isCoursesDone(Inscription $inscription) : bool {
        $step = $inscription->getStep();
        $stepCourses = $this->findOneBy(['code' => 'course']);
        if ($step->getOrder() > $stepCourses->getOrder()) {
            return true;
        }else {
            return false;
        }
    }

    public function getLastStepMsg(?Inscription $inscription): ?Stepmessage {
        if(!$inscription) {
            return null;
        }
        $step = $inscription->getStep();
        $stepMsg = $this->stepMessageService->findOneBy(
            [
                'type' => 'denied',
                'showed' => false,
                'inscription' => $inscription
            ],
            [
                'date' => 'desc'
        ]);
        if($stepMsg) {
            $stepMsg->setShowed(true);
            $this->stepMessageService->update($stepMsg);

            return $stepMsg;
        }
        return null;
    }

    public function getRedirect(?Step $step)
    {
        switch ($step->getCode()){
            case "pre-registration":
                return "inscription/information";
//            case "course":
//                return "dashboard/courses";
        }
        return false;
    }

}