<?php


namespace Application\Application\Service\API;

use  Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use UnicaenUtilisateur\Entity\Db\UserInterface;

interface HistoServiceInterface
{
    public function setEntityHistoCreateur(HistoriqueAwareInterface $entity, UserInterface $user = null);
    public function setEntityHistoModificateur(HistoriqueAwareInterface $entity, UserInterface $user = null);
    public function setEntityHistoDestructeur(HistoriqueAwareInterface $entity, UserInterface $user = null);
    public function archiverEntity(HistoriqueAwareInterface $entity, UserInterface $user = null);
    public function restaurerEntity(HistoriqueAwareInterface $entity, UserInterface $user = null);
}