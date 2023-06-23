<?php

namespace  Application\Application\Entity\Interfaces;


use phpDocumentor\Reflection\Types\Boolean;
use UnicaenDbImport\Entity\Db\Source;

/**
 * Pour faire le liens entre les données est différentes sources externes possible
 */
interface SourceAwareInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;


    /**
     * Une entité ayant une source doit nécessairement avoir un code (ne serait-ce que pour dire que la source est SMILE et le codeSource : elle même
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * @return Source|Null
     */
    public function getSource(): ?Source;
    /**
     * @param Source $source
     */
    public function setSource(Source $source): void;
    /**
     * @return string|null
     */
    public function getSourceCode(): ?string;
    /**
     * @param string $codeSource
     */
    public function setSourceCode(?string $codeSource): void;

}