<?php

namespace  Application\Application\Entity\Interfaces;

use DateTime;
use UnicaenUtilisateur\Entity\Db\UserInterface;

interface HistoriqueAwareInterface extends \UnicaenUtilisateur\Entity\Db\HistoriqueAwareInterface


{
    /**
     * @param DateTime|null $dateObs
     * @return bool
     */
    public function estArchivee(DateTime $dateObs = null) : bool;

    /**
     * @param UserInterface $histoDestructeur
     * @param DateTime|null $histoDestruction
     * @return HistoriqueAwareInterface
     */
    public function archiver(UserInterface $histoDestructeur, DateTime $histoDestruction = null) : HistoriqueAwareInterface ;

    /**
     * @param UserInterface $histoDestructeur
     * @param DateTime|null $histoDestruction
     * @return HistoriqueAwareInterface
     */
    public function restraurer(UserInterface $histoDestructeur, DateTime $histoDestruction = null) : HistoriqueAwareInterface;

}