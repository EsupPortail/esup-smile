<?php

namespace Application\Application\View\Renderer;

use  Application\Application\Entity\Interfaces\GenderAwareInterface;
use  Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Laminas\View\Helper\AbstractHelper;

class HistoriqueViewHelper extends AbstractHelper
{
    /** @var HistoriqueAwareInterface $entity */
    protected $entity;

    /**
     * @return HistoriqueAwareInterface
     */
    public function getEntity(): HistoriqueAwareInterface
    {
        return $this->entity;
    }

    /**
     * @param HistoriqueAwareInterface $entity
     */
    public function setEntity(HistoriqueAwareInterface $entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @param HistoriqueAwareInterface|null $entity
     * @return self
     */
    public function __invoke(?HistoriqueAwareInterface $entity = null): HistoriqueViewHelper
    {
        if ($entity == null) {
            return $this;
        }
        $this->entity = $entity;
        return $this;
    }

    public function __toString()
    {
        if ($this->entity === null) {
            return '';
        }
        return $this->render();
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->renderHistoDate();
    }

    const DATE_CREATION = 1;
    const DATE_MODIFICATION = 2;
    const DATE_SUPPRESSION = 3;
    public function renderHistoDate(int $type= self::DATE_MODIFICATION, ?HistoriqueAwareInterface $entity = null, $withTime=true, $withUser=true): string
    {
        if(!isset($entity)){$entity = $this->entity;}
        if(!isset($entity)){return "";}
        $actionLabel = "";
        $histoDate = null;
        $histoUser = null;
        switch ($type){
            case self::DATE_CREATION:
                $actionLabel = "Créé";
                $histoDate = $entity->getHistoCreation();
                $histoUser = $entity->getHistoCreateur();
            break;
            case self::DATE_MODIFICATION:
                $actionLabel = "Modifié";
                $histoDate = $entity->getHistoModification();
                $histoUser = $entity->getHistoModificateur();
            break;
            case self::DATE_SUPPRESSION:
                $actionLabel = "Archivé";
                $histoDate = $entity->getHistoDestruction();
                $histoUser = $entity->getHistoDestructeur();
            break;
        }
        if(!isset($histoDate)){return "";}

        $genre = ($entity instanceof GenderAwareInterface) ? $entity->getEntityGenre() : GenderAwareInterface::NEUTRE;
        switch ($genre){
            case GenderAwareInterface::MASCULIN: break;
            case GenderAwareInterface::FEMININ:
                $actionLabel .= "e";
                break;
            case GenderAwareInterface::NEUTRE:
            default:
                $actionLabel .= "&middot;e";
                break;
        }

        $html = sprintf("%s le <strong>%s</strong>",
            $actionLabel, $histoDate->format('d/m/Y')
        );

        if($withTime) {
            $html .= sprintf(" à <strong>%s</strong>",$histoDate->format('H:i'));
        }
        if($withUser && isset($histoUser)){
            $html.= sprintf(" par <strong>%s</strong>", $histoUser->getDisplayName());
        }
        return $html;

    }

    /**
     * @return string
     */
    public function renderHistoStatut(?HistoriqueAwareInterface $entity = null): string
    {
        if(!isset($entity)){$entity = $this->entity;}
        if(!isset($entity)){return "";}

        $genre = ($entity instanceof GenderAwareInterface) ? $entity->getEntityGenre() : GenderAwareInterface::NEUTRE;
        switch ($genre){
            case GenderAwareInterface::MASCULIN:
                $label = (!$entity->estArchivee()) ? "Actif" : "Archivé";
                break;
            case GenderAwareInterface::FEMININ:
                $label = (!$entity->estArchivee()) ? "Active" : "Archivée";
            break;
            case GenderAwareInterface::NEUTRE:
            default:
//                $label = ($entity->estArchiver()) ? "Actif&middot;ive" : "Archivé&middot;e";
                $label = (!$entity->estArchivee()) ? "Actif" : "Archivé&middot;e";
            break;
        }
        $badgeClass = ($entity->estNonHistorise()) ? "badge-success" : "badge-muted";
        $html = sprintf("<span class='badge %s'>%s</span>", $badgeClass, $label);

        return $html;
    }
}