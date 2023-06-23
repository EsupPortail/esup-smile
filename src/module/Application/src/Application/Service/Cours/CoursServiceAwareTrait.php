<?php

namespace Application\Application\Service\Cours;
use Application\Entity\Cours;

/**
 * Trait CoursServiceAwareTrait
 *
 * @package Application\Application\Service\Cours
 */
trait CoursServiceAwareTrait
{
    /** @var CoursService $coursService */
    protected $coursService;

    /**
     * @return CoursService
     */
    public function getCoursService(): CoursService
    {
        return $this->coursService;
    }

    /**
     * @param CoursService $coursService
     */
    public function setCoursService(CoursService $coursService): void
    {
        $this->coursService = $coursService;
    }

}