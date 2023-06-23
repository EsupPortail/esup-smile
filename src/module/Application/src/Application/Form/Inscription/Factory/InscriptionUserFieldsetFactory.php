<?php


namespace Application\Application\Form\InscriptionUser\Factory;

use Application\Application\Form\Inscription\InscriptionUserFieldset;
use Application\Application\Form\Misc\CodeValidator\CodeValidator;
use Application\Application\Service\InscriptionUser\InscriptionUserServiceAwareTrait;
use Application\Entity\InscriptionUser;
use Application\Form\InscriptionUser\InscriptionUserHydrator;
use Application\Service\Inscription\InscriptionService;
use Application\Service\InscriptionUser\InscriptionUserService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;
use UnicaenUtilisateur\Service\Role\RoleService;
use UnicaenUtilisateur\Service\User\UserService;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

/**
 * Class InscriptionUserFieldsetFactory
 */
class InscriptionUserFieldsetFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return InscriptionUserFieldset|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {


        /** @var InscriptionUserFieldset $fieldset */
        $fieldset = new InscriptionUserFieldset("user");

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

//        /** @var InscriptionUserHydrator $hydrator */
//        $hydrator = $container->get("HydratorManager")->get(InscriptionUserHydrator::class);
//        $fieldset->setHydrator($hydrator);


        $entityService = $container->get('ServiceManager')->get(InscriptionService::class);
        $fieldset->setInscriptionService($entityService);

        $entityService = $container->get('ServiceManager')->get(UserService::class);
        $fieldset->setUserService($entityService);

        $roleService = $container->get("ServiceManager")->get(RoleService::class);
        $fieldset->setRoleService($roleService);

        $fieldset->build();

        return $fieldset;
    }
}