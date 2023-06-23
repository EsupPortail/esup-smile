<?php

namespace Application\Application\Validator\Actions\Factory;

use Application\Application\Validator\Actions\AbstractActionsValidator;
use BjyAuthorize\Service\Authorize;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Laminas\ServiceManager\ServiceManager;
use UnicaenAuthentification\Service\UserContext;
use UnicaenPrivilege\Service\AuthorizeService;

class AbstractActionsValidatorFactory implements AbstractFactoryInterface
{

    /**
     * Can the factory create an instance for the service
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return class_exists($requestedName);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $validator = new $requestedName;
        $this->initValidator($validator, $container);

        return $validator;
    }

    /**
     * Initialize services
     *
     * @param AbstractActionsValidator $validator
     * @param ContainerInterface $container
     * @return AbstractActionsValidator
     */
    protected function initValidator(AbstractActionsValidator $validator, ContainerInterface $container)
    {
        /**
         * @var UserContext $userContextService
         * @var ServiceManager $serviceManager
         * @var EntityManager $entityManager
         */
        $userContextService = $container->get('UnicaenAuthentification\Service\UserContext');
        $entityManager = $container->get('Doctrine\ORM\EntityManager');
        $serviceManager = $container->get('ServiceManager');
        $authorizeService = $container->get('BjyAuthorize\Service\Authorize');

        $validator->setEntityManager($entityManager);
        $validator->setServiceManager($serviceManager);
        $validator->setServiceAuthorize($authorizeService);
        return $validator;
    }
}