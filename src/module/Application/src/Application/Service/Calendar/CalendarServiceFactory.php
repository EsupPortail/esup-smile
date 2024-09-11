<?php

namespace Application\Application\Service\Calendar;

use Application\Application\Service\Calendar\CalendarService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class CoursServiceFactory
 * @package Application\Application\Service\Cours
 */
class CalendarServiceFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return CalendarService|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var CalendarService $serviceProvider */
        $serviceProvider = new CalendarService();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $serviceProvider->setEntityManager($entityManager);

        return $serviceProvider;
    }
}