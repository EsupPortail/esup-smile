<?php

namespace Application\Service\Inscription;

use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Entity\Inscription;
use Laminas\Form\Element\DateTime;
use Laminas\Mvc\Application;
use UnicaenAuthentification\Service\UserContext;
use UnicaenUtilisateur\Entity\Db\Role;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;

class InscriptionService extends CommonEntityService
{
//    use HistoEntityServiceTrait;
    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return Inscription::class;
    }

    public function findByUser(UserInterface $user) {
        return $this->findOneBy(['user' => $user]);
    }

    public function create(UserInterface $user, array $fieldset)
    {
        $inscription = new \Application\Entity\Inscription();
        $inscription->setUser($user);
        if (isset($fieldset['esi'])) {
            $inscription->setEsi($fieldset['esi']);
        }
        if (isset($fieldset['firstname'])) {
            $inscription->setFirstname($fieldset['firstname']);
        }
        if (isset($fieldset['lastname'])) {
            $inscription->setLastname($fieldset['lastname']);
        }
        if (isset($fieldset['birthdate'])) {
            $date = new \DateTime();
            $date->setTimestamp(strtotime($fieldset['birthdate']));
            $inscription->setBirthdate($date);
        }
        if (isset($fieldset['city'])) {
            $inscription->setCity($fieldset['city']);
        }

        $this->add($inscription);
    }

    public function removeAllCours(Inscription $inscription) {
        $cours = $inscription->getCours();
        foreach ($cours as $c) {
            $inscription->removeCours($c);
        }
        $this->update($inscription);
        return $inscription;
    }

    public function isNomine(UserInterface $user, string $year) : Inscription|false {
        $inscription = $this->findOneBy(['year' => $year, 'email' => $user->getEmail()]);
        if ($inscription !== null) {
            return $inscription;
        }
        return false;
    }

    /**
     * @param Inscription $inscription
     * @param int|null    $year
     *
     * @return array
     */
    public function getNominations(Inscription $inscription, int|null $year) {
        if($year !== null) {
            $nominations = $this->findAllBy(['user' => null, 'year' => $year]);
        }else {
            $nominations = $this->findAllBy(['user' => null]);
        }
        return $nominations;
    }

    public function getByGestionnaire(UserInterface $user, string $year): array
    {
        $inscriptionsToReturn = [];
        $roleGestionnaire = $this->getEntityManager()->getRepository(Role::class)->findOneBy(['roleId' => 'gestionnaire']);
        $isGestionnaire = $user->hasRole($roleGestionnaire);
        $inscriptions = $this->findAllBy(['year' => $year]);

        foreach ($inscriptions as $i) {
            if($isGestionnaire) {
                if($i->getComposante() === null) {
                    $inscriptionsToReturn[] = $i;
                }else {
                    $group = $i->getComposante()->getGroupe();
                    if($group !== null) {
                        $users = $group->getUsers();
                        if ($users !== null) {
                            foreach ($users as $u) {
                                if ($u->getId() === $user->getId()) {
                                    $inscriptionsToReturn[] = $i;
                                }
                            }
                        }
                    }
                }
            }else if (!in_array($i, $inscriptionsToReturn)) {
                if ($i->getMailreferent() === $user->getEmail()) {
                    $inscriptionsToReturn[] = $i;
                }
            }
        }

        return $inscriptionsToReturn;

    }

    public function getUniversityYear(int $inscriptionMonth): int
    {
        $currentYear = intval(date('Y'));
        $currentMonth = intval(date('m'));

        if ($currentMonth < 9) {
            if ($inscriptionMonth < 9 && $inscriptionMonth > $currentMonth) {
                return $currentYear;
            }else if ($inscriptionMonth < 9 && $inscriptionMonth < $currentMonth) {
                return $currentYear + 1;
            }else if ($inscriptionMonth >= 9) {
                return $currentYear + 1;
            }
        }else {
            if ($inscriptionMonth < 9) {
                return $currentYear;
            }else if ($inscriptionMonth > 9 && $inscriptionMonth > $currentMonth) {
                return $currentYear;
            }else if ($inscriptionMonth > 9 && $inscriptionMonth < $currentMonth) {
                return $currentYear + 1;
            }else {
                return $currentYear + 1;
            }
        }

        return $currentYear;
    }
    protected UserContext $userContext;

    /**
     * @return UserContext
     */
    public function getUserContext(): UserContext
    {
        return $this->userContext;
    }
    /**
     * @param UserContext $userContext
     */
    public function setUserContext(UserContext $userContext): void
    {
        $this->userContext = $userContext;
    }

    public function isReferent(UserInterface $user): bool
    {
        $inscription = $this->findOneBy(['mailreferent' => $user->getEmail()]);
        return ($inscription !== null);
    }


}