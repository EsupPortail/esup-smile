<?php

namespace Application\Application\Service\Calendar;
use Application\Entity\Calendar;

/**
 * Trait CalendarServiceAwareTrait
 *
 * @package Application\Application\Service\Calendar
 */
trait CalendarServiceAwareTrait
{
    /** @var CalendarService $calendarService */
    protected $calendarService;

    /**
     * @return CalendarService
     */
    public function getCalendarService(): CalendarService
    {
        return $this->calendarService;
    }

    /**
     * @param CalendarService $calendarService
     */
    public function setCalendarService(CalendarService $calendarService): void
    {
        $this->calendarService = $calendarService;
    }

}