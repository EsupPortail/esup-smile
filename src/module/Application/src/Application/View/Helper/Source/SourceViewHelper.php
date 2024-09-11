<?php

namespace Application\Application\View\Helper\Source;

use Application\Application\Entity\Interfaces\SourceAwareInterface;
use Application\Application\Entity\Traits\InterfacesImplementation\SourceAwareTrait;
use Application\Application\Provider\Entities\CodeSourceProvider;
use Application\Application\Service\API\SourceEntityServiceTrait;
use Application\Application\View\Renderer\PhpRenderer;
use Application\Provider\Privilege\SmilePrivileges;
use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Resolver\TemplatePathStack;
use UnicaenPrivilege\Provider\Privilege\Privileges;

class SourceViewHelper extends AbstractHelper
{
    use SourceEntityServiceTrait;

    use SourceAwareTrait;
    /** @var SourceAwareInterface $entity */
    protected $entity;

    public function canSeeSources() : bool
    {
        return $this->view->isAllowed(Privileges::getResourceId(SmilePrivileges::SOURCE_AFFICHER));
    }

    /**
     * @param SourceAwareInterface|null $entity
     * @return self
     */
    public function __invoke(?SourceAwareInterface $entity = null): SourceViewHelper
    {
        if ($entity == null) {
            return $this;
        }
        $this->entity = $entity;
        $this->setSource($entity->getSource());
        $this->setSourceCode($entity->getSourceCode());
        return $this;
    }

    public function __toString()
    {
        if ($this->getSource() === null) {
            return '';
        }
        return $this->getSource()->getLibelle();
    }

    /**
     * @return string
     */
    public function renderBadge(): string
    {
        if ($this->getSource() === null) {
            return '';
        }
        switch ($this->getSource()->getCode()) {
            case CodeSourceProvider::SMILE_SOURCE_CODE :
                $badgeClass = 'badge-primary';
                break;
            case CodeSourceProvider::PYC_SOURCE_CODE :
                $badgeClass = 'badge-success';
                break;
            default:
                $badgeClass= 'bg-dark';
        }

        $sourceLibelle =  ($this->getSource()->getLibelle()) ?? "Indéterminée";
        $html = sprintf("<span class='badge %s'>%s</span>", $badgeClass, $sourceLibelle);

        return $html;
    }

    /** @return string */
    public function renderEntitySourcesInformations(?SourceAwareInterface $entity = null):string
    {
        if(!isset($entity)){$entity = $this->entity;}
        if(!isset($entity)){return "";}

        /** @var PhpRenderer $view */
        $view = $this->getView();
        $view->resolver()->attach(new TemplatePathStack(['script_paths' => [__DIR__ . "/Partial"]]));
        return $view->partial('entity-source-infos', ['entity' => $entity]);
    }


}