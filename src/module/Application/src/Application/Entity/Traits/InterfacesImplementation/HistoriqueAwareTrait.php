<?php

namespace  Application\Application\Entity\Traits\InterfacesImplementation;

use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use DateTime;
use UnicaenUtilisateur\Entity\Db\UserInterface;

trait HistoriqueAwareTrait
{
    use \UnicaenUtilisateur\Entity\Db\HistoriqueAwareTrait;

    /**
     * @param DateTime|null $dateObs
     * @return bool
     */
    public function estArchivee(DateTime $dateObs = null) : bool
    {
        return $this->estHistorise($dateObs);
    }

    /**
     * @param UserInterface $histoDestructeur
     * @param DateTime|null $histoDestruction
     * @return HistoriqueAwareInterface
     */
    public function archiver(UserInterface $histoDestructeur, DateTime $histoDestruction = null) : HistoriqueAwareInterface
    {
        if(!isset($histoDestruction)){$histoDestruction = new DateTime();}
        $this->setHistoModificateur($histoDestructeur);
        $this->setHistoModification($histoDestruction);
        $this->historiser($histoDestructeur, $histoDestruction);
        /** @var HistoriqueAwareInterface $this */
        return $this;
    }

    /**
     * @return HistoriqueAwareInterface
     */
    public function restraurer(UserInterface $histoRestaurateur, DateTime $histoRestauration = null) : HistoriqueAwareInterface
    {
        $this->dehistoriser();
        if(!isset($histoRestauration)){$histoRestauration = new DateTime();}
        $this->setHistoModification($histoRestauration);
        $this->setHistoModificateur($histoRestaurateur);
        /** @var HistoriqueAwareInterface $this */
        return $this;
    }

}