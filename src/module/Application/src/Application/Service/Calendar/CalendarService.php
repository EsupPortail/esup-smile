<?php

namespace Application\Application\Service\Calendar;

use Application\Application\Service\API\CommonEntityService;
use Application\Entity\Calendar;
use Application\Entity\Period;

/**
 * Class CoursService
 *
 * @package Application\Application\Service\Cours
 */
class CalendarService extends CommonEntityService
{

    /** @return string */
    public function getEntityClass()
    {
        return Calendar::class;
    }

    public function findAllToArray(): array
    {
        $calendars = $this->findAll();
        $calendarsArray = [];
        foreach ($calendars as $calendar) {
            $calendarsArray[] = $calendar->toArray();
        }
        return $calendarsArray;
    }

    public function getCurrentPeriod(): mixed
    {
        $qb = $this->getEntityManager()->getRepository(Period::class)->createQueryBuilder('p');

        $qb->select('p')
            ->where('p.startDate <= :today')
            ->andWhere('p.endDate >= :today')
            ->setParameter('today', new \DateTime(), \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE);

        $results = $qb->getQuery()->getResult();
        if($results) {
            return $results[0];
        }
        return null;
    }
}