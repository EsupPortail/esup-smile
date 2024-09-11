<?php


namespace Application\Application\Service\API;

use  Application\Application\Entity\Interfaces\SourceAwareInterface;
use Application\Application\Provider\Entities\CodeSourceProvider;
use Doctrine\DBAL\ParameterType;
use UnicaenApp\Service\EntityManagerAwareTrait;
use Application\Entity\Source;

/** Trait permettant de gerer les bases sources des étntités */
Trait SourceEntityServiceTrait
{
    use EntityManagerAwareTrait;

    /**
     * @param string $codeSource
     * @return Source|null
     */
    public function findSourceByCode(string $codeSource) : ?Source
    {
        /** @var Source $source */
        $source = $this->getEntityManager()->getRepository(Source::class)->findOneBy(['code' => $codeSource]);
        return $source;
    }

    /** @return Source */
    public function getSmileSource() : ?Source
    {
        return $this->findSourceByCode(CodeSourceProvider::SMILE_SOURCE_CODE);
    }

    /** @return Source */
    public function getCsvSource() : ?Source
    {
        return $this->findSourceByCode(CodeSourceProvider::CSV_SOURCE_CODE);
    }

    protected function setDefaultSource(SourceAwareInterface $entity, $sourceCode=CodeSourceProvider::SMILE_SOURCE_CODE) : SourceAwareInterface
    {
        $source = $entity->getSource();
        if(isset($source)){return $entity;}
        $source = $this->findSourceByCode($sourceCode);
        if(isset($source)){
            $entity->setSource($source);
            $entity->setSourceCode($entity->getCode());
        }
        return $entity;
    }

}